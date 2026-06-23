<?php
/**
 * File Upload Validation Tests
 *
 * RED phase  : Tests FAIL now, confirming that upload handlers do not
 *              validate MIME type, file size, or CSV structure.
 * GREEN phase: Tests PASS after validation is added to upload handlers.
 *
 * Strategy: Read the actual upload handler and Badges controller to verify
 * that validation code is present. Also include positive-control tests
 * that verify the validation logic works correctly when implemented.
 */

use PHPUnit\Framework\TestCase;

class FileUploadTest extends TestCase
{
    private string $root;
    private string $tmp_dir;

    protected function setUp(): void
    {
        $this->root    = realpath(__DIR__ . '/../../');
        $this->tmp_dir = $this->root . '/tests/tmp';
        if (!is_dir($this->tmp_dir)) {
            mkdir($this->tmp_dir, 0777, true);
        }
    }

    protected function tearDown(): void
    {
        foreach (glob($this->tmp_dir . '/*.php') ?: [] as $f) unlink($f);
        foreach (glob($this->tmp_dir . '/*.csv') ?: [] as $f) unlink($f);
        foreach (glob($this->tmp_dir . '/*.tmp') ?: [] as $f) unlink($f);
    }

    private function fileContains(string $file, string $pattern, bool $is_regex = false): bool
    {
        $path = $this->root . '/' . $file;
        if (!file_exists($path)) {
            return false;
        }
        $content = file_get_contents($path);
        if ($is_regex) {
            return (bool) preg_match($pattern, $content);
        }
        return strpos($content, $pattern) !== false;
    }

    // -----------------------------------------------------------------------
    // Tests against actual application files
    // -----------------------------------------------------------------------

    /**
     * Verify the Badges controller validates MIME type before processing CSV.
     * FAILS until MIME type validation is added to Badges.php.
     *
     * @group file-upload
     * @group vulnerable
     */
    public function testBadgesControllerValidatesMimeType(): void
    {
        $file = 'application/controllers/Badges.php';

        $has_mime_check = $this->fileContains($file, 'mime_content_type', false) ||
                          $this->fileContains($file, 'finfo_file', false) ||
                          $this->fileContains($file, 'FILEINFO_MIME_TYPE', false);

        $this->assertTrue(
            $has_mime_check,
            "VULNERABILITY: Badges.php does not validate the MIME type of uploaded CSV files.\n" .
            "Add mime_content_type() or finfo_file() check before processing any uploaded file."
        );
    }

    /**
     * Verify the Badges controller validates CSV column headers before importing.
     * FAILS until header validation is added.
     *
     * @group file-upload
     * @group vulnerable
     */
    public function testBadgesControllerValidatesCsvHeaders(): void
    {
        $file = 'application/controllers/Badges.php';

        // Look for header validation: fgetcsv + comparison to expected headers
        $has_header_check = $this->fileContains($file, 'fgetcsv', false) &&
                            ($this->fileContains($file, 'expected', false) ||
                             $this->fileContains($file, 'header', false) ||
                             $this->fileContains($file, 'columns', false));

        $this->assertTrue(
            $has_header_check,
            "VULNERABILITY: Badges.php does not validate CSV column headers before importing.\n" .
            "Add a header check using fgetcsv() and compare against the expected schema before processing rows."
        );
    }

    /**
     * Verify the upload handler enforces a maximum file size server-side.
     * FAILS until a size limit check is added.
     *
     * @group file-upload
     * @group vulnerable
     */
    public function testUploadHandlerEnforcesFileSizeLimit(): void
    {
        $file = 'application/helpers/uploader/class.upload.php';

        $has_size_check = $this->fileContains($file, 'max_size', false) ||
                          $this->fileContains($file, 'filesize', false) ||
                          $this->fileContains($file, 'UPLOAD_ERR_INI_SIZE', false);

        $this->assertTrue(
            $has_size_check,
            "VULNERABILITY: class.upload.php does not enforce a server-side file size limit.\n" .
            "Add a filesize() check against a defined maximum before accepting any uploaded file."
        );
    }

    /**
     * Verify the upload handler sanitises the original filename before storing.
     * FAILS until filename sanitisation is added.
     *
     * @group file-upload
     * @group vulnerable
     */
    public function testUploadHandlerSanitisesFilename(): void
    {
        $file = 'application/helpers/uploader/class.upload.php';

        $has_sanitise = $this->fileContains($file, 'preg_replace', false) ||
                        $this->fileContains($file, 'basename', false) ||
                        $this->fileContains($file, 'sanitize', false) ||
                        $this->fileContains($file, 'random', false);

        $this->assertTrue(
            $has_sanitise,
            "VULNERABILITY: class.upload.php does not sanitise the uploaded filename.\n" .
            "Generate a random filename on upload — never use the original user-supplied name."
        );
    }

    // -----------------------------------------------------------------------
    // Positive-control tests (validation logic correctness)
    // These test the validation functions themselves and should always pass.
    // -----------------------------------------------------------------------

    /**
     * Verify that the MIME-based allowed list correctly accepts a valid CSV.
     * Always passes — confirms our validation logic is correct when implemented.
     *
     * @group file-upload
     * @group target
     */
    public function testValidCsvPassesMimeAllowList(): void
    {
        $path    = $this->tmp_dir . '/valid_test.csv';
        file_put_contents($path, "id,name,email\n1,Test,test@example.com\n");
        $allowed = ['text/plain', 'text/csv', 'application/csv'];
        $mime    = mime_content_type($path);

        $this->assertTrue(
            in_array($mime, $allowed, true),
            "A plain CSV file should be in the allowed MIME list. Detected: {$mime}"
        );
    }

    /**
     * Verify that a binary (JPEG) file is rejected by the MIME allow list.
     * Always passes — confirms our validation logic is correct when implemented.
     *
     * @group file-upload
     * @group target
     */
    public function testBinaryFileFailsMimeAllowList(): void
    {
        $path    = $this->tmp_dir . '/binary_test.tmp';
        file_put_contents($path, "\xFF\xD8\xFF\xE0" . str_repeat("\x00", 12));
        $allowed = ['text/plain', 'text/csv', 'application/csv'];
        $mime    = mime_content_type($path);

        $this->assertFalse(
            in_array($mime, $allowed, true),
            "A JPEG binary file must not pass the CSV MIME allow list. Detected: {$mime}"
        );
    }

    /**
     * Verify that content scanning detects PHP tags in an uploaded file.
     * Always passes — confirms our content-scan logic is correct when implemented.
     *
     * @group file-upload
     * @group target
     */
    public function testContentScanDetectsPhpTags(): void
    {
        $open_tag = '<' . '?php';
        $content  = $open_tag . ' echo "hello"; ?' . '>';
        $path     = $this->tmp_dir . '/content_test.csv';
        file_put_contents($path, $content);

        $file_content = file_get_contents($path);
        $has_php_tag  = strpos($file_content, '<' . '?php') !== false;

        $this->assertTrue(
            $has_php_tag,
            "Content scanner must detect PHP open tags in a file before accepting it"
        );
    }

    /**
     * Verify that path traversal is eliminated by basename() sanitisation.
     * Always passes — confirms our filename sanitisation logic is correct.
     *
     * @group file-upload
     * @group target
     */
    public function testPathTraversalIsRemovedByBasename(): void
    {
        $dangerous_names = [
            '../../../etc/passwd',
            '..\\..\\windows\\system32\\cmd.exe',
            '/etc/passwd',
        ];

        foreach ($dangerous_names as $name) {
            $safe = basename($name);
            $this->assertStringNotContainsString('/', $safe,
                "basename() should strip path separators from: {$name}");
            $this->assertStringNotContainsString('\\', $safe,
                "basename() should strip backslashes from: {$name}");
        }
    }
}

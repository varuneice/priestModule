#!/usr/bin/env bash
# =============================================================================
# run-tests.sh
# Test runner for HDBS Payment security tests.
#
# Usage:
#   bash run-tests.sh                        # Run all tests
#   bash run-tests.sh --group sql-injection  # Run a specific group
#   bash run-tests.sh --group vulnerable     # Run only vulnerability-confirming tests
#   bash run-tests.sh --group target         # Run only post-fix target tests
#   bash run-tests.sh --coverage             # Run with HTML coverage report
#
# Requirements:
#   - XAMPP MySQL must be running
#   - Run setup first: bash tests/setup-test-db.sh
#   - Run from the project root: priestModule/
# =============================================================================

PHP="/c/xampp/php/php.exe"
PHPUNIT="vendor/bin/phpunit"

# Available test groups
VALID_GROUPS=("sql-injection" "xss" "csrf" "file-upload" "vulnerable" "target")

echo "============================================================"
echo "  HDBS Payment — Security Test Runner"
echo "  $(date '+%Y-%m-%d %H:%M:%S')"
echo "============================================================"

# Parse arguments
GROUP=""
COVERAGE=false

while [[ "$#" -gt 0 ]]; do
    case $1 in
        --group)
            GROUP="$2"
            shift 2
            ;;
        --coverage)
            COVERAGE=true
            shift
            ;;
        *)
            echo "Unknown option: $1"
            echo "Usage: bash run-tests.sh [--group GROUP] [--coverage]"
            echo "Groups: ${VALID_GROUPS[*]}"
            exit 1
            ;;
    esac
done

# Check MySQL is running
echo ""
echo "[Pre-flight] Checking MySQL..."
if ! /c/xampp/mysql/bin/mysql.exe -u root -e "USE hdbs_test;" > /dev/null 2>&1; then
    echo "  ERROR: Test database 'hdbs_test' not accessible."
    echo "  Run:  bash tests/setup-test-db.sh"
    exit 1
fi
echo "  OK — Test database is reachable."
echo ""

# Build PHPUnit command
CMD=("$PHP" "$PHPUNIT" "--colors=always")

if [ -n "$GROUP" ]; then
    CMD+=("--group" "$GROUP")
    echo "  Running group: $GROUP"
else
    echo "  Running: ALL security tests"
fi

if [ "$COVERAGE" = true ]; then
    CMD+=("--coverage-html" "tests/coverage-report")
    echo "  Coverage: ON  →  tests/coverage-report/index.html"
fi

echo ""
echo "------------------------------------------------------------"

# Run tests
"${CMD[@]}"
EXIT_CODE=$?

echo "------------------------------------------------------------"
echo ""

if [ $EXIT_CODE -eq 0 ]; then
    echo "  RESULT: ALL TESTS PASSED"
else
    echo "  RESULT: SOME TESTS FAILED (exit code: $EXIT_CODE)"
fi

echo ""
echo "============================================================"

exit $EXIT_CODE

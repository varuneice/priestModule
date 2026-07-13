<?php
unset($_REQUEST['controller']);
unset($_REQUEST['action']);

$_REQUEST['controller'] = "GzFront";
$_REQUEST['action'] = "index";

ob_start();

require_once INSTALL_PATH . '/load.php';

$content = ob_get_contents();
ob_end_clean();

$content = preg_replace('/\r\n|\n|\t/', '', $content);
echo 'document.write(' . json_encode($content, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) . ');';
?>

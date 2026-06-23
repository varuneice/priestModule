<?php
require $content_tpl;
?>
<?php
foreach ($this->controller->css as $css) {
    echo '<link type="text/css" rel="stylesheet" href="' . (isset($css['remote']) && $css['remote'] ? NULL : INSTALL_URL) . $css['path'] . $css['file'] . '" />';
}
?>
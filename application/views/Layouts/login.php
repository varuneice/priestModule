<?php

foreach ($this->controller->css as $css) {
    echo '<link type="text/css" rel="stylesheet" href="' . (isset($css['remote']) && $css['remote'] ? NULL : INSTALL_URL) . $css['path'] . $css['file'] . '" />';
}
require $content_tpl;
foreach ($this->controller->js as $js) {
    echo '<script type="text/javascript" src="' . (isset($js['remote']) && $js['remote'] ? NULL : INSTALL_URL) . $js['path'] . $js['file'] . '"></script>';
}
?>
<?php
//require_once VIEWS_PATH . 'Layouts/admin/footer.php';
?>
<div id="container-abc-url-id" style="display: none;"><?php echo INSTALL_URL; ?></div>
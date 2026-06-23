<?php
if (is_file($content_tpl)) {
    require $content_tpl;
}
foreach ($this->controller->css as $css) {
    echo '<link type="text/css" rel="stylesheet" href="' . (isset($css['remote']) && $css['remote'] ? NULL : INSTALL_URL) . $css['path'] . $css['file'] . '" />';
}



<?php
foreach ($this->controller->css as $css) {
    echo '<link type="text/css" rel="stylesheet" href="' . $css['path'] . $css['file'] . '" />';
}

foreach ($this->controller->js as $js) {
    echo '<script type="text/javascript" src="' . $js['path'] . $js['file'] . '"></script>';
}
?>
<div id="body-contetn">
    <div class="grid">
        <?php require $content_tpl; ?>
    </div>
</div>

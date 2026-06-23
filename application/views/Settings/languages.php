<section class="content-header">
    <h1>
        <?php echo __('languages_settings'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li class="active"><?php echo __('languages_settings'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?php echo __('options'); ?></h3>
        </div>
        <div class="box-body">
            <?php require 'component/languages_tabs.php'; ?>
        </div>
    </div>
</section>
<div id="dialogAddLocal" title="add local" style="display:none">
    <?php require 'component/frm_add_local.php'; ?>
</div>
<div id="dialogAddLanguage" title="add language" style="display:none">
    <?php require 'component/frm_add_language.php'; ?>
</div>
<div id="dialogEditLanguage" title="edit language" style="display:none">
    
</div>
<div id="dialogDeleteLanguage" title="Delete Language" style="display:none">
    <p>Delete Language</p>
</div>
<div id="record_id" style="display:none"></div>
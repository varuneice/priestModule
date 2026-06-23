<div class="overlay"></div>
<div class="loading-img"></div>
<form name="edit_language" id="edit_language_id" method="post" action="<?php echo INSTALL_URL; ?>index.php?controller=Settings&action=edit_language" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>"> 
    <fieldset>
        <div class="form-group">
            <label class="control-label" for="language">
                language
            </label>
            <input data-rule-required="true" class="form-control" type="text" name="language" value="<?php echo $tpl['language']['language'] ?? ''; ?>">
            <div class="control-group"></div>
        </div>  
        <div class="form-group">
            <label class="control-label" for="isdefault">
                is default
            </label>
            <input type="checkbox" value="1" name="isdefault" <?php echo ($tpl['language']['isdefault'] == '1') ? "checked='checked'" : ""; ?>/>
            <div class="control-group"></div>
        </div>
        <div class="form-group">
            <label class="control-label" for="flag">
                flag
            </label>
            <?php if (is_file(INSTALL_PATH . UPLOAD_PATH . 'flag/' . $tpl['language']['flag'])) { ?>
                <img src="<?php echo INSTALL_URL . UPLOAD_PATH . 'flag/' . $tpl['language']['flag']; ?>" />
                <?php
            }
            ?>
            <input class="form-control" type="file" name="flag">
            <div class="control-group"></div>
        </div>
    </fieldset>
    <fieldset>
        <input type="hidden" name="id" value="<?php echo $tpl['language']['id'] ?>" />
        <button id="submit" class="btn btn-default" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
    </fieldset>
</form>


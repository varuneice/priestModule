<form name="add_language" id="add_language_id" method="post" action="<?php echo INSTALL_URL; ?>index.php?controller=Settings&action=add_language" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>"> 
    <fieldset>
        <div class="form-group">
            <label class="control-label" for="language">
                language
            </label>
            <input data-rule-required="true" class="form-control" type="text" name="language" value="">
            <div class="control-group"></div>
        </div>  
        <div class="form-group">
            <label class="control-label" for="isdefault">
                is default
            </label>
            <input type="checkbox" value="1" name="isdefault" />
            <div class="control-group"></div>
        </div>
        <div class="form-group">
            <label class="control-label" for="flag">
                flag
            </label>
            <input class="form-control" type="file" name="flag">
            <div class="control-group"></div>
        </div>
    </fieldset>
    <fieldset>
        <button id="submit" class="btn btn-default" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
    </fieldset>
</form>


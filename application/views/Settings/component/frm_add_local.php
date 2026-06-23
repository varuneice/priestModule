<form name="add_local" id="frm_add_local_id" method="post" action="<?php echo INSTALL_URL; ?>
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">index.php?controller=Settings&action=add_local" > 
    <fieldset>
        <div class="form-group">
            <label class="control-label" for="type">
                value
            </label>
            <input data-rule-required="true" class="form-control" type="text" name="value" value="">
            <div class="control-group"></div>
        </div>  
        <div class="form-group">
            <label class="control-label" for="field">
                field
            </label>
            <input data-rule-required="true" class="form-control" type="text" name="field" value="">
            <div class="control-group"></div>
        </div>
        <div class="form-group">
            <label class="control-label" for="key">
                key
            </label>
            <input data-rule-required="true" class="form-control" type="text" name="key" value="">
            <div class="control-group"></div>
        </div> 
        <div class="form-group">
            <label class="control-label" for="key">
                arr key
            </label>
            <input data-rule-required="true" class="form-control" type="text" name="arr_key" value="">
            <div class="control-group"></div>
        </div> 
        <div class="form-group">
            <label class="control-label" for="layout">
                layout
            </label>
            <select data-rule-required="true" name="layout"  class="form-control input-sm" >
                <?php foreach (array('frontend' => 'frontend', 'backhand' => 'backhand') as $k => $v) {
                    ?>
                    <option value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                    <?php
                }
                ?>
            </select>
            <div class="control-group"></div>
        </div>
        <div class="form-group">
            <label class="control-label" for="type">
                type
            </label>
            <select data-rule-required="true" name="type"  class="form-control input-sm" >
                <?php foreach (array('array' => 'array', 'text' => 'text') as $k => $v) {
                    ?>
                    <option value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                    <?php
                }
                ?>
            </select>
            <div class="control-group"></div>
        </div>  
    </fieldset>
    <fieldset>
        <input type="hidden" id="language_id" name="language_id" />
        <button id="submit" class="btn btn-default" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
    </fieldset>
</form>


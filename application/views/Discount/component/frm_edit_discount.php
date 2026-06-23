<form name="add_discount" id="add_discount_id" method="post" action="">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>"> 
    <input type="hidden" name="id" value="<?php echo $tpl['discount']['id'] ?? ''; ?>" />
    <fieldset>
        <div class="form-group">
            <label class="control-label" for="calendar_id">
                <?php echo __('calendar'); ?>:
            </label>
            <select data-rule-required="true" name="calendar_id"  class="form-control input-sm" >
                <?php
                foreach (($tpl['calendars'] ?? []) as $k => $v) {
                    ?>
                    <option <?php echo ($tpl['discount']['calendar_id'] == $v['id']) ? "selected='selected'" : ""; ?> value="<?php echo $v['id']; ?>" ><?php echo $v['i18n'][$this->controller->tpl['default_language']['id']]['title']; ?></option>
                    <?php
                }
                ?>
            </select>
            <div class="control-group"></div>
        </div>  
        <div class="form-group">
            <label class="control-label" for="discount_title">
                <?php echo __('title'); ?>:
            </label>
            <input data-rule-required="true" class="form-control" type="text" placeholder="Enter ..." name="discount_title" value="<?php echo $tpl['discount']['discount_title'] ?? ''; ?>">
            <div class="control-group"></div>
        </div>
        <div class="form-group">
            <label class="control-label" for="price_deducted">
                <?php echo __('promo_code'); ?>:
            </label>
            <div class="input-group">
                <input data-rule-required="true" class="form-control" type="text" name="promo_code" value="<?php echo $tpl['discount']['promo_code'] ?? ''; ?>">
            </div>
            <div class="control-group"></div>
        </div>
        <div class="form-group">
            <label class="control-label" for="discount">
                <?php echo __('discount'); ?>:
            </label>
            <div class="input-group">
                <span class="input-group-addon">$/%</span>
                <input data-rule-required="true" class="form-control" type="text" name="discount" value="<?php echo $tpl['discount']['discount'] ?? ''; ?>">
            </div>
            <div class="control-group"></div>
        </div>
        <div class="form-group">
            <label class="control-label" for="type">
                <?php echo __('type'); ?>:
            </label>
            <select data-rule-required="true" name="type"  class="form-control input-sm" >
                <?php foreach (__('discount_type') as $k => $v) {
                    ?>
                    <option <?php echo ($tpl['discount']['type'] == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                    <?php
                }
                ?>
            </select>
            <div class="control-group"></div>
        </div>  
    </fieldset>
</form>
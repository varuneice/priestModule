<?php
$currency = $tpl['option_arr_values']['currency'] ?? '';
$currencies = Util::$currencies;
?>
<form name="edit_time_price" id="edit_time_price_id" method="post" action="">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>"> 
    <input type="hidden" name="id" value="<?php echo $tpl['arr']['id'] ?? ''; ?>" />
    <div class="form-group">
        <label class="control-label" for="calendar"><?php echo __('calendar'); ?>:</label>
        <select name="calendar_id" id="calendar_id" class="form-control input-sm medium" >
            <?php
            foreach (($tpl['calendars'] ?? []) as $key => $value) {
                ?>
                <option <?php echo ($tpl['arr']['calendar_id'] == $value['id']) ? "selected='selected'" : ""; ?> value="<?php echo $value['id']; ?>">
                    <?php echo $value['i18n'][$this->controller->tpl['default_language']['id']]['title']; ?>
                </option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label class="control-label" for="tooltip"><?php echo __('tooltip'); ?>:</label>
        <input class="form-control input-sm" name="tooltip" value="<?php echo $tpl['arr']['tooltip'] ?>"/>
    </div>
    <div class="form-group">
        <label class="control-label" for="timestamp"><?php echo __('start_date'); ?>:</label>
        <div class="input-group bootstrap-timepicker">    
            <input id="edit-datepicker" class="form-control input-sm left-radius" type="text" name="timestamp" value="<?php echo date('m/d/Y', $tpl['arr']['timestamp'] ?? 0); ?>" data-date-format="<?php echo $tpl['bootsrap_format'] ?? ''; ?>" first-day="<?php echo $tpl['option_arr_values']['week_first_day'] ?? ''; ?>">
            <div class="input-group-addon right-radius">
                <i class="fa fa-fw fa-calendar"></i>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label" for="timestamp"><?php echo __('end_date'); ?>:</label>
        <div class="input-group bootstrap-timepicker">    
            <input id="edit-end-datepicker" class="form-control input-sm left-radius" type="text" name="timestamp_end" value="<?php echo date('m/d/Y', $tpl['arr']['timestamp_end'] ?? 0); ?>" data-date-format="<?php echo $tpl['bootsrap_format'] ?? ''; ?>" first-day="<?php echo $tpl['option_arr_values']['week_first_day'] ?? ''; ?>">
            <div class="input-group-addon right-radius">
                <i class="fa fa-fw fa-calendar"></i>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label" for="start"><?php echo __('start_time'); ?>:</label>
        <div class="input-group bootstrap-timepicker">    
            <input class="edit-timepicker form-control input-sm left-radius" type="text" name="start" value="<?php echo $tpl['arr']['start'] ?? ''; ?>">
            <div class="input-group-addon right-radius">
                <i class="fa fa-fw fa-clock-o"></i>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label" for="end"><?php echo __('end_time'); ?>:</label>
        <div class="input-group bootstrap-timepicker">    
            <input class="left-radius edit-timepicker form-control input-sm" type="text" name="end" value="<?php echo $tpl['arr']['end'] ?? ''; ?>">
            <div class="input-group-addon right-radius">
                <i class="fa fa-fw fa-clock-o"></i>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label" for="lunch_start"><?php echo __('lunch_from'); ?>:</label>
        <div class="input-group bootstrap-timepicker">    
            <input class="left-radius edit-timepicker form-control input-sm" type="text" name="lunch_start" value="<?php echo $tpl['arr']['lunch_start'] ?? ''; ?>">
            <div class="input-group-addon right-radius">
                <i class="fa fa-fw fa-clock-o"></i>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label" for="lunch_end"><?php echo __('lunch_to'); ?>:</label>
        <div class="input-group bootstrap-timepicker">    
            <input class="left-radius edit-timepicker form-control input-sm" type="text" name="lunch_end" value="<?php echo $tpl['arr']['lunch_end'] ?? ''; ?>">
            <div class="input-group-addon right-radius">
                <i class="fa fa-fw fa-clock-o"></i>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label" for="slot_lenght"><?php echo __('slot_lenght'); ?>:</label>
        <select name="slot_lenght" id="slot_lenght" class="form-control input-sm medium" >
            <?php foreach (Util::$slot_lenght as $key => $value) {
                ?>
                <option <?php echo ($tpl['arr']['slot_lenght'] == $key) ? "selected='selected'" : ""; ?> value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label class="control-label" for="slot_lenght"><?php echo __('bookings_per_slot'); ?>:</label>
        <input class="form-control input-sm touchSpin left-radius" type="text" name="count" value="<?php echo $tpl['arr']['count'] ?? ''; ?>" >
    </div>
    <div class="form-group">
        <label class="control-label" for="price"><?php echo __('price_per_slot'); ?>:</label>
        <div class="input-group" style="width: 120px;">
            <div class="input-group-addon left-radius">
                <?php
                echo $currencies[$currency]['symbol'];
                ?>
            </div>
            <input class="form-control input-sm" type="text" name="price" value="<?php echo $tpl['arr']['price'] ?? ''; ?>" >
        </div>
    </div>
    <div class="form-group">
        <label class="control-label" for="is_day_off"><?php echo __('is_day_off'); ?>:</label>
        <input type="checkbox" name="is_day_off" value="1" <?php echo ($tpl['arr']['is_day_off'] == 1) ? "checked='checked'" : ""; ?> class="is_day_off"/>
    </div>
</form>
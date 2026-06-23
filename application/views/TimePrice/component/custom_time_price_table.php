
<?php
$currency = $tpl['option_arr_values']['currency'] ?? '';
$currencies = Util::$currencies;
$slot_lenght = Util::$slot_lenght;
?>
<div class="overlay"></div>
<div class="loading-img"></div>
<?php if (!empty($tpl['arr'])) { ?>
    <table id="working-time-table-id" class="table table-responsive table-hover table-bordered" cellpadding="0" cellspacing="0" >
        <thead>
            <tr>
                <th><?php echo __('calendar'); ?></th>
                <th><?php echo __('start_date'); ?></th>
                <th><?php echo __('end_date'); ?></th>
                <th><?php echo __('tooltip'); ?></th>
                <th><?php echo __('start_time'); ?></th>
                <th><?php echo __('end_time'); ?></th>
                <th><?php echo __('lunch_from'); ?></th>
                <th><?php echo __('lunch_to'); ?></th>
                <th><?php echo __('slot_lenght'); ?></th>
                <th><?php echo __('bookings_per_slot'); ?></th>
                <th><?php echo __('price_per_slot'); ?></th>
                <th><?php echo __('is_day_off'); ?></th>
                <th class="icon-th"></th>
                <th class="icon-th"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (($tpl['arr'] ?? []) as $key => $value) { ?>
                <tr>
                    <td>
                        <span class="margin8">
                            <?php echo @$value['calendar']['i18n'][$this->controller->tpl['default_language']['id']]['title']; ?>
                        </span>
                    </td>
                    <td>
                        <span class="margin8">
                            <?php echo date($tpl['option_arr_values']['date_format'], $value['timestamp']); ?>
                        </span>
                    </td>
                     <td>
                        <span class="margin8">
                            <?php echo date($tpl['option_arr_values']['date_format'], $value['timestamp_end']); ?>
                        </span>
                    </td>
                    <td>
                        <span class="margin8">
                            <?php echo $value['tooltip']; ?>
                        </span>
                    </td>
                    <td>
                        <div class="form-group <?php echo (@$value['is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                            <?php echo @$value['start']; ?>
                        </div>
                    </td>
                    <td>
                        <div class="form-group <?php echo (@$value['is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                            <?php echo @$value['end']; ?>
                        </div>
                    </td>
                    <td>
                        <div class="form-group <?php echo (@$value['is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                            <?php echo @$value['lunch_start']; ?>
                        </div>
                    </td>
                    <td>
                        <div class="form-group <?php echo (@$value['is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                            <?php echo @$value['lunch_end']; ?>
                        </div>
                    </td>
                    <td>
                        <div class="form-group <?php echo (@$value['is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                            <?php
                            echo $slot_lenght[$value['slot_lenght'] ?? ''] ?? '';
                            ?>
                        </div>
                    </td>
                    <td>
                        <div class="<?php echo (@$value['is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                            <?php echo @$value['count']; ?>
                        </div>
                    </td>
                    <td>
                        <div class="<?php echo (@$value['is_day_off'] == '1') ? "not-visibility" : ""; ?>"> 
                            <?php echo Util::currenctFormat($currency, $value['price']); ?>
                        </div>
                    </td>
                    <td>
                        <?php echo (@$value['is_day_off'] == '1') ? "Yes" : "No"; ?>
                    </td>
                    <td>
                        <a class="btn btn-success btn-sm icon-edit" href="javascript:" rev="<?php echo $value['id']; ?>" >
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-danger btn-sm custom-icon-delete" rev="<?php echo $value['id']; ?>" href="javascript:">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>
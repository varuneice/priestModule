<form name="getCustomPricFrm" method="post" id="dialogSetCustomPriceFrmId">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
    <input type="hidden" name="calendar_id" value="<?php echo $_POST['calendar_id'] ?? ''; ?>" >
    
    <?php 
    if(!empty($tpl['working_time']['timestamp'])){
        ?>
        <input type="hidden" name="custom_date_id" value="<?php echo $tpl['working_time']['id'] ?? ''; ?>" >
    <?php
    }else{
        ?>
        <input type="hidden" name="day" value="<?php echo $_POST['day'] ?? ''; ?>" >
        <?php
    }
    ?>
    <div class="box box-solid box-primary">
        <div class="box-body">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>
                            <?php echo __('start_time'); ?>
                        </th>
                        <th>
                            <?php echo __('day'); ?>
                        </th>
                        <th>
                            <?php echo __('prices'); ?>
                        </th>
                        <th>
                            <input class="checkall" id="checkedAll" type="checkbox" name="checkedAll" value="1" >
                            <?php echo __('holes9only'); ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($tpl['working_time'])) {
                        $currency = $tpl['option_arr_values']['currency'] ?? '';
                        $currencies = Util::$currencies;
                        
                        if(!empty($tpl['working_time']['timestamp'])){
                            $start_time = explode(':', $tpl['working_time']['start'] ?? '00:00');
                            $end_time = explode(':', $tpl['working_time']['end'] ?? '00:00');

                            $slot_lenght = $tpl['working_time']['slot_lenght'] ?? '';
                            $price = $tpl['working_time']['price'] ?? '';
                            
                            $date = $tpl['working_time']['timestamp'] ?? '';
                        }else{
                        
                            $date = time();

                            switch ($_POST['day'] ?? '') {
                                case '1':
                                    $start_time = explode(':', $tpl['working_time']['monday_start'] ?? '00:00');
                                    $end_time = explode(':', $tpl['working_time']['monday_end'] ?? '00:00');

                                    $slot_lenght = $tpl['working_time']['monday_slot_lenght'] ?? '';
                                    $price = $tpl['working_time']['monday_price'] ?? '';
                                    break;
                                case '2':
                                    $start_time = explode(':', $tpl['working_time']['tuesday_start'] ?? '00:00');
                                    $end_time = explode(':', $tpl['working_time']['tuesday_end'] ?? '00:00');

                                    $slot_lenght = $tpl['working_time']['tuesday_slot_lenght'] ?? '';
                                    $price = $tpl['working_time']['tuesday_price'] ?? '';
                                    break;
                                case '3':
                                    $start_time = explode(':', $tpl['working_time']['wednesday_start'] ?? '00:00');
                                    $end_time = explode(':', $tpl['working_time']['wednesday_end'] ?? '00:00');
                                    $slot_lenght = $tpl['working_time']['wednesday_slot_lenght'] ?? '';
                                    $price = $tpl['working_time']['wednesday_price'] ?? '';
                                    break;
                                case '4':
                                    $start_time = explode(':', $tpl['working_time']['thursday_start'] ?? '00:00');
                                    $end_time = explode(':', $tpl['working_time']['thursday_end'] ?? '00:00');

                                    $slot_lenght = $tpl['working_time']['thursday_slot_lenght'] ?? '';
                                    $price = $tpl['working_time']['thursday_price'] ?? '';
                                    break;
                                case '5':
                                    $start_time = explode(':', $tpl['working_time']['friday_start'] ?? '00:00');
                                    $end_time = explode(':', $tpl['working_time']['friday_end'] ?? '00:00');

                                    $slot_lenght = $tpl['working_time']['friday_slot_lenght'] ?? '';
                                    $price = $tpl['working_time']['friday_price'] ?? '';
                                    break;
                                case '6':
                                    $start_time = explode(':', $tpl['working_time']['saturday_start'] ?? '00:00');
                                    $end_time = explode(':', $tpl['working_time']['saturday_end'] ?? '00:00');

                                    $slot_lenght = $tpl['working_time']['saturday_slot_lenght'] ?? '';
                                    $price = $tpl['working_time']['saturday_price'] ?? '';
                                    break;
                                case '7':
                                    $start_time = explode(':', $tpl['working_time']['sunday_start'] ?? '00:00');
                                    $end_time = explode(':', $tpl['working_time']['sunday_end'] ?? '00:00');

                                    $slot_lenght = $tpl['working_time']['sunday_slot_lenght'] ?? '';
                                    $price = $tpl['working_time']['sunday_price'] ?? '';
                                    break;
                            }
                        }
                        for ($i = mktime($start_time[0], $start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date)); $i < mktime($end_time[0], $end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date)); $i+=$slot_lenght * 60) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo date($tpl['option_arr_values']['time_format'], $i); ?>
                                </td>
                                <td>
                                    <?php echo date($tpl['option_arr_values']['time_format'], ($i + $slot_lenght * 60)); ?>
                                </td>
                                <td>
                                    <div class="input-group medium">
                                        <div class="input-group-addon left-radius">
                                            <?php
                                            echo $currencies[$currency]['symbol'];
                                            ?>
                                        </div>
                                        <input class="form-control input-sm" type="text" name="price[<?php echo $i; ?>]" value="<?php echo (!empty($tpl['custom_prices'][date('H:i', $i)])) ? $tpl['custom_prices'][date('H:i', $i)] : $price; ?>" >
                                    </div>
                                </td>
                                <td>
                                    <input type="checkbox" class="checkSingle" name="holes9only[<?php echo $i; ?>]" value="1" <?php echo (!empty($tpl['holes9only'][date('H:i', $i)]) && $tpl['holes9only'][date('H:i', $i)] == 1) ? "checked='checked'" : ""; ?> />
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</form>
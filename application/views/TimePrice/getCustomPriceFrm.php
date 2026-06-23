<form name="getCustomPricFrm" method="post" id="dialogSetCustomPriceFrmId">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
    <input type="hidden" name="calendar_id" value="<?php echo $_POST['calendar_id'] ?? ''; ?>" >
    <input type="hidden" name="day" value="<?php echo $_POST['day'] ?? ''; ?>" >
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
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($tpl['working_time'])) {
                        $currency = $tpl['option_arr_values']['currency'] ?? '';
                        $currencies = Util::$currencies;
                        $date = time();
                        switch ($_POST['day'] ?? '') {
                            case '1':
                                $start_time = explode(':', $tpl['working_time']['monday_start'] ?? '00:00');
                                $end_time = explode(':', $tpl['working_time']['monday_end'] ?? '00:00');

                                $launch_start_time = explode(':', $tpl['working_time']['monday_lunch_start'] ?? '00:00');
                                $launch_end_time = explode(':', $tpl['working_time']['monday_lunch_end'] ?? '00:00');

                                $launch_start = mktime($launch_start_time[0], $launch_start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
                                $launch_end = mktime($launch_end_time[0], $launch_end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));

                                $slot_lenght = $tpl['working_time']['monday_slot_lenght'] ?? '';
                                break;
                            case '2':
                                $start_time = explode(':', $tpl['working_time']['tuesday_start'] ?? '00:00');
                                $end_time = explode(':', $tpl['working_time']['tuesday_end'] ?? '00:00');

                                $launch_start_time = explode(':', $tpl['working_time']['tuesday_lunch_start'] ?? '00:00');
                                $launch_end_time = explode(':', $tpl['working_time']['tuesday_lunch_end'] ?? '00:00');

                                $launch_start = mktime($launch_start_time[0], $launch_start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
                                $launch_end = mktime($launch_end_time[0], $launch_end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));

                                $slot_lenght = $tpl['working_time']['tuesday_slot_lenght'] ?? '';
                                break;
                            case '3':
                                $start_time = explode(':', $tpl['working_time']['wednesday_start'] ?? '00:00');
                                $end_time = explode(':', $tpl['working_time']['wednesday_end'] ?? '00:00');

                                $launch_start_time = explode(':', $tpl['working_time']['wednesday_lunch_start'] ?? '00:00');
                                $launch_end_time = explode(':', $tpl['working_time']['wednesday_lunch_end'] ?? '00:00');

                                $launch_start = mktime($launch_start_time[0], $launch_start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
                                $launch_end = mktime($launch_end_time[0], $launch_end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));

                                $slot_lenght = $tpl['working_time']['wednesday_slot_lenght'] ?? '';
                                break;
                            case '4':
                                $start_time = explode(':', $tpl['working_time']['thursday_start'] ?? '00:00');
                                $end_time = explode(':', $tpl['working_time']['thursday_end'] ?? '00:00');

                                $launch_start_time = explode(':', $tpl['working_time']['thursday_lunch_start'] ?? '00:00');
                                $launch_end_time = explode(':', $tpl['working_time']['thursday_lunch_end'] ?? '00:00');

                                $launch_start = mktime($launch_start_time[0], $launch_start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
                                $launch_end = mktime($launch_end_time[0], $launch_end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));

                                $slot_lenght = $tpl['working_time']['thursday_slot_lenght'] ?? '';
                                break;
                            case '5':
                                $start_time = explode(':', $tpl['working_time']['friday_start'] ?? '00:00');
                                $end_time = explode(':', $tpl['working_time']['friday_end'] ?? '00:00');

                                $launch_start_time = explode(':', $tpl['working_time']['friday_lunch_start'] ?? '00:00');
                                $launch_end_time = explode(':', $tpl['working_time']['friday_lunch_end'] ?? '00:00');

                                $launch_start = mktime($launch_start_time[0], $launch_start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
                                $launch_end = mktime($launch_end_time[0], $launch_end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));

                                $slot_lenght = $tpl['working_time']['friday_slot_lenght'] ?? '';
                                break;
                            case '6':
                                $start_time = explode(':', $tpl['working_time']['saturday_start'] ?? '00:00');
                                $end_time = explode(':', $tpl['working_time']['saturday_end'] ?? '00:00');

                                $launch_start_time = explode(':', $tpl['working_time']['saturday_lunch_start'] ?? '00:00');
                                $launch_end_time = explode(':', $tpl['working_time']['saturday_lunch_end'] ?? '00:00');

                                $launch_start = mktime($launch_start_time[0], $launch_start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
                                $launch_end = mktime($launch_end_time[0], $launch_end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));

                                $slot_lenght = $tpl['working_time']['saturday_slot_lenght'] ?? '';
                                break;
                            case '7':
                                $start_time = explode(':', $tpl['working_time']['sunday_start'] ?? '00:00');
                                $end_time = explode(':', $tpl['working_time']['sunday_end'] ?? '00:00');

                                $launch_start_time = explode(':', $tpl['working_time']['sunday_lunch_start'] ?? '00:00');
                                $launch_end_time = explode(':', $tpl['working_time']['sunday_lunch_end'] ?? '00:00');

                                $launch_start = mktime($launch_start_time[0], $launch_start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
                                $launch_end = mktime($launch_end_time[0], $launch_end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));

                                $slot_lenght = $tpl['working_time']['sunday_slot_lenght'] ?? '';
                                break;
                        }
                        for ($i = mktime($start_time[0], $start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date)); $i < mktime($end_time[0], $end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date)); $i += $slot_lenght * 60) {
                            if ($i >= $launch_start && $i <= $launch_end) {
                                $i = $launch_end;
                            }
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
                                        <input class="form-control input-sm" type="text" name="price[<?php echo $i; ?>]" value="<?php echo (!empty($tpl['custom_prices'][date('h:i', $i)])) ? $tpl['custom_prices'][date('h:i', $i)] : 0; ?>" >
                                    </div>
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
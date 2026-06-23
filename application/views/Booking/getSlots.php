<div class="GZBookingContainer">
    <div class="box box-solid box-primary">
        <div class="box-body">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>
                            <?php echo __('start_time'); ?>
                        </th>
                        <th>
                            <?php echo __('end_time'); ?>
                        </th>
                        <th>
                            <?php echo __('prices'); ?>
                        </th>
                        <th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($tpl['custom_dates'])) {
                        $date = Util::dateToTimestamp($tpl['option_arr_values']['date_format'], ($_POST['date'] ?? '') );

                        $start_time = explode(':', $tpl['custom_dates']['start'] ?? '00:00');
                        $end_time = explode(':', $tpl['custom_dates']['end'] ?? '00:00');

                        $launch_start_time = explode(':', $tpl['custom_dates']['lunch_start'] ?? '00:00');
                        $launch_end_time = explode(':', $tpl['custom_dates']['lunch_end'] ?? '00:00');

                        $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, date('n', $date), date('j', $date), date('Y', $date));
                        $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, date('n', $date), date('j', $date), date('Y', $date));

                        $slot_lenght = $tpl['custom_dates']['slot_lenght'] ?? '';
                        $price = $tpl['custom_dates']['price'] ?? '';
                        $count = $tpl['custom_dates']['count'] ?? '';
                    } elseif (!empty($tpl['working_time'])) {
                        $date = Util::dateToTimestamp($tpl['option_arr_values']['date_format'], ($_POST['date'] ?? '') );
                        switch (date('N', $date)) {
                            case '1':
                                $start_time = explode(':', $tpl['working_time']['monday_start'] ?? '00:00');
                                $end_time = explode(':', $tpl['working_time']['monday_end'] ?? '00:00');

                                $launch_start_time = explode(':', $tpl['working_time']['monday_lunch_start'] ?? '00:00');
                                $launch_end_time = explode(':', $tpl['working_time']['monday_lunch_end'] ?? '00:00');

                                $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, date('n', $date), date('j', $date), date('Y', $date));
                                $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, date('n', $date), date('j', $date), date('Y', $date));

                                $slot_lenght = $tpl['working_time']['monday_slot_lenght'] ?? '';
                                $price = $tpl['working_time']['monday_price'] ?? '';
                                $count = $tpl['working_time']['monday_count'] ?? '';
                                break;
                            case '2':
                                $start_time = explode(':', $tpl['working_time']['tuesday_start'] ?? '00:00');
                                $end_time = explode(':', $tpl['working_time']['tuesday_end'] ?? '00:00');

                                $launch_start_time = explode(':', $tpl['working_time']['tuesday_lunch_start'] ?? '00:00');
                                $launch_end_time = explode(':', $tpl['working_time']['tuesday_lunch_end'] ?? '00:00');

                                $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, date('n', $date), date('j', $date), date('Y', $date));
                                $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, date('n', $date), date('j', $date), date('Y', $date));

                                $slot_lenght = $tpl['working_time']['tuesday_slot_lenght'] ?? '';
                                $price = $tpl['working_time']['tuesday_price'] ?? '';
                                $count = $tpl['working_time']['tuesday_count'] ?? '';
                                break;
                            case '3':
                                $start_time = explode(':', $tpl['working_time']['wednesday_start'] ?? '00:00');
                                $end_time = explode(':', $tpl['working_time']['wednesday_end'] ?? '00:00');

                                $launch_start_time = explode(':', $tpl['working_time']['wednesday_lunch_start'] ?? '00:00');
                                $launch_end_time = explode(':', $tpl['working_time']['wednesday_lunch_end'] ?? '00:00');

                                $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, date('n', $date), date('j', $date), date('Y', $date));
                                $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, date('n', $date), date('j', $date), date('Y', $date));

                                $slot_lenght = $tpl['working_time']['wednesday_slot_lenght'] ?? '';
                                $price = $tpl['working_time']['wednesday_price'] ?? '';
                                $count = $tpl['working_time']['wednesday_count'] ?? '';
                                break;
                            case '4':
                                $start_time = explode(':', $tpl['working_time']['thursday_start'] ?? '00:00');
                                $end_time = explode(':', $tpl['working_time']['thursday_end'] ?? '00:00');

                                $launch_start_time = explode(':', $tpl['working_time']['thursday_lunch_start'] ?? '00:00');
                                $launch_end_time = explode(':', $tpl['working_time']['thursday_lunch_end'] ?? '00:00');

                                $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, date('n', $date), date('j', $date), date('Y', $date));
                                $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, date('n', $date), date('j', $date), date('Y', $date));

                                $slot_lenght = $tpl['working_time']['thursday_slot_lenght'] ?? '';
                                $price = $tpl['working_time']['thursday_price'] ?? '';
                                $count = $tpl['working_time']['thursday_count'] ?? '';
                                break;
                            case '5':
                                $start_time = explode(':', $tpl['working_time']['friday_start'] ?? '00:00');
                                $end_time = explode(':', $tpl['working_time']['friday_end'] ?? '00:00');

                                $launch_start_time = explode(':', $tpl['working_time']['friday_lunch_start'] ?? '00:00');
                                $launch_end_time = explode(':', $tpl['working_time']['friday_lunch_end'] ?? '00:00');

                                $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, date('n', $date), date('j', $date), date('Y', $date));
                                $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, date('n', $date), date('j', $date), date('Y', $date));

                                $slot_lenght = $tpl['working_time']['friday_slot_lenght'] ?? '';
                                $price = $tpl['working_time']['friday_price'] ?? '';
                                $count = $tpl['working_time']['friday_count'] ?? '';
                                break;
                            case '6':
                                $start_time = explode(':', $tpl['working_time']['saturday_start'] ?? '00:00');
                                $end_time = explode(':', $tpl['working_time']['saturday_end'] ?? '00:00');

                                $launch_start_time = explode(':', $tpl['working_time']['saturday_lunch_start'] ?? '00:00');
                                $launch_end_time = explode(':', $tpl['working_time']['saturday_lunch_end'] ?? '00:00');

                                $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, date('n', $date), date('j', $date), date('Y', $date));
                                $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, date('n', $date), date('j', $date), date('Y', $date));

                                $slot_lenght = $tpl['working_time']['saturday_slot_lenght'] ?? '';
                                $price = $tpl['working_time']['saturday_price'] ?? '';
                                $count = $tpl['working_time']['saturday_count'] ?? '';
                                break;
                            case '7':
                                $start_time = explode(':', $tpl['working_time']['sunday_start'] ?? '00:00');
                                $end_time = explode(':', $tpl['working_time']['sunday_end'] ?? '00:00');

                                $launch_start_time = explode(':', $tpl['working_time']['sunday_lunch_start'] ?? '00:00');
                                $launch_end_time = explode(':', $tpl['working_time']['sunday_lunch_end'] ?? '00:00');

                                $launch_start = mktime((int)($launch_start_time[0] ?? 0), (int)($launch_start_time[1] ?? 0), 0, date('n', $date), date('j', $date), date('Y', $date));
                                $launch_end = mktime((int)($launch_end_time[0] ?? 0), (int)($launch_end_time[1] ?? 0), 0, date('n', $date), date('j', $date), date('Y', $date));

                                $slot_lenght = $tpl['working_time']['sunday_slot_lenght'] ?? '';
                                $price = $tpl['working_time']['sunday_price'] ?? '';
                                $count = $tpl['working_time']['sunday_count'] ?? '';
                                break;
                        }
                    }
                    for ($i = mktime((int)($start_time[0] ?? 0), (int)($start_time[1] ?? 0), 0, date('n', $date), date('j', $date), date('Y', $date)); $i < mktime((int)($end_time[0] ?? 0), (int)($end_time[1] ?? 0), 0, date('n', $date), date('j', $date), date('Y', $date)); $i += $slot_lenght * 60) {
                        if ($i >= $launch_start && $i <= $launch_end) {
                            $i = $launch_end;
                        }
                        $booked = 0;
                        foreach (($tpl['booked_slots'] ?? []) as $booked_timestamp => $booked_count) {
                            if ($booked_timestamp >= $i && $booked_timestamp < ($i + $slot_lenght * 60)) {
                                $booked += $booked_count;
                            }
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
                                <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $price); ?>
                            </td>
                            <td>
                                <?php
                                if ($count > $booked) {
                                    if ($count > 1) {
                                        ?>
                                        <select name="count" data-date="<?php echo $date; ?>" data-start-time="<?php echo $i; ?>" class="gzTimeSlotDropDownClass">
                                            <option value=""><?php echo __('select_slot'); ?></option>
                                            <?php
                                            for ($c = 1; $c <= ($count - $booked); $c++) {
                                                ?>
                                                <option <?php echo (!empty($_SESSION[$this->controller->default_product]['admin']['slots'][$_REQUEST['calendar_id']][$i]) && $_SESSION[$this->controller->default_product]['admin']['slots'][$_REQUEST['calendar_id']][$i] == $c) ? "selected='selected'" : ""; ?> value="<?php echo $c; ?>"><?php echo $c; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <?php
                                    } else {
                                        if (empty($_SESSION[$this->controller->default_product]['admin']['slots'][$_REQUEST['calendar_id']][$i])) {
                                            ?>
                                            <a href="javascript:" data-date="<?php echo $date; ?>" data-start-time="<?php echo $i; ?>" class="gzTimeSlotButtonPlusClass fa fa-fw fa-plus-square"></a>
                                            <?php
                                        } else {
                                            ?>
                                            <div>
                                                <a href="javascript:" data-date="<?php echo $date; ?>" data-start-time="<?php echo $i; ?>" class="gzTimeSlotButtonMinusClass fa fa-fw fa-minus-square"></a>
                                            </div>
                                            <?php
                                        }
                                    }
                                } else {
                                    ?>
                                    <strong>
                                        <?php echo __('full_booked'); ?>
                                    </strong>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
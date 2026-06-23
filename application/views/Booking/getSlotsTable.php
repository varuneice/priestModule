<?php if (!empty($_SESSION[$this->controller->default_product]['admin'])) { ?>
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th>
                    <?php echo __('date'); ?>
                </th>
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
                    <?php echo __('count'); ?>
                </th>
                <th>

                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($_SESSION[$this->controller->default_product]['admin']['slots'][$_REQUEST['calendar_id']] ?? [] as $i => $count) {
                $date = strtotime(date("Y-m-d", $i));
                
                if(!empty($tpl['custom_dates'][$date])){
                    $slot_lenght = $tpl['custom_dates'][$date]['slot_lenght'];
                    $price = $tpl['custom_dates'][$date]['price'];
                }else{
                    $bookedLocation = $tpl['location_booking'] ?? null;

                    switch (date('N', $i)) {
                        case '1':
                            $slot_lenght = $tpl['working_time']['monday_slot_lenght'] ?? '';
                            $price = $tpl['working_time']['monday_price'] ?? '';
                            break;
                        case '2':
                            $slot_lenght = $tpl['working_time']['tuesday_slot_lenght'] ?? '';
                            $price = $tpl['working_time']['tuesday_price'] ?? '';
                            break;
                        case '3':
                            $slot_lenght = $tpl['working_time']['wednesday_slot_lenght'] ?? '';
                            $price = $tpl['working_time']['wednesday_price'] ?? '';
                            break;
                        case '4':
                            $slot_lenght = $tpl['working_time']['thursday_slot_lenght'] ?? '';
                            $price = $tpl['working_time']['thursday_price'] ?? '';
                            break;
                        case '5':
                            $slot_lenght = $tpl['working_time']['friday_slot_lenght'] ?? '';
                            $price = $tpl['working_time']['friday_price'] ?? '';
                            break;
                        case '6':
                            $slot_lenght = $tpl['working_time']['saturday_slot_lenght'] ?? '';
                            $price = $tpl['working_time']['saturday_price'] ?? '';
                            break;
                        case '7':
                            $slot_lenght = $tpl['working_time']['sunday_slot_lenght'] ?? '';
                            $price = $tpl['working_time']['sunday_price'] ?? '';
                            break;
                    }
                }
                ?>
                <tr>
                    <td>
                        <?php echo date($tpl['option_arr_values']['date_format'], $i); ?>
                    </td>
                    <td>
                        <?php echo date($tpl['option_arr_values']['time_format'], $i); ?>
                    </td>
                    <td>
                       <?php
                        if ($bookedLocation == "outsidewholeday") { ?>
                            <?php echo date($tpl['option_arr_values']['time_format'], ($i + 360 * 60)); ?>
                        <?php } else { ?>
                            <?php echo date($tpl['option_arr_values']['time_format'], ($i + $slot_lenght * 60)); ?>
                        <?php } ?>
                    </td>
                    <td>
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $count * $price); ?>
                    </td>
                    <td>
                        <?php echo $count ?>
                    </td>
                    <td>
                        <a href="javascript:" data-date="<?php echo $date; ?>" data-start-time="<?php echo $i; ?>" class="gzRemoveTimeSlotClass fa fa-fw fa-minus-square"></a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
<?php } ?>
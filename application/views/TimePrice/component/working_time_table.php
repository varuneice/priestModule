
<?php
$currency = $tpl['option_arr_values']['currency'] ?? '';
$currencies = Util::$currencies;
?>
<div class="overlay"></div>
<div class="loading-img"></div>
<?php if (!empty($tpl['calendars'])) { ?>
    <strong><?php echo __('calendars'); ?> :</strong> 
    <div class="btn-group">
        <button type="button" class="btn btn-default btn-flat">
            <?php
            echo $tpl['default_calendar']['i18n'][$this->controller->tpl['default_language']['id']]['title'];
            ?>
        </button>
        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <?php
            foreach (($tpl['calendars'] ?? []) as $k => $v) {
                ?>
                <li><a class="slecet_employee_class" rel="<?php echo $v['id']; ?>" href="<?php echo INSTALL_URL . 'TimePrice/index/' . $v['id']; ?>"><?php echo $v['i18n'][$this->controller->tpl['default_language']['id']]['title']; ?></a></li>    
                <?php
            }
            ?>
        </ul>
    </div>
    <div class="clearfix"></div>
    <br />
<?php } ?>
<form id="frm-working-time" class="frm-class booking-frm-class" action="<?php echo INSTALL_URL . 'TimePrice/index/' . $v['id']; ?>" method="post" name="frm-working-time">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
    <table id="working-time-table-id" class="table table-responsive table-hover table-bordered" cellpadding="0" cellspacing="0" >
        <thead>
            <tr>
                <th><?php echo __('day'); ?></th>
                <th><?php echo __('tooltip'); ?></th>
                <th><?php echo __('start_time'); ?></th>
                <th><?php echo __('end_time'); ?></th>
                <th><?php echo __('lunch_from'); ?></th>
                <th><?php echo __('lunch_to'); ?></th>
                <th><?php echo __('slot_lenght'); ?></th>
                <th><?php echo __('bookings_per_slot'); ?></th>
                <th><?php echo __('price_per_slot'); ?></th>
                <th><?php echo __('is_day_off'); ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <span class="margin8">
                        <?php echo __('Monday'); ?>
                    </span>
                </td>
                <td>
                    <div class="form-group monday <?php echo (@$tpl['working_time']['monday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <input class="form-control input-sm " type="text" name="monday_tooltip" value="<?php echo @$tpl['working_time']['monday_tooltip']; ?>">
                    </div>
                </td>
                <td>
                    <div class="form-group monday <?php echo (@$tpl['working_time']['monday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="timepicker form-control input-sm left-radius" type="text" name="monday_start" value="<?php echo @$tpl['working_time']['monday_start']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group monday <?php echo (@$tpl['working_time']['monday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="monday_end" value="<?php echo @$tpl['working_time']['monday_end']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group monday <?php echo (@$tpl['working_time']['monday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="monday_lunch_start" value="<?php echo @$tpl['working_time']['monday_lunch_start']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group monday <?php echo (@$tpl['working_time']['monday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="monday_lunch_end" value="<?php echo @$tpl['working_time']['monday_lunch_end']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <select name="monday_slot_lenght" id="monday_slot_lenght" class="form-control input-sm medium monday <?php echo (@$tpl['working_time']['monday_is_day_off'] == '1') ? "not-visibility" : ""; ?>" >
                        <?php foreach (Util::$slot_lenght as $key => $value) {
                            ?>
                            <option <?php echo ($key == @$tpl['working_time']['monday_slot_lenght']) ? "selected='selected'" : ""; ?> value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <div class="monday <?php echo (@$tpl['working_time']['monday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <input class="form-control input-sm touchSpin left-radius" type="text" name="monday_count" value="<?php echo @$tpl['working_time']['monday_count']; ?>" >
                    </div>
                </td>
                <td>
                    <div class="monday <?php echo (@$tpl['working_time']['monday_is_day_off'] == '1') ? "not-visibility" : ""; ?>"> 
                        <div class="input-group">
                            <div class="input-group-addon left-radius">
                                <?php
                                echo $currencies[$currency]['symbol'];
                                ?>
                            </div>
                            <input class="form-control input-sm" type="number" onkeyup="if(this.value<0){this.value= this.value * -1}" step="0.01" min="0" name="monday_price" value="<?php echo @$tpl['working_time']['monday_price']; ?>" >
                        </div>
                        <a href="javascript:" class="customize_price" data-day="1"><?php echo __('customize'); ?></a>
                    </div>
                </td>
                <td>
                    <input <?php echo (@$tpl['working_time']['monday_is_day_off'] == '1') ? "checked='checked'" : ""; ?> type="checkbox" rel="monday" name="monday_is_day_off" value="1"  class="is_day_off"/>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="margin8">
                        <?php echo __('Tuesday'); ?>
                    </span>
                </td>
                <td>
                    <div class="form-group tuesday <?php echo (@$tpl['working_time']['tuesday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <input class="form-control input-sm " type="text" name="tuesday_tooltip" value="<?php echo @$tpl['working_time']['tuesday_tooltip']; ?>">
                    </div>
                </td>
                <td>
                    <div class="input-group tuesday <?php echo (1 == @$tpl['working_time']['tuesday_is_day_off']) ? "not-visibility" : ""; ?>">
                        <div class="form-group">
                            <div class="input-group bootstrap-timepicker">    
                                <input class="left-radius timepicker form-control input-sm" type="text" name="tuesday_start" value="<?php echo @$tpl['working_time']['tuesday_start']; ?>">
                                <div class="input-group-addon right-radius">
                                    <i class="fa fa-fw fa-clock-o"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group tuesday <?php echo (1 == @$tpl['working_time']['tuesday_is_day_off']) ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="tuesday_end" value="<?php echo @$tpl['working_time']['tuesday_end']; ?>">
                            <div class="input-group-addon  right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group tuesday <?php echo (1 == @$tpl['working_time']['tuesday_is_day_off']) ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="tuesday_lunch_start" value="<?php echo @$tpl['working_time']['tuesday_lunch_start']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group tuesday <?php echo (1 == @$tpl['working_time']['tuesday_is_day_off']) ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="tuesday_lunch_end" value="<?php echo @$tpl['working_time']['tuesday_lunch_end']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <select name="tuesday_slot_lenght" id="tuesday_slot_lenght" class="form-control input-sm medium tuesday <?php echo (@$tpl['working_time']['tuesday_is_day_off'] == '1') ? "not-visibility" : ""; ?>" >
                        <?php foreach (Util::$slot_lenght as $key => $value) {
                            ?>
                            <option <?php echo ($key == @$tpl['working_time']['tuesday_slot_lenght']) ? "selected='selected'" : ""; ?> value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <div class="tuesday <?php echo (@$tpl['working_time']['tuesday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <input class="form-control input-sm touchSpin left-radius" type="text" name="tuesday_count" value="<?php echo @$tpl['working_time']['tuesday_count']; ?>" >
                    </div>
                </td>
                <td>
                    <div class="tuesday <?php echo (@$tpl['working_time']['tuesday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group ">
                            <div class="input-group-addon left-radius">
                                <?php
                                echo $currencies[$currency]['symbol'];
                                ?>
                            </div>
                            <input class="form-control input-sm" type="number" onkeyup="if(this.value<0){this.value= this.value * -1}" step="0.01" min="0" name="tuesday_price" value="<?php echo @$tpl['working_time']['tuesday_price']; ?>" >
                        </div>
                        <a href="javascript:" class="customize_price" data-day="2"><?php echo __('customize'); ?></a>
                    </div>
                </td>
                <td>
                    <input <?php echo (@$tpl['working_time']['tuesday_is_day_off'] == '1') ? "checked='checked'" : ""; ?> type="checkbox" rel="tuesday" name="tuesday_is_day_off" value="1" class="is_day_off"/>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="margin8">
                        <?php echo __('Wednesday'); ?>
                    </span>
                </td>
                <td>
                    <div class="form-group wednesday <?php echo (@$tpl['working_time']['wednesday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <input class="form-control input-sm " type="text" name="wednesday_tooltip" value="<?php echo @$tpl['working_time']['wednesday_tooltip']; ?>">
                    </div>
                </td>
                <td>
                    <div class="input-group wednesday <?php echo (@$tpl['working_time']['wednesday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="form-group">
                            <div class="input-group bootstrap-timepicker">    
                                <input class="left-radius timepicker form-control input-sm" type="text" name="wednesday_start" value="<?php echo @$tpl['working_time']['wednesday_start']; ?>">
                                <div class="input-group-addon right-radius">
                                    <i class="fa fa-fw fa-clock-o"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group wednesday <?php echo (@$tpl['working_time']['wednesday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="wednesday_end" value="<?php echo @$tpl['working_time']['wednesday_end']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group wednesday <?php echo (@$tpl['working_time']['wednesday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="wednesday_lunch_start" value="<?php echo @$tpl['working_time']['wednesday_lunch_start']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group wednesday <?php echo (@$tpl['working_time']['wednesday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="wednesday_lunch_end" value="<?php echo @$tpl['working_time']['wednesday_lunch_end']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <select name="wednesday_slot_lenght" id="wednesday_slot_lenght" class="form-control input-sm medium wednesday <?php echo (@$tpl['working_time']['wednesday_is_day_off'] == '1') ? "not-visibility" : ""; ?>" >
                        <?php foreach (Util::$slot_lenght as $key => $value) {
                            ?>
                            <option <?php echo ($key == @$tpl['working_time']['wednesday_slot_lenght']) ? "selected='selected'" : ""; ?> value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <div class="wednesday <?php echo (@$tpl['working_time']['wednesday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <input class="form-control input-sm touchSpin left-radius" type="text" name="wednesday_count" value="<?php echo @$tpl['working_time']['wednesday_count']; ?>" >
                    </div>
                </td>
                <td>
                    <div class="wednesday <?php echo (@$tpl['working_time']['wednesday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group ">
                            <div class="input-group-addon left-radius">
                                <?php
                                echo $currencies[$currency]['symbol'];
                                ?>
                            </div>
                            <input class="form-control input-sm" type="number" onkeyup="if(this.value<0){this.value= this.value * -1}" step="0.01" min="0" name="wednesday_price" value="<?php echo @$tpl['working_time']['wednesday_price']; ?>" >
                        </div>
                        <a href="javascript:" class="customize_price" data-day="3"><?php echo __('customize'); ?></a>
                    </div>
                </td>
                <td>
                    <input <?php echo (@$tpl['working_time']['wednesday_is_day_off'] == '1') ? "checked='checked'" : ""; ?> type="checkbox" name="wednesday_is_day_off" value="1" rel="wednesday" class="is_day_off"/>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="margin8">
                        <?php echo __('Thursday'); ?>
                    </span>
                </td>
                <td>
                    <div class="form-group thursday <?php echo (@$tpl['working_time']['thursday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <input class="form-control input-sm " type="text" name="thursday_tooltip" value="<?php echo @$tpl['working_time']['thursday_tooltip']; ?>">
                    </div>
                </td>
                <td>
                    <div class="form-group thursday <?php echo (@$tpl['working_time']['thursday_is_day_off'] == '1') ? "not-visibility" : ""; ?>" >
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="thursday_start" value="<?php echo @$tpl['working_time']['thursday_start']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group thursday <?php echo (@$tpl['working_time']['thursday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="thursday_end" value="<?php echo @$tpl['working_time']['thursday_end']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group thursday <?php echo (@$tpl['working_time']['thursday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="thursday_lunch_start" value="<?php echo @$tpl['working_time']['thursday_lunch_start']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group thursday <?php echo (@$tpl['working_time']['thursday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="thursday_lunch_end" value="<?php echo @$tpl['working_time']['thursday_lunch_end']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <select name="thursday_slot_lenght" id="thursday_slot_lenght" class="form-control input-sm medium thursday <?php echo (@$tpl['working_time']['thursday_is_day_off'] == '1') ? "not-visibility" : ""; ?>" >
                        <?php foreach (Util::$slot_lenght as $key => $value) {
                            ?>
                            <option <?php echo ($key == @$tpl['working_time']['thursday_slot_lenght']) ? "selected='selected'" : ""; ?> value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <div class="thursday <?php echo (@$tpl['working_time']['thursday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <input class="form-control input-sm touchSpin left-radius" type="text" name="thursday_count" value="<?php echo @$tpl['working_time']['thursday_count']; ?>" >
                    </div>
                </td>
                <td>
                    <div class="thursday <?php echo (@$tpl['working_time']['thursday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group ">
                            <div class="input-group-addon left-radius">
                                <?php
                                echo $currencies[$currency]['symbol'];
                                ?>
                            </div>
                            <input class="form-control input-sm" type="number" onkeyup="if(this.value<0){this.value= this.value * -1}" step="0.01" min="0" name="thursday_price" value="<?php echo @$tpl['working_time']['thursday_price']; ?>" >
                        </div>
                        <a href="javascript:" class="customize_price" data-day="4"><?php echo __('customize'); ?></a>
                    </div>
                </td>
                <td>
                    <input <?php echo (@$tpl['working_time']['thursday_is_day_off'] == '1') ? "checked='checked'" : ""; ?> type="checkbox" name="thursday_is_day_off" value="1" rel="thursday" class="is_day_off"/>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="margin8">
                        <?php echo __('Friday'); ?>
                    </span>
                </td>
                <td>
                    <div class="form-group friday <?php echo (@$tpl['working_time']['friday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <input class="form-control input-sm " type="text" name="friday_tooltip" value="<?php echo @$tpl['working_time']['friday_tooltip']; ?>">
                    </div>
                </td>
                <td>
                    <div class="form-group friday <?php echo (@$tpl['working_time']['friday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="friday_start" value="<?php echo @$tpl['working_time']['friday_start']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group friday <?php echo (@$tpl['working_time']['friday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="friday_end" value="<?php echo @$tpl['working_time']['friday_end']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group friday <?php echo (@$tpl['working_time']['friday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="friday_lunch_start" value="<?php echo @$tpl['working_time']['friday_lunch_start']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group friday <?php echo (@$tpl['working_time']['friday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="friday_lunch_end" value="<?php echo @$tpl['working_time']['friday_lunch_end']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <select name="friday_slot_lenght" id="friday_slot_lenght" class="form-control input-sm medium friday <?php echo (@$tpl['working_time']['friday_is_day_off'] == '1') ? "not-visibility" : ""; ?>" >
                        <?php foreach (Util::$slot_lenght as $key => $value) {
                            ?>
                            <option <?php echo ($key == @$tpl['working_time']['friday_slot_lenght']) ? "selected='selected'" : ""; ?> value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <div class="friday <?php echo (@$tpl['working_time']['friday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <input class="form-control input-sm touchSpin left-radius" type="text" name="friday_count" value="<?php echo @$tpl['working_time']['friday_count']; ?>" >
                    </div>
                </td>
                <td>
                    <div class=" friday <?php echo (@$tpl['working_time']['friday_is_day_off'] == '1') ? "not-visibility" : ""; ?>"> 
                        <div class="input-group ">
                            <div class="input-group-addon left-radius">
                                <?php
                                echo $currencies[$currency]['symbol'];
                                ?>
                            </div>
                            <input class="form-control input-sm" type="number" onkeyup="if(this.value<0){this.value= this.value * -1}" step="0.01" min="0" name="friday_price" value="<?php echo @$tpl['working_time']['friday_price']; ?>" >
                        </div>
                        <a href="javascript:" class="customize_price" data-day="5"><?php echo __('customize'); ?></a>
                    </div>
                </td>
                <td>
                    <input <?php echo (@$tpl['working_time']['friday_is_day_off'] == '1') ? "checked='checked'" : ""; ?> type="checkbox" name="friday_is_day_off" value="1" rel="friday" class="is_day_off"/>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="margin8">
                        <?php echo __('Saturday'); ?>
                    </span>
                </td>
                <td>
                    <div class="form-group saturday <?php echo (@$tpl['working_time']['saturday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <input class="form-control input-sm " type="text" name="saturday_tooltip" value="<?php echo @$tpl['working_time']['saturday_tooltip']; ?>">
                    </div>
                </td>
                <td>
                    <div class="form-group saturday <?php echo (@$tpl['working_time']['saturday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="saturday_start" value="<?php echo @$tpl['working_time']['saturday_start']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group saturday <?php echo (@$tpl['working_time']['saturday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="saturday_end" value="<?php echo @$tpl['working_time']['saturday_end']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group saturday <?php echo (@$tpl['working_time']['saturday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="saturday_lunch_start" value="<?php echo @$tpl['working_time']['saturday_lunch_start']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group saturday <?php echo (@$tpl['working_time']['saturday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="saturday_lunch_end" value="<?php echo @$tpl['working_time']['saturday_lunch_end']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <select name="saturday_slot_lenght" id="saturday_slot_lenght" class="form-control input-sm medium saturday <?php echo (@$tpl['working_time']['saturday_is_day_off'] == '1') ? "not-visibility" : ""; ?>" >
                        <?php foreach (Util::$slot_lenght as $key => $value) {
                            ?>
                            <option <?php echo ($key == @$tpl['working_time']['saturday_slot_lenght']) ? "selected='selected'" : ""; ?> value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <div class="saturday <?php echo (@$tpl['working_time']['saturday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <input class="form-control input-sm touchSpin left-radius" type="text" name="saturday_count" value="<?php echo @$tpl['working_time']['saturday_count']; ?>" >
                    </div>
                </td>
                <td>
                    <div class="saturday <?php echo (@$tpl['working_time']['saturday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group">
                            <div class="input-group-addon left-radius">
                                <?php
                                echo $currencies[$currency]['symbol'];
                                ?>
                            </div>
                            <input class="form-control input-sm" type="number" onkeyup="if(this.value<0){this.value= this.value * -1}" step="0.01" min="0" name="saturday_price" value="<?php echo @$tpl['working_time']['saturday_price']; ?>" >
                        </div>
                        <a href="javascript:" class="customize_price" data-day="6"><?php echo __('customize'); ?></a>
                    </div>
                </td>
                <td>
                    <input <?php echo (@$tpl['working_time']['saturday_is_day_off'] == '1') ? "checked='checked'" : ""; ?> type="checkbox" name="saturday_is_day_off" value="1" rel="saturday" class="is_day_off"/>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="margin8">
                        <?php echo __('Sunday'); ?>
                    </span>
                </td>
                <td>
                    <div class="form-group sunday <?php echo (@$tpl['working_time']['sunday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <input class="form-control input-sm " type="text" name="sunday_tooltip" value="<?php echo @$tpl['working_time']['sunday_tooltip']; ?>">
                    </div>
                </td>
                <td>
                    <div class="form-group sunday <?php echo (@$tpl['working_time']['sunday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="sunday_start" value="<?php echo @$tpl['working_time']['sunday_start']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group sunday <?php echo (@$tpl['working_time']['sunday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="sunday_end" value="<?php echo @$tpl['working_time']['sunday_end']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group sunday <?php echo (@$tpl['working_time']['sunday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="sunday_lunch_start" value="<?php echo @$tpl['working_time']['sunday_lunch_start']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group sunday <?php echo (@$tpl['working_time']['sunday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group bootstrap-timepicker">    
                            <input class="left-radius timepicker form-control input-sm" type="text" name="sunday_lunch_end" value="<?php echo @$tpl['working_time']['sunday_lunch_end']; ?>">
                            <div class="input-group-addon right-radius">
                                <i class="fa fa-fw fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <select name="sunday_slot_lenght" id="sunday_slot_lenght" class="form-control input-sm medium sunday <?php echo (@$tpl['working_time']['sunday_is_day_off'] == '1') ? "not-visibility" : ""; ?>" >
                        <?php foreach (Util::$slot_lenght as $key => $value) {
                            ?>
                            <option <?php echo ($key == @$tpl['working_time']['sunday_slot_lenght']) ? "selected='selected'" : ""; ?> value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <div class="sunday <?php echo (@$tpl['working_time']['sunday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <input class="form-control input-sm touchSpin left-radius" type="text" name="sunday_count" value="<?php echo @$tpl['working_time']['sunday_count']; ?>" >
                    </div>
                </td>
                <td>
                    <div class="sunday <?php echo (@$tpl['working_time']['sunday_is_day_off'] == '1') ? "not-visibility" : ""; ?>">
                        <div class="input-group">
                            <div class="input-group-addon left-radius">
                                <?php
                                echo $currencies[$currency]['symbol'];
                                ?>
                            </div>
                            <input class="form-control input-sm" type="number" onkeyup="if(this.value<0){this.value= this.value * -1}" step="0.01" min="0" name="sunday_price" value="<?php echo @$tpl['working_time']['sunday_price']; ?>" >
                        </div>
                        <a href="javascript:" class="customize_price" data-day="7"><?php echo __('customize'); ?></a>
                    </div>
                </td>
                <td>
                    <input <?php echo (@$tpl['working_time']['sunday_is_day_off'] == '1') ? "checked='checked'" : ""; ?> type="checkbox" name="sunday_is_day_off" value="1" rel="sunday" class="is_day_off"/>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6">
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button>
                </td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="workin_time_send" value="1" /> 
    <input type="hidden" name="id" value="<?php echo @$tpl['working_time']['id']; ?>" /> 
    <input type="hidden" name="calendar_id" id="calendar_id" value="<?php echo $tpl['default_calendar']['id'] ?? ''; ?>" /> 
</form>
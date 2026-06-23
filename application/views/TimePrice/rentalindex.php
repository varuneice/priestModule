<style>
  #working-time-table-id1{
     overflow-y: scroll; 
     height: 254px; 
    display: block;

} 
</style> 

<section class="content-header">
    <h1>
        <?php echo __('title_price'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li class="active"><?php echo __('title_price'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<section class="content left width_100">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#tab_2"><?php echo __('custom_time'); ?></a>
            </li>
        </ul>
        <div class="tab-content" style="float: left; width: 100%;">
            <div id="tab_2" class="tab-pane active">
                <form name="custom-price-plan" id="custom-prce-plan-id" action="" method="post">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="working-time-table-id1" class="table table-responsive table-hover table-bordered" cellpadding="0" cellspacing="0" >
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div style="width: 100px;">
                                                <select name="calendar_id" id="calendar_id" class="form-control input-sm medium" >
                                                    <?php
                                                    foreach (($tpl['calendars'] ?? []) as $key => $value) {
                                                        ?>
                                                        <option value="<?php echo $value['id']; ?>">
                                                            <?php echo $value['i18n'][$this->controller->tpl['default_language']['id']]['title']; ?>
                                                        </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="margin8">
                                                <div class="input-group" style="width: 110px !important;">    
                                                    <input class="datepicker form-control input-sm left-radius" style="width: 95px !important;" type="text" name="timestamp" value="" data-date-format="<?php echo $tpl['bootsrap_format'] ?? ''; ?>" first-day="<?php echo $tpl['option_arr_values']['week_first_day'] ?? ''; ?>">
                                                    <div class="input-group-addon right-radius">
                                                        <i class="fa fa-fw fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="margin8">
                                                <div class="input-group" style="width: 110px !important;">    
                                                    <input class="datepicker form-control input-sm left-radius"  style="width: 95px !important;" type="text" name="timestamp_end" value="" data-date-format="<?php echo $tpl['bootsrap_format'] ?? ''; ?>" first-day="<?php echo $tpl['option_arr_values']['week_first_day'] ?? ''; ?>">
                                                    <div class="input-group-addon right-radius">
                                                        <i class="fa fa-fw fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input class="form-control input-sm medium" type="text" name="tooltip" value="">
                                        </td>
                                        <td>
                                            <div class="input-group bootstrap-timepicker " >    
                                                <input class="timepicker form-control input-sm left-radius input-sm medium" type="text" name="start" value="" id="customstarttime">
                                                <div class="input-group-addon right-radius">
                                                    <i class="fa fa-fw fa-clock-o"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="margin8">
                                                <div class="input-group bootstrap-timepicker">    
                                                    <input class="left-radius timepicker form-control input-sm medium" type="text" name="end" value="" id="customendtime">
                                                    <div class="input-group-addon right-radius">
                                                        <i class="fa fa-fw fa-clock-o"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="margin8">
                                                <div class="input-group bootstrap-timepicker">    
                                                    <input class="left-radius timepicker form-control input-sm medium" type="text" name="lunch_start" value="" id="customlunch_start">
                                                    <div class="input-group-addon right-radius">
                                                        <i class="fa fa-fw fa-clock-o"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="margin8">
                                                <div class="input-group bootstrap-timepicker">    
                                                    <input class="left-radius timepicker form-control input-sm medium" type="text" name="lunch_end" value="" id="customlunch_end">
                                                    <div class="input-group-addon right-radius">
                                                        <i class="fa fa-fw fa-clock-o"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <select name="slot_lenght" id="slot_lenght" class="form-control input-sm medium" >
                                                <?php foreach (Util::$slot_lenght as $key => $value) {
                                                    ?>
                                                     <!-- <option value="" >Select slot</option> -->
                                                    <option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="margin8">
                                                <input class="form-control input-sm touchSpin left-radius" type="text" name="count" value="" >
                                            </div>
                                        </td>
                                        <td style="width: 130px;">
                                            <div class="margin8"> 
                                                <div class="input-group">
                                                    <div class="input-group-addon left-radius">
                                                        <?php
                                                        echo Util::getCurrensySimbol($tpl['option_arr_values']['currency'] ?? '');
                                                        ?>
                                                    </div>
                                                    <input class="form-control input-sm medium" type="number" onkeyup="if(this.value<0){this.value= this.value * -1}" step="0.01" min="0" name="price" value="<?php echo @$value['price']; ?>" id="customepricetime">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="is_day_off" value="1"  class="is_day_off"/>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <a id="add-time-id" class="btn btn-primary" ><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('add'); ?></a>
                        </div>
                    </div>
                    <br />
                    <br />
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="custom-prices-container-id">
                             <?php require 'component/custom_time_price_rentaltable.php'; ?>
                            </div>
                        </div>
                    </div>    
                </form>
            </div>
        </div>
    </div>
</section>
<div id="record_id" style="display:none"></div>
<div id="dialogSetCustomPrice" title="<?php echo __('set_custom_price'); ?>" style="display:none">
    <div id="set_custom_price_id"></div>
</div>
<div id="dialogDelete" title="<?php echo htmlspecialchars(__('time_del_title')); ?>" style="display:none">
    <p><?php echo __('time_del_body'); ?></p>
</div>
<div id="dialogEditCustomTime" title="<?php echo htmlspecialchars(__('Edit_Discount')); ?>" style="display:none">
</div>
<script>
    $(document).ready(function() {
            $("#customstarttime").val("");
            $("#customendtime").val("");
            $("#customlunch_start").val("");
            $("#customlunch_end").val("");
            $("#slot_lenght").val("");
            $("#customepricetime").val("");
           
 });
</script>

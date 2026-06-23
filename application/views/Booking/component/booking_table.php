<style>
    .box{
    overflow-x:auto!important;
}
    </style>
<div class="overlay"></div>
<div class="loading-img"></div>
<table id="<?php echo (count($tpl['arr'])) ? "gzhotel-booking-booking-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
            <th class="">
                <input class="simple" type="checkbox" name="mark-all" id="mark-all-id" value="all"/>
            </th>
            <th><?php echo __('booking_number'); ?></th>
             <th><?php echo __('Date'); ?></th>
            <th><?php echo __('Slot'); ?></th>
            <th><?php echo __('Member Id'); ?></th>
            <th class="title-th"><?php echo __('client_name'); ?></th>
            <th><?php echo __('amount'); ?></th>
            <th><?php echo __('Puja Type'); ?></th>
            <th><?php echo __('Location'); ?></th>
            <th><?php echo __('Email'); ?></th>
            <th><?php echo __('Phone'); ?></th>
            <th><?php echo __('label_status'); ?></th>
           
            <th class="icon-th"></th>
            <th class="icon-th"></th>
            <th class="icon-th"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['arr']);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $slot = $tpl['arr'][$i]['slots'];
                $arr = explode(" ", $slot[0] ?? '');
                ?>
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td>
                        <input class="simple mark" type="checkbox" name="mark[]"  id="mark-<?php echo $tpl['arr'][$i]['id']; ?>" value="<?php echo $tpl['arr'][$i]['id']; ?>"/>
                    </td>
                    <td><?php echo $tpl['arr'][$i]['booking_number']; ?></td>
                    <!-- <td><?php echo @implode('<br />', $tpl['arr'][$i]['slots']); ?></td>-->
                    <td><?php echo $arr[0] ?? ''; ?></td>
                    <td><?php echo $arr[1] ?? ''; ?></td>
                    <td><?php echo $tpl['arr'][$i]['Member_id']; ?></td>
                    <td><?php echo $tpl['arr'][$i]['first_name'] . ' ' . $tpl['arr'][$i]['second_name']; ?></td>
                    <td><?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['arr'][$i]['total']); ?></td>
                    <td><?php echo $tpl['arr'][$i]['promo_code']; ?></td>
                    <td><?php echo $tpl['arr'][$i]['location']; ?></td>
                    <td><?php echo $tpl['arr'][$i]['email']; ?></td>
                    <td><?php echo $tpl['arr'][$i]['phone']; ?></td>


                    <td>
                        <span class="label label-<?php echo $tpl['arr'][$i]['status']; ?>">
                             <?php echo $status_arr[$tpl['arr'][$i]['status']] ?? ''; ?>
                        </span>
                    </td>
                    <td><a class="btn btn-primary btn-sm" href="<?php echo INSTALL_URL; ?>Booking/send/<?php echo $tpl['arr'][$i]['id']; ?>"><span class="glyphicon glyphicon-envelope"></span></a></td>
                    <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Booking/edit/<?php echo $tpl['arr'][$i]['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td><a cat="1" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['arr'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>Booking/delete/<?php echo $tpl['arr'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="9">
                    <?php
                    echo __('no_booking');
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="9">
                <div class="btn-group" style="margin-left:8%;">
                    <button type="button" class="btn btn-primary btn-flat"><?php echo __('action'); ?></button>
                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo INSTALL_URL ?>Booking/export"><?php echo __('export'); ?></a></li>
                        <li class="divider"></li>
                        <li><a id="delete-selected-id" href="javascript:;"><?php echo __('delete_selected'); ?></a></li>
                        <li class="divider"></li>
                    </ul>
                </div>
            </td>
        </tr>
    </tfoot>
</table>
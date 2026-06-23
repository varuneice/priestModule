<div class="overlay"></div>
<div class="loading-img"></div>
<table id="<?php echo (count($tpl['arr'])) ? "gzhotel-booking-invoice-id" : ""; ?>" class="gzblog-table" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
            <th class="">
                <input class="simple" type="checkbox" name="mark-all" id="mark-all-id" value="all"/>
            </th>
            <th><?php echo __('invoice_number'); ?></th>
            <th><?php echo __('booking_number'); ?></th>
            <th class="title-th"><?php echo __('client_name'); ?></th>
            <th><?php echo __('amount'); ?></th>
            <th><?php echo __('label_status'); ?></th>
            <th class="icon-th"></th>
            <th class="icon-th"></th>
            <th class="icon-th"></th>
            <th class="icon-th"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['arr']);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                ?>
                <tr  class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td>
                        <input class="simple mark" type="checkbox" name="mark[]"  id="mark-<?php echo $tpl['arr'][$i]['id']; ?>" value="<?php echo $tpl['arr'][$i]['id']; ?>"/>
                    </td>
                    <td>#<?php echo $tpl['arr'][$i]['invoice_number'] ?></td>
                    <td><?php echo $tpl['arr'][$i]['booking_number'] ?></td>
                    <td><?php echo $tpl['arr'][$i]['first_name'] . ' ' . $tpl['arr'][$i]['second_name']; ?></td>
                    <td><?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['arr'][$i]['total']); ?></td>
                    <td><?php 
                    $status_arr = __('status_arr');
                    echo $status_arr[$tpl['arr'][$i]['status'] ?? ''] ?? '';
                    ?></td>
                    <td><a class="btn btn-primary btn-sm" href="<?php echo INSTALL_URL; ?>Invoice/viewInvoice/<?php echo $tpl['arr'][$i]['id']; ?>" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                    <td><a class="btn btn-primary btn-sm" href="<?php echo INSTALL_URL; ?>Invoice/sendEmail/<?php echo $tpl['arr'][$i]['id']; ?>" target="_blank"><span class="glyphicon glyphicon-envelope"></span></span></a></td>
                    <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Invoice/edit/<?php echo $tpl['arr'][$i]['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td><a class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['arr'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>Invoice/delete/<?php echo $tpl['arr'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="11">
                    <?php
                    echo __('no_invoice');
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="11">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-flat"><?php echo __('action'); ?></button>
                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a id="delete-selected-id" href="javascript:;"><?php echo __('delete_selected'); ?></a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo INSTALL_URL; ?>Invoice/create"><?php echo __('add_invoice'); ?></a></li>
                    </ul>
                </div>
            </td>
        </tr>
    </tfoot>
</table>
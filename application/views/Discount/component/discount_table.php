<div class="overlay"></div>
<div class="loading-img"></div>
<table id="gzhotel-booking-discount-id" class="gzblog-table" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
            <th><?php echo __('title'); ?></th>
            <th><?php echo __('calendar'); ?></th>
            <th><?php echo __('promo_code'); ?></th>
            <th><?php echo __('discount'); ?></th>
            <th><?php echo __('type'); ?></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($tpl['discounts']) > 0) {
            foreach (($tpl['discounts'] ?? []) as $k => $v) {
                ?>
                <tr>
                    <td><?php echo $v['discount_title']; ?></td>
                    <td><?php echo $v['calendar']['i18n'][$this->controller->tpl['default_language']['id']]['title']; ?></td>
                    <td><?php echo $v['promo_code']; ?></td>
                    <td><?php echo ($v['type'] == 'price') ? Util::currenctFormat($tpl['option_arr_values']['currency'], $v['discount']) : $v['discount'] . ' %'; ?></td>
                    <td><?php echo $v['type']; ?></td>
                    <td><a class="btn btn-default btn-sm icon-edit" href="<?php echo $_SERVER['PHP_SELF']; ?>Discount/edit/<?php echo $v['id']; ?>" rev="<?php echo $v['id']; ?>" rel="<?php echo $v['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td><a class="btn btn-default btn-sm icon-delete" rev="<?php echo $v['id']; ?>" href="<?php echo $_SERVER['PHP_SELF']; ?>Discount/delete/<?php echo $v['id']; ?>" rel="<?php echo $v['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="8">
                <button id="add_discount_id" class="btn btn-default btn-flat"><?php echo __('Add_Discount'); ?></button>
            </td>
        </tr>
    </tfoot>
</table>
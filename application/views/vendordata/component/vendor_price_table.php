<div class="overlay"></div>
<div class="loading-img"></div>
<table id="vendor-price-table-id" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th>
                <?php echo __('Payment For'); ?>
            </th>
            <th>
                <?php echo __('Type'); ?>
            </th>
            <th>
                <?php echo __('price'); ?>
            </th>
            <th class="icon-th"></th>
            <th class="icon-th"></th>

        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['vendorpricearr']);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $payfor = $tpl['vendorpricearr'][$i]['paymentfor'];
                if ($payfor == 'BOOTH') {
                    $payforui = 'Booth Rentals';
                } else if ($payfor == 'MAGADV') {
                    $payforui = 'Magazine Advertisements';
                } else if ($payfor == 'OTHADV') {
                    $payforui = 'Other Advertisements';
                }
                else{
                    $payforui  = $tpl['vendorpricearr'][$i]['paymentfor'];
                }

                ?>
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td>
                        <?php echo $payforui; ?>
                    </td>
                    <td>
                        <?php echo $tpl['vendorpricearr'][$i]['type']; ?>
                    </td>
                   <td>
                        <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'],$tpl['vendorpricearr'][$i]['price']); ?>
                    </td>

                    <td><a class="btn btn-success btn-sm"
                            href="<?php echo INSTALL_URL; ?>vendordata/vendorpriceedit/<?php echo $tpl['vendorpricearr'][$i]['id']; ?>"
                            rev="<?php echo $tpl['vendorpricearr'][$i]['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td><a cat="2" class="btn btn-danger btn-sm icon-delete"
                            rev="<?php echo $tpl['vendorpricearr'][$i]['id']; ?>"
                            href="<?php echo INSTALL_URL; ?>vendordata/delete/<?php echo $tpl['vendorpricearr'][$i]['id']; ?>"><span
                                class="glyphicon glyphicon-remove"></span></a></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="9">
                    <?php
                    echo __('No matching records found');
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="9" style="display:none">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-flat">
                        <?php echo __('action'); ?>
                    </button>
                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo INSTALL_URL ?>Category/export"><?php echo __('export'); ?></a></li>
                        <li class="divider" style="display:none;"></li>
                        <li style="display:none;"><a id="delete-selected-id" href="javascript:;">
                                <?php echo __('delete_selected'); ?>
                            </a></li>
                        <li class="divider" style="display:none;"></li>
                        <li style="display:none;"><a href="<?php echo INSTALL_URL; ?>Member/create"><?php echo __('add_members'); ?></a></li>
                    </ul>
                </div>
            </td>
        </tr>
    </tfoot>
</table>
<script>
    if ($('#vendor-price-table-id').length > 0) {
        $('#vendor-price-table-id').dataTable({
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [1, 3] }
            ]
        });
    }
</script>
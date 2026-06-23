<div class="overlay"></div>
<div class="loading-img"></div>
<table id="<?php echo (count($tpl['benefactors'])) ? "tab-3-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
            <th><?php echo __('Member id'); ?></th>
            <th><?php echo __('Member Name'); ?></th>
            <th class="title-th"><?php echo __('Spouse Name'); ?></th>
            <th class="title-th"><?php echo __('Category'); ?></th>
            <th><?php echo __('Tele1'); ?></th>
            <th><?php echo __('Email'); ?></th>
            <th><?php echo __('Pay Date'); ?></th>
             <th><?php echo __('OID'); ?></th>
            <th><?php echo __('Annual Maintenance'); ?></th>
             <th><?php echo __('LTC'); ?></th>
            <th><?php echo __('YTD'); ?></th>
            <th class="icon-th"></th>
            <th class="icon-th"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['benefactors']);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                ?>
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td><?php echo $tpl['benefactors'][$i]['Member_id']; ?></td>
                   <td><?php echo ($tpl['benefactors'][$i]['F_Name'] ?? '').' '.($tpl['benefactors'][$i]['M_Name'] ?? '').' '.($tpl['benefactors'][$i]['L_Name'] ?? ''); ?></td>
                    <td><?php echo ($tpl['benefactors'][$i]['Sp_FName'] ?? '').' '.($tpl['benefactors'][$i]['Sp_LName'] ?? ''); ?></td>
                    <td><?php echo $tpl['benefactors'][$i]['Category']; ?></td>
                    <td><?php echo $tpl['benefactors'][$i]['Tele1']; ?></td>
                    <td><?php echo $tpl['benefactors'][$i]['email']; ?></td>
                    <td><?php echo $tpl['benefactors'][$i]['pay_date']; ?></td>
                     <td><?php echo $tpl['benefactors'][$i]['oid']; ?></td>
                    <td><?php echo $tpl['benefactors'][$i]['AMC']; ?></td>
                    <td><?php echo $tpl['benefactors'][$i]['LTC']; ?></td>
                    <td><?php echo $tpl['benefactors'][$i]['YTD']; ?></td>
                    <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Member/adminedit/<?php echo $tpl['benefactors'][$i]['ID']; ?>" rev="<?php echo $tpl['benefactors'][$i]['ID']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <?php if ($this->controller->isAdmin())  { ?>
                    <td><a cat="3" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['benefactors'][$i]['ID']; ?>" href="<?php echo INSTALL_URL; ?>Member/delete/<?php echo $tpl['benefactors'][$i]['ID']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                <?php }?>
                     <?php if (!$this->controller->isAdmin() )  { ?>
                    <td><a cat="3" rev="<?php echo $tpl['benefactors'][$i]['ID']; ?>" href=""><span></span></a></td>
                    <?php }?>
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
            <td colspan="9">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-flat"><?php echo __('action'); ?></button>
                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo INSTALL_URL ?>Member/export/BF"><?php echo __('export'); ?></a></li>
                        <li class="divider" style="display:none;"></li>
                        <li style="display:none;"><a id="delete-selected-id" href="javascript:;"><?php echo __('delete_selected'); ?></a></li>
                        <li class="divider" style="display:none;"></li>
                        <li style="display:none;"><a href="<?php echo INSTALL_URL; ?>Member/create"><?php echo __('add_members'); ?></a></li>
                    </ul>
                </div>
            </td>
        </tr>
    </tfoot>
</table> 
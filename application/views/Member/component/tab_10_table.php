<div class="overlay"></div>
<div class="loading-img"></div>
<table id="<?php echo (count($tpl['inactiveMembers'])) ? "tab-10-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
            <th><?php echo __('Member id'); ?></th>
           <th><?php echo __('Member Name'); ?></th>
            <th class="title-th"><?php echo __('Spouse Name'); ?></th>
            <th class="title-th"><?php echo __('Category'); ?></th>
            <th><?php echo __('Tele1'); ?></th>
            <th><?php echo __('Email'); ?></th>
            <th><?php echo __('Active'); ?></th>
            <th class="icon-th" style="display:none;"></th>
            <th class="icon-th" style="display:none;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['inactiveMembers']);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                ?>
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td><?php echo $tpl['inactiveMembers'][$i]['Member_id']; ?></td>
                    <td><?php echo ($tpl['inactiveMembers'][$i]['F_Name'] ?? ''). ' ' . ($tpl['inactiveMembers'][$i]['M_Name'] ?? '') . ' ' . ($tpl['inactiveMembers'][$i]['L_Name'] ?? ''); ?></td>
                    <td><?php echo ($tpl['inactiveMembers'][$i]['Sp_FName'] ?? '').' '.($tpl['inactiveMembers'][$i]['Sp_LName'] ?? '');?></td>
                    <td><?php echo $tpl['inactiveMembers'][$i]['Category']; ?></td>
                    <td><?php echo $tpl['inactiveMembers'][$i]['Tele1']; ?></td>
                    <td><?php echo $tpl['inactiveMembers'][$i]['email']; ?></td>
                    <td><?php echo $tpl['inactiveMembers'][$i]['Active']; ?></td>
                    <td style="display:none;"><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Member/adminedit/<?php echo $tpl['inactiveMembers'][$i]['ID']; ?>" rev="<?php echo $tpl['inactiveMembers'][$i]['ID']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td style="display:none;"><a cat="9" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['inactiveMembers'][$i]['ID']; ?>" href="<?php echo INSTALL_URL; ?>Member/delete/<?php echo $tpl['inactiveMembers'][$i]['ID']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td> 
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
                        <li><a href="<?php echo INSTALL_URL ?>Member/export/inactiveMembers"><?php echo __('export'); ?></a></li>
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
<script>
    if ($('#tab-10-table-id').length > 0) {
            $('#tab-10-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 7]}
                ]
            });
        }
    </script>

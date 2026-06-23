<style>
 @media only screen and (max-width: 499px){
		 .right-side {
              margin-left:0px!important;
             }
	}
		@media (min-width: 500px) and (max-width: 767px) {
			.right-side {
              margin-left:0px!important;
             }
		}

		@media (min-width: 768px) and (max-width: 830px) {
            .right-side {
              margin-left:0px!important;
             }
		}

		@media(min-width: 831px) and (max-width: 990px) {
			.right-side {
              margin-left:0px!important;
             }
		}	

 </style>
<div class="overlay"></div>
<div class="loading-img"></div>
<table id="<?php echo (count($tpl['active'])) ? "tab-1-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
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
            <th><?php echo __('Annual Membership'); ?></th>
            <th><?php echo __('LTC'); ?></th>
            <th><?php echo __('YTD'); ?></th>
            <th class="icon-th"></th>
            <th class="icon-th"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['active']);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                                $name = ($tpl['active'][$i]['F_Name'] ?? '').' '.($tpl['active'][$i]['M_Name'] ?? '').' '.($tpl['active'][$i]['L_Name'] ?? '');
                ?>
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td><?php echo $tpl['active'][$i]['Member_id']; ?></td>
                    <td><?php echo $name; ?></td>
                    <td><?php echo ($tpl['active'][$i]['Sp_FName'] ?? '').' '.($tpl['active'][$i]['Sp_LName'] ?? ''); ?></td>
                    <td><?php echo $tpl['active'][$i]['Category']; ?></td>
                    <td><?php echo $tpl['active'][$i]['Tele1']; ?></td>
                    <td><?php echo $tpl['active'][$i]['email']; ?></td>
                    <td><?php echo $tpl['active'][$i]['pay_date']; ?></td>
                    <td><?php echo $tpl['active'][$i]['oid']; ?></td>
                    <td><?php echo $tpl['active'][$i]['ARC']; ?></td>
                    <td><?php echo $tpl['active'][$i]['LTC']; ?></td>
                    <td><?php echo $tpl['active'][$i]['YTD']; ?></td>
                    <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Member/adminedit/<?php echo $tpl['active'][$i]['ID']; ?>" rev="<?php echo $tpl['active'][$i]['ID']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <?php if ($this->controller->isAdmin())  { ?>
                    <td><a cat="1" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['active'][$i]['ID']; ?>" href="<?php echo INSTALL_URL; ?>Member/delete/<?php echo $tpl['active'][$i]['ID']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                    <?php }?>
                     <?php if (!$this->controller->isAdmin() )  { ?>
                    <td><a cat="1" rev="<?php echo $tpl['active'][$i]['ID']; ?>" href=""><span></span></a></td>
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
                        <li><a href="<?php echo INSTALL_URL ?>Member/export/GM"><?php echo __('export'); ?></a></li>
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
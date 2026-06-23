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
<div>
<table id="<?php echo (count($tpl['arr'])) ? "vendor_tab_data" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
            <th style="display:none;"><?php echo __('ID'); ?></th> 
            <th><?php echo __('Requested Date'); ?></th>
            <th><?php echo __('Owner Name'); ?></th>
            <th><?php echo __('Business Name'); ?></th>
            <th><?php echo __('Phone'); ?></th>
            <th><?php echo __('Email'); ?></th>
            <th><?php echo __('Payment For'); ?></th>
            <th><?php echo __('Order Id'); ?></th>
            <th><?php echo __('Amount'); ?></th>
            <th><?php echo __('Total Amount'); ?></th>
            <th><?php echo __('Status'); ?></th>
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
                $statusactive = $tpl['arr'][$i]['status'];
                $requestdate =  $tpl['arr'][$i]['update_on'] ?? '';
               $newrequestdate = explode(" ",$requestdate);
                $datadesc = $tpl['arr'][$i]['id'];
                
                $paytype = $tpl['arr'][$i]['paytype'];
                if($paytype == "BOOTH"){$finalpaytype = "Booth Rentals";}
                elseif($paytype == "MAGADV"){ $finalpaytype = "Magazine Advertisements";}
                elseif($paytype == "OTHADV"){ $finalpaytype = "Other Advertisements";}
                else{ $finalpaytype = $tpl['arr'][$i]['paytype'];}

                ?>
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td style="display:none;"><?php echo $datadesc; ?></td> 
                    <td><?php echo $newrequestdate[0]; ?></td>
                    <td><?php echo $tpl['arr'][$i]['ownername']; ?></td>
                    <td><?php echo $tpl['arr'][$i]['businessname']; ?></td>
                    <td><?php echo $tpl['arr'][$i]['phone']; ?></td>
                    <td><?php echo $tpl['arr'][$i]['email']; ?></td>
                    <td><?php echo $finalpaytype; ?></td>
                    <td><?php echo $tpl['arr'][$i]['oid']; ?></td>
                   <td><?php echo Util::currenctFormat($tpl['option_arr_values']['currency'],$tpl['arr'][$i]['item_cost']); ?></td>
                    <td><?php echo Util::currenctFormat($tpl['option_arr_values']['currency'],$tpl['arr'][$i]['amount']); ?></td>
                    <td>
                        <?php if ($statusactive != 'Active' && $statusactive != 'confirmed')  { ?>
                        <span class="label label-pending"><?php echo $tpl['arr'][$i]['status']; ?></span>
                        <?php } ?> 
                        <?php if ($statusactive == 'confirmed')  { ?>
                        <span class="label label-confirmed"><?php echo "Paid"; ?></span>
                        <?php } ?> 
                        <?php if ($statusactive == 'Active')  { ?>
                        <span class="label label-confirmed"><?php echo $tpl['arr'][$i]['status']; ?></span> 
                        <?php } ?> 
                    </td>
                    <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>vendordata/edit/<?php echo $tpl['arr'][$i]['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td><a cat="1" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['arr'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>vendordata/delete/<?php echo $tpl['arr'][$i]['uid'] ?? $tpl['arr'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
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
                        <li><a href="<?php echo INSTALL_URL ?>vendordata/export"><?php echo __('export'); ?></a></li>
                        <li class="divider" style = "display:none;"></li>
                        <li style = "display:none;"><a id="delete-selected-id" href="javascript:;"><?php echo __('delete_selected'); ?></a></li>
                        <li class="divider" style = "display:none;"></li>
                    </ul>
                </div>
            </td>
        </tr>
    </tfoot>
</table>
 </div>

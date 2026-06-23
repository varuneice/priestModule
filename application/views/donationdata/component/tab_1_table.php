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
<table id="<?php echo (count($tpl['Donationarr'])) ? "tab-1-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
        <th style="display:none;"><?php echo __('ID'); ?></th> 
           <th><?php echo __('Transaction Date'); ?></th>
            <th><?php echo __('Check Date'); ?></th>
            <th><?php echo __('Member ID'); ?></th>
            <th><?php echo __('Order ID'); ?></th>
            <th class="title-th"><?php echo __('Member Name'); ?></th>
            <th><?php echo __('Email'); ?></th>
            <th><?php echo __('Phone'); ?></th>
            <th><?php echo __('Donation Amount'); ?></th>
            <th><?php echo __('Purpose'); ?></th>
            <th><?php echo __('Pay Type'); ?></th>
            <th><?php echo __('Status'); ?></th>    
            <th class="icon-th" style="display:none;"></th>
            <th class="icon-th" style="display:none;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['Donationarr']);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $dataid   = $tpl['Donationarr'][$i]['id'];
                $datadesc = $dataid;
                
        
             
               $today = date("m/d/Y"); 
                $statusconfirmed = "Confirmed";
               $status = "Payment Failed";
               ?>
              <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                   <td style="display:none;"> <?php echo   $datadesc ?> </td>
                   <td><?php echo $tpl['Donationarr'][$i]['pay_date']; ?></td>
                   <?php if($tpl['Donationarr'][$i]['chkdate'] != "" && $tpl['Donationarr'][$i]['chkdate'] !="0000-00-00"){
                   ?>
                   <td><?php echo $tpl['Donationarr'][$i]['chkdate']; ?></td>
                   <?php
                   }else{
                   ?>
                   <td></td>
                   <?php
                   } ?>
                   <td><?php echo $tpl['Donationarr'][$i]['Member_id']; ?></td>
                   <td><?php echo $tpl['Donationarr'][$i]['oid'] ; ?></td>
                   <td><?php echo $tpl['Donationarr'][$i]['MemberName'] ; ?></td>
                   <td><?php echo $tpl['Donationarr'][$i]['Email']; ?></td>
                   <td><?php echo $tpl['Donationarr'][$i]['Mobile']; ?></td>
                   <td><?php echo $tpl['Donationarr'][$i]['Amount']; ?></td>
                   <td><?php echo $tpl['Donationarr'][$i]['purpose']; ?></td>
                   <?php if (  $tpl['Donationarr'][$i]['paymentfor'] == "" ||$tpl['Donationarr'][$i]['paymentfor'] =="null" )  { ?>
                    <td><?php echo strtoupper($tpl['Donationarr'][$i]['pay_type']); ?></td>
                   <?php
                    } else {
                    ?>
                    <td><?php echo $tpl['Donationarr'][$i]['paymentfor']; ?></td>
                    <?php
                     } ?>
                     <td>
                   <?php if (  $tpl['Donationarr'][$i]['payment_status'] == "succeeded" || $tpl['Donationarr'][$i]['payment_status'] =="APPROVED" )  { ?>
                   <span class="label label-confirmed"><?php echo $statusconfirmed ?></span>
                   <?php
                                } else {
                                    ?>
                   <span class="label label-danger"><?php echo $status ?></span>
                   <?php
                     } ?>

                       <!-- <span class="label label-<?php echo $tpl['Donationarr'][$i]['payment_status']; ?>">

                            <?php echo $status_arr[$tpl['Donationarr'][$i]['payment_status']] ?? ''; ?>
                       </span> -->
                   </td>
                   <td style="display:none;"><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Member/adminedit/<?php echo $dataid; ?>" rev="<?php echo $dataid; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td style="display:none;"><a cat="1" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $dataid; ?>" href="<?php echo INSTALL_URL; ?>Member/delete/<?php echo $dataid; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                    
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
                        <li><a href="<?php echo INSTALL_URL ?>donationdata/export"><?php echo __('export'); ?></a></li>
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
if ($('#tab-1-table-id').length > 0) {
    $('#tab-1-table-id').dataTable({
        "aoColumnDefs": [
            {'bSortable': false, 'aTargets': [11, 12]}
        ],
        "aaSorting": [[0, "desc"]]
    });
}
</script>
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
<table id="<?php echo (count($tpl['arr'])) ? "gzhotel-booking-booking-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
            <th class="">
                <!-- <input class="simple" type="checkbox" name="mark-all" id="mark-all-id" value="all"/> -->
            </th>
            <th><?php echo __('Date'); ?></th>
            <th><?php echo __('Member ID'); ?></th>
            <th class="title-th"><?php echo __('Member Name'); ?></th>
            <th><?php echo __('Category'); ?></th>
            <th><?php echo __('Status'); ?></th>
            <!-- <th class="icon-th"></th>
            <th class="icon-th"></th>
            <th class="icon-th"></th> -->
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['arr']);
        $status_arr = __('status_arr');
        
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                // strtotime($original_date)  $new_date = date("d-m-Y", $timestamp)
                $date = strtotime($tpl['arr'][$i]['Updatedon']);
                $date2 = date("m-d-Y", $date ); 
               $checkid =  $tpl['arr'][$i]['member_id'];
                    if($checkid == null || $checkid == ""){
                        $memberid = 'Not Assigned';
                    }
                    else{
                        $memberid = $tpl['arr'][$i]['member_id'];  
                    }
                ?>
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td>
                        <!-- <input class="simple mark" type="checkbox" name="mark[]"  id="mark-<?php echo $tpl['arr'][$i]['id']; ?>" value="<?php echo $tpl['arr'][$i]['id']; ?>"/> -->
            </td>       
                    <td> <?php echo $date2 ?> </td>
                    <td><?php echo $memberid; ?></td>
                    <td> <?php echo $tpl['arr'][$i]['F_Name'] . ' ' . ($tpl['arr'][$i]['M_Name'] ?? '') . ' ' . $tpl['arr'][$i]['L_Name']; ?></td>
                    <td><?php echo $tpl['arr'][$i]['Category']; ?></td> 
                    <td><?php  if($tpl['arr'][$i]['Status'] == 'P'){
                         echo 'Payment Confirmed';
                          }
                          else if($tpl['arr'][$i]['Status'] == 'R'){
                            echo 'Membership Renew';
                           }
                           else if($tpl['arr'][$i]['Status'] == 'A'){
                            echo 'Maintenance';
                           }
                          else if($tpl['arr'][$i]['Status'] == 'E'){
                           echo 'Both Expired';
                          }
                          else if($tpl['arr'][$i]['Status'] == 'Firste'){
                            echo 'FirstSal Expired';
                           }
                           else if($tpl['arr'][$i]['Status'] == 'Spousee'){
                            echo 'SpouseSal Expired';
                           }
                          else if($tpl['arr'][$i]['Status'] == 'Spe'){
                            echo 'SpouseSal Expired';
                           }
                           else if($tpl['arr'][$i]['Status'] == 'T'){
                            echo 'Active';
                          } else if($tpl['arr'][$i]['Status'] == 'F'){
                            echo 'Pending';
                          }
                          else{
                            echo 'Data Update';
                             //echo $status_arr[$tpl['log_arr'][$i]['Status']];  
                          }
                    ?>
                    </td>               
                    <td style="display:none;"><a class="btn btn-primary btn-sm" href="<?php echo INSTALL_URL; ?>Booking/send/<?php echo $tpl['arr'][$i]['id']; ?>"><span class="glyphicon glyphicon-envelope"></span></a></td>
                    <td style="display:none;"><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Booking/edit/<?php echo $tpl['arr'][$i]['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td style="display:none;"><a class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['arr'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>Booking/delete/<?php echo $tpl['arr'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
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
                        <li><a href="<?php echo INSTALL_URL ?>MemberLog/export"><?php echo __('export'); ?></a></li>
                        <li class="divider"style="display:none;" ></li>
                        <li style="display:none;"><a id="delete-selected-id" href="javascript:;"><?php echo __('delete_selected'); ?></a></li>
                        <li class="divider" style="display:none;"></li>
                    </ul>
                </div>
            </td>
        </tr>
    </tfoot>
</table>
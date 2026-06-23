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
		
		.box{
    overflow-x:auto!important;
}
 </style>
<div class="overlay"></div>
<div class="loading-img"></div>
<table id="<?php echo (count($tpl['ticketarr'])) ? "tickettab-2-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
        <th style="display:none;"><?php echo __('ID'); ?></th>
        <th><?php echo __('Date'); ?></th>
            <th><?php echo __('Member ID'); ?></th>
            <th><?php echo __('Order ID'); ?></th>
            <th class="title-th"><?php echo __('Member Name'); ?></th>
            <th><?php echo __('Email'); ?></th>
            <th><?php echo __('Phone'); ?></th> 
            <th><?php echo __('Event Name'); ?></th> 
            <th><?php echo __('Ticket'); ?></th> 
            <th><?php echo __('Event Days'); ?></th>
            <th><?php echo __('Ticket Amount'); ?></th>
            <th><?php echo __('Total Amount'); ?></th>
            <th><?php echo __('Additional Comments'); ?></th>
            <th><?php echo __('Status'); ?></th>    
            <th class="icon-th" style="display:none;"></th>
            <th class="icon-th" style="display:none;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['ticketarr']);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                
               $dbdate =strtotime($tpl['ticketarr'][$i]['pay_date']);
               $date = date("m/d/Y", $dbdate );

               $today = date("m/d/Y");
               
               $dataid = $tpl['ticketarr'][$i]['id'];
               $datadesc = $dataid;
               ?>
              <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                   <td style="display:none;"> <?php echo   $datadesc ?> </td>
                   <td> <?php echo $date ?> </td>
                   <td><?php echo $tpl['ticketarr'][$i]['Member_id']; ?></td>
                   <td><?php echo $tpl['ticketarr'][$i]['oid'] ; ?></td>
                   <td><?php echo $tpl['ticketarr'][$i]['name'] ; ?></td>
                   <td><?php echo $tpl['ticketarr'][$i]['email']; ?></td>
                   <td><?php echo $tpl['ticketarr'][$i]['tele']; ?></td>
                   <td><?php echo $tpl['ticketarr'][$i]['type']; ?></td>
                   <td><?php echo $tpl['ticketarr'][$i]['item_number']; ?></td>
                   <td><?php echo $tpl['ticketarr'][$i]['itemeventday']; ?></td>
                   <td><?php echo $tpl['ticketarr'][$i]['item_cost']; ?></td>
                    <td><?php echo $tpl['ticketarr'][$i]['amount']; ?></td>
                    <td><?php echo $tpl['ticketarr'][$i]['remarks']; ?></td>
                   <td>
                       <span class="label label-<?php echo $tpl['ticketarr'][$i]['payment_status']; ?>">
                            <?php echo $status_arr[$tpl['ticketarr'][$i]['payment_status'] ?? ''] ?? ''; ?>
                       </span>
                   </td>

                   <td style="display:none;"><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Eventa/event/<?php echo $tpl['ticketarr'][$i]['id']; ?>" rev="<?php echo $tpl['ticketarr'][$i]['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td style="display:none;"><a cat="1" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['ticketarr'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>Member/delete/<?php echo $tpl['ticketarr'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                    
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
                        <li><a href="<?php echo INSTALL_URL ?>Eventadmin/ticketexport"><?php echo __('export'); ?></a></li>
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
if ($('#tickettab-2-table-id').length > 0) {
            $('#tickettab-2-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [7, 8]}
                ],
                "aaSorting": [[0, "desc"]]
            });
        }
 </script>
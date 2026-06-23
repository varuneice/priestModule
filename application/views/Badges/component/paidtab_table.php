<div class="overlay"></div>
<div class="loading-img"></div>
<table id="<?php echo (count($tpl['paidarr'])) ? "tab-2-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
            <th><?php echo __('Oid'); ?></th>
            <th><?php echo __('Name'); ?></th>
            <th><?php echo __('City'); ?></th>
            <th><?php echo __('Amount'); ?></th>
            <th><?php echo __('CT Members'); ?></th>
            <th><?php echo __('Senior Members'); ?></th>
            <th style ="display:none;"><?php echo __('Item Name'); ?></th>
            <th><?php echo __('Parking Lot Assigned'); ?></th>
            <th><?php echo __('Decal'); ?></th>
            <th><?php echo __('Date'); ?></th>
            <th><?php echo __('label_status'); ?></th>
            <th class="icon-th"></th>
            <th class="icon-th" ></th>    
        </tr>
    </thead>
    <tbody>
        <?php
       
            // $opts = array();
            // $paidarr = $PaidparkingviewModel->getAll($opts);
            // $itemname =$paidarr['item_name'];
           
        //   $fullname= $tpl['paidarr']['item_name'];
        //   $name=explode(" ",$fullname);
        //    //$first 
        //    echo $name[0];
        //    //$last= 
        //    echo $name[1];  
        $count = count($tpl['paidarr']);
        $status_arr = __('paidarr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                
                $dbdate =strtotime($tpl['paidarr'][$i]['Date']);
                $date = date("m/d/Y", $dbdate );

                $today = date("m/d/Y"); 
                ?>
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td><?php echo $tpl['paidarr'][$i]['oid']; ?></td>
                    <td><?php echo $tpl['paidarr'][$i]['name']; ?></td>
                    <td><?php echo $tpl['paidarr'][$i]['city']; ?></td>
                    <td><?php echo $tpl['paidarr'][$i]['amount']; ?></td>
                    <td><?php echo $tpl['paidarr'][$i]['ct_members']; ?></td>
                    <td><?php echo $tpl['paidarr'][$i]['senior']; ?></td>
                    <td style ="display:none;"><?php echo $tpl['paidarr'][$i]['item_name']; ?></td>
                    <?php if ($tpl['paidarr'][$i]['parking_assigned'] == null || $tpl['paidarr'][$i]['parking_assigned'] == '' )  { ?>
					<td><?php echo $tpl['paidarr'][$i]['item_name']; ?></td>
						<?php
                        } else {
                        ?>
						 <td><?php echo $tpl['paidarr'][$i]['parking_assigned']; ?></td>
						<?php
                        } ?>
                    <!-- <td><?php echo $tpl['paidarr'][$i]['parking_assigned']; ?></td> -->
                    <td><?php echo $tpl['paidarr'][$i]['Decal']; ?></td>
                    
                    <?php if ($tpl['paidarr'][$i]['Date'] == null || $tpl['paidarr'][$i]['Date'] == "0000-00-00")  { ?>
                    <td><?php echo $today ; ?></td> 
                    <?php
                                } else {
                                    ?>
                    <td><?php echo $date; ?></td>  
                    <?php
                    } ?>
                    
                    <td>
                    <span class="label label-confirmed"><?php echo $tpl['paidarr'][$i]['status']; ?></span>    
                    </td>
                    <?php if ($tpl['paidarr'][$i]['Decal'] != null || $tpl['paidarr'][$i]['Decal'] != '')  { ?>
                    <td><a  class="btn btn-primary btn-sm" href="<?php echo INSTALL_URL; ?>Badges/PaidparkingviewInvoice/<?php echo $tpl['paidarr'][$i]['id']; ?>" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                    <?php
                            } ?>
                   <?php if ($tpl['paidarr'][$i]['Decal'] == null || $tpl['paidarr'][$i]['Decal'] == '')  { ?>
                    <td><a disabled="" class="btn btn-primary btn-sm" href="<?php echo INSTALL_URL; ?>Badges/PaidparkingviewInvoice/<?php echo $tpl['paidarr'][$i]['id']; ?>" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                    <?php
                            } ?>
                    <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Badges/Paidparking/<?php echo $tpl['paidarr'][$i]['id']; ?>" rev="<?php echo $tpl['paidarr'][$i]['id']; ?>"><span class="">Select</span></a></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="9">
                    <?php
                    echo __('No Matching Records Found');
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <?php if ($this->controller->isParkingAdmin() || $this->controller->isAdmin())  { ?>
            <td colspan="9">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-flat"><?php echo __('action'); ?></button>
                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo INSTALL_URL ?>Badges/Paidparkingexport"><?php echo __('export'); ?></a></li>
                        <li class="divider" style="display:none;"></li>
                        <li style="display:none;"><a id="delete-selected-id" href="javascript:;"><?php echo __('delete_selected'); ?></a></li>
                        <li style="display:none;" class="divider"></li>
                        <li style="display:none;"><a href="<?php echo INSTALL_URL; ?>Member/create"><?php echo __('add_members'); ?></a></li>
                    </ul>
                </div>
            </td>
            <?php } ?> 
        </tr>
    </tfoot>
</table> 
<script>
$(function() {
    if ($('#tab-2-table-id').length > 0) {
            $('#tab-2-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 7]}
                ]
            });
        }
    });
</script>
<style>
      @media only screen and (max-width: 1280px){
              .phoneview{
             overflow-x:auto;
              }  
            }

            @media only screen and (max-width: 1160px){
                .phoneview{  
                overflow-x:auto;
              }  
               
            }
            @media only screen  and (min-width: 1282px) and (min-width : 1824px) {
                .phoneview{
               overflow-x:auto;
              }  
            } 
          
            @media only screen  and (min-width: 1825px) and (min-width : 1920px )  {
                .phoneview{
               overflow-x:auto;
              }  
            } 

</style>
<div class="overlay"></div>
<div class="loading-img"></div>
<div class ="phoneview">
<table id="<?php echo (count($tpl['arr'])) ? "tab-1-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
            <th><?php echo __('Member ID'); ?></th>
            <th><?php echo __('First Name'); ?></th>
            <th><?php echo __('Last Name'); ?></th>
            <th class="title-th"><?php echo __('Spouse'); ?></th>
            <th><?php echo __('YTD'); ?></th>
            <th><?php echo __('Sponsorship Amount'); ?></th>
            <th><?php echo __('Sponsor Level'); ?></th>
            <th><?php echo __('Parking Lot Assigned'); ?></th>
            <th><?php echo __('Decal'); ?></th>
            <th><?php echo __('label_status'); ?></th>
            <th class="icon-th"></th>
            <th class="icon-th"></th>
            <!-- <th class="icon-th"></th> -->
            
            <!-- <th class="icon-th"></th> -->
        </tr>
    </thead>
    <tbody>
        <?php
      
        $count = count($tpl['arr']);
        //$test =array_unique($tpl['arr'], 'Member_id');
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                // $test =array_unique($tpl['arr'], $tpl['arr']['F_Name']);
                ?>
                
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td><?php echo $tpl['arr'][$i]['Member_id']; ?></td>
                    <td><?php echo $tpl['arr'][$i]['F_Name']; ?></td>
                    <td><?php echo $tpl['arr'][$i]['L_Name']; ?></td>
                    <td><?php echo $tpl['arr'][$i]['Sp_FName']; ?></td>
                    <!-- <td><?php echo $tpl['arr'][$i]['Category']; ?></td> -->
                    <td id ="ytd"><?php echo $tpl['arr'][$i]['donation']; ?></td>
                    <?php if ($tpl['arr'][$i]['sponsor_amount'] == null || $tpl['arr'][$i]['sponsor_amount'] == ''|| $tpl['arr'][$i]['sponsor_amount'] == 0 )  { ?>
                    <td id ="sponsor_amount" style ="color:#3BA424;"><?php echo $tpl['arr'][$i]['donation']; ?></td> 
                    <?php
                                } else {
                                    ?>
                    <td id ="sponsor_amount" style ="color:red;"><?php echo $tpl['arr'][$i]['sponsor_amount']; ?></td> 
                    <?php
                            } ?>

                    <td><?php echo $tpl['arr'][$i]['SponsorshipCategory']; ?></td>

                    <?php if (($tpl['arr'][$i]['SponsorshipCategory'] == 'Diamond' || $tpl['arr'][$i]['SponsorshipCategory'] == 'Emerald' || $tpl['arr'][$i]['SponsorshipCategory'] == 'Platinum') &&  $tpl['arr'][$i]['parking_assigned'] == null )    { ?>
                           <td><?php echo "MainParking"; ?></td> 
                       <?php }
                       else if($tpl['arr'][$i]['SponsorshipCategory'] == 'Gold' &&  $tpl['arr'][$i]['parking_assigned'] == null) { ?>
                         <td><?php echo "KalaBhavan"; ?></td>
                        <?php }
                       else if($tpl['arr'][$i]['SponsorshipCategory'] == 'Silver' &&  $tpl['arr'][$i]['parking_assigned'] == null ) { ?>
                       <td><?php echo "JainTemple"; ?></td>
                    <?php }
                    
                     else if($tpl['arr'][$i]['SponsorshipCategory'] == 'General' &&  $tpl['arr'][$i]['parking_assigned'] == null ) { ?>
                     <td><?php echo " "; ?></td>
                  <?php }
                    else{ ?>
                     <td><?php echo $tpl['arr'][$i]['parking_assigned']; ?></td>
                <?php } 
                   ?>
                   
                    <td><?php echo $tpl['arr'][$i]['Decal']; ?></td>
                    <td>
                    <span class="label label-confirmed"><?php echo $tpl['arr'][$i]['status']; ?></span>
                        
                    </td>
                    <?php if ($tpl['arr'][$i]['Decal'] != null || $tpl['arr'][$i]['Decal'] != '')  { ?>
                    <td><a class="btn btn-primary btn-sm" href="<?php echo INSTALL_URL; ?>Badges/viewInvoice/<?php echo $tpl['arr'][$i]['ID']; ?>" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                    <?php
                            } ?>
                   <?php if ($tpl['arr'][$i]['Decal'] == null || $tpl['arr'][$i]['Decal'] == '')  { ?>
                    <td><a disabled="" class="btn btn-primary btn-sm" href="<?php echo INSTALL_URL; ?>Badges/viewInvoice/<?php echo $tpl['arr'][$i]['ID']; ?>" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                    <?php
                            } ?>

                    <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Badges/edit/<?php echo $tpl['arr'][$i]['ID']; ?>" rev="<?php echo $tpl['arr'][$i]['ID']; ?>"><span class="">Select</span></a></td>
                    <!-- <td><a cat="1" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['arr'][$i]['ID']; ?>" href="<?php echo INSTALL_URL; ?>Badges/delete/<?php echo $tpl['active'][$i]['ID']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td> -->
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
                    <button type="button" style ="margin-left:50px;" class="btn btn-primary btn-flat"><?php echo __('action'); ?></button>
                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown"> 
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo INSTALL_URL ?>Badges/export"><?php echo __('export'); ?></a></li>
                        <li class="divider" style="display:none;"></li>
                        <li style="display:none;"><a id="delete-selected-id" href="javascript:;"><?php echo __('delete_selected'); ?></a></li>
                        <li class="divider" style="display:none;"></li>
                        <li style="display:none;"><a href="<?php echo INSTALL_URL; ?>Badges/create"><?php echo __('add_members'); ?></a></li>
                    </ul>
                </div>
            </td>
            <?php } ?> 
        </tr>
    </tfoot>
</table> 
 </div> 
<script>
$(function() {
    if ($('#tab-1-table-id').length > 0) {
            $('#tab-1-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 7]}
                ]
            });
        }
    });

</script>
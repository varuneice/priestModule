<!-- <style>
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

</style> -->
<div class="overlay"></div>
<div class="loading-img"></div>
<div style = "overflow-x:auto;">
<table id="<?php echo (count($tpl['badgesarr'])) ? "tab-4-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
<!-- <div class="navbar-inner"> -->
<?php if ($this->controller->isBadgesAdmin() || $this->controller->isAdmin())  { ?>
        <ul class="nav nav-pills">
           <li class="active" style="float:left;" >
                <a  href="<?php echo INSTALL_URL; ?>BadgesAssign/badgesimport">
                    <i class="fa fa-fw fa-upload"></i>
                    <?php echo __('import'); ?>
                </a>
            </li>
        </ul>
          <?php
          } ?>
    <br>
<thead>
        <tr>
            <th><?php echo __('MID'); ?></th>
            <th><?php echo __('OID'); ?></th>
            <th><?php echo __('Category'); ?></th>
            <th><?php echo __('First Name'); ?></th>
            <th><?php echo __('Last Name'); ?></th>
            <th><?php echo __('Spouse Name'); ?></th>
            <th><?php echo __('Magazines'); ?></th>
            <th><?php echo __('Student Verified'); ?></th>
            <th><?php echo __('Sponsorship Amount'); ?></th>
            <th><?php echo __('Sponsor'); ?></th>
            <th><?php echo __('Pending Issues'); ?></th>
            <th><?php echo __('S.NO'); ?></th>
            <th><?php echo __('Total Badges Issued'); ?></th>
            <th><?php echo __('Date'); ?></th>
            <th><?php echo __('label_status'); ?></th>
            <th class="icon-th"></th>
            <th class="icon-th"></th>
            <!-- <th class="icon-th"></th> -->
           
        </tr>
    </thead>
        
    <tbody>
        <?php
        $count = count($tpl['badgesarr']);
        $status_arr = __('badgesarr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                
                 $dbdate =strtotime($tpl['badgesarr'][$i]['Date']);
                $date = date("m/d/Y", $dbdate );

                $today = date("m/d/Y"); 
                
                ?>
               <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td><?php echo $tpl['badgesarr'][$i]['MID']; ?></td>                
                    <td><?php echo $tpl['badgesarr'][$i]['OID']; ?></td>  
                    <td><?php echo $tpl['badgesarr'][$i]['Category']; ?></td>              
                    <td><?php echo $tpl['badgesarr'][$i]['F_Name']; ?></td>              
                    <td><?php echo $tpl['badgesarr'][$i]['L_Name']; ?></td>
                    <td><?php echo $tpl['badgesarr'][$i]['Sp_FName']; ?></td>
                    <td><?php echo $tpl['badgesarr'][$i]['Magazines']; ?></td> 
                    <td><?php echo $tpl['badgesarr'][$i]['StudentVerified']; ?></td>
                    <td><?php echo $tpl['badgesarr'][$i]['Sponsorship_Amount']; ?></td>
                    <td><?php echo $tpl['badgesarr'][$i]['Sponsor']; ?></td>                   
                    <td><?php echo $tpl['badgesarr'][$i]['PendingIssues']; ?></td>
                    <td><?php echo $tpl['badgesarr'][$i]['SeqNo']; ?></td>  
                    <td><?php echo $tpl['badgesarr'][$i]['total_badges']; ?></td>
                    <?php if ($tpl['badgesarr'][$i]['Date'] == null || $tpl['badgesarr'][$i]['Date'] == "0000-00-00")  { ?>
                    <td><?php echo $today ; ?></td> 
                    <?php
                                } else {
                                    ?>
                    <td><?php echo $date; ?></td>  
                    <?php
                    } ?>
                    
                    <td>
                    <span class="label label-confirmed"><?php echo $tpl['badgesarr'][$i]['Status']; ?></span>   
                    </td>                                                   
                    <?php if ($tpl['badgesarr'][$i]['Status'] != null || $tpl['arr'][$i]['Status'] != '')  { ?>
                    <td><a class="btn btn-primary btn-sm" href="<?php echo INSTALL_URL; ?>BadgesAssign/viewInvoiceBadges/<?php echo $tpl['badgesarr'][$i]['id']; ?>" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                    <?php
                      } ?>
                   <?php if ($tpl['badgesarr'][$i]['Status'] == null || $tpl['badgesarr'][$i]['Status'] == '')  { ?>
                    <td><a disabled="" class="btn btn-primary btn-sm" href="<?php echo INSTALL_URL; ?>BadgesAssign/viewInvoiceBadges/<?php echo $tpl['badgesarr'][$i]['id']; ?>" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                    <?php
                            } ?>
                    
                   
                    <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>BadgesAssign/edit/<?php echo $tpl['badgesarr'][$i]['id']; ?>" rev="<?php echo $tpl['badgesarr'][$i]['id']; ?>"><span class=""></span>Select</a></td>
                    <!-- <td><a cat="3" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['badgesarr'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>BadgesAssign/delete/<?php echo $tpl['badgesarr'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>  -->
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
              <?php if ($this->controller->isBadgesAdmin() || $this->controller->isAdmin())  { ?>
            <td colspan="9">
                <div class="btn-group">
                    <button type="button" style ="margin-left:50px;" class="btn btn-primary btn-flat"><?php echo __('action'); ?></button>
                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo INSTALL_URL ?>BadgesAssign/Badgesexport"><?php echo __('export'); ?></a></li>
                        <li class="divider" style="display:none;"></li>
                        <li style="display:none;"><a id="delete-selected-id" href="javascript:;"><?php echo __('delete_selected'); ?></a></li>
                        <li style="display:none;" class="divider"></li>
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
    if ($('#tab-4-table-id').length > 0) {
            $('#tab-4-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 7]}
                ]
            });
        }
    });
</script>
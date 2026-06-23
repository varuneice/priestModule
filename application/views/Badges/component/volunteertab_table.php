<div class="overlay"></div>
<div class="loading-img"></div>
<table id="<?php echo (count($tpl['volarr'])) ? "tab-3-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
<!-- <div class="navbar-inner"> -->
<?php if ($this->controller->isParkingAdmin() || $this->controller->isAdmin())  { ?>
        <ul class="nav nav-pills">
           <li class="active" style="float:left; margin-top: -27px;" >
                <a  href="<?php echo INSTALL_URL; ?>Badges/import">
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
            <th><?php echo __('First Name'); ?></th>
            <th><?php echo __('Last Name'); ?></th>
             <th><?php echo __('Core Team'); ?></th>
            <th><?php echo __('Spouse Name'); ?></th>
            <th><?php echo __('Parking Lot Assigned'); ?></th>
            <th><?php echo __('Decal Assigned'); ?></th>
            <th><?php echo __('Date'); ?></th>
            <th><?php echo __('label_status'); ?></th>
            <th class="icon-th"></th>
            <th class="icon-th"></th>
            <!-- <th class="icon-th"></th> -->
        </tr>
    </thead>
        
    <tbody>
        <?php
        $count = count($tpl['volarr']);
        $status_arr = __('volarr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                 $dbdate =strtotime($tpl['volarr'][$i]['Date']);
                $date = date("m/d/Y", $dbdate );

                $today = date("m/d/Y"); 
                ?>
               <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td><?php echo $tpl['volarr'][$i]['MID']; ?></td>                
                    <td><?php echo $tpl['volarr'][$i]['Volunteer_Name'];?></td> 
                    <td><?php echo $tpl['volarr'][$i]['L_Name']; ?></td>        <td><?php echo $tpl['volarr'][$i]['Core_Team']; ?></td>        
                    <td><?php echo $tpl['volarr'][$i]['Spouse_Name']; ?></td>              
                    <td><?php echo $tpl['volarr'][$i]['Parking_AreaAssigned']; ?></td>
                    <td><?php echo $tpl['volarr'][$i]['Decal']; ?></td> 
                    
                    
                    <?php if ($tpl['volarr'][$i]['Date'] == null || $tpl['volarr'][$i]['Date'] == "0000-00-00")  { ?>
                    <td><?php echo $today ; ?></td> 
                    <?php
                                } else {
                                    ?>
                    <td><?php echo $date; ?></td>  
                    <?php
                    } ?> 
                    
                    <td>
                    <span class="label label-confirmed"><?php echo $tpl['volarr'][$i]['Status']; ?></span>   
                    </td>
                    <?php if ($tpl['volarr'][$i]['Decal'] != null || $tpl['volarr'][$i]['Decal'] != '')  { ?>
                    <td><a class="btn btn-primary btn-sm" href="<?php echo INSTALL_URL; ?>Badges/VolunteersviewInvoice/<?php echo $tpl['volarr'][$i]['ID']; ?>" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                    <?php
                            } ?>
                   <?php if ($tpl['volarr'][$i]['Decal'] == null || $tpl['volarr'][$i]['Decal'] == '')  { ?>

                    <td><a disabled=""  class="btn btn-primary btn-sm" href="<?php echo INSTALL_URL; ?>Badges/VolunteersviewInvoice/<?php echo $tpl['volarr'][$i]['ID']; ?>" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                    <?php
                            } ?>
                   
                    <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Badges/Volunteers/<?php echo $tpl['volarr'][$i]['ID']; ?>" rev="<?php echo $tpl['volarr'][$i]['ID']; ?>"><span class=""></span>Select</a></td>
                    <!-- <td><a cat="3" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['volarr'][$i]['ID']; ?>" href="<?php echo INSTALL_URL; ?>Badges/delete/<?php echo $tpl['volarr'][$i]['ID']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td> -->
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
                    <button type="button"  class="btn btn-primary btn-flat"><?php echo __('action'); ?></button>
                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo INSTALL_URL ?>Badges/Volunteeerexport"><?php echo __('export'); ?></a></li>
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

<script>
$(function() {
    if ($('#tab-3-table-id').length > 0) {
            $('#tab-3-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 7]}
                ]
            });
        }
    });
</script>
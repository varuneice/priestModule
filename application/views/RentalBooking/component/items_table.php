<div class="overlay"></div>
<div class="loading-img"></div>
<table id="<?php echo (count($tpl['Itemsarr'])) ? "items-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
<?php if ( $this->controller->isAdmin())  { ?>
        <ul class="nav nav-pills">
           <li class="active" style="float:left;" >
                <a  href="<?php echo INSTALL_URL; ?>RentalBooking/itemsimport">
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
        <th><?php echo __('Categories'); ?></th>
            <th><?php echo __('Count'); ?></th>
            <th class="title-th"><?php echo __('title'); ?></th>
            <th><?php echo __('Description'); ?></th>
            <th><?php echo __('Rent by hour'); ?></th>    
            <th><?php echo __('Rent by day'); ?></th>
            <th><?php echo __('Rent by week'); ?></th>    
            <th class="icon-th" ></th>
            <th class="icon-th"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['Itemsarr']);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                
             
               ?>
              <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                   <td> <?php echo $tpl['Itemsarr'][$i]['categories'] ; ?></td> 
                   <td><?php echo $tpl['Itemsarr'][$i]['count'] ; ?></td>
                   <td><?php echo $tpl['Itemsarr'][$i]['title']; ?></td>
                   <td><?php echo $tpl['Itemsarr'][$i]['description']; ?></td>
                   <td><?php echo $tpl['Itemsarr'][$i]['rent_by_hour']; ?></td>
                   <td><?php echo $tpl['Itemsarr'][$i]['rent_by_day']; ?></td>
                   <td><?php echo $tpl['Itemsarr'][$i]['rent_by_week']; ?></td>
                  
                   <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>RentalBooking/itemsedit/<?php echo $tpl['Itemsarr'][$i]['id']; ?>" rev="<?php echo $tpl['Itemsarr'][$i]['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                   <td><a class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['Itemsarr'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>RentalBooking/delete/<?php echo $tpl['Itemsarr'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
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
            <td colspan="9" style="display:none;">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-flat"><?php echo __('action'); ?></button>
                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo INSTALL_URL ?>RentalBooking/itemsexport"><?php echo __('export'); ?></a></li>
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
if ($('#items-table-id').length > 0) {
            $('#items-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [2, 7]}
                ]
            });
        }
 </script>
<div class="overlay"></div>
<div class="loading-img"></div>
<!-- <table id="<?php echo (count($tpl['Rentallocationpricearr'])) ? "tab-2-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
     -->
     <table id="tab-rental-table-id" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
 
<thead>
       <tr>
        <th><?php echo __('Location'); ?></th>
        <th><?php echo __('Type'); ?></th>
        <th><?php echo __('price'); ?></th>
        <th><?php echo __('Durantion (Hours)'); ?></th>
            <th class="icon-th"></th>
            <th class="icon-th"></th>
           
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['Rentallocationpricearr']);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
             $prevlocation = $tpl['Rentallocationpricearr'][$i]['location'];
                if($prevlocation == 'both'){
                    $location = 'Both Auditorium and Kalabhavan';
              }else{
                $location = $tpl['Rentallocationpricearr'][$i]['location'];
              }
               
               ?>
              <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
              <td><?php echo $location; ?></td>
                   <td><?php echo $tpl['Rentallocationpricearr'][$i]['type']; ?></td>
                   <td><?php echo $tpl['Rentallocationpricearr'][$i]['price']; ?></td>
                   <td><?php echo $tpl['Rentallocationpricearr'][$i]['hours']; ?></td>
                 
                   <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>RentalBooking/rentaledit/<?php echo $tpl['Rentallocationpricearr'][$i]['id']; ?>" rev="<?php echo $tpl['Rentallocationpricearr'][$i]['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                   <?php if ($this->controller->isAdmin())  { ?>
                    <td><a cat="2" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['Rentallocationpricearr'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>RentalBooking/delete/<?php echo $tpl['Rentallocationpricearr'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                    <?php }?>
                     <?php if ($this->controller->isRegistration() || $this->controller->isRental() || $this->controller->isEducation())  { ?>
                    <td><a cat="2" rev="<?php echo $tpl['Rentallocationpricearr'][$i]['id']; ?>" href=""><span></span></a></td>
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
            <td colspan="9" style="display:none">
                <div class="btn-group"> 
                    <button type="button" class="btn btn-primary btn-flat"><?php echo __('action'); ?></button>
                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo INSTALL_URL ?>Category/export"><?php echo __('export'); ?></a></li>
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
if ($('#tab-rental-table-id').length > 0) {
            $('#tab-rental-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [1, 3]}
                ]
            });
        }
 </script>
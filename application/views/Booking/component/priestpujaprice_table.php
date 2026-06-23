<div class="overlay"></div>
<div class="loading-img"></div>
 <table id="tab-pujaprice-table-id" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
 
<thead>
       <tr>
        <th><?php echo __('Puja Name'); ?></th>
        <th><?php echo __('location'); ?></th>
        <th><?php echo __('Price'); ?></th>
            <th class="icon-th"></th>
            <th class="icon-th"></th>    
        </tr>
    </thead>

    
    <tbody>
        <?php
        $count = count($tpl['pujapricearr']);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
              $location = $tpl['pujapricearr'][$i]['location'];
                // if($location == 'inside'){
                // $type = 'Inside Durgabari';
                // }
                // else if($location == 'outside'){
                //     $type = 'Outside Durgabari';
                // }
                // else{
                //     $type = 'Online(epuja)';  
                // }
                
                if($location == 'inside'){
                $type = 'Inside Durgabari';
                }
                else if($location == 'outside'){
                    $type = 'Outside Durgabari';
                }
                else if($location == 'outsidewholeday'){
                    $type = 'Outside Durgabari Whole Day';
                }

                else if($location == 'wholeday'){
                    $type = 'Out Of Town / Whole Day ';
                }
                
               ?>
               
              <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                   <td><?php echo $tpl['pujapricearr'][$i]['pujaname']; ?></td>
                   <td><?php echo $type; ?></td>
                   <td><?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['pujapricearr'][$i]['price']); ?></td>
                   <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Booking/priestpriceedit/<?php echo $tpl['pujapricearr'][$i]['id']; ?>" rev="<?php echo $tpl['pujapricearr'][$i]['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                   <td><a cat="2" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['pujapricearr'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>Booking/delete/<?php echo $tpl['pujapricearr'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
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
</table> 
<script>
if ($('#tab-pujaprice-table-id').length > 0) {
            $('#tab-pujaprice-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [1, 3]}
                ]
            });
        }
 </script>
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
<table id="<?php echo (count($tpl['matrixarr'])) ? "tab-1-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
            <th><?php echo __('Type'); ?></th>
            <th><?php echo __('Main Parking'); ?></th>
            <th><?php echo __('Kala Bhavan'); ?></th>
            <th><?php echo __('Green Field'); ?></th>
            <th><?php echo __('Jain Temple'); ?></th>  
            <th><?php echo __('Total Matrix'); ?></th>
              
            <!-- <th class="icon-th"></th>
            <th class="icon-th"></th> -->
        </tr>
    </thead>
    <tbody>
        <?php  
        $count = count($tpl['matrixarr']);
        $status_arr = __('matrixarr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $test = Array_sum ($tpl['matrixarr'][$i]['TotalMatrix']);
                $test2 = Array_sum ($tpl['matrixarr'][$i]['KalaBhavan']);
                $test3 = Array_sum ($tpl['matrixarr'][$i]['MainParking']);
                $test4 = Array_sum ($tpl['matrixarr'][$i]['GreenField']);
                $test5 = Array_sum ($tpl['matrixarr'][$i]['JainTemple']);
                ?>
                
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td><?php echo $tpl['matrixarr'][$i]['Type']; ?></td>  
                    <td><?php echo $tpl['matrixarr'][$i]['MainParking']; ?></td> 
                    <td><?php echo $tpl['matrixarr'][$i]['KalaBhavan']; ?></td>              
                    <td><?php echo $tpl['matrixarr'][$i]['GreenField']; ?></td>
                    <td><?php echo $tpl['matrixarr'][$i]['JainTemple']; ?></td>              
                    <td><?php echo $tpl['matrixarr'][$i]['TotalMatrix']; ?></td>  
                                 
                   
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
        <tr>
              <td><?php echo $test; ?></td>
              
            </tr>
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
                        <li><a href="<?php echo INSTALL_URL ?>Badges/matrixexport"><?php echo __('export'); ?></a></li>
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

    </script>
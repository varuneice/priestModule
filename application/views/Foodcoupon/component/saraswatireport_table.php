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
<table id="<?php echo (count($tpl['saraswatireportarr'])) ? "tab-6-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
            <th><?php echo __('Registration count processed'); ?></th>
            <th><?php echo __('Adult food coupons issued'); ?></th>
            <th><?php echo __('Parents  food coupons'); ?></th>
            <th><?php echo __('Total  food coupons issued'); ?></th>
                         
            <!-- <th class="icon-th"></th>
            <th class="icon-th"></th>  -->
        </tr>
    </thead>
    <tbody>
        <?php  
        $count = count($tpl['saraswatireportarr']);
        $status_arr = __('saraswatireportarr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                ?>
                
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td><?php echo $tpl['saraswatireportarr'][$i]['Registrationcountprocessed']; ?></td>  
                    <td><?php echo $tpl['saraswatireportarr'][$i]['Adultfoodcouponsissued']; ?></td> 
                    <td><?php echo $tpl['saraswatireportarr'][$i]['Parentsfoodcouponsissued']; ?></td>              
                    <td><?php echo $tpl['saraswatireportarr'][$i]['Totalfoodcouponsissued']; ?></td>
                                                              
                   
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
             <?php if ($this->controller->isFoodcouponAdmin() || $this->controller->isAdmin())  { ?>
            <td colspan="9">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-flat"><?php echo __('action'); ?></button>
                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown"> 
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo INSTALL_URL ?>Foodcoupon/saraswatireportexport"><?php echo __('export'); ?></a></li>
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

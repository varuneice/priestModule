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
</style>
<div class="overlay"></div>
<div class="loading-img"></div>
<!-- <table id="<?php echo (count($tpl['feearr'])) ? "tab-1-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" > -->
<table id="tab-1-table-id" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
<thead>
        <tr>
            <th><?php echo __('SemesterName'); ?></th>
            <th><?php echo __('price'); ?></th> 
            <th><?php echo __('Late Fee'); ?></th>
            <th><?php echo __('Type'); ?></th>       
            <th class="icon-th"></th>
            <th class="icon-th" style="display:none;"></th>
        
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['feearr']);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $Price= $tpl['feearr'][$i]['Price'] ?? '';
                $name=explode("/",$Price);
                $first = $name[0] ?? '';
                $last= $name[1] ?? '';
                 $notregister = "Non Member";
                $register = "Member"; 
               ?>
              <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                   
                   <td><?php echo $tpl['feearr'][$i]['SemmsterName']; ?></td>
                   <td><?php echo  $first; ?></td>
                   <td><?php echo $tpl['feearr'][$i]['lateFee']; ?></td>    
                   <?php if ($tpl['feearr'][$i]['type'] == "nonmember" )  { ?>
                    <td>   <?php echo $notregister ?>  </td> 
                    <?php
                                } else {
                                    ?>
                   <td>   <?php echo $register ?>  </td> 
                    <?php
                     } ?>
                   
                   <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Student/feeedit/<?php echo $tpl['feearr'][$i]['Id']; ?>" rev="<?php echo $tpl['feearr'][$i]['Id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                   
                   <td style= "display:none"><a class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['feearr'][$i]['Id']; ?>" href="<?php echo INSTALL_URL; ?>Student/delete/<?php echo $tpl['feearr'][$i]['Id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
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
        <tr style="display:none;">
            <td colspan="9">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-flat"><?php echo __('action'); ?></button>
                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo INSTALL_URL ?>Studentfee/export"><?php echo __('export'); ?></a></li>
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
if ($('#tab-1-table-id').length > 0) {
            $('#tab-1-table-id').dataTable({
                "aoColumnDefs": [
                  //  {'bSortable': false, 'aTargets': [3, 1]}
                ]
            });
        }
 </script>

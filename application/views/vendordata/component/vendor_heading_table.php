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
<div>
<table id="<?php echo (count($tpl['headingvendor'])) ? "vendor_headingtab_data" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
             <th><?php echo __('Heading'); ?></th>
            <th class="icon-th"></th>
            <th class="icon-th"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['headingvendor']);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
              
                
                ?>
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">

                    <td><?php echo $tpl['headingvendor'][$i]['datavendor']; ?></td>
                   
                    <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>vendordata/vendorheadingedit/<?php echo $tpl['headingvendor'][$i]['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td><a cat="3" class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['headingvendor'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>vendordata/delete/<?php echo $tpl['headingvendor'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
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
                        <li><a href="<?php echo INSTALL_URL ?>vendordata/export"><?php echo __('export'); ?></a></li>
                        <li class="divider" style = "display:none;"></li>
                        <li style = "display:none;"><a id="delete-selected-id" href="javascript:;"><?php echo __('delete_selected'); ?></a></li>
                        <li class="divider" style = "display:none;"></li>
                    </ul>
                </div>
            </td>
        </tr>
    </tfoot>
</table>
 </div>
   <script>
    if ($('#vendor_headingtab_data').length > 0) {
        $('#vendor_headingtab_data').dataTable({
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [1, 3] }
            ]
        });
    }
</script>

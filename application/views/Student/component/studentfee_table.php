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
<table id="<?php echo (count($tpl['feearr'])) ? "gzhotel-booking-booking-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
            <th class="">
                <!-- <input class="simple" type="checkbox" name="mark-all" id="mark-all-id" value="all"/> -->
            </th>
            <th><?php echo __('Semester Name'); ?></th>
            <th><?php echo __('Price'); ?></th>
            <th><?php echo __('Type'); ?></th>
            <th class="icon-th"></th>
            <th class="icon-th"></th>
           
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
               
                ?>
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td>
                     
            </td>       
                   <td><?php echo $tpl['feearr'][$i]['SemmsterName']; ?></td>
                   <td><?php echo $first; ?></td>
                   <td><?php echo $tpl['feearr'][$i]['type']; ?></td>   
                    <td ><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Booking/edit/<?php echo $tpl['arr'][$i]['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td style= "display:none"><a class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['arr'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>Booking/delete/<?php echo $tpl['arr'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
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
            <td colspan="9">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-flat"><?php echo __('action'); ?></button>
                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo INSTALL_URL ?>MemberLog/export"><?php echo __('export'); ?></a></li>
                        <li class="divider"style="display:none;" ></li>
                        <li style="display:none;"><a id="delete-selected-id" href="javascript:;"><?php echo __('delete_selected'); ?></a></li>
                        <li class="divider" style="display:none;"></li>
                    </ul>
                </div>
            </td>
        </tr>
    </tfoot>
</table>
<script>
if ($('#gzhotel-booking-booking-id').length > 0) {
            $('#gzhotel-booking-booking-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 7]}
                ]
            });
        }
 </script>

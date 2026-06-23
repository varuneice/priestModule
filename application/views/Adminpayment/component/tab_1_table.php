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
<?php $tpl['Eventarr'] = is_array($tpl['Eventarr'] ?? null) ? $tpl['Eventarr'] : []; ?>
<table id="<?php echo (count($tpl['Eventarr'])) ? "tab-2-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
        <th style="display:none;"><?php echo __('ID'); ?></th> 
        <th><?php echo __('Event Name'); ?></th>
            <th><?php echo __('Revenue'); ?></th>
            <th><?php echo __('Year'); ?></th>
            
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['Eventarr']);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                 $data = $_POST['select'] ?? '';
                 $url =  INSTALL_URL .'Adminpayment/exportyear/'.$data;
               ?>
              <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                  <td><?php echo $tpl['Eventarr'][$i]['EventName']; ?></td>
                   <td><?php echo $tpl['Eventarr'][$i]['Revenue'] ; ?></td>
                   <td><?php echo $tpl['Eventarr'][$i]['year'] ; ?></td>
                  
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
        <?php if ($this->controller->isAdmin())  { ?>
            <td colspan="9">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-flat"><?php echo __('action'); ?></button>
                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown" style="height: 34px;">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="<?php echo  $url; ?>"><?php echo __('export'); ?></a></li>
                        <li class="divider" style="display:none;"></li>
                        <li style="display:none;"><a id="delete-selected-id" href="javascript:;"><?php echo __('delete_selected'); ?></a></li>
                        <li class="divider" style="display:none;"></li>
                        <li style="display:none;"><a href="<?php echo INSTALL_URL; ?>Member/create"><?php echo __('add_members'); ?></a></li>
                    </ul>
                </div>
            </td>
            <?php }?>
        </tr>
    </tfoot>
</table> 

<script>


$(function() {
    if ($('#tab-2-table-id').length > 0) {
            $('#tab-2-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 7]}
                ]
            });
        }
    });
    
    var yearget =  $("#datanew").val();
    $("#data").val(yearget);

</script>

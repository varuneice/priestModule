<div class="overlay"></div>
<div class="loading-img"></div>
<!-- <table id="<?php echo (count($tpl['Categoryarr'])) ? "tab-1-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
     -->
     <table id="tab-1-table-id" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
<?php if ( $this->controller->isAdmin())  { ?>
        <ul class="nav nav-pills">
           <li class="active" style="float:left;" >
                <a  href="<?php echo INSTALL_URL; ?>Category/import">
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
        <th><?php echo __('ID'); ?></th>
        <th><?php echo __('Category'); ?></th>
            <th class="icon-th"></th>
            <th class="icon-th" style="display:none;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['Categoryarr']);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
            
               
               ?>
              <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
              <td><?php echo $tpl['Categoryarr'][$i]['id']; ?></td>
                   <td><?php echo $tpl['Categoryarr'][$i]['category']; ?></td> 
                 <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Category/edit/<?php echo $tpl['Categoryarr'][$i]['id']; ?>" rev="<?php echo $tpl['Categoryarr'][$i]['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                   <td style="display:none;"><a class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['Categoryarr'][$i]['id']; ?>" href="<?php echo INSTALL_URL; ?>Category/delete/<?php echo $tpl['Categoryarr'][$i]['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
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
if ($('#tab-1-table-id').length > 0) {
            $('#tab-1-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [1, 2]}
                ]
            });
        }
 </script>
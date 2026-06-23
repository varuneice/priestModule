<style>
    @media only screen and (max-width: 499px) {
        .right-side {
            margin-left: 0px !important;
        }

        body {
            width: 119% !IMPORTANT;
        } 
       
    }

    @media (min-width: 500px) and (max-width: 767px) {
        .right-side {
            margin-left: 0px !important;
        }

        body {
            width: 119% !IMPORTANT;
        }
       
    }

    @media (min-width: 768px) and (max-width: 830px) {
        .right-side {
            margin-left: 0px !important;
        }

        body {
            width: 119% !IMPORTANT;
        }
      
    }

    @media(min-width: 831px) and (max-width: 990px) {
        .right-side {
            margin-left: 0px !important;
        }

        body {
            width: 119% !IMPORTANT;
        }
       
    }
.box{
    overflow-x:auto!important;
}


</style>
<div class="overlay"></div>
<div class="loading-img"></div>
<div class ="phoneview">
<table id="<?php echo (count($tpl['arr'])) ? "gzhotel-booking-booking-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
            <th style="display:none;"><?php echo __('ID'); ?></th> 
             <th><?php echo __('Pay Date'); ?></th>
            <th><?php echo __('Member Id'); ?></th>
             <th><?php echo __('Order ID'); ?></th>
            <th><?php echo __('Member Name'); ?></th>
            <th><?php echo __('Student 1 Name'); ?></th>
            <th><?php echo __('Student 2 Name'); ?></th>
            <th><?php echo __('Student 1 Subject'); ?></th>
            <th><?php echo __('Student 2 Subject'); ?></th>
            <th><?php echo __('Email'); ?></th>
            <th><?php echo __('School'); ?></th> 
            <th><?php echo __('Amount'); ?></th>
            <th><?php echo __('Status'); ?></th>
            <th class="icon-th" style = "display:none;"></th>
            <th class="icon-th"></th>
             <th class="icon-th"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['arr']);
        $status_arr = __('status_arr');
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $statusconfirmed = "Confirmed";
                $status = "Payment Failed";
                
                $dataid = $tpl['arr'][$i]['uid'];
                $datadesc = $dataid;
                ?>
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td style="display:none;"> <?php echo   $datadesc ?> </td>
                    <td><?php echo $tpl['arr'][$i]['pay_date']; ?></td>
                    <td><?php echo $tpl['arr'][$i]['reg_uid']; ?></td>
                    <td><?php echo $tpl['arr'][$i]['oid'] ; ?></td>
                    <td><?php echo $tpl['arr'][$i]['membername']; ?></td>
                    <td><?php echo $tpl['arr'][$i]['St_Name1']; ?></td>
                    <td><?php echo $tpl['arr'][$i]['St_Name2']; ?></td>
                    <td>
                        <?php
                        $subject = unserialize($tpl['arr'][$i]['subject']);
                        echo implode(',', is_array($subject) ? $subject : []);
                        ?>
                    </td>
                    <td>
                        <?php
                        $newsubject = unserialize($tpl['arr'][$i]['type']);
                        echo implode(',', is_array($newsubject) ? $newsubject : []);
                        ?>
                    </td>
                    <td><?php echo $tpl['arr'][$i]['email']; ?></td>
                    <td><?php echo $tpl['arr'][$i]['Registration_type']; ?></td>
                  
                    <td><?php echo $tpl['arr'][$i]['totalamount']; ?></td>
                    <td>
                 
                 <?php if (  $tpl['arr'][$i]['payment_status'] == "confirmed")  { ?>
                 <span class="label label-confirmed"><?php echo $statusconfirmed ?></span>
                 <?php
                              } else {
                                  ?>
                 <span class="label label-danger"><?php echo $status ?></span>
                 <?php
                   } ?>

                     
                 </td>
                    <td style= "display:none"><a class="btn btn-primary btn-sm" href="<?php echo INSTALL_URL; ?>Student/send/<?php echo $tpl['arr'][$i]['uid']; ?>"><span class="glyphicon glyphicon-envelope"></span></a></td>
                    <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Student/edit/<?php echo $tpl['arr'][$i]['uid']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td><a class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['arr'][$i]['uid']; ?>" href="<?php echo INSTALL_URL; ?>Student/delete/<?php echo $tpl['arr'][$i]['uid']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
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
                        <li><a href="<?php echo INSTALL_URL ?>Student/export"><?php echo __('export'); ?></a></li>
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
if ($('#gzhotel-booking-booking-id').length > 0) {
            $('#gzhotel-booking-booking-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 10]}
                ]
            });
        }
 </script>
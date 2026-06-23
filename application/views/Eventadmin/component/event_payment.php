<style>
    @media only screen and (max-width: 499px) {
        .right-side {
            margin-left: 0px !important;
        }
    }

    @media (min-width: 500px) and (max-width: 767px) {
        .right-side {
            margin-left: 0px !important;
        }
    }

    @media (min-width: 768px) and (max-width: 830px) {
        .right-side {
            margin-left: 0px !important;
        }
    }

    @media(min-width: 831px) and (max-width: 990px) {
        .right-side {
            margin-left: 0px !important;
        }
    }
</style>
<div class="overlay"></div>
<div class="loading-img"></div>

<table id="event_Payment_account" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?php echo __('Event Type'); ?></th>
            <th><?php echo __('Event Payment Account'); ?></th>
            <th class="icon-th"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['EventAccount']);
        $status_arr = __('status_arr');
        
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                ?>
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">      
                   <td><?php echo $tpl['EventAccount'][$i]['modulename']; ?></td>
                   <td><?php echo $tpl['EventAccount'][$i]['paymentaccount']; ?></td>   
                <td><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Eventadmin/eventPaymentEdit/<?php echo $tpl['EventAccount'][$i]['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
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
    if ($('#event_Payment_account').length > 0) {
        $('#event_Payment_account').dataTable({
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [1, 2]}
            ]
        });
    }
</script>
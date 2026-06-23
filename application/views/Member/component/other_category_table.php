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
<table id="<?php echo (count($tpl['otherCategory'])) ? "gzhotel-booking-booking-id2" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?php echo __('Member ID'); ?></th>
            <th><?php echo __('Category'); ?></th>
            <th class="title-th"><?php echo __('Member Name'); ?></th>
            <th><?php echo __('Email'); ?></th>
            <th><?php echo __('Phone No'); ?></th>
            <th><?php echo __('Address'); ?></th>
            <th><?php echo __('City'); ?></th>
            <th><?php echo __('State'); ?></th>
            <th><?php echo __('Zip'); ?></th>
            <th style="display: none;" class="icon-th"></th>
            <th style="display: none;" class="icon-th"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['otherCategory']);
        $status_arr = __('status_arr');

        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
        ?>
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td><?php echo $tpl['otherCategory'][$i]['Member_id']; ?></td>
                    <td><?php echo $tpl['otherCategory'][$i]['Category']; ?></td>
                    <td> <?php echo $tpl['otherCategory'][$i]['F_Name'] . ' ' . $tpl['otherCategory'][$i]['M_Name'] . ' ' . $tpl['otherCategory'][$i]['L_Name']; ?></td>
                    <td><?php echo $tpl['otherCategory'][$i]['email']; ?></td>
                    <td><?php echo $tpl['otherCategory'][$i]['Tele1']; ?></td>
                    <td><?php echo $tpl['otherCategory'][$i]['Address1'] . ' ' . $tpl['otherCategory'][$i]['Address2'] . ' ' . $tpl['otherCategory'][$i]['Address3']; ?></td>
                    <td><?php echo $tpl['otherCategory'][$i]['City']; ?></td>
                    <td><?php echo $tpl['otherCategory'][$i]['State']; ?></td>
                    <td><?php echo $tpl['otherCategory'][$i]['Zip']; ?></td>
                    <td style="display:none;"><a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>Booking/edit/<?php echo $tpl['otherCategory'][$i]['id'] ?? ''; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td style="display:none;"><a class="btn btn-danger btn-sm icon-delete" rev="<?php echo $tpl['otherCategory'][$i]['id'] ?? ''; ?>" href="<?php echo INSTALL_URL; ?>Booking/delete/<?php echo $tpl['otherCategory'][$i]['id'] ?? ''; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
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
                        <li><a href="<?php echo INSTALL_URL ?>Member/otherCategoryReportExport"><?php echo __('export'); ?></a></li>
                    </ul>
                </div>
            </td>
        </tr>
    </tfoot>
</table>


<script>
    if ($('#gzhotel-booking-booking-id2').length > 0) {
        $('#gzhotel-booking-booking-id2').dataTable({
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [6, 7]
            }]
        });
    }
</script>
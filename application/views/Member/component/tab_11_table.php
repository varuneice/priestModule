<div class="overlay"></div>
<div class="loading-img"></div>
<table id="<?php echo (count($tpl['gcDuplicateMembers'])) ? "tab-11-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
            <th><?php echo __('GC Member id'); ?></th>
            <th><?php echo __('GC Name'); ?></th>
            <th><?php echo __('GC Phone'); ?></th>
            <th><?php echo __('GC Email'); ?></th>
            <th><?php echo __('Member id'); ?></th>
            <th><?php echo __('Member Name'); ?></th>
            <th><?php echo __('Category'); ?></th>
            <th><?php echo __('Member Phone'); ?></th>
            <th><?php echo __('Member Email'); ?></th>
            <th><?php echo __('Match'); ?></th>
            <th class="icon-th"><?php echo __('Action'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = count($tpl['gcDuplicateMembers']);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $row = $tpl['gcDuplicateMembers'][$i];
                ?>
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td><?php echo $row['gc_member_id']; ?></td>
                    <td><?php echo ($row['gc_first_name'] ?? '') . ' ' . ($row['gc_middle_name'] ?? '') . ' ' . ($row['gc_last_name'] ?? ''); ?></td>
                    <td><?php echo $row['gc_phone']; ?></td>
                    <td><?php echo $row['gc_email']; ?></td>
                    <td><?php echo $row['real_member_id']; ?></td>
                    <td><?php echo ($row['member_first_name'] ?? '') . ' ' . ($row['member_middle_name'] ?? '') . ' ' . ($row['member_last_name'] ?? ''); ?></td>
                    <td><?php echo $row['member_category']; ?></td>
                    <td><?php echo $row['member_phone']; ?></td>
                    <td><?php echo $row['member_email']; ?></td>
                    <td><?php echo $row['match_type']; ?></td>
                    <td>
                        <form method="post" action="<?php echo INSTALL_URL; ?>Member/markGcDuplicateInactive" onsubmit="return confirm('Mark this GC duplicate inactive?');">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                            <input type="hidden" name="gc_id" value="<?php echo $row['gc_id']; ?>">
                            <button type="submit" class="btn btn-warning btn-sm"><?php echo __('Mark GC Inactive'); ?></button>
                        </form>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="11">
                    <?php echo __('No matching records found'); ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
<script>
    if ($('#tab-11-table-id').length > 0) {
        $('#tab-11-table-id').dataTable({
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [10]}
            ]
        });
    }
</script>

<table id="<?php echo (count($tpl['members'])) ? "member-category-ltc-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th>Member ID</th>
            <th>Member Name</th>
            <th>Current Category</th>
            <th>Expired Status</th>
            <th>YTD</th>
            <th>LTC</th>
            <th>Eligible Category</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($tpl['members']) > 0) { ?>
            <?php foreach ($tpl['members'] as $i => $member) { ?>
                <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                    <td><?php echo $member['Member_id']; ?></td>
                    <td><?php echo trim(($member['F_Name'] ?? '') . ' ' . ($member['M_Name'] ?? '') . ' ' . ($member['L_Name'] ?? '')); ?></td>
                    <td><?php echo $member['Category']; ?></td>
                    <td><?php
                        $firstLate = (($member['FirstSal'] ?? '') == 'Late');
                        $spouseLate = (($member['SpouseSal'] ?? '') == 'Late');
                        if ($firstLate && $spouseLate) {
                            echo 'Member and Spouse Late';
                        } elseif ($firstLate) {
                            echo 'Member Late';
                        } elseif ($spouseLate) {
                            echo 'Spouse Late';
                        } else {
                            echo 'Surviving';
                        }
                    ?></td>
                    <td><?php echo number_format((float) ($member['YTD'] ?? 0), 2); ?></td>
                    <td><?php echo number_format((float) ($member['LTC'] ?? 0), 2); ?></td>
                    <td><?php echo $member['eligible_category_display'] ?? 'Not eligible'; ?></td>
                    <td>
                        <a class="btn btn-success btn-sm" href="<?php echo INSTALL_URL; ?>MemberCategory/edit/<?php echo $member['ID']; ?>">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="8">No matching records found</td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    if ($('#member-category-ltc-table-id').length > 0) {
        $('#member-category-ltc-table-id').dataTable();
    }
</script>

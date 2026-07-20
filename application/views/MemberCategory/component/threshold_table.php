<?php $thresholdCount = count($tpl['thresholds'] ?? array()); ?>
<form method="post" action="<?php echo INSTALL_URL; ?>MemberCategory/index">
    <input type="hidden" name="save_thresholds" value="1">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
    <table id="<?php echo ($thresholdCount) ? "member-category-threshold-table-id" : ""; ?>" class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th>Category</th>
                <th>Name</th>
                <th>Threshold Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($thresholdCount > 0) { ?>
                <?php foreach ($tpl['thresholds'] as $i => $threshold) { ?>
                    <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                        <td><?php echo $threshold['category_code']; ?></td>
                        <td><?php echo $threshold['category_name']; ?></td>
                        <td>
                            <input class="form-control input-sm" type="number" min="0" step="0.01" name="threshold_amount[<?php echo $threshold['id']; ?>]" value="<?php echo number_format((float) $threshold['threshold_amount'], 2, '.', ''); ?>" style="width: 180px;">
                        </td>
                        <td><?php echo ((int) $threshold['is_active'] === 1) ? 'Active' : 'Inactive'; ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="4">No thresholds found</td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">
                    <button type="submit" class="btn btn-primary btn-sm">Save Thresholds</button>
                </td>
            </tr>
        </tfoot>
    </table>
</form>


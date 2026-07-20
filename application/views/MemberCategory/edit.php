<section class="content-header">
    <h1>Edit Member Category</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>Admin/dashboard"><i class="fa fa-dashboard"></i><?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>MemberCategory/index">Member Category</a></li>
        <li class="active">Edit</li>
    </ol>
</section>

<section class="content">
    <?php require_once VIEWS_PATH . 'Layouts/admin/error_notice.php'; ?>

    <form class="form-horizontal" method="post" action="<?php echo INSTALL_URL; ?>MemberCategory/edit/<?php echo $tpl['arr']['ID'] ?? ''; ?>">
        <input type="hidden" name="save_member_category" value="1">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <input type="hidden" name="ID" value="<?php echo $tpl['arr']['ID'] ?? ''; ?>">
        <div class="box box-info">
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <td>Member ID</td>
                        <td><?php echo $tpl['arr']['Member_id'] ?? ''; ?></td>
                        <td>Member Name</td>
                        <td><?php echo trim(($tpl['arr']['F_Name'] ?? '') . ' ' . ($tpl['arr']['M_Name'] ?? '') . ' ' . ($tpl['arr']['L_Name'] ?? '')); ?></td>
                    </tr>
                    <tr>
                        <td>Current Category</td>
                        <td><?php echo $tpl['arr']['Category'] ?? ''; ?></td>
                        <td>LTC</td>
                        <td><?php echo number_format((float) ($tpl['arr']['LTC'] ?? 0), 2); ?></td>
                    </tr>
                    <tr>
                        <td>YTD</td>
                        <td><?php echo number_format((float) ($tpl['arr']['YTD'] ?? 0), 2); ?></td>
                        <td>Eligible Category</td>
                        <td>
                            <?php
                            if (!empty($tpl['eligible_categories'])) {
                                $eligibleNames = array();
                                foreach ($tpl['eligible_categories'] as $category) {
                                    $eligibleNames[] = $category['category_code'];
                                }
                                echo implode(', ', $eligibleNames);
                            } else {
                                echo 'Not eligible';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>New Category</td>
                        <td colspan="3">
                            <select name="Category" class="form-control input-sm" style="width: 220px;" <?php echo empty($tpl['eligible_categories']) ? 'disabled' : ''; ?>>
                                <option value="">Select Category</option>
                                <?php foreach (($tpl['eligible_categories'] ?? []) as $category) { ?>
                                    <option value="<?php echo $category['category_code']; ?>"><?php echo $category['category_code'] . ' - ' . $category['category_name']; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary" <?php echo empty($tpl['eligible_categories']) ? 'disabled' : ''; ?>>Save Category</button>
                <a class="btn btn-default" href="<?php echo INSTALL_URL; ?>MemberCategory/index">Back</a>
            </div>
        </div>
    </form>
</section>


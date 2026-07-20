<section class="content-header">
    <h1>Member Category</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>Admin/dashboard"><i class="fa fa-dashboard"></i><?php echo __('home'); ?></a></li>
        <li class="active">Member Category</li>
    </ol>
</section>

<section class="content">
    <?php require_once VIEWS_PATH . 'Layouts/admin/error_notice.php'; ?>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab_thresholds">Category Threshold</a></li>
        <li><a data-toggle="tab" href="#tab_members">Members YTD/LTC</a></li>
    </ul>

    <div class="tab-content" style="padding-top: 15px;">
        <div id="tab_thresholds" class="tab-pane fade in active">
            <?php require_once VIEWS_PATH . 'MemberCategory/component/threshold_table.php'; ?>
        </div>
        <div id="tab_members" class="tab-pane fade">
            <?php require_once VIEWS_PATH . 'MemberCategory/component/member_ltc_table.php'; ?>
        </div>
    </div>
</section>

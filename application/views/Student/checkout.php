<section class="content-header">
    <h1>
        <?php echo __('pay'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Student/index"><?php echo __('title_student'); ?></a></li>
        <li class="active"><?php echo __('pay'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<section class="content left width_100">
    <div class="padding-19 nav-tabs-custom left width_100">
        <?php
        if (!empty($_SESSION['status'])) {
            ?>
            <div class="alert alert-danger in">
                <strong><?php echo $_SESSION['status']; ?></strong>
            </div>
            <?php
        } else {

            if (($_POST['Payment_method'] ?? '') == 'stripe') {
                ?>
                <div class="payment_information">
                    <p class="error" style="font-weight: bold; font-size: 22px;"><?php echo __('payment_information'); ?></p>
                    <p><strong><?php echo __('reference_number'); ?>:</strong> <?php echo $tpl['arr']['ID'] ?? ''; ?></p>
                    <p><strong><?php echo __('transaction_id'); ?>:</strong> <?php echo $tpl['payment']['balance_transaction'] ?? ''; ?></p>
                    <p><strong><?php echo __('paid_amount'); ?>:</strong> <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['arr']['amount']); ?></p>
                </div>
                <?php
            } else {
                ?>
                <div class="alert alert-success  in">
                    <i class="fa-fw fa fa-check"></i>
                    <strong><?php echo __('success'); ?></strong>
                </div>
                <?php
            }
        }
        ?>
    </div>
</section>
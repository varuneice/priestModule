<style>
.payment_information{
    display:none;
} 
 .amd z{display:none;}
  .alert-success{display:none;}
 .ab z{display:none;}
 #amc z{display:none;}
 #abc z{display:none;}
 #vid{display:none;}
</style>


<?php
if (!empty($_SESSION['status'])) {
    ?>
    <div class="alert alert-warning  in">
        <i class="fa-fw fa fa-warning"></i>
        <strong><?php echo __('warning'); ?></strong>
        <?php echo $_SESSION['status']; ?>
    </div>
    <?php
    unset($_SESSION['status']);
} else {
    if (!empty($_POST['payment_method']) && in_array($_POST['payment_method'], array('paypal', '2checkout', 'authorize'))) {
        ?>
        <div class="alert alert-warning  in">
            <i class="fa-fw fa fa-warning"></i>
            <strong><?php echo __('warning'); ?></strong>
            <?php echo __('payment_redirect_wait'); ?>
        </div>
        <?php
    } elseif (($_POST['payment_method'] ?? '') == 'stripe') {
        ?>
        <div class="payment_information">
            <p class="error" style="font-weight: bold; font-size: 22px;"><?php echo __('payment_information'); ?></p>
            <p><strong><?php echo __('reference_number'); ?>:</strong> <?php echo $tpl['booking_details']['id'] ?? ''; ?></p>
            <p><strong><?php echo __('transaction_id'); ?>:</strong> <?php echo $tpl['payment']['balance_transaction'] ?? ''; ?></p>
            <p><strong><?php echo __('paid_amount'); ?>:</strong> <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $tpl['booking_details']['amount'] ?? 0); ?></p>
            <p><strong><?php echo __('slot_date'); ?>:</strong> <?php echo implode(', ', (array)($tpl['booking_details']['slots'] ?? [])) ?></p>
        </div>
        <?php
    } else {
        ?>
        <div class="alert alert-success  in">
            <i class="fa-fw fa fa-check"></i>
            <strong><?php echo __('success'); ?></strong>
            <?php echo __('booking_save'); ?>
        </div>
        <?php
    }
    ?>
    <?php
    if (!empty($_REQUEST['payment_method']) && $_REQUEST['payment_method'] == 'paypal') {
        require 'component/payment/paypal.php';
    } elseif (!empty($_REQUEST['payment_method']) && $_REQUEST['payment_method'] == '2checkout') {
        require 'component/payment/2checkout.php';
    } elseif (!empty($_REQUEST['payment_method']) && $_REQUEST['payment_method'] == 'authorize') {
        require 'component/payment/authorize.php';
    }
}
?>
<?php
$api_login_id = trim(@$tpl['option_arr_values']['authorize_loginid']);
$transaction_key = trim();
$amount = @$tpl['booking_details']['amount'];
$fp_timestamp = time();
$fp_sequence = $tpl['booking_details']['id'] ?? ''; // Can be changed to an invoice or other unique number.

$fingerprint = AuthorizeNetSIM_Form::getFingerprint($api_login_id, $transaction_key, $amount, $fp_sequence, $fp_timestamp);

//$url = "https://test.authorize.net/gateway/transact.dll";
$url = "https://secure.authorize.net/gateway/transact.dll";
?>
<form method='post' action="<?php echo $url; ?>" id="gz-hotel-booking-pay-frm-id">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
    <input type='hidden' name="x_login" value="<?php echo $api_login_id; ?>" />
    <input type='hidden' name="x_fp_hash" value="<?php echo $fingerprint; ?>" />
    <input type='hidden' name="x_amount" value="<?php echo $amount; ?>" />
    <input type='hidden' name="x_trans_id" value="<?php echo $tpl['booking_details']['id'] ?? ''; ?>" />
    <input type='hidden' name="x_fp_timestamp" value="<?php echo $fp_timestamp; ?>" />
    <input type='hidden' name="x_fp_sequence" value="<?php echo $fp_sequence; ?>" />
    <input type='hidden' name="x_version" value="3.1" />
    <input type='hidden' name="x_show_form" value="payment_form" />
    <input type='hidden' name="x_test_request" value="true" />
    <input type='hidden' name="x_method" value="cc" />
    <input type="hidden" name="x_currency_code" value="<?php echo $tpl['option_arr_values']['currency'] ?? ''; ?>" />
    <input type='hidden' name='x_relay_response' value="true" />
    <input type='hidden' name='x_relay_url' value="<?php echo INSTALL_URL ?>?controller=GzFront&action=authorize_confirm" />
    <input type='hidden' name='x_relay_always' value="true" />
</form>
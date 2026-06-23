<?php
$url = "https://www.2checkout.com/checkout/purchase";
//$url = "https://sandbox.2checkout.com/checkout/purchase";
?>
<form action='<?php echo $url; ?>' method='post' id="gz-hotel-booking-pay-frm-id">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
    <input type='hidden' name='sid' value='<?php echo @$tpl['option_arr_values']['checkout_acc']; ?>' />
    <input type='hidden' name='mode' value='2CO' />
    <input name="return_url" type="hidden" value="<?php echo INSTALL_URL ?>?controller=GzFront&action=confirm_2checkout">
    <input type="hidden" name="x_receipt_link_url"  value="<?php echo INSTALL_URL ?>?controller=GzFront&action=confirm_2checkout">
    <input type='hidden' name='li_0_type' value='product' />
    <input type='hidden' name='li_0_name' value='<?php echo implode(',', $tpl['booking_details']['slots'] ?? []);; ?>' />
    <input type='hidden' name='li_0_price' value='<?php echo @$tpl['booking_details']['amount']; ?>' />
    <input type='hidden' name='li_0_tangible' value='Y' />
    <input type='hidden' name='currency_code' value='<?php echo @$tpl['option_arr_values']['currency']; ?>' />
    <input type="hidden" name="merchant_order_id" value="<?php echo @$tpl['booking_details']['id']; ?>" />
    <input type="hidden" name="cart_order_id" value="<?php echo @$tpl['booking_details']['id']; ?>" />
    <input name="card_holder_name" type="hidden" value="<?php echo @$tpl['booking_details']['first_name'].' '.@$tpl['booking_details']['first_name']; ?>">
    <input name="street_address" type="hidden" value="<?php echo @$tpl['booking_details']['address_1']; ?>">
    <input name="street_address2" type="hidden" value="<?php echo @$tpl['booking_details']['address_2']; ?>">
    <input name="city" type="hidden" value="<?php echo @$tpl['booking_details']['city']; ?>">
    <input name="state" type="hidden" value="<?php echo @$tpl['booking_details']['state']; ?>">
    <input name="zip" type="hidden" value="<?php echo @$tpl['booking_details']['zip']; ?>">
    <input name="country" type="hidden" value="<?php echo @$tpl['booking_details']['country']; ?>">
    <input name="email" type="hidden" value="<?php echo @$tpl['booking_details']['email']; ?>">
    <input name="phone" type="hidden" value="<?php echo @$tpl['booking_details']['phone']; ?>">
    <input name="ship_name" type="hidden" value="<?php echo @$tpl['booking_details']['first_name'].' '.@$tpl['booking_details']['first_name']; ?>">
    <input name="ship_street_address" type="hidden" value="<?php echo @$tpl['booking_details']['address_1']; ?>">
    <input name="ship_street_address2" type="hidden" value="<?php echo @$tpl['booking_details']['address_2']; ?>">
    <input name="ship_city" type="hidden" value="<?php echo @$tpl['booking_details']['city']; ?>">
    <input name="ship_state" type="hidden" value="<?php echo @$tpl['booking_details']['state']; ?>">
    <input name="ship_zip" type="hidden" value="<?php echo @$tpl['booking_details']['zip']; ?>">
    <input name="ship_country" type="hidden" value="<?php echo @$tpl['booking_details']['country']; ?>">
    <input name="paypal_direct" type="hidden" value="Y">
</form>

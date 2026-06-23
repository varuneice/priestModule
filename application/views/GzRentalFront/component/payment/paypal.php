<?php
$url = "https://www.paypal.com/cgi-bin/webscr";
//$url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
?>
<form action="<?php echo $url; ?>" method="post" id="gz-hotel-booking-pay-frm-id">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
    <input type="hidden" name="cmd" value="_cart" />
    <input type="hidden" name="upload" value="1">
    <input type="hidden" name="business" value="<?php echo @$tpl['option_arr_values']['paypal_id']; ?>" />
    <input type="hidden" name="item_name_1" value="<?php echo implode(',', $tpl['booking_details']['slots'] ?? []);; ?>" />
    <input type="hidden" name="item_number_1" value="<?php echo @$tpl['booking_details']['id']; ?>" />
    <input type="hidden" name="custom" value="<?php echo @$tpl['booking_details']['id']; ?>" />
    <input type="hidden" name="currency_code" value="<?php echo @$tpl['option_arr_values']['currency']; ?>" />
    <input type="hidden" name="amount_1" value="<?php echo @$tpl['booking_details']['amount']; ?>" />
    <input type="hidden" name="quantity_1" value="1" /> 
    <input type="hidden" name="first_name" value="<?php echo @$tpl['booking_details']['first_name']; ?>" />
    <input type="hidden" name="last_name" value="<?php echo @$tpl['booking_details']['second_name']; ?>" />
    <input type="hidden" name="address1" value="<?php echo @$tpl['booking_details']['address_1']; ?>" />
    <input type="hidden" name="address2" value="<?php echo @$tpl['booking_details']['address_2']; ?>" />
    <input type="hidden" name="city" value="<?php echo @$tpl['booking_details']['city']; ?>" />
    <input type="hidden" name="state" value="<?php echo @$tpl['booking_details']['state']; ?>" />
    <input type="hidden" name="zip" value="<?php echo @$tpl['booking_details']['zip']; ?>" />
    <input type="hidden" name="email" value="<?php echo @$tpl['booking_details']['email']; ?>" />
    <input type="hidden" name="notify_url" value='<?php echo INSTALL_URL ?>?controller=GzFront&action=paypal_confirm' />
    <input type="hidden" name="return" value="<?php echo INSTALL_URL ?>?controller=GzFront&action=paypal_confirm">
    <input type="hidden" name="rm" value="2">
    <input type="hidden" name="cbt" value="Return to The Store">
    <input style="display: none;" type="image" name="submit" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online">
</form>

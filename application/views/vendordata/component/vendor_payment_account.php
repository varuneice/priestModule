<form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>vendordata/updateVendorPayAccount"
    method="post" name="RenewMembershipLastDate" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
    <table id="<?php echo (count($tpl['vendorpayAccountarr'])) ? "gzhotel-booking-booking-id" : ""; ?>"
        class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0">
        <tbody>
            <tr class="tr">
                <td class="td"><label>Vendor Payment Account</label></td>
                <td class="td">
                    <select data-rule-required='true' name="paymentaccount" id="paymentfor" class="form-control input-sm">
                    <option value="Regularaccount" <?php echo ($tpl['vendorpayAccountarr'][0]['paymentaccount'] == 'Regularaccount') ? 'selected' : ''; ?>>Regular Account</option>
                        <option value="Pujaaccount" <?php echo ($tpl['vendorpayAccountarr'][0]['paymentaccount'] == 'Pujaaccount') ? 'selected' : ''; ?>>Puja Account</option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <input type="hidden" name="id" value="<?php echo $tpl['vendorpayAccountarr'][0]['id']; ?>" />
    <?php if ($this->controller->isAdmin()) { ?>
        <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit"
            tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
    <?php } ?>
</form>

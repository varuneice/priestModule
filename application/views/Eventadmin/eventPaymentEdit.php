<style>
    @media only screen and (max-width: 499px) {
        .right-side {
            margin-left: 0px !important;
        }
    }

    @media (min-width: 500px) and (max-width: 767px) {
        .right-side {
            margin-left: 0px !important;
        }
    }

    @media (min-width: 768px) and (max-width: 830px) {
        .right-side {
            margin-left: 0px !important;
        }
    }

    @media(min-width: 831px) and (max-width: 990px) {
        .right-side {
            margin-left: 0px !important;
        }
    }
</style>
<section class="content-header">
    <h1>
        <?php echo __('Edit'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>EventAdmin/eventindex"><?php echo __('Event Payement'); ?></a></li>
        <li class="active"><?php echo __('Edit Event Payment'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';

?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Eventadmin/eventPaymentEdit" method="post" name="eventPaymentEdit" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <h1 style="margin:0; font-size:24px; color:#2679b5;"> Edit Event Payment Account </h1><br>
                <table id="<?php echo (count($tpl['payarr'])) ? "gzhotel-booking-booking-id" : ""; ?>"
                    class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0">
                    <tbody>

                        <tr class="tr">

                            <td class="td"> <label>Event Type</label> </td>
                            <td class="td"><input id="txtEventAccount" class="form-control input-sm" type="text" name="modulename" size="25" value="<?php echo $tpl['payarr']['modulename'] ?? ''; ?>" title="<?php echo __('Event Type'); ?>" placeholder="Event Type" readonly></td>
                            <td class="td"><label>Event Payment Account</label></td>
                            <td class="td">
                                <select data-rule-required='true' name="paymentaccount" id="paymentfor" class="form-control input-sm">
                                <option value="Regularaccount" <?php echo (($tpl['payarr']['paymentaccount'] ?? '') == 'Regularaccount') ? 'selected' : ''; ?>>Regular Account</option>
                                    <option value="Pujaaccount" <?php echo (($tpl['payarr']['paymentaccount'] ?? '') == 'Pujaaccount') ? 'selected' : ''; ?>>Puja Account</option>
                                </select>
                            </td>

                        </tr>

                    </tbody>
                </table>
            </fieldset>
            <br>
            <input type="hidden" name="id" value="<?php echo $tpl['payarr']['id'] ?? ''; ?>" />
            <?php if ($this->controller->isAdmin()) { ?>
                <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit"
                    tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
            <?php } ?>
        </div>

    </form>

</section>
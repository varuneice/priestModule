<section class="content-header">
    <h1>
        <?php echo __('send_email'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Foodcoupon/index"><?php echo __('Food coupons'); ?></a></li>
        <li class="active"><?php echo __('send_email'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<section class="content left width_100">
    <form id="send_invoice_emal_id" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Foodcoupon/foodsendEmail" method="post" name="send_invoice_emal">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <div class="callout callout-info">
                <p>
                    <?php echo __('send_invoice_email_info'); ?>
                </p>
            </div>
            <fieldset>
                <div class="form-group">
                    <label class="control-label" for="subject"><?php echo __('subject'); ?>:</label>
                    <input id="phone" class="form-control input-sm" type="text" name="subject" size="25" value="" title="subject">
                    <div class="control-group"></div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="message"><?php echo __('message'); ?>:</label>
                    <textarea name="message"></textarea>
                    <div class="control-group"></div>
                </div>
                <fieldset class="form-actions">
                    <input type="hidden" name="invoice_id" value="<?php echo $_REQUEST['id']; ?>" />
                    <input type="hidden" name="action" value="sendEmail" /> 
                    <input type="hidden" name="controller" value="Invoice" /> 
                    <input type="hidden" name="send_mail" value="1" /> 
                    <button id="submit" class="btn btn-default" autocomplete="off" value="<?php echo __('send'); ?>" name="submit" tabindex="9" type="submit"><?php echo __('send'); ?></button>
                </fieldset>
            </fieldset>
        </div>
    </form>
</section>
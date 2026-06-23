<section class="content-header">
    <h1>
        <?php echo __('send_email'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i><?php echo __('home'); ?></a></li>
    </ol>
</section>
<!-- Main content -->
<section class="content left width_100">
    <?php
    require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
    ?>
    <form id="install_frm" class="frm-class" action="<?php echo INSTALL_URL; ?>RentalBooking/send/<?php echo $_GET['id'] ?? ''; ?>" method="post" name="">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <div class="callout callout-info">
                    <p>
                        <?php echo __('send_info'); ?>
                    </p>
                </div>
                <div class="form-group">
                    <label class="control-label" for="additional"><?php echo __('subject'); ?>:</label>
                    <input id="country" class="form-control input-sm" type="text" name="subject" size="25" value="<?php echo $tpl['subjetc']; ?>" title="<?php echo __('subject'); ?>" placeholder="">
                </div>
                <div class="form-group">
                    <label class="control-label" for="additional"><?php echo __('message'); ?>:</label>
                    <textarea class="form-control textarea-resizable" name="message" id="email_message_id">
                        <?php echo $tpl['message']; ?>
                    </textarea>
                </div>
            </fieldset>
            <fieldset class="form-actions">
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? ''; ?>" />
                <input type="hidden" name="send_email" value="1" /> 
                <button id="submit" class="btn btn-default" autocomplete="off" value="<?php echo __('send'); ?>" name="submit" tabindex="9" type="submit"><?php echo __('send'); ?></button>
            </fieldset>
        </div>
    </form>
</section><!-- /.content -->
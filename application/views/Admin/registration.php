<div id="install-container">
    <div class="grid">
        <header class="header bordered" role="banner">
        <img src="./picture/full_logo.png" > <h1><b>Houston Durgabari Society</b></h1>
        </header>
        <div class="breadcrumb">
            <div class="sub-breadcrumb">
                <span class="time">It is currently <?php echo date('l jS \of F Y h:i:s'); ?></span>
            </div>
        </div>
        <?php
        require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
        ?>
        <div id="page-body">
            <main role="main">
                <h1 class="bordered title"><span class="green"></span><?php echo __('registration') ?></h1>
                <form action="<?php echo INSTALL_URL; ?>Admin/registration"  method="post" id="registration" class="frm-class">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    <div class="well">
                        <fieldset>
                            <div class = "form-group">
                                <label  class = "control-label" for = "title"><?php echo __('first') ?><span class="red">*</span></label>
                                <input data-rule-required="true" class = "form-control input-sm" type = "text" name = "first" size = "25"  title = "<?php echo _('first') ?>" placeholder = "<?php echo _('first') ?>" /> 
                            </div>

                            <div class = "form-group">
                                <label class = "control-label" for = "title"><?php echo __('last') ?><span class="red">*</span></label>
                                <input data-rule-required="true" class = "form-control input-sm" type = "text" name = "last" size = "25"  title = "<?php echo _('last') ?>" placeholder = "<?php echo _('last') ?>" />
                            </div>
                            <div class = "form-group">
                                <label class = "control-label" for = "title"><?php echo __('email') ?><span class="red">*</span></label>
                                <input data-rule-required="true" data-rule-equalto="#repeat_email" id="email" class = "form-control input-sm" type = "email" name = "email" size = "25"  title = "<?php echo _('email') ?>" placeholder = "<?php echo _('email') ?>" />
                            </div>
                            <div class = "form-group">
                                <label class = "control-label" for = "title"><?php echo __('confirm_email') ?><span class="red">*</span></label>
                                <input data-rule-required="true" data-rule-equalto="#email" id="repeat_email" class = "form-control input-sm" type = "email" name = "repeat_email" size = "25"  title = "<?php echo _('confirm_email') ?>" placeholder = "<?php echo _('confirm_email') ?>" />
                            </div>
                            <div class = "form-group">
                                <label class = "control-label" for = "title"><?php echo __('password') ?></label>
                                <input data-rule-equalto="#repeat_password" data-rule-required="true" id="password" class = "form-control input-sm" type = "password" name = "password" size = "25"  title = "<?php echo _('password') ?>" placeholder = "<?php echo _('password') ?>" />
                            </div>
                            <div class = "form-group">
                                <label class = "control-label" for = "title"><?php echo __('confirm_passowrd') ?></label>
                                <input data-rule-equalto="#password" data-rule-required="true" id="repeat_password" class = "form-control input-sm" type = "password" name = "repeat_password" size = "25"  title = "<?php echo _('confirm_passowrd') ?>" placeholder = "<?php echo _('confirm_passowrd') ?>" />
                            </div> 
                        </fieldset>
                        <fieldset>
                            <button id = "get-ifno-id" class = "btn btn-default" autocomplete = "off" value = "1" name = "submit" tabindex = "9" type = "submit"><?php echo __('save') ?></button>
                        </fieldset>
                    </div>
                </form>

            </main>
        </div>
    </div>
</div>
<footer id="footer">
    <section class="container clearfix">
        <div class="bottom">
            <section style="text-align: center;">
            © All Right Reserved
             
                <a style="font-size: 16px; font-weight: bold;" href="https://www.eicetechnology.com/">Eice</a>
            </section>
        </div>
</footer>
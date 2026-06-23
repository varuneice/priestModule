<section class="content-header">
    <h1>
        <?php echo __('settings'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Calendar/index"><?php echo __('calendars'); ?></a></li>
        <li class="active"><?php echo __('settings'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<section class="content">
    <form id="general-options-id" class="frm-options" action="<?php echo INSTALL_URL; ?>Calendar/settings/<?php echo $_GET['id'] ?? ''; ?>" method="post" name="create">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#tab_1"><?php echo __('menu_general'); ?></a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#tab_2"><?php echo __('menu_appearance'); ?></a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#tab_3"><?php echo __('menu_booking'); ?></a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#tab_4"><?php echo __('menu_payment'); ?></a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#tab_5"><?php echo __('menu_email'); ?></a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#tab_6"><?php echo __('member_email'); ?></a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#tab_7">Forget Email</a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#tab_8"><?php echo __('menu_terms'); ?></a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#tab_9"><?php echo __('menu_invoice'); ?></a>
                </li>
            </ul>    
            <div class="tab-content">
                <div id="tab_1" class="tab-pane active">
                    <fieldset>
                        <?php require 'settings/general.php'; ?>
                        <input type="hidden" name="update_option" value="1" />
                        <button id="submit" class="btn btn-primary" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button>
                    </fieldset>
                </div>
                <div id="tab_2" class="tab-pane">
                    <fieldset>
                        <?php require 'settings/appearance.php'; ?>
                        <input type="hidden" name="update_option" value="1" />
                        <button id="submit" class="btn btn-primary" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button>
                    </fieldset>
                </div>
                <div id="tab_3" class="tab-pane">
                    <fieldset>
                        <?php require 'settings/booking.php'; ?>
                        <input type="hidden" name="update_option" value="1" />
                        <button id="submit" class="btn btn-primary" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button>
                    </fieldset>
                </div>
                <div id="tab_4" class="tab-pane">
                    <?php require 'settings/payment.php'; ?>
                    <input type="hidden" name="update_option" value="1" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button>
                </div>
                <div id="tab_5" class="tab-pane">
                    <?php require 'settings/emails.php'; ?>
                    <input type="hidden" name="update_option" value="1" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button>
                </div>
                <div id="tab_6" class="tab-pane">
                    <?php require 'settings/member_emails.php'; ?>
                    <input type="hidden" name="update_option" value="1" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button>
                </div>
                 <div id="tab_7" class="tab-pane">
                    <?php require 'settings/forget_emails.php'; ?>
                    <input type="hidden" name="update_option" value="1" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button>
                </div>
                <div id="tab_8" class="tab-pane">
                    <?php require 'settings/terms.php'; ?>
                    <input type="hidden" name="update_option" value="1" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button>
                </div>
                <div id="tab_9" class="tab-pane">
                    <?php require 'settings/invoice.php'; ?>
                    <input type="hidden" name="update_option" value="1" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button>
                </div>
            </div>
        </div>
    </form>
</section>
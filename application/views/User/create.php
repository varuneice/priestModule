<section class="content-header">
    <h1>
        <?php echo __('add_user'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>User/index"><?php echo __('title_users'); ?></a></li>
        <li class="active"><?php echo __('add_user'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<section class="content left width_100">
    <form id="new_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>User/create" method="post" name="create" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <div class="form-group">
                    <label class="control-label" for="type"><?php echo __('type'); ?>:</label>
                    <select name="type" id="type" class="form-control input-sm medium" >
                        <option value="">---</option>
                        <?php
                        $type_arr = __('type_arr');
                        foreach ($type_arr as $k => $v) {
                            ?>
                            <option value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label" for="email"><?php echo __('email'); ?>:</label>
                    <input id="email" class="form-control input-sm" type="text" name="email" size="25" value="" title="email" placeholder="email">
                </div>
                <div class="form-group">
                    <label class="control-label" for="confirm_email"><?php echo __('confirm_email'); ?>:</label>
                    <input id="confirm_email" class="form-control input-sm" type="text" name="confirm_email" size="25" value="" title="<?php echo __('confirm_email'); ?>" placeholder="<?php echo __('confirm_email'); ?>">
                </div>
                <div class="form-group">
                    <label class="control-label" for="first"><?php echo __('first'); ?>:</label>
                    <input id="first" class="form-control input-sm" type="text" name="first" size="25" value="" title="<?php echo __('first'); ?>" placeholder="<?php echo __('first'); ?>">
                </div>
                <div class="form-group">
                    <label class="control-label" for="last"><?php echo __('last'); ?>:</label>
                    <input id="last" class="form-control input-sm" type="text" name="last" size="25" value="" title="<?php echo __('last'); ?>" placeholder="<?php echo __('last'); ?>">
                </div>
                <div class="form-group">
                    <label class="control-label" for="password"><?php echo __('password'); ?>:</label>
                    <input id="password" class="form-control input-sm" type="password" name="password" size="25" value="" title="<?php echo __('password'); ?>" placeholder="<?php echo __('password'); ?>">
                </div>
                <div class="form-group">
                    <label class="control-label" for="confirm_password"><?php echo __('confirm_password'); ?>:</label>
                    <input id="confirm_password" class="form-control input-sm" type="password" name="confirm_password" size="25" value="" title="<?php echo __('confirm_password'); ?>" placeholder="<?php echo __('confirm_password'); ?>">
                </div>
                <div class="form-group">
                    <label class="control-label" for="img">
                        <?php echo __('image'); ?>:
                    </label>
                    <input class="form-control" type="file" name="img">
                </div>
                <div class="form-group">
                    <label class="control-label" for="type"><?php echo __('user_status'); ?>:</label>
                    <select name="status" id="status" class="form-control input-sm medium" >
                        <option value="">---</option>
                        <?php
                        $user_status_arr = __('user_status_arr');
                        foreach ($user_status_arr as $k => $v) {
                            ?>
                            <option value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <fieldset>
                    <input type="hidden" name="create_user" value="1" /> 
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
                </fieldset>
            </fieldset>
        </div>
    </form>
</section>
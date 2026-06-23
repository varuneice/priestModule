<section class="content-header">
    <h1>
        <?php echo __('edit_user'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>User/index"><?php echo __('title_users'); ?></a></li>
        <li class="active"><?php echo __('edit_user'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$tpl['arr'] = array_merge(
    ['type' => '', 'avatar' => '', 'status' => ''],
    is_array($tpl['arr'] ?? null) ? $tpl['arr'] : []
);
?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>User/edit" method="post" name="edit" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <div class="form-group">
                    <label class="control-label" for="type"><?php echo __('type'); ?>:</label>
                    <?php if ($this->controller->isAdmin()) { ?>
                        <select name="type" id="type" class="form-control input-sm medium" >
                            <option value="">---</option>
                            <?php
                            $type_arr = __('type_arr');
                            foreach ($type_arr as $k => $v) {
                                ?>
                                <option <?php echo ($tpl['arr']['type'] == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    <?php } else {
                        ?>
                        <input type="hidden" name="type" value="<?php echo $tpl['arr']['type'] ?? ''; ?>" />
                        <?php echo $type_arr[$tpl['arr']['type']] ?? ''; ?>
                    <?php }
                    ?>
                </div>
                <div class="form-group">
                    <label class="control-label" for="email"><?php echo __('email'); ?>:</label>
                    <input id="email" class="form-control input-sm" type="text" name="email" size="25" value="<?php echo $tpl['arr']['email'] ?? ''; ?>" title="email" placeholder="email">
                </div>
                <div class="form-group">
                    <label class="control-label" for="confirm_email"><?php echo __('confirm_email'); ?>:</label>
                    <input id="confirm_email" class="form-control input-sm" type="text" name="confirm_email" size="25" value="" title="<?php echo __('confirm_email'); ?>" >
                </div>
                <div class="form-group">
                    <label class="control-label" for="first"><?php echo __('first'); ?>:</label>
                    <input id="first" class="form-control input-sm" type="text" name="first" size="25" value="<?php echo $tpl['arr']['first'] ?? ''; ?>" title="<?php echo __('first'); ?>">
                </div>
                <div class="form-group">
                    <label class="control-label" for="last"><?php echo __('last'); ?>:</label>
                    <input id="last" class="form-control input-sm" type="text" name="last" size="25" value="<?php echo $tpl['arr']['last'] ?? ''; ?>" title="<?php echo __('last'); ?>">
                </div>
                <div class="form-group">
                    <label class="control-label" for="passowrd"><?php echo __('passowrd'); ?>:</label>
                    <input id="password" class="form-control input-sm" type="password" name="password" size="25" value="" title="<?php echo __('passowrd'); ?>">
                </div>
                <div class="form-group">
                    <label class="control-label" for="confirm_passowrd"><?php echo __('confirm_passowrd'); ?>:</label>
                    <input id="confirm_password" class="form-control input-sm" type="password" name="confirm_password" size="25" value="" title="<?php echo __('confirm_passowrd'); ?>" >
                </div>
                <div class="form-group" id="img-file-id">
                    <?php if (is_file(INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/' . $tpl['arr']['avatar'])) { ?>
                        <fieldset>    
                            <div class="view view-tenth">   
                                <img src="<?php echo INSTALL_URL . UPLOAD_PATH . 'avatar/thumb/' . $tpl['arr']['avatar']; ?>" />
                                <div class="mask">
                                    <a rev="<?php echo $tpl['arr']['id'] ?? ''; ?>" class="info btn btn-app btn-danger gallery-delete" href="<?php echo INSTALL_URL; ?>User/deleteImage/<?php echo $tpl['arr']['id'] ?? ''; ?>"><i class="fa fa-times"></i><?php echo __('remove'); ?></a>
                                </div>
                            </div>
                        </fieldset>
                    <?php } else { ?>
                        <label class="control-label" for="img">
                            <?php echo __('image'); ?>:
                        </label>
                        <input class="form-control" type="file" name="img">
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label class="control-label" for="status"><?php echo __('user_status'); ?>:</label>
                    <select name="status" id="status" class="form-control input-sm medium" >
                        <option value="">---</option>
                        <?php
                        $user_status_arr = __('user_status_arr');
                        foreach ($user_status_arr as $k => $v) {
                            ?>
                            <option <?php echo ($tpl['arr']['status'] == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <fieldset>
                    <input type="hidden" name="edit_user" value="1" /> 
                    <input type="hidden" name="id" value="<?php echo $tpl['arr']['id'] ?? ''; ?>" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
                </fieldset>
            </fieldset>
        </div>
    </form>
    <div id="dialogDeleteImage" title="<?php echo htmlspecialchars(__('gallery_del_title')); ?>" style="display:none">
        <p><?php echo __('gallery_del_body'); ?></p>
    </div>
</section>

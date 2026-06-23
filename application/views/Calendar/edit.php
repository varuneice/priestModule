<section class="content-header">
    <h1>
        <?php echo __('edit_calendar'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Calendar/index"><?php echo __('calendars'); ?></a></li>
        <li class="active"><?php echo __('edit_calendar'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<section class="content left width_100">
    <div class="padding-19 nav-tabs-custom left width_100">
        <div class="callout callout-info">
            <p><?php echo __('calendar_edit_info'); ?></p>
        </div>   
        <form id="frm_calendar" class="frm-class" action="<?php echo INSTALL_URL; ?>Calendar/edit" method="post" name="edit">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
            <fieldset>
                 <?php
                if (!$this->controller->isEditor()) {
                    ?>
                <div class="form-group">
                    <label class="control-label" for="user_id"><?php echo __('calendar_owner'); ?>:</label>
                    <select data-rule-required="true" name="user_id"  class="form-control input-sm" >
                        <?php foreach (($tpl['users'] ?? []) as $user) {
                            ?>
                            <option <?php echo ($tpl['arr']['user_id'] == $user['id']) ? "selected='selected'" : ""; ?> value="<?php echo $user['id']; ?>" >
                                <?php
                                if (!empty($user['first']) || !empty($user['last'])) {
                                    echo $user['first'] . ' ' . $user['last'];
                                } else {
                                    echo $user['email'];
                                }
                                ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                 <?php } else {
                    ?>
                    <input type="hidden" name="user_id" value="<?php echo $this->controller->getUserId(); ?>" />
                    <?php
                }
                ?>
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <?php
                        $count = count($tpl['languages']);
                        for ($i = 0; $i < $count; $i++) {
                            ?>
                            <li class="<?php echo ($i == 0) ? "active" : ""; ?>">
                                <a data-toggle="tab" href="#language_<?php echo $tpl['languages'][$i]['id']; ?>">
                                    <?php if (is_file(INSTALL_PATH . UPLOAD_PATH . 'flag/' . $tpl['languages'][$i]['flag'])) { ?>
                                        <img src="<?php echo INSTALL_URL . UPLOAD_PATH . 'flag/' . $tpl['languages'][$i]['flag']; ?>" />
                                        <?php
                                    } else {
                                        echo $tpl['languages'][$i]['language'];
                                    }
                                    ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content">
                        <?php
                        $i = 0;
                        foreach (($tpl['languages'] ?? []) as $language) {
                            ?>
                            <div id="language_<?php echo $language['id']; ?>" class="tab-pane <?php echo ($i == 0) ? "active" : ""; ?>">
                                <div class="form-group">
                                    <label class="control-label" for="title"><?php echo __('calendar_title'); ?>:</label>
                                    <input data-rule-required="true" id="title" class="form-control input-sm" type="text" name="title[<?php echo $language['id']; ?>]" size="25" value="<?php echo $tpl['arr']['i18n'][$language['id']]['title']; ?>" title="<?php echo __('calendar_title'); ?>">
                                </div>
                            </div>
                            <?php
                            $i++;
                        }
                        ?>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <input type="hidden" name="action" value="edit" /> 
                <input type="hidden" name="id" value="<?php echo $tpl['arr']['id'] ?? ''; ?>" />
                <input type="hidden" name="edit_calendar" value="1" /> 
                <button id="submit" class="btn btn-primary" autocomplete="off" value="Save" name="save" tabindex="9"><i class="fa fa-fw fa-save"></i>&nbsp;<?php echo __('save') ?></button>
            </fieldset>
        </form>
    </div>
</section>



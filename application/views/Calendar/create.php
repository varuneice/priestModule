<section class="content-header">
    <h1>
        <?php echo __('add_calendar'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Calendar/index"><?php echo __('calendars'); ?></a></li>
        <li class="active"><?php echo __('add_calendar'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$tpl['languages'] = is_array($tpl['languages'] ?? null) ? $tpl['languages'] : [];
$defaultLanguageId = $this->controller->tpl['default_language']['id'] ?? null;
?>
<section class="content left width_100">
    <form id="frm_calendar" class="frm-class" action="<?php echo INSTALL_URL; ?>Calendar/create" method="post" name="create">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <div class="callout callout-info">
                <p><?php echo __('calendar_type_info'); ?></p>
            </div>
            <fieldset>
                <?php
                if (!$this->controller->isEditor()) {
                    ?>
                    <div class="form-group">
                        <label class="control-label" for="user_id"><?php echo __('calendar_owner'); ?>:</label>
                        <select data-rule-required="true" name="user_id"  class="form-control input-sm" >
                            <option>---</option>
                            <?php foreach (($tpl['users'] ?? []) as $user) {
                                ?>
                                <option value="<?php echo $user['id']; ?>" >
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
                <div class="form-group">
                    <label class="control-label" for="option_id"><?php echo __('copy_options'); ?>:</label>
                    <select data-rule-required="true" id="option_id" name="option_id"  class="form-control input-sm" >
                        <option value="">---</option>
                        <?php foreach (($tpl['calendars'] ?? []) as $calendar) {
                            ?>
                            <option value="<?php echo $calendar['id']; ?>">
                                <?php
                                echo $calendar['i18n'][$defaultLanguageId]['title'] ?? ($calendar['title'] ?? '');
                                ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
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
                                    <input data-rule-required="true"  id="title" class="form-control input-sm" type="text" name="title[<?php echo $language['id']; ?>]" size="25" value="">
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
                <input type="hidden" name="create_calendar" value="1" /> 
                <button id="submit" class="btn btn-primary" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;<?php echo __('save') ?></button>
            </fieldset>
        </div>
    </form>
</section>

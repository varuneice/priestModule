<section class="content-header">
    <h1>
        <?php echo __('settings'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li class="active"><?php echo __('settings'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<section class="content">
    <form id="general-options-id" class="frm-options" action="<?php echo INSTALL_URL; ?>Settings/index" method="post" name="create">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
     <div class="nav-tabs-custom">
         <div class="tab-content">
<?php
foreach (($tpl['general'] ?? []) as $option) {
    $class = '';
    $smtp_class = '';

    if (in_array($option['key'], array('smtp_host', 'smtp_port', 'smtp_pass', 'smtp_user'))) {
        if ($tpl['option_arr_values']['send_email'] == 'mail') {
            $smtp_class = "display_none";
        }
        $class = 'smtp_class';
    } 

    if ($option['type'] == 'string') {
        ?>
        <div class="form-group <?php echo $class . ' ' . $smtp_class; ?>">
            <label class="control-label" for="title"><?php echo $option['title'] ?>:</label>
            <input id="<?php echo $option['key']; ?>" class="form-control input-sm" type="text" name="<?php echo $option['key'] ?>" size="25" value="<?php echo $option['value']; ?>">
        </div>
        <?php
    } elseif ($option['type'] == 'text') {
        ?>
        <div class="form-group <?php echo $class . ' ' . $smtp_class; ?>">
            <label class="control-label" for="body"><?php echo $option['title'] ?>:</label>
            <textarea name="<?php echo $option['key']; ?>" id="<?php echo $option['key'] ?>" class="form-control input-sm height_300" ><?php echo $option['value']; ?></textarea>
        </div>
        <?php
    } elseif ($option['type'] == 'enum') {
        $default = explode("::", $option['value'] ?? '');
        $enum = explode("|", $default[0]);

        $enumLabels = array();
        if (!empty($option['label']) && strpos($option['label'], "|") !== false) {
            $enumLabels = explode("|", $option['label'] ?? '');
        }
        ?>
        <div class="form-group <?php echo $class . ' ' . $smtp_class; ?>">
            <label class="control-label" for="<?php echo $option['key']; ?>"><?php echo $option['title'] ?>:</label>
            <select name="<?php echo $option['key']; ?>" id="<?php echo $option['key']; ?>" class="select-sm" >
                <?php
                foreach ($enum as $k => $el) {
                    if ($default[1] == $el) {
                        ?><option value="<?php echo $default[0] . '::' . $el; ?>" selected="selected"><?php echo array_key_exists($k, $enumLabels) ? stripslashes($enumLabels[$k]) : stripslashes($el); ?></option><?php
                    } else {
                        ?><option value="<?php echo $default[0] . '::' . $el; ?>"><?php echo array_key_exists($k, $enumLabels) ? stripslashes($enumLabels[$k]) : stripslashes($el); ?></option><?php
                    }
                }
                ?>
            </select>
        </div>
        <?php
    } elseif ($option['type'] == 'int') {
        ?>
        <div class="form-group <?php echo $class . ' ' . $smtp_class; ?>">
            <label class="control-label" for="title"><?php echo $option['title'] ?>:</label>
            <input id="<?php echo $option['key'] ?>" class="form-control input-sm int width_100" type="text" name="<?php echo $option['key'] ?>" size="25" value="<?php echo $option['value']; ?>">
        </div>
        <?php
    } elseif ($option['type'] == 'float') {
        ?>
        <div class="form-group <?php echo $class . ' ' . $smtp_class; ?>">
            <label class="control-label" for="title"><?php echo $option['title'] ?>:</label>
            <input id="<?php echo $option['key'] ?>" class="form-control input-sm float" type="text" name="<?php echo $option['key'] ?>" size="25" value="<?php echo $option['value']; ?>">
        </div>
        <?php
    } elseif ($option['type'] == 'price') {
        ?>
        <div class="form-group <?php echo $class . ' ' . $smtp_class; ?>">
            <label class="control-label" for="title"><?php echo $option['title'] ?>:</label>
            <input id="<?php echo $option['key'] ?>" class="form-control input-sm float" type="text" name="<?php echo $option['key'] ?>" size="25" value="<?php echo $option['value']; ?>" title="Title" placeholder="title">
        </div>
        <?php
    }
}
?>
             <input type="hidden" name="update_option" value="1" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button>
             </div>
         </div>
    </form>
</section>

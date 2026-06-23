<div class="callout callout-info" style="float: left;">
    <h4><?php echo __('emails_token_info'); ?></h4>
    <p>
        <?php
        $email_token = __('member_email_token');
        echo '<div class="email-token-class">' . implode('</div><div class="email-token-class">', $email_token) . '</div>';
        ?>
    </p>
</div>
<?php
foreach (($tpl['emails']['member'] ?? []) as $option) {
    if ($option['type'] == 'string') {
        ?>
        <div class="form-group">
            <label class="control-label" for="title" style="width: 100%; float: none;"><?php echo $option['title'] ?>:</label>
            <input id="<?php echo $option['key']; ?>" class="form-control input-sm" type="text" name="<?php echo $option['key'] ?>" size="25" value="<?php echo $option['value']; ?>" title="Title" placeholder="title">
            <div class="control-group"></div>
        </div>
        <?php
    } elseif ($option['type'] == 'text') {
        ?>
        <div class="form-group">
            <label class="control-label" for="body"><?php echo $option['title'] ?>:</label>
            <textarea name="<?php echo $option['key']; ?>" id="<?php echo $option['key'] ?>" class="form-control input-sm height_300" ><?php echo $option['value']; ?></textarea>
            <div class="control-group"></div>
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
        <div class="form-group">
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
            <div class="control-group"></div>
        </div>
        <?php
    } elseif ($option['type'] == 'int') {
        ?>
        <div class="form-group">
            <label class="control-label" for="title"><?php echo $option['title'] ?>:</label>
            <input id="<?php echo $option['key'] ?>" class="form-control input-sm int" type="text" name="<?php echo $option['key'] ?>" size="25" value="<?php echo $option['value']; ?>" title="Title" placeholder="title">
            <div class="control-group"></div>
        </div>
        <?php
    } elseif ($option['type'] == 'float') {
        ?>
        <div class="form-group">
            <label class="control-label" for="title"><?php echo $option['title'] ?>:</label>
            <input id="<?php echo $option['key'] ?>" class="form-control input-sm float" type="text" name="<?php echo $option['key'] ?>" size="25" value="<?php echo $option['value']; ?>" title="Title" placeholder="title">
            <div class="control-group"></div>
        </div>
        <?php
    } elseif ($option['type'] == 'price') {
        ?>
        <div class="form-group">
            <label class="control-label" for="title"><?php echo $option['title'] ?>:</label>
            <input id="<?php echo $option['key'] ?>" class="form-control input-sm float" type="text" name="<?php echo $option['key'] ?>" size="25" value="<?php echo $option['value']; ?>" title="Title" placeholder="title">
            <div class="control-group"></div>
        </div>
        <?php
    }
}
?>
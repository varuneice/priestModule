<div class="main">
    <?php
    if (count($tpl['gallery']) > 0) {
        foreach (($tpl['gallery'] ?? []) as $k => $v) {
            if (is_file(INSTALL_PATH . UPLOAD_PATH . "calendars/thumb/" . $v['thumb'])) {
                ?>
                <div class="view view-tenth">
                    <img src='<?php echo INSTALL_URL . UPLOAD_PATH . "calendars/thumb/" . $v['thumb']; ?>' class='preview'>
                    <div class="mask">
                        <a href="<?php echo INSTALL_URL; ?>Calendar/cropImage/<?php echo $v['id']; ?>" class="info btn btn-app gallery-crop" style="width: 55px;"><i class="fa fa-crop"></i><?php echo __('crop'); ?></a>
                        <a rev="<?php echo $v['id']; ?>" rel="<?php echo $v['calendar_id']; ?>" class="info btn btn-app gallery-delete" href="<?php echo INSTALL_URL; ?>Calendar/deleteImage/<?php echo $v['id']; ?>" style="width: 55px;"><i class="fa fa-times"></i><?php echo __('remove'); ?></a>
                    </div>
                </div>
                <?php
            }
        }
    }
    ?>
</div>
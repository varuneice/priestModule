<div class="callout callout-info">
    <h4><?php echo __('labels_title'); ?></h4>
    <p>
        <?php echo __('labels_title_info'); ?>
    </p>
</div>
<div class="overlay"></div>
<div class="loading-img"></div>
<?php
$count = count($tpl['languages']);
if ($count > 0) {
    ?>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <?php
            for ($i = 0; $i < $count; $i++) {
                ?>
                <li class="<?php echo ((!empty($_POST['language_id']) && $_POST['language_id'] == $tpl['languages'][$i]['id']) || ($i == 0 && empty($_POST['language_id']))) ? "active" : ""; ?>">
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
                <div id="language_<?php echo $language['id']; ?>" class="tab-pane <?php echo ((!empty($_POST['language_id']) && $_POST['language_id'] == $language['id']) || ($i == 0 && empty($_POST['language_id']))) ? "active" : ""; ?>">
                    <table id="gz-shopping-cart-local-table-<?php echo $language['id'] ?>" class="gzblog-table <?php echo (count($tpl['local'][$language['id']]) > 0)?"gz-shopping-cart-local-table":""; ?>" cellpadding="0" cellspacing="0" >
                        <thead>
                            <tr>
                                <th class="">Key</th>
                                <th class=""><?php echo __('field'); ?></th>
                                <th><?php echo __('value'); ?></th>
                                <th><?php echo __('type'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = count($tpl['local'][$language['id']]);
                            if ($count > 0) {
                                for ($i = 0; $i < $count; $i++) {
                                    ?>
                                    <tr class="<?php echo $i % 2 === 0 ? 'odd' : 'even'; ?>">
                                        <td><?php echo $tpl['local'][$language['id']][$i]['key']; ?></td>
                                        <td><?php echo $tpl['local'][$language['id']][$i]['field']; ?></td>
                                        <td><input class="local-value form-control" type="text" value="<?php echo $tpl['local'][$language['id']][$i]['value']; ?>" data-tab="<?php echo $language['id']; ?>" data-id="<?php echo $tpl['local'][$language['id']][$i]['id']; ?>"/></td>
                                        <td><?php echo $tpl['local'][$language['id']][$i]['type']; ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="10">
                                        <?php echo __('no_labels_title'); ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
                $i++;
            }
            ?>
        </div>
    </div>
    <?php
}
?>

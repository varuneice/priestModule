<div class="overlay"></div>
<div class="loading-img"></div>
<table id="gz-abc-user-id" class="gzblog-table" cellpadding="0" cellspacing="0" >
    <thead>
        <tr>
            <th><?php echo __('image'); ?></th>
            <th><?php echo __('name'); ?></th>
            <th><?php echo __('email'); ?></th>
            <th><?php echo __('type'); ?></th>
            <th><?php echo __('label_status'); ?></th>
            <th style="width: 35px;"></th>
            <th style="width: 35px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($tpl['arr']) > 0) {
            foreach (($tpl['arr'] ?? []) as $k => $v) {
                ?>
                <tr>
                    <td>
                        <?php if (is_file(INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/' . $v['avatar'])) { ?>
                        <div class="view view-tenth" style="width: 120px;">   
                                <img src="<?php echo INSTALL_URL . UPLOAD_PATH . 'avatar/thumb/' . $v['avatar']; ?>" />
                            </div>
                        <?php } else {
                            ?>
                            <div class="view view-tenth">   
                                <img src="<?php echo INSTALL_URL . IMG_PATH . 'user.png'; ?>" />
                            </div>
                            <?php
                        }
                        ?>
                    </td>
                    <td><?php echo $v['first'] . ' ' . $v['last']; ?></td>
                    <td><?php echo $v['email']; ?></td>
                    <td>
                        <?php
                        $type_arr = __('type_arr');
                        echo $type_arr[$v['type']];
                        ?>
                    </td>
                    <td>
                        <?php
                        $user_status_arr = __('user_status_arr');
                        echo $user_status_arr[$v['status']];
                        ?>
                    </td>
                    <td><a class="btn btn-success btn-sm icon-edit" href="<?php echo INSTALL_URL; ?>User/edit/<?php echo $v['id']; ?>" rev="<?php echo $v['id']; ?>" ><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td><a class="btn  btn-danger btn-sm icon-delete" rev="<?php echo $v['id']; ?>" href="<?php echo INSTALL_URL; ?>User/delete/<?php echo $v['id']; ?>" ><span class="glyphicon glyphicon-remove"></span></a></td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>
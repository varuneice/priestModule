<?php
$user = $this->controller->getUser();
?>
<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </a>
    <div class="navbar-right">
        <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i>
                    <span><?php echo $user['email']; ?> <i class="caret"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header bg-aqua">
                        <?php if (is_file(INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/' . $user['avatar'])) { ?>
                            <img src="<?php echo INSTALL_URL . UPLOAD_PATH . 'avatar/thumb/' . $user['avatar']; ?>" />
                            <?php
                        } else {
                            ?>
                            <img src="<?php echo INSTALL_URL . IMG_PATH . 'user.png'; ?>" />
                            <?php
                        }
                        ?>
                        <p>
                            <?php echo $user['first'] . ' ' . $user['last']; ?> - <?php
                            $type_arr = __('type_arr');
                            echo $type_arr[$user['type']]
                            ?>
                        </p>
                    </li>
                    <li class="user-footer">
                        <?php if ($this->controller->isAdmin()) { ?>
                            <div class="pull-left">
                                <a href="<?php echo INSTALL_URL ?>User/edit/<?php echo $user['id']; ?>" class="btn btn-default btn-flat">Profile</a>
                            </div>
                        <?php } ?>
                        <div class="pull-right">
                            <a href="<?php echo INSTALL_URL ?>Admin/logout" class="btn btn-default btn-flat"><i class="fa fa-fw fa-sign-out"></i>&nbsp;<?php echo __('sign_out'); ?></a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<aside class="left-side sidebar-offcanvas">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <?php if (is_file(INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/' . $user['avatar'])) { ?>
                    <img src="<?php echo INSTALL_URL . UPLOAD_PATH . 'avatar/thumb/' . $user['avatar']; ?>" />
                    <?php
                } else {
                    ?>
                    <img src="<?php echo INSTALL_URL . IMG_PATH . 'user.png'; ?>" />
                    <?php
                }
                ?>
            </div>
            <div class="pull-left info">
                <?php
                if (!empty($user['first']) && !empty($user['last'])) {
                    ?>
                    <p><?php echo $user['first'] . ' ' . $user['last']; ?></p>
                    <?php
                } else { /*
                  ?>
                  <p><?php echo $user['email']; ?></p>
                  <?php */
                }
                ?>
            </div>
        </div>
        <ul class="sidebar-menu">
            <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
            <li class="<?php echo (@$_REQUEST['controller'] == 'Admin') ? "active" : ""; ?>">
                <a href="<?php echo INSTALL_URL; ?>Admin/dashboard">
                    <i class="fa fa-dashboard"></i> <span><?php echo __('dashboard'); ?></span>
                </a>
            </li>
             <?php } ?>
            <?php if (!$this->controller->isMember()) { ?>
                <li class="treeview <?php echo (@$_REQUEST['controller'] == 'Calendar') ? "active" : ""; ?>">
                    <a href="#">
                        <i class="fa fa-fw fa-calendar"></i>
                        <span><?php echo __('calendars'); ?></span>
                        <i class="fa fa-angle-down pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="<?php echo (@$_REQUEST['controller'] == 'Calendar' && @$_REQUEST['action'] == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Calendar/index"><i class="fa    fa-caret-right"></i><?php echo __('all_calendars'); ?></a></li>
                    </ul>
                </li>
                <li class="treeview <?php echo (@$_REQUEST['controller'] == 'Booking') ? "active" : ""; ?>">
                    <a href="#">
                        <i class="fa fa-fw fa-calendar-o"></i>
                        <span><?php echo __('bookings'); ?></span>
                        <i class="fa fa-angle-down pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="<?php echo (@$_REQUEST['controller'] == 'Booking' && @$_REQUEST['action'] == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Booking/index"><i class="fa    fa-caret-right"></i><?php echo __('all_bookings'); ?></a></li>
                    </ul>
                </li>
               
                <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                    <li class="<?php echo (in_array($_REQUEST['controller'], array('TimePrice'))) ? "active" : ""; ?>">
                        <a href="<?php echo INSTALL_URL; ?>TimePrice/index">
                            <i class="fa fa-fw fa-clock-o"></i>
                            <?php echo __('price_plan'); ?>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($this->controller->isAdmin()) { ?>
                    <li class="treeview <?php echo (@$_REQUEST['controller'] == 'User') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('users'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo (@$_REQUEST['controller'] == 'User' && @$_REQUEST['action'] == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>User/index"><i class="fa    fa-caret-right"></i><?php echo __('all_users'); ?></a></li>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'User' && @$_REQUEST['action'] == 'create') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>User/create"><i class="fa    fa-caret-right"></i><?php echo __('add_users'); ?></a></li>
                        </ul>
                    </li>
                <?php } ?>
                <!-- new menu added-- -->
                <?php if ($this->controller->isAdmin()) { ?>
                    <li style="display:block" class="treeview <?php echo (@$_REQUEST['controller'] == 'Member') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Members'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo (@$_REQUEST['controller'] == 'Member' && @$_REQUEST['action'] == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Member/index"><i class="fa    fa-caret-right"></i><?php echo __('all_members'); ?></a></li>
                            
                        </ul>
                    </li>
                <?php } ?>
                
            <?php } else {
                ?>
                <li  style="display:block" class="<?php echo (@$_REQUEST['controller'] == 'Member') ? "active" : ""; ?>">
                    <a href="<?php echo INSTALL_URL; ?>Member/edit/<?php echo $_SESSION[$this->controller->default_user]['ID']; ?>">
                        <i class="fa fa-fw fa-user"></i> <span><?php echo __('profile'); ?></span>
                    </a>
                </li>
                <?php }
            ?>
            <?php if ($this->controller->isAdmin()) { ?>
                    <li  style="display:block" class="treeview <?php echo (@$_REQUEST['controller'] == 'MemberLog') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Member Logs'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo (@$_REQUEST['controller'] == 'MemberLog' && @$_REQUEST['action'] == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>MemberLog/index"><i class="fa    fa-caret-right"></i><?php echo __('Member Logs'); ?></a></li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if ($this->controller->isAdmin()) { ?>
                    <li style="display:block" class="treeview <?php echo (@$_REQUEST['controller'] == 'donationdata') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Donation'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo (@$_REQUEST['controller'] == 'donationdata' && @$_REQUEST['action'] == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>donationdata/index"><i class="fa    fa-caret-right"></i><?php echo __('Donation'); ?></a></li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if ($this->controller->isAdmin()) { ?>
                    <li style="display:block" class="treeview <?php echo (@$_REQUEST['controller'] == 'Student') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Student'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo (@$_REQUEST['controller'] == 'Student' && @$_REQUEST['action'] == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Student/index"><i class="fa    fa-caret-right"></i><?php echo __('All Student'); ?></a></li>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'Student' && @$_REQUEST['action'] == 'StudentFee') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Student/StudentFee"><i class="fa    fa-caret-right"></i><?php echo __('Student Fee New'); ?></a></li>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'Student' && @$_REQUEST['action'] == 'feeindex') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Student/feeindex"><i class="fa    fa-caret-right"></i><?php echo __('Student Fee'); ?></a></li>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'Student' && @$_REQUEST['action'] == 'subjectindex') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Student/subjectindex"><i class="fa    fa-caret-right"></i><?php echo __('Student Subject'); ?></a></li>
                        </li>
                        </ul>
                    </li>

                <?php }?>
        </ul>
    </section>
</aside>
<style>
            @media only screen and (max-width: 1280px){
              .user-panel{
                margin-top: 46px; 
              }  
            }

            @media only screen and (max-width: 1160px){
                .user-panel{
                margin-top: 46px; 
              }  
               
            }
            @media only screen  and (min-width: 1282px) and (min-width : 1824px) {
                .user-panel{
                margin-top: 46px; 
              }  
            } 
            /* @media screen and (max-width: )  */

            @media only screen  and (min-width: 1825px) and (min-width : 1920px )  {
                .user-panel{
                margin-top: 46px; 
              }  
            } 
</style>


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
             <?php if ($this->controller->isAdmin() || $this->controller->isEditor()|| $this->controller->isRental()) { ?>
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
                <?php } ?>
                <?php if ($this->controller->isAdmin() || $this->controller->isEditor()) { ?>
                <li class="treeview <?php echo (@$_REQUEST['controller'] == 'Booking') ? "active" : ""; ?>">
                    <a href="#">
                        <i class="fa fa-fw fa-calendar-o"></i>
                        <span><?php echo __('bookings'); ?></span>
                        <i class="fa fa-angle-down pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="<?php echo (@$_REQUEST['controller'] == 'Booking' && @$_REQUEST['action'] == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Booking/index"><i class="fa    fa-caret-right"></i><?php echo __('all_bookings'); ?></a></li>
                        <li class="<?php echo (@$_REQUEST['controller'] == 'Booking' && @$_REQUEST['action'] == 'priestpriceindex') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Booking/priestpriceindex"><i class="fa fa-caret-right"></i><?php echo __('All Puja Price'); ?></a></li> 
                        <li class="<?php echo (@$_REQUEST['controller'] == 'Booking' && @$_REQUEST['action'] == 'preiestpricecreate') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Booking/preiestpricecreate"><i class="fa fa-caret-right"></i><?php echo __('Add New Puja'); ?></a></li> 
                    
                    </ul>
                </li>
               
                    <li class="<?php echo (in_array($_REQUEST['controller'], array('TimePrice'))) ? "active" : ""; ?>">
                        <a href="<?php echo INSTALL_URL; ?>TimePrice/index">
                            <i class="fa fa-fw fa-clock-o"></i>
                            <?php echo __('price_plan'); ?>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($this->controller->isRental()) { ?>
                    <li class="<?php echo (in_array($_REQUEST['controller'], array('TimePrice'))) ? "active" : ""; ?>">
                        <a href="<?php echo INSTALL_URL; ?>TimePrice/rentalindex">
                            <i class="fa fa-fw fa-clock-o"></i>
                            <?php echo __('Day Off'); ?>
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
                 <?php if ($this->controller->isAdmin()||$this->controller->isRegistration() || $this->controller->isRental()|| $this->controller->isEducation() || $this->controller->isEvents()) { ?>
                    <li class="treeview <?php echo (in_array(@$_REQUEST['controller'], array('Member', 'MemberCategory'))) ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Members'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo (@$_REQUEST['controller'] == 'Member' && @$_REQUEST['action'] == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Member/index"><i class="fa    fa-caret-right"></i><?php echo __('all_members'); ?></a></li>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'Member' && @$_REQUEST['action'] == 'create') ? "active" : ""; ?>" style="display:none;"><a href="<?php echo INSTALL_URL; ?>Member/create"><i class="fa  fa-caret-right"></i><?php echo __('add_members'); ?></a></li>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'Member' && @$_REQUEST['action'] == 'membersReport') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Member/membersReport"><i class="fa  fa-caret-right"></i><?php echo __( 'Renew/Maintenance Report'); ?></a></li>
<li class="<?php echo (@$_REQUEST['controller'] == 'MemberCategory' && @$_REQUEST['action'] == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>MemberCategory/index"><i class="fa  fa-caret-right"></i><?php echo __('Category'); ?></a></li>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php if ($this->controller->isMember()) { ?>
                <li class="<?php echo (@$_REQUEST['controller'] == 'Member') ? "active" : ""; ?>">
                    <a href="<?php echo INSTALL_URL; ?>Member/edit/<?php echo $_SESSION[$this->controller->default_user]['ID']; ?>">
                        <i class="fa fa-fw fa-user"></i> <span><?php echo __('profile'); ?></span>
                    </a>
                </li>
                <?php } ?>
                 <!--menu Memberlogs -- -->
                 <?php if ($this->controller->isAdmin()) { ?>
                    <li class="treeview <?php echo (@$_REQUEST['controller'] == 'MemberLog') ? "active" : ""; ?>">
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
                
                <?php if ($this->controller->isAdmin()|| $this->controller->isRegistration() || $this->controller->isEvents()) { ?>
                    <li class="treeview <?php echo (@$_REQUEST['controller'] == 'donationdata') ? "active" : ""; ?>">
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
                    <li class="treeview <?php echo (@$_REQUEST['controller'] == 'giftshop') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Other Payment'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo (@$_REQUEST['controller'] == 'giftshop' && @$_REQUEST['action'] == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>giftshop/index"><i class="fa    fa-caret-right"></i><?php echo __('Other Payment'); ?></a></li>
                        </ul>
                    </li>
                <?php } ?>
                 <?php if ($this->controller->isAdmin()) { ?>
                    <li style="display:block;" class="treeview <?php echo (@$_REQUEST['controller'] == 'Adminpayment') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Admin Payment'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                             <li class="<?php echo (@$_REQUEST['controller'] == 'Adminpayment' && @$_REQUEST['action'] == 'Adminpayment') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Adminpayment/Adminpayment"><i class="fa    fa-caret-right"></i><?php echo __('Admin Payment'); ?></a></li> 
                              <li class="<?php echo (@$_REQUEST['controller'] == 'Adminpaymentstudent' && @$_REQUEST['action'] == 'Adminpaymentstudent') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Adminpaymentstudent/Adminpaymentstudent"><i class="fa    fa-caret-right"></i><?php echo __('Admin Payment student'); ?></a></li>
                              <li style = "display:block;" class="<?php echo (@$_REQUEST['controller'] == 'RentalBooking' && @$_REQUEST['action'] == 'create') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>RentalBooking/create"><i class="fa fa-caret-right"></i><?php echo __('Admin Rental Booking'); ?></a></li>
                              
                               <li style = "display:none;" class="<?php echo (@$_REQUEST['controller'] == 'Adminpayment' && @$_REQUEST['action'] == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Adminpayment/index"><i class="fa fa-caret-right"></i><?php echo __('Year wise revenue'); ?></a></li>
                        </ul>
                    </li>
                <?php } ?>
                 
                 <!-- <?php if ($this->controller->isAdmin() || $this->controller->isVolunteer() || $this->controller->isParkingAdmin()) { ?>
                    <li style="display:none;" class="treeview <?php echo (@$_REQUEST['controller'] == 'Badges') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Parking'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo (@$_REQUEST['controller'] == 'Badges' && @$_REQUEST['action'] == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Badges/index"><i class="fa    fa-caret-right"></i><?php echo __('Parking'); ?></a></li>
                             <li class="<?php echo (@$_REQUEST['controller'] == 'Badges' && @$_REQUEST['action'] == 'matrix') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Badges/Matrix"><i class="fa    fa-caret-right"></i><?php echo __('Matrix'); ?></a></li>
                        </ul>
                    </li>
                <?php } ?>

               <?php if ($this->controller->isAdmin() || $this->controller->isBadgesVolunteer() || $this->controller->isBadgesAdmin()) { ?>
                    <li  style="display:none;" class="treeview <?php echo (@$_REQUEST['controller'] == 'BadgesAssign') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Badges'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo (@$_REQUEST['controller'] == 'BadgesAssign' && @$_REQUEST['action'] == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>BadgesAssign/index"><i class="fa    fa-caret-right"></i><?php echo __('Badges'); ?></a></li>
                             <li class="<?php echo (@$_REQUEST['controller'] == 'BadgesAssign' && @$_REQUEST['action'] == 'badgesreport') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>BadgesAssign/Badgesreport"><i class="fa    fa-caret-right"></i><?php echo __('Badges report'); ?></a></li>
                        </ul>
                    </li>
                <?php } ?>
                
                <?php if ($this->controller->isAdmin() || $this->controller->isFoodcouponVolunteer() || $this->controller->isFoodcouponAdmin()) { ?>
                    <li style="display:none;" class="treeview <?php echo (@$_REQUEST['controller'] == 'Foodcoupon') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Food coupons'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo (@$_REQUEST['controller'] == 'Foodcoupon' && @$_REQUEST['action'] == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Foodcoupon/index"><i class="fa    fa-caret-right"></i><?php echo __('Food coupons'); ?></a></li>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'Foodcoupon' && @$_REQUEST['action'] == 'report') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Foodcoupon/Foodcouponsreport"><i class="fa    fa-caret-right"></i><?php echo __('Report'); ?></a></li>
                        </ul>
                    </li>
                <?php } ?> -->



                <?php if ($this->controller->isAdmin() || $this->controller->isEvents()) { ?>
                    <li class="treeview <?php echo (@$_REQUEST['controller'] == 'Eventadmin') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Event'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?php echo (@$_REQUEST['controller'] == 'Eventadmin' && @$_REQUEST['action'] == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Eventadmin/index"><i class="fa    fa-caret-right"></i><?php echo __('Event'); ?></a></li>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'Eventadmin' && @$_REQUEST['action'] == 'eventindex') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Eventadmin/eventindex"><i class="fa fa-caret-right"></i><?php echo __('All Event'); ?></a></li>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'Eventadmin' && @$_REQUEST['action'] == 'create') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Eventadmin/create"><i class="fa  fa-caret-right"></i><?php echo __('Add Event'); ?></a></li>
                           
                        </ul>
                    </li>
                    <?php } ?> 
                    
                     <?php if ($this->controller->isAdmin()|| $this->controller->isEducation()) { ?>
                    <li class="treeview <?php echo (@$_REQUEST['controller'] == 'Student') ? "active" : ""; ?>">
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
                            <li class="<?php echo (@$_REQUEST['controller'] == 'Student' && @$_REQUEST['action'] == 'RegistrationLasteDateindex') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Student/RegistrationLasteDateindex"><i class="fa    fa-caret-right"></i><?php echo __('Registration Last Date'); ?></a></li>
                        </li>
                        </ul>
                    </li>

                <?php }?>
              
              <?php if ($this->controller->isAdmin()|| $this->controller->isRental()) { ?>
                    <li style="display:block;" class="treeview <?php echo (@$_REQUEST['controller'] == 'RentalBooking') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Rental Booking'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                      <ul class="treeview-menu">
                            <li class="<?php echo (@$_REQUEST['controller'] == 'RentalBooking' && @$_REQUEST['action'] == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>RentalBooking/index"><i class="fa    fa-caret-right"></i><?php echo __('All Booking'); ?></a></li>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'RentalBooking' && @$_REQUEST['action'] == 'rentalpricecreate') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>RentalBooking/rentalpricecreate"><i class="fa fa-caret-right"></i><?php echo __('Add Amount'); ?></a></li>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'RentalBooking' && @$_REQUEST['action'] == 'categoryitemindex') ? "active" : ""; ?>" style="display:none;"><a href="<?php echo INSTALL_URL; ?>RentalBooking/categoryitemindex"><i class="fa fa-caret-right"></i><?php echo __('All Category & Items'); ?></a></li>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'RentalBooking' && @$_REQUEST['action'] == 'categorycreate') ? "active" : ""; ?>" style="display:none;"><a href="<?php echo INSTALL_URL; ?>RentalBooking/categorycreate"><i class="fa fa-caret-right"></i><?php echo __('Add Category'); ?></a></li>
                            <li class="<?php echo (@$_REQUEST['controller'] == 'RentalBooking' && @$_REQUEST['action'] == 'itemscreate') ? "active" : ""; ?>"  style="display:none;"><a href="<?php echo INSTALL_URL; ?>RentalBooking/itemscreate"><i class="fa fa-caret-right"></i><?php echo __('Add Items'); ?></a></li>
                        </ul>
                    </li>
                <?php }?>
                <?php ?>
                 <?php if ($this->controller->isAdmin()) { ?>
                    <li style="display:none" class="treeview <?php echo (@$_REQUEST['controller'] == 'vendordata') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Vendor Payment'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                             <li   class="<?php echo (@$_REQUEST['controller'] == 'vendordata' && @$_REQUEST['action'] == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>vendordata/index"><i class="fa    fa-caret-right"></i><?php echo __('Vendor Payment'); ?></a></li> 
                        </ul>
                    </li>
                <?php } ?>
                 <?php if ($this->controller->isAdmin() || $this->controller->isVendor()) { ?>
                    <li style="display:block" class="treeview <?php echo (@$_REQUEST['controller'] == 'vendordata') ? "active" : ""; ?>">
                        <a href="#">
                            <i class="fa fa-fw fa-user"></i>
                            <span><?php echo __('Vendor Payment'); ?></span>
                            <i class="fa fa-angle-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                             <li   class="<?php echo (@$_REQUEST['controller'] == 'vendordata' && @$_REQUEST['action'] == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>vendordata/index"><i class="fa    fa-caret-right"></i><?php echo __('Vendor Payment'); ?></a></li> 
                             <li   class="<?php echo (@$_REQUEST['controller'] == 'vendordata' && @$_REQUEST['action'] == 'vendorpricecreate') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>vendordata/vendorpricecreate"><i class="fa    fa-caret-right"></i><?php echo __('Vendor Payment Price'); ?></a></li> 
                              <li   class="<?php echo (@$_REQUEST['controller'] == 'vendordata' && @$_REQUEST['action'] == 'vendorheading') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>vendordata/vendorheading"><i class="fa    fa-caret-right"></i><?php echo __('Vendor Heading'); ?></a></li> 
                              <li   class="<?php echo (@$_REQUEST['controller'] == 'vendordata' && @$_REQUEST['action'] == 'vendorpaymentfor') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>vendordata/vendorpaymentfor"><i class="fa    fa-caret-right"></i><?php echo __('Vendor Payment For New'); ?></a></li>
                             
                            </ul>
                    </li>
                <?php } ?>
                
        </ul>
    </section>
</aside>

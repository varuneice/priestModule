<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>HDBS</title>
          <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
        <?php
        $user = $this->controller->getUser();
        foreach ($this->controller->css as $css) {
            echo '<link type="text/css" rel="stylesheet" href="' . (isset($css['remote']) && $css['remote'] ? NULL : INSTALL_URL) . $css['path'] . $css['file'] . '" />';
        }
        foreach ($this->controller->js as $js) {
            echo '<script type="text/javascript" src="' . (isset($js['remote']) && $js['remote'] ? NULL : INSTALL_URL) . $js['path'] . $js['file'] . '"></script>';
        }
        ?>
    </head>
    <body class="skin-blue">
        <header class="header">
        <?php 
         if($this->controller->isLoged()){
        if ($this->controller->isAdmin()) { ?>
            <a href="javascript:void(0);" class="logo" title="HDBS-PAYMENT|Booking System">
            HDBS Payment
            </a>
          <?php }else if($this->controller->isEditor()) { ?>
            <a href="javascript:void(0);" class="logo" title="HDBS-PAYMENT|Booking System">
            Priest Service Dashboard
            </a>
              <?php }else if($this->controller->isParkingAdmin() || $this->controller->isVolunteer()) { ?>
            <a href="javascript:void(0);" class="logo" title="HDBS-PAYMENT|Parking System">
            Parking Dashboard
            </a>
            <?php }
            else if($this->controller->isBadgesAdmin() || $this->controller->isBadgesVolunteer()) { ?>
                <a href="javascript:void(0);" class="logo" title="HDBS-PAYMENT|Badges System">
                Badges Dashboard
                </a>
                <?php }
            else if($this->controller->isFoodcouponAdmin() || $this->controller->isFoodcouponVolunteer()) { ?>
                <a href="javascript:void(0);" class="logo" title="HDBS-PAYMENT|Food Coupons System">
                Food Coupons Dashboard
                </a>
                <?php }
                else if($this->controller->isEducation()) { ?>
                        <a href="javascript:void(0);" class="logo" title="HDBS-Education">
                        HDBS-Education
                    </a>
                     <?php }
                else if($this->controller->isRental()) { ?>
                        <a href="javascript:void(0);" class="logo" title="HDBS-Rental">
                        HDBS-Rental
                    </a>
                    <?php }
                else if($this->controller->isRegistration()) { ?>
                        <a href="javascript:void(0);" class="logo" title="HDBS-Membership/Donation">
                        HDBS-Membership/Donation
                    </a>
                     <?php }
                 else if($this->controller->isEvents()) { ?>
                    <a href="javascript:void(0);" class="logo" title="HDBS-Events">
                    HDBS-Events
                </a>
                <?php }
                 else if($this->controller->isVendor()) { ?>
                    <a href="javascript:void(0);" class="logo" title="HDBS-Vendor">
                    HDBS-Vendor
                </a>
                <?php }else{ ?>
                <a href="javascript:void(0);" class="logo" title="HDBS-PAYMENT|Booking System">
                Member Dashboard
                </a>
                <?php } 
           
            require_once VIEWS_PATH . 'Layouts/admin/menu/navbar_static_top.php';
            }
         ?>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left" id="gz-time-slot-booking-container-id">
            <?php
            if($this->controller->isLoged()){
                require_once VIEWS_PATH . 'Layouts/admin/menu/sidebar.php';
            }
            ?>
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side <?php echo (!$this->controller->isLoged())?"strech":""; ?>">
                <?php
                require $content_tpl;
                ?>
            </aside><!-- /.right-side -->
            <a class="btn btn-icon btn-info btn-scroll-to-top fade" data-click="scroll-top" href="javascript:;">
                <i class="fa fa-angle-up"></i>
            </a>
            <?php
            require_once VIEWS_PATH . 'Layouts/admin/footer.php';
            ?>
        </div>
        <div id="container-abc-url-id" style="display: none;"><?php echo INSTALL_URL; ?></div>
    </div>




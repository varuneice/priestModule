<head>
    <meta charset="UTF-8">
    <title>HDBS</title>
    <link rel="stylesheet"
        href="<?= INSTALL_URL ?>application/web/css/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet"
        href="<?= INSTALL_URL ?>application/web/css/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?= INSTALL_URL ?>application/web/css/assets/css/style1.css">
    <link rel="stylesheet" href="<?= INSTALL_URL ?>application/web/css/jquery.signature.css">

    <style>
        
    /* CSS for Extra Large (xl) screen */
    @media only screen and (max-width: 1440px) {

        /* Write your code here */
        #sig {
            width: 100px !important;
        }
        

    }

    /* CSS for Extra Large (xl) screen */
    @media only screen and (max-width: 1366px) {

        /* Write your code here */
        #sig {
            width: 100px !important;
        }
    }

    /* CSS for Large (lg) screen */
    @media only screen and (max-width: 1280px) {

        /* Write your code here */
        #sig {
            width: 100px !important;
        }
    }

    /* CSS for Large (lg) screen */
    @media only screen and (max-width: 1152px) {

        /* Write your code here */
        #sig {
            width: 100px !important;
        }

    }

    /* CSS for Large (lg) screen */
    @media only screen and (max-width: 1024px) {

        /* Write your code here */
        #sig {
            width: 100px !important;
        }

    }

    /* CSS for Large (lg) screen */
    @media only screen and (max-width: 992px) {

        /* Write your code here */
        #sig {
            width: 100px !important;
        }

    }

    /* CSS for Medium (md) screen */
    @media only screen and (max-width: 800px) {

        /* Write your code here */
        #sig {
            width: 100px !important;
        }

    }

    /* CSS for Medium (md) screen */
    @media only screen and (max-width: 768px) {
        #sig {
            width: 100px !important;
        }

    }

    /* CSS for Medium (md) screen */
    @media only screen and (max-width: 600px) {

        /* Write your code here */
        #sig {
            width: 100px !important;
        }

    }

    /* CSS for Extra Small (xs) screen */
    @media only screen and (max-width: 414px) {

        /* Write your code here */
        #sig {
            width: 100px !important;
        }

    }

    /* CSS for Extra Small (xs) screen */
    @media only screen and (max-width: 394px) {

        /* Write your code here */
        #sig {
            width: 100px !important;
        }

    }

    /* CSS for Extra Small (xs) screen */
    @media only screen and (max-width: 375px) {

        /* Write your code here */
        #sig {
            width: 100px !important;
        }

    }

    /* CSS for Extra Small (xs) screen */
    @media only screen and (max-width: 360px) {

        /* Write your code here */
        #sig {
            width: 100px !important;
        }

    }

    /* CSS for Extra Small (xs) screen */
    @media only screen and (max-width: 320px) {

        /* Write your code here */
        #sig {
            width: 100px !important;
        }

    }

    /* CSS for Extra Small (md) & Landscap screen */
    @media only screen and (max-width: 823px) and (min-width:801px) {

        /* Write your code here */
        #sig {
            width: 100px !important;
        }

    }

    /* CSS for Small (sm) & Landscap screen */
    @media only screen and (max-width: 667px) and (min-width:601px) {

        /* Write your code here */
        #sig {
            width: 100px !important;
        }

    }

    /* CSS for Small (sm) & Landscap Mobile screen */
    @media only screen and (max-width: 568px) {

        /* Write your code here */
        #sig {
            width: 100px !important;
        }

    }

    input {
        font-weight: bold;
    }

    .bg-gradient-green {
        background: linear-gradient(to right, #219839, #59b387) !important;
    }

    .bg-gradient-orange {
        background: linear-gradient(to right, #ea764b, #d77c48) !important;
    }



    .form-control {
        font-size: 17px;
    }

    .ui-datepicker-calendar {
        display: none;
    }

    td {
        text-align: center;
    }

    .ui-datepicker-month {
        display: none;
    }

    .ui-icon-circle-triangle-w {
        width: 35px !important;
    }

    .ui-icon.ui-icon-circle-triangle-e {
        width: 35px !important;
        margin-left: -29px !important;
        font: bold;
    }

    .icheckbox_minimal {
        display: none;
    }

    .sr-only {
        display: none;
    }
    </style>
</head>
<section class="content-header">
    <h1>
        <?php echo __('edit_Foodcoupon'); ?>
    </h1>
    <?php if (!$this->controller->isMember()) { ?>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Foodcoupon/foodcoupon"><?php echo __('Foodcoupon'); ?></a></li>
        <li class="active"><?php echo __('edit_Foodcoupon'); ?></li>
    </ol>
    <?php } ?>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$allotparking = $tpl['foodarr']['Parking_AreaAssigned'] ?? ''; 
$volunteer =  $this->controller->isFoodcouponVolunteer();
$couponStatus = $tpl['foodarr']['Status'] ?? ''; 
$stu = $tpl['foodarr']['Student'] ?? ''; 
$datedb = $tpl['foodarr']['Date'] ?? '';  
$pujatype = $tpl['foodarr']['PujaType'] ?? '';

if($pujatype == "kali")
{
    $today = date("Y");
    $pujname = "Kali Puja Food Coupons";
    $fullpujaname = $today ." ". $pujname;

}

if ($pujatype == "saraswati") {
    $today = date("Y");
    $pujaname = "Saraswati Puja Food Coupons";
    $fullpujaname = $today ." ". $pujaname;
}
?>
<section class="content left width_100">
    <form id="badges-form" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Foodcoupon/edit"
        method="post" name="edit" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 stretch-card1 grid-margin1">
                        <table class="table1">
                            <tr class="tr">
                                <td style="font-size: xx-large;" class="td"><?php echo "$fullpujaname"?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-orange card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>First 
                                        &nbsp;</b><i class="mdi  float-right"></i>
                                </h4>
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>Name
                                        &nbsp;</b><i class="mdi  float-right"></i>
                                </h4>
                                <h2 class="mb-5"> <b><input readonly id="Your_Name" class="form-control input-sm"
                                            type="text" name="F_Name" size="25"
                                            value="<?php echo $tpl['foodarr']['F_Name'] ?? ''; ?>" title="First Name"
                                            placeholder="First Name"></b></h2>
                                <!-- <h2 class="mb-5"><?php echo $tpl['foodarr']['F_Name'] ?? ''; ?></h2> -->

                            </div>
                        </div>
                    </div>



                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-orange card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>Last
                                        </b><i class="mdi  float-right"></i>
                                </h4>
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>
                                        Name</b><i class="mdi  float-right"></i>
                                </h4>
                                <h2 class="mb-5"> <input readonly id="last name" class="form-control input-sm"
                                        type="text" name="L_Name" size="25"
                                        value="<?php echo $tpl['foodarr']['L_Name'] ?? ''; ?>" title="Last Name"
                                        placeholder="Last Name"></h2>
                                <!-- <h2 class="mb-5"> <?php echo $tpl['arr']['L_Name'] ?? ''; ?></h2> -->

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-orange card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>Spouse
                                    </b><i class="mdi  float-right"></i>
                                </h4>
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>
                                        Name</b><i class="mdi  float-right"></i>
                                </h4>
                                <h2 class="mb-5"> <input readonly id="Spouse" class="form-control input-sm" type="text"
                                        name="Sp_FName" size="25" value="<?php echo $tpl['foodarr']['Sp_FName'] ?? ''; ?>"
                                        title="Spouse Name" placeholder="Spouse Name"></h2>
                                <!-- <h2 class="mb-5"> <?php echo $tpl['foodarr']['Sp_FName'] ?? ''; ?></h2> -->

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>Parent 1
                                        </b><i class="mdi  mdi-24px float-right"></i>
                                </h4>
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>
                                        Name</b><i class="mdi  mdi-24px float-right"></i>
                                </h4>
                                <?php if ($this->controller->isFoodcouponAdmin() || $this->controller->isAdmin())  { ?>
                                <h2 class="mb-5"> <input id="Parent1" class="form-control input-sm" type="text"
                                        name="Parent1" size="25" value="<?php echo $tpl['foodarr']['Parent1'] ?? ''; ?>"
                                        title="Parent1" placeholder="Parent 1 Name"></h2>
                                <?php
                                } else {
                                    ?>
                                <h2 class="mb-5"> <input readonly id="Parent1" class="form-control input-sm" type="text"
                                        name="Parent1" size="25" value="<?php echo $tpl['foodarr']['Parent1'] ?? ''; ?>"
                                        title="Parent1" placeholder="Parent 1 Name"></h2>
                                <?php
                            } ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>Child 1 
                                        </b><i class="mdi  mdi-24px float-right"></i>
                                </h4>
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>Name
                                        </b><i class="mdi  mdi-24px float-right"></i>
                                </h4>
                               
                                <?php if ($this->controller->isFoodcouponAdmin() || $this->controller->isAdmin())  { ?>
                                <h2 class="mb-5"><input id="Child1" class="form-control input-sm" type="text"
                                        name="Child1" size="25" value="<?php echo $tpl['foodarr']['Child1'] ?? ''; ?>"
                                        title="Child1" placeholder="Child 1 Name"></h2>
                                <?php
                                } else {
                                    ?>

                                <h2 class="mb-5"><input readonly id="Child1" required="true"
                                        class="form-control input-sm" type="text" name="Child1" size="25"
                                        value="<?php echo $tpl['foodarr']['Child1'] ?? ''; ?>" title="Child1"
                                        placeholder="Child 1 Name"></h2>
                                <?php
                            } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>Child 2
                                        </b><i class="mdi  mdi-24px float-right"></i>

                                </h4>

                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>
                                        Name</b><i class="mdi  mdi-24px float-right"></i>

                                </h4>
                                <?php if ($this->controller->isFoodcouponAdmin() || $this->controller->isAdmin())  { ?>
                                <h2 class="mb-5"> <input id="Child2" class="form-control input-sm" type="text"
                                        name="Child2" size="25" value="<?php echo $tpl['foodarr']['Child2'] ?? ''; ?>"
                                        title="Child2" placeholder="Child 2 Name"></h2>

                                <?php
                                } else {
                                    ?>
                                <h2 class="mb-5"> <input readonly id="Child2" class="form-control input-sm" type="text"
                                        name="Child2" size="25" value="<?php echo $tpl['foodarr']['Child2'] ?? ''; ?>"
                                        title="Child2" placeholder="Child 2 Name"></h2>
                                <?php
                            } ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>Child 3
                                        </b><i class="mdi  float-right"></i>
                                </h4>
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>
                                        Name</b><i class="mdi  float-right"></i>
                                </h4>

                                <?php if ($this->controller->isFoodcouponAdmin() || $this->controller->isAdmin())  { ?>
                                <h2 class="mb-5"> <input id="Child3" class="form-control input-sm" type="text"
                                        name="Child3" size="25" value="<?php echo $tpl['foodarr']['Child3'] ?? ''; ?>"
                                        title="Child3" placeholder="Child 3 Name"
                                        style="font-weight:bold; font-size:15px; color:black;"></h2>

                                <?php
                                } else {
                                    ?>

                                <h2 class="mb-5"> <input readonly id="Child3" class="form-control input-sm" type="text"
                                        name="Child3" size="25" value="<?php echo $tpl['foodarr']['Child3'] ?? ''; ?>"
                                        title="Child3" placeholder="Child 3 Name"
                                        style="font-weight:bold; font-size:15px; color:black;"></h2>

                                <?php
                            } ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>Parent 2
                                        </b><i class="mdi  mdi-24px float-right"></i>
                                </h4>
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>
                                        Name</b><i class="mdi  mdi-24px float-right"></i>
                                </h4>
                                <?php if ($this->controller->isFoodcouponAdmin() || $this->controller->isAdmin())  { ?>
                                <h2 class="mb-5"> <input id="Parent2" class="form-control input-sm" type="text"
                                        name="Parent2" size="25" value="<?php echo $tpl['foodarr']['Parent2'] ?? ''; ?>"
                                        title="Parent2" placeholder="Parent 2 Name"
                                        style="font-weight:bold; font-size:15px; color:black;"></h2>

                                <?php
                                } else {
                                    ?>
                                <h2 class="mb-5"> <input readonly id="Parent2" class="form-control input-sm" type="text"
                                        name="Parent2" size="25" value="<?php echo $tpl['foodarr']['Parent2'] ?? ''; ?>"
                                        title="Parent2" placeholder="Parent 2 Name"
                                        style="font-weight:bold; font-size:15px; color:black;"></h2>
                                <?php
                            } ?>

                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>Regular
                                        #</b> <i class="mdi  mdi-24px float-right"></i>
                                </h4>
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>Adults
                                        </b> <i class="mdi  mdi-24px float-right"></i>
                                </h4>
                                <?php if ($this->controller->isFoodcouponAdmin() || $this->controller->isAdmin())  { ?>
                                <h2 class="mb-5"> <input id="Adult" class="form-control input-sm" type="number"
                                        name="Adult" size="25" value="<?php echo $tpl['foodarr']['Adult'] ?? ''; ?>"
                                        title="Adult" placeholder="Adults #"></h2>
                                <?php
                                } else {
                                    ?>
                                <h2 class="mb-5"> <input readonly id="Adult" class="form-control input-sm" type="number"
                                        name="Adult" size="25" value="<?php echo $tpl['foodarr']['Adult'] ?? ''; ?>"
                                        title="Adult" placeholder="Adults #"></h2>
                                <?php
                            } ?>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-green card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>Veggies #</b><i class="mdi  mdi-24px float-right"></i>
                                </h4>

                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>
                                &nbsp; &nbsp;</b><i class="mdi  mdi-24px float-right"></i>
                                </h4>
                                <?php if ($this->controller->isFoodcouponAdmin() || $this->controller->isAdmin())  { ?>
                                <h2 class="mb-5">
                                    <input  id="SeqNo" class="form-control mb-5" type="number" name="Veggies"
                                        size="12" value="<?php echo $tpl['foodarr']['Veggies'] ?? ''; ?>" title="Veggies"
                                        placeholder="Veggies">
                                </h2>
                                <?php
                                } else {
                                    ?>

                                <h2 class="mb-5">
                                    <input  id="SeqNo" readonly class="form-control mb-5" type="number" name="Veggies"
                                        size="12" value="<?php echo $tpl['foodarr']['Veggies'] ?? ''; ?>" title="Veggies"
                                        placeholder="Veggies">
                                </h2>
                                <!-- <h2 class="mb-5"><?php echo $tpl['foodarr']['Veggies'] ?? ''; ?></h2> -->
                                <?php
                            } ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>Parents
                                        #</b><i class="mdi  mdi-24px float-right"></i>
                                </h4>
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>&nbsp;
                                        </b><i class="mdi  mdi-24px float-right"></i>
                                </h4>
                                <?php if ($this->controller->isFoodcouponAdmin() || $this->controller->isAdmin())  { ?>
                                <h2 class="mb-5"> <input id="Child" class="form-control input-sm" type="number"
                                        name="Parents" size="25" value="<?php echo $tpl['foodarr']['Parents'] ?? ''; ?>"
                                        title="Parents " placeholder="Parents #"
                                        style="font-weight:bold; font-size:15px; color:black;"></h2>
                                <?php
                                } else {
                                    ?>
                                <h2 class="mb-5"> <input readonly id="Child" class="form-control input-sm" type="number"
                                        name="Parents" size="25" value="<?php echo $tpl['foodarr']['Parents'] ?? ''; ?>"
                                        title="Parents " placeholder="Parents #"
                                        style="font-weight:bold; font-size:15px; color:black;"></h2>
                                <?php
                            } ?>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>Total #</b>
                                    <i class="mdi  mdi-24px float-right"></i>
                                </h4>
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>&nbsp;</b>
                                    <i class="mdi  mdi-24px float-right"></i>
                                </h4>
                                <?php if ($this->controller->isFoodcouponAdmin() || $this->controller->isAdmin())  { ?>
                                <h2 class="mb-5"> <input id="Total" class="form-control input-sm" type="number"
                                        name="Total" size="25" value="<?php echo $tpl['foodarr']['Total'] ?? ''; ?>"
                                        title="Total" placeholder="Total #"></h2>
                                <?php
                                } else {
                                    ?>
                                <h2 class="mb-5"> <input readonly id="Total" class="form-control input-sm" type="number"
                                        name="Total" size="25" value="<?php echo $tpl['foodarr']['Total'] ?? ''; ?>"
                                        title="Total" placeholder="Total #"></h2>
                                <?php
                            } ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>YTD</b><i
                                        class="mdi  mdi-24px float-right"></i>
                                </h4>
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>&nbsp;</b><i
                                        class="mdi  mdi-24px float-right"></i>
                                </h4>
                                <?php if ($this->controller->isFoodcouponAdmin() || $this->controller->isAdmin())  { ?>
                                <h2 class="mb-5"> <input id="YTD" class="form-control input-sm" type="text" name="YTD"
                                        size="25" value="<?php echo $tpl['foodarr']['YTD'] ?? ''; ?>" title="YTD "
                                        placeholder="YTD" style="font-weight:bold; font-size:15px; color:black;"></h2>
                                <?php
                                } else {
                                    ?>

                                <h2 class="mb-5"> <input readonly id="YTD" class="form-control input-sm" type="text"
                                        name="YTD" size="25" value="<?php echo $tpl['foodarr']['YTD'] ?? ''; ?>"
                                        title="YTD " placeholder="YTD"
                                        style="font-weight:bold; font-size:15px; color:black;"></h2>
                                <?php
                            } ?>

                            </div>
                        </div>
                    </div>


                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1" style="height:175px;">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size:18px; color:white;"><b>Sponsorship
                                        </b>

                                </h4>
                                <h4 class="font-weight-normal mb-3" style="font-size:18px; color:white;"><b>
                                        Amount</b>

                                </h4>
                                <?php if ($this->controller->isFoodcouponAdmin() || $this->controller->isAdmin())  { ?>
                                <h2 class="mb-5"> <input id="Sponsorship_Amount" onchange="sponsoramount(this.id)"
                                        class="form-control input-sm" type="text" name="Sponsorship_Amount" size="25"
                                        value="<?php echo $tpl['foodarr']['Sponsorship_Amount'] ?? ''; ?>"
                                        title="Sponsorship_Amount" placeholder="Sponsorship Amount"></h2>
                                </h2>
                                <?php
                                } else {
                                    ?>
                                <h2 class="mb-5"> <input id="Sponsorship_Amount" readonly class="form-control input-sm"
                                        type="text" name="Sponsorship_Amount" size="25"
                                        value="<?php echo $tpl['foodarr']['Sponsorship_Amount'] ?? ''; ?>"
                                        title="Sponsorship_Amount" placeholder="Sponsorship Amount"></h2>
                                <?php
                            } ?>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>Sponsor</b>
                                    <!-- <i class="mdi mdi-pen mdi-24px float-right"></i> -->
                                </h4>
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>&nbsp;</b>
                                    <!-- <i class="mdi mdi-pen mdi-24px float-right"></i> -->
                                </h4>

                                <?php if ($this->controller->isFoodcouponAdmin() || $this->controller->isAdmin())  { ?>
                                <h2 class="mb-5"> <input readonly id="Sponsor" class="form-control input-sm" type="text"
                                        name="Sponsor" size="25" value="<?php echo $tpl['foodarr']['Sponsor'] ?? ''; ?>"
                                        title="Sponsor " placeholder="Sponsor"
                                        style="font-weight:bold; font-size:15px; color:black;"></h2>

                                <?php
                                } else {
                                    ?>

                                <h2 class="mb-5"> <input readonly id="Sponsor" class="form-control input-sm" type="text"
                                        name="Sponsor" size="25" value="<?php echo $tpl['foodarr']['Sponsor'] ?? ''; ?>"
                                        title="Sponsor " placeholder="Sponsor"
                                        style="font-weight:bold; font-size:15px; color:black;"></h2>
                                <?php
                            } ?>

                                <!-- <h2 class="mb-5">YES</h2>  -->

                            </div>
                        </div>
                    </div>


                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>Magazine
                                        #</b> <i class="mdi  mdi-24px float-right"></i>
                                </h4>
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>&nbsp;
                                        </b> <i class="mdi  mdi-24px float-right"></i>
                                </h4>
                                <?php if ($this->controller->isFoodcouponAdmin() || $this->controller->isAdmin())  { ?>
                                <h2 class="mb-5"> <input id="Magazines" class="form-control input-sm" type="number"
                                        name="Magazines" size="25" value="<?php echo $tpl['foodarr']['Magazines'] ?? ''; ?>"
                                        title="Magazines" placeholder="Magazines #"></h2>
                                <?php
                                } else {
                                    ?>
                                <h2 class="mb-5"> <input readonly id="Magazines" class="form-control input-sm"
                                        type="number" name="Magazines" size="25"
                                        value="<?php echo $tpl['foodarr']['Magazines'] ?? ''; ?>" title="Magazines"
                                        placeholder="Magazines #"></h2>
                                <?php
                            } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 style="font-size: 20px; color:white;" class="font-weight-normal mb-2"><b>Student</b>
                                </h4>
                                <h4 style="font-size: 20px; color:white;" class="font-weight-normal mb-2"><b>&nbsp;</b>
                                </h4>
                                <h2 class="mb-5">
                                   <input <?php echo ($tpl['foodarr']['Student'] == 'Yes') ? "checked='checked'" : ""; ?>
                                        type="radio" id="yes" name="Student" value="Yes">
                                    <label for="yes" style="font-size: 22px; color:white;">Yes</label>&nbsp;&nbsp;

                                    <input <?php echo ($tpl['foodarr']['Student'] == 'No') ? "checked='checked'" : ""; ?>
                                        type="radio" id="no" name="Student" value="No">
                                    <label for="no" style="font-size: 20px; color:white;">No</label>
                                </h2>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1" style="height:176px;">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size:18px; color:white;"><b>Student
                                        </b>

                                </h4>
                                <h4 class="font-weight-normal mb-3" style="font-size:18px; color:white;"><b>
                                        Verified</b>

                                </h4>
                                <?php if ($this->controller->isFoodcouponAdmin() || $this->controller->isAdmin())  { ?>
                                <h2 class="mb-5"> <input  id="StudentVerified" 
                                        class="form-control input-sm" type="text" name="StudentVerified" size="25"
                                        value="<?php echo $tpl['foodarr']['StudentVerified'] ?? ''; ?>"
                                        title="StudentVerified " placeholder="Student Verified "
                                        style="font-weight:bold; font-size:15px; color:black;"></h2>
                                <?php
                                } else {
                                    ?>

                                <h2 class="mb-5"> <input readonly  id="StudentVerified"
                                        onchange="issue(this.id)" class="form-control input-sm" type="text"
                                        name="StudentVerified" size="25"
                                        value="<?php echo $tpl['foodarr']['StudentVerified'] ?? ''; ?>"
                                        title="StudentVerified " placeholder="Student Verified "
                                        style="font-weight:bold; font-size:15px; color:black;"></h2>
                                <!-- <h2 class="mb-5">YES</h2>  -->
                                <?php
                            } ?>

                            </div>
                        </div>
                    </div>


                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>Pending
                                        </b>
                                </h4>
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>
                                        Issues</b>
                                </h4>
                                <?php if ($this->controller->isFoodcouponAdmin() || $this->controller->isAdmin())  { ?>
                                <h2 class="mb-5"> <input id="PendingIssues" class="form-control input-sm" type="text"
                                        name="PendingIssues" size="25"
                                        value="<?php echo $tpl['foodarr']['PendingIssues'] ?? ''; ?>"
                                        title="Pending Issues" placeholder="Pending Isssues"></h2>
                                <?php }else{ ?>
                                <h2 class="mb-5"> <input id="PendingIssues" onchange="issue(this.id)"
                                        class="form-control input-sm" type="text" name="PendingIssues" size="25"
                                        value="<?php echo $tpl['foodarr']['PendingIssues'] ?? ''; ?>"
                                        title="Pending Isssues" placeholder="Pending Isssues"></h2>
                                <?php } 
                                                
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1" style ="height: 176px;">
                                <!-- <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" /> -->
                                <h4 class="font-weight-normal mb-3" style="font-size: 18px; color:white;"><b>Total Foodcoupon
                                    </b>

                                </h4>
                                <h4 class="font-weight-normal mb-3" style="font-size: 18px; color:white;"><b>
                                     Issued</b>

                                </h4>
                                <?php if ($this->controller->isFoodcouponAdmin() || $this->controller->isAdmin())  { ?>
                                <h2 class="mb-5"> <input id="totalFoodcoupon"  class="form-control input-sm"
                                        type="number" name="total_coupon" size="25"
                                        value="<?php echo $tpl['foodarr']['total_coupon'] ?? ''; ?>" title="TotalFoodcoupon"
                                        placeholder="TotalFoodcoupon Badges"></h2>
                                <?php }else{ ?>
                                <h2 class="mb-5"> <input id="totalFoodcouponbadges" required="true" class="form-control input-sm"
                                        type="number" name="total_coupon" size="25"
                                        value="<?php echo $tpl['foodarr']['total_coupon'] ?? ''; ?>" title="TotalFoodcoupon"
                                        placeholder="Total Food coupon"></h2>
                                <?php } 
                                                
                            ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-primary1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>MID</b><i
                                        class="mdi  mdi-24px float-right"></i>
                                </h4>
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>&nbsp;</b><i
                                        class="mdi  mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5"> <input readonly id="MID" class="form-control input-sm" type="text"
                                        name="MID" size="25" value="<?php echo $tpl['foodarr']['MID'] ?? ''; ?>"
                                        title="MID " placeholder="MID"
                                        style="font-weight:bold; font-size:15px; color:black;"></h2>
                                <!-- <h2 class="mb-5">YES</h2>  -->

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-primary1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>OID</b> <i
                                        class="mdi  mdi-24px float-right"></i>
                                </h4>
                                <h4 class="font-weight-normal mb-3" style="font-size: 21px; color:white;"><b>&nbsp;</b> <i
                                        class="mdi  mdi-24px float-right"></i>
                                </h4>

                                <h2 class="mb-5"> <input readonly id="OID" class="form-control input-sm" type="text"
                                        name="OID" size="25" value="<?php echo $tpl['foodarr']['OID'] ?? ''; ?>" title="OID"
                                        placeholder="OID"></h2>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-primary1 card-img-holder1 text-white1">
                            <div class="card-body1" Style="height: 174px;">
                                <!-- <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />  -->
                                <h4 style="font-size:21px; color:white;"><b> Date </b></h4>
                                <h4 style="font-size:21px; color:white;"><b> &nbsp; </b></h4>
                                <!-- <h2 class="mb-5"> <input style="width: 100%!important;" max="<?php echo date('Y-m-d'); ?>"
                                    id="year_birth3" class="form-control input-sm" type="date" name="Date" size="25"
                                    value="" title="Date" placeholder=""></h2>    -->
                                <?php if ($this->controller->isFoodcouponAdmin() || $this->controller->isAdmin())  { ?>
                                <h2 class="mb-5"><input class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  type="date" id="date" name="Date"
                                        max="<?php echo date('Y-m-d'); ?>"
                                        value="<?php echo $tpl['foodarr']['Date'] ?? ''; ?>" title="Date"></h2>
                                <?php
                                } else {
                                    ?>
                                <h2 class="mb-5">
                                    <input class="col-lg-12 col-md-12 col-sm-12 col-xs-12" required="true" type="date" id="date" name="Date"
                                        max="<?php echo date('Y-m-d'); ?>"
                                        value="<?php echo $tpl['foodarr']['Date'] ?? ''; ?>" title="Date">

                                </h2>
                                <?php
                            } ?>
                            </div>
                        </div>
                    </div>



                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-primary1 card-img-holder1 text-white1">
                            <div class="card-body1" Style="height: 173px;">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 style="font-size:15px; color:white;" class="font-weight-normal mb-2"><b>Name
                                        Authorized </b>
                                </h4>
                                <h4 style="font-size:15px; color:white;" class="font-weight-normal mb-2"><b>
                                       To Collect</b>
                                </h4>
                                <h2 class="mb-5"> <input id="Name_Authorized" class="form-control input-sm" type="text"
                                        name="Name_Authorized" size="25"
                                        value="<?php echo $tpl['foodarr']['Name_Authorized'] ?? ''; ?>"
                                        title="Name_Authorized" placeholder="Name_Authorized "></h2>

                            </div>
                        </div>
                    </div>
                </div>



                <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-primary1 card-img-holder1 text-white1">
                        <div class="card1 bg-gradient-primary1 card-img-holder1 text-white1">
                            <div class="card-body1">
                            <div class="row"> 
                             <h4 class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="font-size:17px; color:white;"><b>Signature</b></h4>
                             <button class="col-lg-3 col-md-3 col-sm-3 col-xs-3" id="clear" style="font-size:15px;margin-bottom: 3px; ">Clear</button>
                            <button class="col-lg-3 col-md-3 col-sm-3 col-xs-3" id="disable" style="font-size:15px; margin-bottom: 3px;">Disable</button>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> </div>
                            </div>
                            <div class="row"> 
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div  style="width:150%!important;height:70px!important;" id="sig"> </div>
                                <textarea id="signature64" name="signed" style="display: none"></textarea>
                                
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> </div>
                            
                            </div>
                                <!-- <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" /> -->
                                <!-- <h4 class="font-weight-normal mb-3">Signature<i class="mdi mdi-diamond mdi-24px float-right"></i> -->
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                             <div class="card1 bg-gradient-primary1 card-img-holder1 text-white1">
                            <div class="card-body1" Style="height:154px;">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 style="font-size:21px; color:white;" class="font-weight-normal mb-2"><b>City
                                  </b>
                                </h4>
                                <h2 class="mb-5"> <input readonly id="city" class="form-control input-sm" type="text"
                                        name="City" size="25"
                                        value="<?php echo $tpl['foodarr']['City'] ?? ''; ?>"
                                        title="City" placeholder="City "></h2>

                            </div>
                        </div>
                    </div> 

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-primary1 card-img-holder1 text-white1">
                            <div class="card-body1" Style="height:154px;">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />

                                <!-- <input type="hidden" name="edit_badges" value="1" /> -->
                                <!-- <input type="hidden" name="create_parking" value="1" /> -->
                                
                                <input type="hidden" name="ID" value="<?php echo $tpl['foodarr']['id'] ?? ''; ?>" />
                                <input type="hidden" name="MID" value="<?php echo $tpl['foodarr']['MID'] ?? ''; ?>" />
                                <input type="hidden" name="PujaType" value="<?php echo $tpl['foodarr']['PujaType'] ?? ''; ?>" />
                                <input type="hidden" name="OID" value="<?php echo $tpl['foodarr']['OID'] ?? ''; ?>" />
                                <input type="hidden" name="Phone" value="<?php echo $tpl['foodarr']['Phone'] ?? ''; ?>" />
                                <input type="hidden" name="Email" value="<?php echo $tpl['foodarr']['Email'] ?? ''; ?>" />
                                <!-- <input type="hidden" name="SponsorshipCategory" value="<?php echo $tpl['foodarr']['SponsorshipCategory'] ?? ''; ?>" /> -->
                                <div class="row">
                                    <?php if ($this->controller->isFoodcouponAdmin() || $this->controller->isAdmin())  { ?>

                                    <button class="col-lg-6 col-md-6 col-sm-6 col-xs-6 btn btn-primary"
                                        style="font-size:27px;" id="submits"
                                        autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9"
                                        type="submit"><i
                                            class="fa fa-fw fa-save"></i><b><?php echo _('Save') ?></b></button>

                                    <?php
                                } else {
                                    ?>
                                    <button class="col-lg-6 col-md-6 col-sm-6 col-xs-6 btn btn-primary" 
                                        style="font-size:27px;" id="submit"
                                        autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9"
                                        type="submit"><b><?php echo _('Save') ?></b></button>
                                    <?php
                            } ?>

                                    <button
                                        onclick="location.href = '<?php echo INSTALL_URL; ?>Foodcoupon/index';"
                                        class="col-lg-6 col-md-6 col-sm-6 col-xs-6 btn btn-primary"
                                        style="font-size:27px;"
                                        id="clean" style="font-size:17px; margin-bottom: 3px;"><b>Cancel</b></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </form>
    <div id="dialogDeleteImage" title="<?php echo htmlspecialchars(__('gallery_del_title')); ?>" style="display:none">
        <p><?php echo __('gallery_del_body'); ?></p>
    </div>
</section>



<script>
$(document).ready(function() {
    debugger;
    var pType = <?php echo(json_encode($pujatype)); ?>;
    
    $("#type").val(pType);

    //var student = document.getElementById("StudentVerified").value;
    //var studentverified = student.toLowerCase();
    var volunteer = <?php echo(json_encode($volunteer)); ?>;
    var PI = document.getElementById("PendingIssues").value;
    var issue = PI.toLowerCase()
    // if ((issue == 'no' || issue == '') && (studentverified != 'no')) {

    //     $("#submit").prop("disabled", false);

    // } else {

    //     $("#submit").prop("disabled", true);

    // }

     if (volunteer == true && PI == "") {
         document.getElementById("PendingIssues").readOnly = true;

     }


    // var stud = <?php echo(json_encode($stu)); ?>;
    // var st = stud.toLowerCase();
    // if (st == "yes") {
    //     $("#StudentVerified").prop('readonly', false);
    // } else {
    //     $("#StudentVerified").prop('readonly', true);
    // }

    datecurr();
    couponstatus();



});
$(function() {
    //debugger;
    var sig = $('#sig').signature({
        syncField: '#signature64',
        syncFormat: 'PNG'
    });
    var sig = $('#sig').signature();
    $('#disable').click(function(e) {
        e.preventDefault();
        var disable = $(this).text() === 'Disable';
        $(this).text(disable ? 'Enable' : 'Disable');
        sig.signature(disable ? 'disable' : 'enable');
    });

    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });
    $('#clean').click(function(e) {
        //debugger;
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
        $("#Decal").val('');
        $("#Full_Name").val('');
        $("#PendingIssues").val('');

    });
    // var ignoreChange = false;
    // let selectedSize;
    // $('input:radio[name=Student]').on('ifChanged', function(event) {
    //     // var frm = $('#payment-form');
    //     const radioButtons = document.querySelectorAll('input[name="Student"]');
    //     if (ignoreChange) {
    //         ignoreChange = false;
    //         return;
    //     }
    //     for (const radioButton of radioButtons) {
    //         if (radioButton.checked) {
    //             selectedSize = radioButton.value;
    //             break;
    //         }
    //     }
    //     if (selectedSize == "Yes") {
    //         $("#StudentVerified").prop('readonly', false);
    //     } else {
    //         $("#StudentVerified").prop('readonly', true);
    //     }

    // });
    // $('#submits').click(function(e) {
    //     debugger;
    //      admincheck();

    // });

   

});

// function admincheck(e){
// var sign = $("#signature64").val();
// var totalbadge = $("#totalbadges").val();    
// if( sign != "" && totalbadge =="" ){
//     $("#totalbadges").prop('required',true);
   
// }
// if(sign == "" && totalbadge !=""){
//     alert("Signature is required");
//     $("#signature64").prop('required',true);  
// }

// }

function couponstatus() {
    var status = <?php echo(json_encode($couponStatus)); ?>;
    var volunteer = <?php echo(json_encode($volunteer)); ?>;
    if (volunteer == true && status == "Coupon Issued") {
        $("#submit").css("display", "none");

    } else {
        $("#submit").css("display", "block");
    }
}

// function issue(pending) {
//     //debugger;
//     var student = document.getElementById("StudentVerified").value;
//     var studentverified = student.toLowerCase();
//     var PI = document.getElementById("PendingIssues").value;
//     var issue = PI.toLowerCase()
//     if ((issue == 'no' || issue == '') && (studentverified != 'no')) {

//         document.getElementById("submit").disabled = false;
//     } else {
//         alert("Please resolve pending issue/ student verify  first");
//         document.getElementById("submit").disabled = true;

//     }
// }


function datecurr() {
    var datedb = <?php echo(json_encode($datedb)); ?>;
    if (datedb == null || datedb == "0000-00-00") {
        $('#date').val(new Date().toJSON().slice(0, 10));

    } else {
        document.getElementById("date").value = datedb;
    }
}


function sponsoramount(elem) {
    //debugger;

    var sp = parseInt($("#Sponsorship_Amount").val());
    var TotalAmount = sp;

    if (TotalAmount >= 4650) {
        document.getElementById("Sponsor").value = "Diamond";


    } else if (TotalAmount >= 2000 && TotalAmount < 4650) {
        document.getElementById("Sponsor").value = "Emerald";


    } else if (TotalAmount >= 1200 && TotalAmount < 2000) {
        document.getElementById("Sponsor").value = "Platinum";

    } else if (TotalAmount >= 800 && TotalAmount < 1200) {
        document.getElementById("Sponsor").value = "Gold";

    } else if (TotalAmount >= 400 && TotalAmount < 800) {
        document.getElementById("Sponsor").value = "Silver";

    } else {
        document.getElementById("Sponsor").value = "General";

    }
}
</script>
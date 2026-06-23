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
       input {font-weight:bold;}  
    .form-control{
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
        <?php echo __('Edit_Parking'); ?>
    </h1>
    <?php if (!$this->controller->isMember()) { ?>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Badges/index"><?php echo __('Parking'); ?></a></li>
        <li class="active"><?php echo __('Edit_Parking'); ?></li>
    </ol>
    <?php } ?>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
  $allotparking = $tpl['arr']['parking_assigned'] ?? '';  
  $sponsoreditamount = $tpl['arr']['sponsor_amount'] ?? '';
  $decaldb = $tpl['arr']['Decal'] ?? '';   
  $vol =  $this->controller->isVolunteer();
  $datedb = $tpl['arr']['Date'] ?? ''; 
?>
<section class="content left width_100">
    <form id="payment-form" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Badges/edit"
        method="post" name="edit" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
            <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 stretch-card1 grid-margin1">
                <table class="table1" >
                    <tr class="tr">
                        <td style="font-size: xx-large;" class="td">Parking Allotment for Sponsor</td>
                    </tr>
                </table>
            </div>
            </div>
    
                <div class="row"> 
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-danger1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;" ><b>Member Id &nbsp;</b><i
                                        class="mdi mdi-pen mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5"> 
                                 <input readonly id="Member_id" class="form-control mb-5" type="text" name="Member_id"
                                size="12" value="<?php echo $tpl['arr']['Member_id'] ?? ''; ?>" title="Member ID"
                                placeholder="Member ID">
                            </h2> 
                                <!-- <h2 class="mb-5"><?php echo $tpl['arr']['MID'] ?? ''; ?></h2> -->

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-danger1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>First Name &nbsp;</b><i
                                        class="mdi mdi-account-card-details float-right"></i>
                                </h4>
                                <h2 class="mb-5"> <b><input readonly id="Your_Name" class="form-control input-sm" type="text" name="F_Name" size="25"
                                value="<?php echo $tpl['arr']['F_Name'] ?? ''; ?>" title="First Name"
                                placeholder="First Name"></b></h2>
                                <!-- <h2 class="mb-5"><?php echo $tpl['arr']['F_Name'] ?? ''; ?></h2> -->

                            </div>
                        </div>
                    </div>
                    </div>
    
                   <div class="row"> 
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-danger1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>Last Name&nbsp;</b><i
                                        class="mdi mdi-account-card-details float-right"></i>
                                </h4>
                                <h2 class="mb-5"> <input readonly  id="last name" class="form-control input-sm" type="text"
                                name="L_Name" size="25" value="<?php echo $tpl['arr']['L_Name'] ?? ''; ?>" title="Last Name"
                                placeholder="Last Name"></h2>
                                <!-- <h2 class="mb-5"> <?php echo $tpl['arr']['L_Name'] ?? ''; ?></h2> -->

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-danger1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>Spouse Name</b><i
                                        class="mdi mdi-gender-male-female float-right"></i>
                                </h4>
                                <h2 class="mb-5"> <input readonly id="Spouse" class="form-control input-sm" type="text" name="Sp_FName" size="25"
                                value="<?php echo $tpl['arr']['Sp_FName'] ?? ''; ?>" title="Spouse Name"
                                placeholder="Spouse Name"></h2>
                                <!-- <h2 class="mb-5"> <?php echo $tpl['arr']['Sp_FName'] ?? ''; ?></h2> -->

                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row"> 
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>YTD</b><i
                                        class="mdi mdi-chart-line mdi-24px float-right"></i>
                                </h4>
                                
                                <!-- <input type="submit" name="submit" value="Submit">   -->
                                <?php if ($this->controller->isParkingAdmin() || $this->controller->isAdmin())  { ?>
                                <h2 class="mb-5"> <input id="ytd" readonly class="form-control input-sm" type="text" name="YTD" size="25"
                                value="<?php echo $tpl['arr']['donation'] ?? ''; ?>" title="YTD"
                                placeholder="YTD"></h2>
                                <?php
                                } else {
                                    ?>
                             <h2 class="mb-5"><input readonly id="ytd" required="true" class="form-control input-sm" type="text" name="parking_assigned" size="25"
                                value="<?php echo $tpl['arr']['donation'] ?? ''; ?>" title="parking Assigned"
                                placeholder="parking Assigned"></h2> 
                                <?php
                            } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>Sponsorship Amount</b><i
                                        class="mdi mdi-chart-line mdi-24px float-right"></i>
                                        <?php if ($this->controller->isParkingAdmin() || $this->controller->isAdmin())  { ?>
                                       <!-- <button id="update" onclick=""class="btn-danger" style ="float: right; color:white;height: 39px;margin-right: 63px;">Update</button> -->
                                          <a id="update" onclick=""class="btn-danger" style ="float:right; color:white;height:29px;font-size:20px;margin-right:90px;">Update</a>
                                        <?php } ?>
                                </h4>
                                <?php if ($this->controller->isParkingAdmin() || $this->controller->isAdmin())  { ?>
                                    <h2 class="mb-5"> <input readonly style ="color:red;" id="sponsor_amount" class="form-control input-sm" type="text" name="sponsor_amount" size="25"
                                value=" <?php echo $tpl['arr']['sponsor_amount'] ?? ''; ?>" title="Sponsorship Amount"
                                placeholder="Sponsor Amount" onchange="sponsoramount(this.id)">
                                </h2>
                                <?php
                                } else {
                                    ?>
                                    <h2 class="mb-5"> <input readonly style ="color:red;" id="sponsor_amount" class="form-control input-sm" type="text" name="sponsor_amount" size="25"
                                value="<?php echo $tpl['arr']['sponsor_amount'] ?? ''; ?>" title="Sponsorship Amount"
                                placeholder="Sponsor Amount"></h2>
                                <?php
                            } ?>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row"> 
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>Parking Basis</b><i
                                        class="mdi mdi-parking float-right"></i>
                                </h4>
                               <h2 class="mb-5"> <input readonly id="Parking_Basis" class="form-control input-sm" type="text" name="Parking_Basis" size="25"
                                value="<?php echo $tpl['arr']['Parking_Basis'] ?? ''; ?>" title="Parking Basis"
                                placeholder="Sponsor" style="font-weight:bold; font-size:15px; color:black;"></h2> 
                               <!-- <h2 class="mb-5">Sponsor</h2>  -->

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>Sponsor Level</b><i
                                        class="mdi mdi-diamond mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5"> <input readonly   id="sponsor_level" class="form-control input-sm" type="text" name="SponsorshipCategory" size="25"
                                value="<?php echo $tpl['arr']['SponsorshipCategory'] ?? ''; ?>" title="Sponsor Level"
                                placeholder="Sponsor Level"></h2>
                                <!-- <h2 class="mb-5">GOLD</h2> -->
                           
                         
                            </div>
                        </div>
                    </div>
    </div>
    <div class="row"> 
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-success1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>Registration Status</b><i
                                        class="mdi mdi-diamond mdi-24px float-right"></i>
                                </h4>
                             <h2 class="mb-5"> <input readonly id="registration_status"  class="form-control input-sm" type="text" name="Registration_Status" size="25"
                                value="<?php echo $tpl['arr']['Registration_Status'] ?? ''; ?>" title="Registration Status"
                                placeholder="YES"  style="font-weight:bold; font-size:15px; color:black;"></h2> 
                                <!-- <h2 class="mb-5">YES</h2>  -->

                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-success1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>Pending Isssues</b> <i
                                        class="mdi mdi-chart-line mdi-24px float-right"></i>
                                </h4>
                                <?php if ($this->controller->isParkingAdmin() || $this->controller->isAdmin())  { ?>
                                <h2 class="mb-5"> <input id="Pending_Issues"  class="form-control input-sm" type="text" name="Pending_Issues" size="25"
                                value="<?php echo $tpl['arr']['Pending_Issues'] ?? ''; ?>" title="Pending Isssues"
                                placeholder="Pending Isssues"></h2>
                                <?php }else{ ?>
                                <h2 class="mb-5"> <input id="Pending_Issues" onchange="issue(this.id)" class="form-control input-sm" type="text" name="Pending_Issues" size="25"
                                value="<?php echo $tpl['arr']['Pending_Issues'] ?? ''; ?>" title="Pending Isssues"
                                placeholder="Pending Isssues"></h2>
                             <?php } 
                                                
                            ?>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-success1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>Parking Lot Assigned</b><i
                                        class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">
                                <?php if ($this->controller->isParkingAdmin() || $this->controller->isAdmin())  { ?>
                                    
                                <select required id="parking_assigned" style="width: 100%!important;height: 36px!important;" 
                                        name="parking_assigned"  value="<?php echo $tpl['arr']['parking_assigned'] ?? ''; ?>" class="form-control input-sm medium valid">
                                        <option value="">Please select parking lot assigned</option>
                                        <option value="None">None</option>
                                        <option value="MainParking">Main Parking</option>
                                        <option value="KalaBhavan">Kala Bhavan</option>
                                        <option value="JainTemple">Jain Temple</option>
                                        <option value="GreenField ">Green Field</option>
                                    </select> 
                                    
                                </h2>
                                <?php
                                } else {
                                    ?>
                                <h2>  <input  readonly id="parking_assigned" required="true" class="form-control input-sm" type="text" name="parking_assigned" size="25"
                                value="<?php echo $tpl['arr']['parking_assigned'] ?? ''; ?>" title="parking Assigned"
                                placeholder="parking Assigned"> 
                                </h2>
                                <?php
                            } ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-success1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>Decal Assigned</b><i
                                        class="mdi mdi-diamond mdi-24px float-right"></i>
                                </h4>
                                <?php if ($this->controller->isParkingAdmin() || $this->controller->isAdmin())  { ?> 
                                <h2 class="mb-5"> <input  id="Decal" class="form-control input-sm"
                                        type="text" name="Decal" size="25" value="<?php echo $tpl['arr']['Decal'] ?? ''; ?>"
                                        title="Decal" placeholder="Decal" ></h2>
                                        <?php
                                } else {
                                    ?>
                                        <h2 class="mb-5"> <input  required="true" id="Decal" class="form-control input-sm"
                                        type="text" name="Decal" size="25" value="<?php echo $tpl['arr']['Decal'] ?? ''; ?>"
                                        title="Decal" placeholder="Decal"></h2>
                                        
                                        <?php
                            } ?>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row"> 
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-primary1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 style="font-size: 27px; color:white;" class="font-weight-normal mb-2"><b>FULL Name When Authorized To Collect</b><i
                                        class="mdi mdi-diamond mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5"> <input  id="Full_Name" class="form-control input-sm"
                                        type="text" name="Name_Authorized" size="25"
                                        value="<?php echo $tpl['arr']['Name_Authorized'] ?? ''; ?>" title="Full Name"
                                        placeholder="Full Name "></h2>

                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-primary1 card-img-holder1 text-white1">
                            <div class="card-body1"><h4 style="font-size: 27px; color:white;"><b>Signature</b></h4>
                                <button id="clear" style="font-size:17px; margin-bottom: 3px;">Clear</button>
                                <button id="disable" style="font-size:17px;margin-bottom: 3px; ">Disable</button>
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <!-- <h4 class="font-weight-normal mb-3">Signature<i class="mdi mdi-diamond mdi-24px float-right"></i> -->
                                <div style="width: 350px!important;height: 62px!important;" id="sig"> </div>
                                <textarea id="signature64" name="signed" style="display: none"></textarea>

                            </div>
                        </div>
                    </div>
                    </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-primary1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                    <h4  style="font-size: 27px; color:white;"><b> Date </b></h4>
                                <!-- <h2 class="mb-5"> <input style="width: 100%!important;" max="<?php echo date('Y-m-d'); ?>"
                                    id="year_birth3" class="form-control input-sm" type="date" name="Date" size="25"
                                    value="" title="Date" placeholder=""></h2>    -->
                                    <?php if ($this->controller->isParkingAdmin() || $this->controller->isAdmin())  { ?>
                                    <h3 class="mb-5"><input  type="date" id="date" name="Date" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $tpl['arr']['Date'] ?? ''; ?>"  title="Date"></h3>
                                    <?php
                                } else {
                                    ?>
                                    <h3 class="mb-5"><input required="true" type="date" id="date" name="Date" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $tpl['arr']['Date'] ?? ''; ?>"  title="Date"></h3>
                                    <?php
                            } ?>
                            </div>
                        </div>
                    </div>
                  
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-primary1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />

                                    <input type="hidden" name="edit_parking" value="1" />
                                    <!-- <input type="hidden" name="create_parking" value="1" /> -->
                                    <input type="hidden" name="ID" value="<?php echo $tpl['arr']['ID'] ?? ''; ?>" />
                      
                                    <input type="hidden" name="Member_id" value="<?php echo $tpl['arr']['Member_id'] ?? ''; ?>" />
                                    <input type="hidden" name="Signature" value="<?php echo $tpl['arr']['Signature'] ?? ''; ?>" />
                                    <input type="hidden" name="parkingid" value="<?php echo $tpl['arr']['parkingid'] ?? ''; ?>" />
                                    <input type="hidden" name="Tele1" value="<?php echo $tpl['arr']['Tele1'] ?? ''; ?>" />
                                    <input type="hidden" name="email" value="<?php echo $tpl['arr']['email'] ?? ''; ?>" />

                                    <!-- <input type="hidden" name="SponsorshipCategory" value="<?php echo $tpl['arr']['SponsorshipCategory'] ?? ''; ?>" /> -->
                                    <div class="row"> 
                                    <?php if ($this->controller->isParkingAdmin() || $this->controller->isAdmin())  { ?>
								
									<button class="col-lg-6 col-md-6 col-sm-6 col-xs-6 btn btn-primary" style="width:150px!important;height:116px;font-size:27px;" id="submits" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9"
                                    type="submit"><i
                                        class="fa fa-fw fa-save"></i><b><?php echo _('Save') ?></b></button>
										
										 <?php
                                } else {
                                    ?>
                                 <button class="col-lg-6 col-md-6 col-sm-6 col-xs-6 btn btn-primary" disabled="" style="width:150px!important;height:116px;font-size:27px;" id="submit" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9"
                                    type="submit"><i
                                        class="fa fa-fw fa-save"></i><b><?php echo _('Save') ?></b></button>
									 <?php
                            } ?>	
										
                                        <button class="col-lg-6 col-md-6 col-sm-6 col-xs-6 btn btn-primary" style="float:right!important;width:150px!important;height:116px;font-size:27px;" id="clean" style="font-size:17px; margin-bottom: 3px;">Clear</button>   
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
<div id="record_id" style="display:none"></div>

<script>
   
$( document ).ready(function() {
  
  var parking_assigned = <?php echo(json_encode($allotparking)); ?>;
  var check = <?php echo(json_encode($sponsoreditamount)); ?>;
  var datedb = <?php echo(json_encode($datedb)); ?>;
  var vol = <?php echo(json_encode($vol)); ?>;
  var decaldb = <?php echo(json_encode($decaldb)); ?>;
  spamount(check);
  sponsoramount("elem");
   datecurr(datedb);
   pendingissue();
   sponsershiplevel(parking_assigned);
   decalassigned(decaldb);
   decaldefault(vol);
   parkingassigncheck();
   
  
    //    if(vol == true && PI == ""){ 
    //     document.getElementById("Pending_Issues").readOnly = true;
    
    // }

   var parkingassigned = document.getElementById("parking_assigned").value;
  if( parkingassigned == ""){
    $( "#submit" ).prop( "disabled", true );   
    $( "#submits" ).prop( "disabled", true ); 
  } 
  
  
   //   var x = document.getElementById("sponsor_amount");
//         if (x.disabled == true ) {
//         //$( "#sponsor_amount" ).prop( "disabled", false );
        
//             $( "#submits").prop( "disabled", false );
         
//         }
//         else {
//             $( "#sponsor_amount" ).prop( "disabled", true );
//         }
        
});
 $('#Decal').click(function(e) {
        //debugger;
		 var PI =  document.getElementById("Pending_Issues").value;
         var issue = PI.toLowerCase()
		 if (issue == 'no' || issue == '' ) {
			  $( "#submit" ).prop( "disabled", false ); 
		 }
		 else{
           alert("Please Clear Pending Issue First Only Then You will be Able to Assign Decal");
		 }
});
$(function() {
    var sig = $('#sig').signature({
        syncField: '#signature64',
        syncFormat: 'PNG'
    });
    
    //var sig = $('#sig').signature();
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
    $('#update').click(function(e) {
        e.preventDefault();
        //debugger;
        var x = document.getElementById("sponsor_amount");
        //var yz = document.getElementById("ytd");
      if(document.querySelector("#sponsor_amount").readOnly) { 
        //if (x.disabled == true ) {
        //$( "#sponsor_amount" ).prop( "disabled", false );
        $("#sponsor_amount").prop('readonly', false);
            $( "#submit").prop( "disabled", false ); 
            $( "#submits").prop( "disabled", false );
         
        }
        else {
            $("#sponsor_amount").prop('readonly', true);
           // $( "#sponsor_amount" ).prop( "disabled", true );
        }
        //var sponshirshipmain = document.getElementById("sponsor_amount").value;
        //var ytdmain = document.getElementById("ytd").value;
        
    });
    $('#clean').click(function(e) {
      
      e.preventDefault();
      sig.signature('clear');
      $("#signature64").val('');
      $("#Decal").val('');
      $("#Full_Name").val('');
      $("#pending_issues").val('');
     

});

});

function parkingassigncheck(){
var PA =  document.getElementById("parking_assigned").value;
        if (PA == null || PA == '' ) {
          $( "#Decal" ).prop( "disabled", true ); 
        }
       else{
         $( "#Decal" ).prop( "disabled", false );  
       
    }
}

function pendingissue(){
    var PI =  document.getElementById("Pending_Issues").value;
    var issue = PI.toLowerCase()
      if (issue == 'no' || issue == '' ) {
       // $( "#Decal" ).prop( "disabled", false ); 
        $( "#submit" ).prop( "disabled", false ); 

          }
       else{   
       // $( "#Decal" ).prop( "disabled", true ); 
        $( "#submit" ).prop( "disabled", true );     
       
    }
}

function decaldefault(vol){

   var decal =  document.getElementById("Decal").value;
   if(decal==null || decal=="" || decal ==" "){
       
       $("#submit").css("display", "block");
       //$("#id").css("display", "block");
  //document.getElementById("submit").style.display = "block"; 
  
 }else{
     var testdeck = decal.split("-");
   var decktest = testdeck[1];

   if(vol == true && decktest != ""){    
 document.getElementById("submit").style.display = "none"; 
   }
 }
 
}


function spamount(check){
    debugger;
    var ytd =$("#ytd").val();
     if(ytd == null || ytd == "")
         {
            document.getElementById("ytd").value = 0;  
         }
       if (check == null||check == "" || check == " ") { 
        $("#sponsor_amount").val(ytd).css('color', '#3BA424');

          }		  	  
       else
        {
         //var totalamount = ytd + sp;
         $("#sponsor_amount").css('color', 'red');
         //sponsoramount("elem");
         }
        }

function sponsershiplevel(parking_assigned){
    //debugger;

    var splevel = $("#sponsor_level").val();
  
    
    if ((splevel == 'Diamond' || splevel == 'Emerald' || splevel == 'Platinum')  && parking_assigned == null ) {
        document.getElementById("parking_assigned").value = "MainParking";

    } else if(splevel == 'Gold' && parking_assigned == null)
    {
        document.getElementById("parking_assigned").value ="KalaBhavan"; 
       
    }
    else if(splevel == 'Silver' && parking_assigned == null)
    {
        document.getElementById("parking_assigned").value ="JainTemple";
          
    }
    else if(splevel == 'General')
    { 
        
        $( "#submit").prop( "disabled", true ); 
        $( "#submits").prop( "disabled", true ); 
           
    }
    else
    {
        var myVariable = <?php echo(json_encode($allotparking)); ?>;
         $("#parking_assigned").val(myVariable);
        //document.getElementById("parking_assigned").value ="General";  
    }
}    
        



function datecurr(datedb) {

if (datedb == null ||datedb == "0000-00-00") 
{
    $('#date').val(new Date().toJSON().slice(0,10));

}
else
{
  document.getElementById("date").value = datedb;
}
}

function sponsoramount(elem) {
    debugger;
    var ytd =$("#ytd").val();
    var TotalAmount = parseInt($("#sponsor_amount").val());
    var spamount = $("#sponsor_amount").val();
    
   //var TotalAmount = sp;

   
   //if(Number.isNaN(TotalAmount) ||  TotalAmount == 0){
        
		
		if (TotalAmount >= 4650) {
            document.getElementById("sponsor_level").value = "Diamond";
         

        } else if(TotalAmount >= 2000 && TotalAmount < 4650)
        {
            document.getElementById("sponsor_level").value ="Emerald";
          
        }
        else if(TotalAmount >= 1200 && TotalAmount < 2000)
        {
            document.getElementById("sponsor_level").value = "Platinum";  
            
        }
        else if(TotalAmount >= 800 && TotalAmount < 1200)
        {
            document.getElementById("sponsor_level").value ="Gold";  
            
        }
        else if(TotalAmount >= 400 && TotalAmount < 800)
        {
            document.getElementById("sponsor_level").value ="Silver" ;
              
        }
        else
        {
            document.getElementById("sponsor_level").value ="General"; 
            //generalonchange();
        }
		
    //}
}
   
    function generalonchange() {
        var gen = document.getElementById("sponsor_level").value;
        //var parkingassigned = document.getElementById("parking_assigned").value 
    if(gen == 'General'){
       $("#Decal").val('');
       $("#parking_assigned").val('');
    }
   }
   


  function issue(pending) {
    //debugger;
    var PI =  document.getElementById("Pending_Issues").value;
    var issue = PI.toLowerCase()
        if (issue == 'no' || issue == null ) {
          document.getElementById("Decal").disabled = false;
          document.getElementById("submit").disabled = false;
        }
      else{
        document.getElementById("Decal").disabled = true; 
        document.getElementById("submit").disabled = true;  
       
    }
}

    function decalassigned(decaldb) {
   debugger;
    var parkinglot = document.getElementById("parking_assigned").value;
    

    if (parkinglot == 'MainParking' && decaldb == null ) 
    {
        document.getElementById("Decal").value = "A-";

    } 
    else if(parkinglot == 'KalaBhavan' && decaldb == null)
    {
        document.getElementById("Decal").value ="B-"; 
       
    }
    else if(parkinglot == 'JainTemple' && decaldb == null)
    {
        document.getElementById("Decal").value ="D-";
          
    }
    else if(parkinglot == 'GreenField' && decaldb == null)
    { 
        
       document.getElementById("Decal").value ="C-";
           
    }
    else{
        document.getElementById("Decal").value = decaldb;
        
    }
}


</script>
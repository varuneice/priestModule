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
$fullname = $tpl['paidarr']['name'] ?? '';
  $name=explode(" ",$fullname);
   $first = $name[0];
   $last= $name[1] ?? '';
   $allotparking = $tpl['paidarr']['parking_assigned'] ?? ''; 
   $vol =  $this->controller->isVolunteer();
   $decaldb = $tpl['paidarr']['Decal'] ?? ''; 
   $itemname = $tpl['paidarr']['item_name'] ?? '';
   $datedb = $tpl['paidarr']['Date'] ?? '';  
?>
<section class="content left width_100">
    <form id="payment-form" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Badges/Paidparking"
        method="post" name="edit" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
            <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 stretch-card1 grid-margin1">
                <table class="table1" >
                    <tr class="tr">
                        <td style="font-size: xx-large;" class="td">Paid Parking Allotment</td>
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
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;" ><b>Oid &nbsp;</b><i
                                        class="mdi mdi-pen mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5"> 
                                 <input readonly id="Member_id" class="form-control mb-5" type="text" name="oid"
                                size="12" value="<?php echo $tpl['paidarr']['oid'] ?? ''; ?>" title="Oid"
                                placeholder="Oid">
                            </h2> 
                                <!-- <h2 class="mb-5"><?php echo $tpl['paidarr']['oid'] ?? ''; ?></h2> -->

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
                                <h2 class="mb-5"> <b><input readonly id="Your_Name" class="form-control input-sm" type="text" name="name" size="25"
                                value="<?php echo $first; ?>" title="First Name"
                                placeholder="First Name"></b></h2>
                                <!-- <h2 class="mb-5"><?php echo $tpl['paidarr']['name'] ?? ''; ?></h2> -->

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
                                name="name" size="25" value="<?php echo $last ?>" title="Last Name"
                                placeholder="Last Name"></h2>
                                <!-- <h2 class="mb-5"> <?php echo $tpl['paidarr']['name'] ?? ''; ?></h2> -->

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-danger1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>Senior</b><i
                                        class="mdi mdi-gender-male-female float-right"></i>
                                </h4>
                                <?php if ($this->controller->isParkingAdmin() || $this->controller->isAdmin())  { ?>
                                <h2 class="mb-5"> <input id="senior" class="form-control input-sm" type="text" name="senior" size="25"
                                value="<?php echo $tpl['paidarr']['senior'] ?? ''; ?>" title="Senior"
                                placeholder="Senior"></h2>
                                <?php
                                } else {
                                    ?>

                                <h2 class="mb-5"> <input id="senior" readonly class="form-control input-sm" type="text" name="senior" size="25"
                                value="<?php echo $tpl['paidarr']['senior'] ?? ''; ?>" title="Senior"
                                placeholder="Senior"></h2>
                                <!-- <h2 class="mb-5"> <?php echo $tpl['paidarr']['senior'] ?? ''; ?></h2> -->
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
                                        class="mdi mdi-chart-line mdi-24px float-right"></i>
                                </h4>
                                <!-- <h2 class="mb-5">2000</h2> -->
                                
                                <h2 class="mb-5"> <input id="Parking_Basis" readonly class="form-control input-sm" type="text" name="Parking_Basis" size="25"
                                value="<?php echo $tpl['paidarr']['Parking_Basis'] ?? ''; ?>" title="Parking Basis"
                                placeholder="Paid"></h2>
                                <!-- <h2 class="mb-5"><?php echo $tpl['arr']['Parking_Basis'] ?? ''; ?></h2> -->

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>CT Member</b><i
                                        class="mdi mdi-chart-line mdi-24px float-right"></i>
                                </h4>
                                <!-- <h2 class="mb-5">2000</h2> -->
                                <?php if ($this->controller->isParkingAdmin() || $this->controller->isAdmin())  { ?>
                                <!-- <h2 class="mb-5">2000</h2> -->
                                <h2 class="mb-5"> <input id="YTD"  class="form-control input-sm" type="text" name="ct_members" size="25"
                                value="<?php echo $tpl['paidarr']['ct_members'] ?? ''; ?>" title="Ct Members"
                                placeholder="Ct Members"></h2>
                                <!-- <h2 class="mb-5"><?php echo $tpl['paidarr']['ct_members'] ?? ''; ?></h2> -->
								<?php
                                } else {
                                    ?>
								<h2 class="mb-5"> <input id="YTD" readonly class="form-control input-sm" type="text" name="ct_members" size="25"
                                value="<?php echo $tpl['paidarr']['ct_members'] ?? ''; ?>" title="Ct Members"
                                placeholder="Ct Members"></h2>
                                <!-- <h2 class="mb-5"><?php echo $tpl['paidarr']['ct_members'] ?? ''; ?></h2> -->
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
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>Registration Status</b><i
                                        class="mdi mdi-parking float-right"></i>
                                </h4>
                               <h2 class="mb-5"> <input readonly id="Registration_Status" class="form-control input-sm" type="text" name="Registration_Status" size="25"
                                value="<?php echo $tpl['paidarr']['Registration_Status'] ?? ''; ?>" title="Registration Status"
                                placeholder="YES"  style="font-weight:bold; font-size:15px; color:black;"></h2> 
                               <!-- <h2 class="mb-5">Sponsor</h2>  -->

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
                                value="<?php echo $tpl['paidarr']['Pending_Issues'] ?? ''; ?>" title="Pending Isssues"
                                placeholder="Pending Isssues"></h2>
                                <?php }else{ ?>
                                <h2 class="mb-5"> <input id="Pending_Issues" onchange="issue(this.id)" class="form-control input-sm" type="text" name="Pending_Issues" size="25"
                                value="<?php echo $tpl['paidarr']['Pending_Issues'] ?? ''; ?>" title="Pending Isssues"
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
                                 <select required="true" id="parking_assigned" style="width: 100%!important;height: 36px!important; "
                                        name="parking_assigned"  value="<?php echo $tpl['paidarr']['parking_assigned'] ?? ''; ?>" class="form-control input-sm medium valid">
                                        <option value="">Please select parking lot assigned</option>
                                        <option value="Main">Main</option>
                                        <option value="Parking - Kala Bhavan">Kala Bhavan</option>
                                        <option value="Parking - Jain Temple">Jain Temple</option>
                                        <option value="Parking - Green Field">Green Field</option>
                                    </select>
                                </h2>
                                <?php
                                } else {
                                    ?>
                                    <h2> <input readonly id="parking_assigned" required="true" class="form-control input-sm" type="text" name="parking_assigned" size="25"
                                value="<?php echo $tpl['paidarr']['parking_assigned'] ?? ''; ?>" title="parking Assigned"
                                placeholder="parking Assigned"> 
                                </h2>
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
                                        type="text" name="Decal" size="25" value="<?php echo $tpl['paidarr']['Decal'] ?? ''; ?>"
                                        title="Decal" placeholder="Decal"></h2>
                                        <?php
                                } else {
                                    ?>

                                        <h2 class="mb-5"> <input required="true" id="Decal" class="form-control input-sm"
                                        type="text" name="Decal" size="25" value="<?php echo $tpl['paidarr']['Decal'] ?? ''; ?>"
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
                                        value="<?php echo $tpl['paidarr']['Name_Authorized'] ?? ''; ?>" title="Full Name"
                                        placeholder="Full Name "></h2>

                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-primary1 card-img-holder1 text-white1">
                            <div class="card-body1"><h4 style="font-size: 27px; color:white;"><b>Signature</b></h4>
                                <button id="clear" style="font-size:17px;margin-bottom: 3px; ">Clear</button>
                                <button id="disable" style="font-size:17px; margin-bottom: 3px;">Disable</button>
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <!-- <h4 class="font-weight-normal mb-3">Signature<i class="mdi mdi-diamond mdi-24px float-right"></i> -->
                                <div style="width: 350px!important;height:62px!important;" id="sig"> </div>
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
                                   <h3 class="mb-5"> <input  type="date" id="date" name="Date" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $tpl['paidarr']['Date'] ?? ''; ?>"  title="Date"></h3>
                                    <?php
                                } else {
                                    ?>

                                     <h3 class="mb-5">  <input required="true" type="date" id="date" name="Date" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $tpl['paidarr']['Date'] ?? ''; ?>"  title="Date"></h3>
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

                                    <input type="hidden" name="edit_paidparking" value="1" />
                                    <!-- <input type="hidden" name="create_parking" value="1" /> -->
                                    <input type="hidden" name="Paidparkingviews" value="<?php echo $tpl['paidarr']['Paidparkingview'] ?? ''; ?>" />
                                    <input type="hidden" name="id" value="<?php echo $tpl['paidarr']['id'] ?? ''; ?>" />
                                    <input type="hidden" name="oid" value="<?php echo $tpl['paidarr']['oid'] ?? ''; ?>" />
                                    <input type="hidden" name="tele" value="<?php echo $tpl['paidarr']['tele'] ?? ''; ?>" /> 
                                       <input type="hidden" name="email" value="<?php echo $tpl['paidarr']['email'] ?? ''; ?>" />
                                    <input type="hidden" name="name" value="<?php echo $tpl['paidarr']['name'] ?? ''; ?>" />
                                    <input type="hidden" name="Signature" value="<?php echo $tpl['paidarr']['Signature'] ?? ''; ?>" />
                                    <input type="hidden" name="parkingid" value="<?php echo $tpl['paidarr']['parkingid'] ?? ''; ?>" />
                                 <?php if ($this->controller->isParkingAdmin() || $this->controller->isAdmin())  { ?>
									
									<button style="width:150px!important;height:116px;font-size:27px;" id="submits" class="btn btn-primary"
                                    autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9"
                                    type="submit"><i
                                        class="fa fa-fw fa-save"></i><b><?php echo _('Save') ?></b></button>
										
										 <?php
                                } else {
                                    ?>
                                 <button disabled="" style="width:150px!important;height:116px;font-size:27px;" id="submit" class="btn btn-primary"
                                    autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9"
                                    type="submit"><i
                                        class="fa fa-fw fa-save"></i><b><?php echo _('Save') ?></b></button>
									 <?php
                            } ?>	
                                        <button style="float:right!important;width:150px!important;height:116px;font-size:27px;" class="btn btn-primary" id="clean" style="font-size:17px; margin-bottom: 3px;">Clear</button>
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
debugger;
datecurr();
 var nameitem = <?php echo(json_encode($itemname)); ?>;
 var allotparking = <?php echo(json_encode($allotparking)); ?>;
  if( nameitem != null && allotparking == null ){ 
      document.getElementById("parking_assigned").value = nameitem;
  }
   else{
     $("#parking_assigned").val(allotparking); 
  }
  decalassigned();
   var voltest = <?php echo(json_encode($vol)); ?>;
   var decal =  document.getElementById("Decal").value;
   var testdeck = decal.split("-");
    testdeck[0];
    var decktest = testdeck[1];
  if(voltest == true && decktest != ""){    
    document.getElementById("submit").style.display = "none";
  }
  

    var PI =  document.getElementById("Pending_Issues").value;
    var issue = PI.toLowerCase()
      if (issue == 'no' || issue == '' ) {
        //$( "#Decal" ).prop( "disabled", false ); 
        $( "#submit" ).prop( "disabled", false ); 

          }
       else{   
        //$( "#Decal" ).prop( "disabled", true ); 
        $( "#submit" ).prop( "disabled", true );     
        ///alert("please clear Pending issue first");
    }
    var parkingassigned = document.getElementById("parking_assigned").value
      if( parkingassigned == "" ){

     $( "#submit" ).prop( "disabled", true );   
  }

});
 $('#Decal').click(function(e) {
        debugger;
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
    $('#clean').click(function(e) {
        debugger;
      e.preventDefault();
      sig.signature('clear');
      $("#signature64").val('');
      $("#Decal").val('');
      $("#Full_Name").val('');
      $("#Pending_Issues").val('');
     

});
    // $('#json').click(function() {
    // 	alert(sig.signature('toJSON'));
    // });
    // $('#svg').click(function() {
    // 	alert(sig.signature('toSVG'));
    // });
});

// $(function() {
//     $('.date-picker').datepicker({
//         changeMonth: false,
//         changeDate: false,
//         changeYear: true,
//         showButtonPanel: true,
//         dateFormat: 'yy',
//         maxDate: new Date(new Date().getFullYear(), 1, 1),
//         onClose: function(dateText, inst) {
//             //var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
//             var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
//             $(this).datepicker('setDate', new Date(year, 1, 1));
//         }
//     });
// });

function datecurr() {
var datedb = <?php echo(json_encode($datedb)); ?>;
if (datedb == null ||datedb == "0000-00-00" ) 
{
    $('#date').val(new Date().toJSON().slice(0,10));

} 
else
{
    document.getElementById("date").value = datedb;
   
}
}

function issue(pending) {
    debugger;
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
function decalassigned() {
    debugger;
    var parkinglot = document.getElementById("parking_assigned").value;
    var decaldb = <?php echo(json_encode($decaldb)); ?>;

    if (parkinglot == 'Main' && decaldb == null ) 
    {
        document.getElementById("Decal").value = "A-";

    } 
    else if(parkinglot == 'Parking - Kala Bhavan' && decaldb == null)
    {
        document.getElementById("Decal").value ="B-"; 
       
    }
    else if(parkinglot == 'Parking - Jain Temple' && decaldb == null)
    {
        document.getElementById("Decal").value ="D-";
          
    }
    else if(parkinglot == 'Parking - Green Field' && decaldb == null)
    { 
        
       document.getElementById("Decal").value ="C-";
           
    }
    else{
        document.getElementById("Decal").value = decaldb;
        //$("#Decal").val(decaldb);
    }
}

</script>
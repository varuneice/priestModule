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
    input {
        font-weight: bold;
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
$allotparking = $tpl['volarr']['Parking_AreaAssigned'] ?? ''; 
$volparking =  $this->controller->isVolunteer();
$decaldb = $tpl['volarr']['Decal'] ?? '';  
$datedb = $tpl['volarr']['Date'] ?? '';  
?>
<section class="content left width_100">
    <form id="payment-form" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Badges/Volunteers"
        method="post" name="edit" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 stretch-card1 grid-margin1">
                        <table class="table1">
                            <tr class="tr">
                                <td style="font-size: xx-large;" class="td">Parking Allotment for Volunteers</td>
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
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>MID
                                        &nbsp;</b><i class="mdi mdi-pen mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">
                                    <input readonly id="MID" class="form-control mb-5" type="text" name="MID"
                                        size="12" value="<?php echo $tpl['volarr']['MID'] ?? ''; ?>" title="MID"
                                        placeholder="MID">
                                </h2>
                                <!-- <h2 class="mb-5"><?php echo $tpl['volarr']['MID'] ?? ''; ?></h2> -->

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-danger1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>First Name
                                        &nbsp;</b><i class="mdi mdi-account-card-details float-right"></i>
                                </h4>
                                <h2 class="mb-5"> <b><input readonly id="Your_Name" class="form-control input-sm"
                                            type="text" name="Volunteer_Name" size="25"
                                            value="<?php echo $tpl['volarr']['Volunteer_Name'] ?? ''; ?>" title="First Name"
                                            placeholder="First Name"></b></h2>
                                <!-- <h2 class="mb-5"><?php echo $tpl['volarr']['Volunteer_Name'] ?? ''; ?></h2> -->

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
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>Last
                                        Name&nbsp;</b><i class="mdi mdi-account-card-details float-right"></i>
                                </h4>
                                <h2 class="mb-5"> <input readonly id="last name" class="form-control input-sm"
                                        type="text" name="L_Name" size="25"
                                        value="<?php echo $tpl['volarr']['L_Name'] ?? ''; ?>" title="Last Name"
                                        placeholder="Last Name"></h2>
                                <!-- <h2 class="mb-5"> <?php echo $tpl['volarr']['L_Name'] ?? ''; ?></h2> -->

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-danger1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>Spouse
                                        Name</b><i class="mdi mdi-gender-male-female float-right"></i>
                                </h4>
                                <h2 class="mb-5"> <input readonly id="Spouse" class="form-control input-sm"
                                        type="text" name="Spouse_Name" size="25"
                                        value="<?php echo $tpl['volarr']['Spouse_Name'] ?? ''; ?>" title="Spouse Name"
                                        placeholder="Spouse Name"></h2>
                                <!-- <h2 class="mb-5"> <?php echo $tpl['volarr']['Spouse_Name'] ?? ''; ?></h2> -->

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
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>Core
                                        Team</b><i class="mdi mdi-chart-line mdi-24px float-right"></i>
                                </h4>
                                <!-- <h2 class="mb-5">2000</h2> -->
                                <h2 class="mb-5"> <input id="Team" readonly class="form-control input-sm" type="text"
                                        name="Core_Team" size="25" value="<?php echo $tpl['volarr']['Core_Team'] ?? ''; ?>"
                                        title="Core Team" placeholder="Core Team"></h2>
                                <!-- <h2 class="mb-5"><?php echo $tpl['volarr']['Core_Team'] ?? ''; ?></h2> -->

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>Parking
                                        Basis</b><i class="mdi mdi-chart-line mdi-24px float-right"></i>
                                </h4>
                                <!-- <h2 class="mb-5">2000</h2> -->
                                <h2 class="mb-5"> <input id="Parking Basis" readonly class="form-control input-sm"
                                        type="text" name="Parking_Basis" size="25"
                                        value="<?php echo $tpl['volarr']['Parking_Basis'] ?? ''; ?>" title="Parking Basis"
                                        placeholder="Volunteer"></h2>
                                <!-- <h2 class="mb-5"><?php echo $tpl['volarr']['Parking_Basis'] ?? ''; ?></h2> -->

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
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>Spouse
                                        Team</b><i class="mdi mdi-parking float-right"></i>
                                </h4>
                                <h2 class="mb-5"> <input readonly id="Spouse_Team" class="form-control input-sm"
                                        type="text" name="Spouse_Team" size="25"
                                        value="<?php echo $tpl['volarr']['Spouse_Team'] ?? ''; ?>" title="Spouse Team"
                                        placeholder="Spouse Team"
                                        style="font-weight:bold; font-size:15px; color:black;"></h2>
                                <!-- <h2 class="mb-5">Sponsor</h2>  -->

                            </div>
                        </div>
                    </div>



                    <!-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-info1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;">
                                    <b>Registration Status</b><i class="mdi mdi-diamond mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5"> <input readonly id="Registered" class="form-control input-sm"
                                        type="text" name="Registered" size="25"
                                        value="<?php echo $tpl['volarr']['Registered'] ?? ''; ?>" title="Registration Status"
                                        placeholder="Registration Status"></h2>
                                 <h2 class="mb-5">GOLD</h2> 

                            </div>
                        </div>
                    </div>
                </div> -->
                
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-success1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>Paid
                                        Parking</b><i class="mdi mdi-diamond mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5"> <input readonly id="registration_status"
                                        class="form-control input-sm" type="text" name="Sponsor_Parking" size="25"
                                        value="<?php echo $tpl['volarr']['Sponsor_Parking'] ?? ''; ?>" title="Sponsor Parking"
                                        placeholder="Sponsor Parking"
                                        style="font-weight:bold; font-size:15px; color:black;"></h2>
                                <!-- <h2 class="mb-5">YES</h2>  -->

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
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>Parking Lot
                                        Assigned</b><i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">
                                <?php if ($this->controller->isParkingAdmin() || $this->controller->isAdmin())  { ?>
                                    <select required="true" id="parking_assigned" onchange="decalassigned(this.id)" style="width: 100%!important; height: 36px!important;"
                                        name="Parking_AreaAssigned"
                                        value="<?php echo $tpl['volarr']['Parking_AreaAssigned'] ?? ''; ?>"
                                        class="form-control input-sm medium valid">
                                        <option value="">Please select parking lot assigned</option>
                                        <option value="MainParking">Main Parking</option>
                                        <option value="KalaBhavan">Kala Bhavan</option>
                                        <option value="JainTemple">Jain Temple</option>
                                        <option value="GreenField">Green Field</option>
                                        <!-- <option value="GreenField22">Test</option> -->
                                    </select>
                                </h2>
                                <?php
                                } else {
                                    ?>
                                <h2>
                                    <input readonly id="parking_assigned" required="true" class="form-control input-sm" type="text" name="Parking_AreaAssigned" size="25"
                                value="<?php echo $tpl['volarr']['Parking_AreaAssigned'] ?? ''; ?>" title="parking Assigned"
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
                                <h4 class="font-weight-normal mb-3" style="font-size: 27px; color:white;"><b>Decal
                                        Assigned</b><i class="mdi mdi-diamond mdi-24px float-right"></i>
                                </h4>
                                <?php if ($this->controller->isParkingAdmin() || $this->controller->isAdmin())  { ?>
                                <h2 class="mb-5"> <input id="Decal" class="form-control input-sm"
                                        type="text" name="Decal" size="25"
                                        value="<?php echo $tpl['volarr']['Decal'] ?? ''; ?>" title="Decal"
                                        placeholder="Decal"></h2>
                                        <?php
                                } else {
                                    ?>

                                        <h2 class="mb-5"> <input required="true" id="Decal" class="form-control input-sm"
                                        type="text" name="Decal" size="25"
                                        value="<?php echo $tpl['volarr']['Decal'] ?? ''; ?>" title="Decal"
                                        placeholder="Decal"></h2>
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
                                <h4 style="font-size: 27px; color:white;" class="font-weight-normal mb-2"><b>FULL Name
                                        When Authorized To Collect</b><i
                                        class="mdi mdi-diamond mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5"> <input id="Full_Name" class="form-control input-sm" type="text"
                                        name="Name_Authorized" size="25"
                                        value="<?php echo $tpl['volarr']['Name_Authorized'] ?? ''; ?>" title="Full Name"
                                        placeholder="Full Name "></h2>

                            </div>
                        </div>
                    </div>
                
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 stretch-card1 grid-margin1">
                        <div class="card1 bg-gradient-primary1 card-img-holder1 text-white1">
                            <div class="card-body1">
                                <h4 style="font-size: 27px; color:white;"><b>Signature</b></h4>
                                <button id="clear" style="font-size:17px;margin-bottom: 3px; ">Clear</button>
                                <button id="disable" style="font-size:17px; margin-bottom: 3px;">Disable</button>
                                <img src="<?= INSTALL_URL ?>images/dashboard/circle.svg"
                                    class="card-img-absolute1" alt="circle-image" />
                                <!-- <h4 class="font-weight-normal mb-3">Signature<i class="mdi mdi-diamond mdi-24px float-right"></i> -->
                                <div style="width: 350px!important;height:74px!important;" id="sig"> </div>
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
                                <h4 style="font-size: 27px; color:white;"><b> Date </b></h4>
                                    <?php if ($this->controller->isParkingAdmin() || $this->controller->isAdmin())  { ?>
                                    <h3 class="mb-5">
                                    <input  type="date" id="date" name="Date" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $tpl['volarr']['Date'] ?? ''; ?>"  title="Date">
                                        </h3>
                                        <?php
                                } else {
                                    ?>

                                        <h3 class="mb-5">  <input required="true" type="date" id="date" name="Date" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $tpl['volarr']['Date'] ?? ''; ?>"  title="Date"></h3>
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
                                <input type="hidden" name="edit_volenteers" value="1" />
                                <input type="hidden" name="ID" value="<?php echo $tpl['volarr']['ID'] ?? ''; ?>" />
                                <input type="hidden" name="Volunteer_Name" value="<?php echo $tpl['volarr']['Volunteer_Name'] ?? ''; ?>" />
                                <input type="hidden" name="L_Name" value="<?php echo $tpl['volarr']['L_Name'] ?? ''; ?>" />
                                <input type="hidden" name="MID" value="<?php echo $tpl['volarr']['MID'] ?? ''; ?>" />
                                
                                <input type="hidden" name="Tele1" value="<?php echo $tpl['volarr']['Tele1'] ?? ''; ?>" /> 
                                <input type="hidden" name="email" value="<?php echo $tpl['volarr']['email'] ?? ''; ?>" />
                                   <div class="row"> 
                                   
                                <?php if ($this->controller->isParkingAdmin() || $this->controller->isAdmin())  { ?>
								
                                <button class="col-lg-6 col-md-6 col-sm-6 col-xs-6 btn btn-primary" style="width:150px!important;height:116px;font-size:27px;" id="submits" 
                                autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9"
                                type="submit"><i
                                    class="fa fa-fw fa-save"></i><b><?php echo _('Save') ?></b></button>
                                    
                                     <?php
                            } else {
                                ?>
                             <button class="col-lg-6 col-md-6 col-sm-6 col-xs-6 btn btn-primary" disabled="" style="width:150px!important;height:116px;font-size:27px;" id="submit"
                                autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9"
                                type="submit"><i
                                    class="fa fa-fw fa-save"></i><b><?php echo _('Save') ?></b></button>
                                 <?php
                        } ?>	
										
                                        <button class="col-lg-6 col-md-6 col-sm-6 col-xs-6 btn btn-primary" style="float:right!important;width:150px!important;height:116px;font-size:27px;"  id="clean" style="font-size:17px; margin-bottom: 3px;">Clear</button>   
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
<div id="record_id" style="display:none"></div>

<script>
    $( document ).ready(function() {
debugger;
datecurr();
 var parkingassigned =  document.getElementById("parking_assigned").value;
 
   if(  parkingassigned == ""){
    $( "#submit" ).prop( "disabled", true );   
  }
  else{
    $( "#submit" ).prop( "disabled", false ); 
  }
  
  
  var myVariable = <?php echo(json_encode($allotparking)); ?>;
 $("#parking_assigned").val(myVariable);
 
   var parkinglot = <?php echo(json_encode($allotparking)); ?>;

if(parkinglot !=null || parkinglot == "" || parkinglot == " "){
    // document.getElementById("parking_assigned").value =parkinglot; 
 $("#parking_assigned").val(parkinglot);
}
 
 
 decalassigned();
 var volparking = <?php echo(json_encode($volparking)); ?>;
 var decal =  document.getElementById("Decal").value;
  var testdeck = decal.split("-");
    testdeck[0];
    var decktest = testdeck[1];
  if(volparking == true && decktest != ""){    
    document.getElementById("submit").style.display = "none";
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
if (datedb == null ||datedb == "0000-00-00") 
{
    $('#date').val(new Date().toJSON().slice(0,10));

} 
else
{
    document.getElementById("date").value = datedb;
   
}
}


function decalassigned() {
    debugger;
    var parkinglot = document.getElementById("parking_assigned").value;
    var decaldb = <?php echo(json_encode($decaldb)); ?>;

    if (parkinglot == 'MainParking' && decaldb == "" ) 
    {
        document.getElementById("Decal").value = "A-";

    } 
    else if(parkinglot == 'KalaBhavan' && decaldb == "")
    {
        document.getElementById("Decal").value ="B-"; 
       
    }
    else if(parkinglot == 'JainTemple' && decaldb == "")
    {
        document.getElementById("Decal").value ="D-";
          
    }
    else if(parkinglot == 'GreenField' && decaldb == "")
    {
        document.getElementById("Decal").value = "C-";
          
    }
    else{
        document.getElementById("Decal").value = decaldb;
     
    }
}
</script>
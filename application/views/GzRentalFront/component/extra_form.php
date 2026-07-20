<style>
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
   .amd z{display:none;}
  .ab z{display:none;}
#vid{display:none;}
 .point{
    pointer-events: none;
    opacity: 0.3;
    }

</style>


<div id="container-abc-url-id" style="display:none;"><?php echo INSTALL_URL; ?></div>
<form action="post" name="gz-time-slot-booking-form" id="gz-time-slot-booking-form-id">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title"><strong><?php echo "Date Time Slot" ?></strong></h3>
          
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr> 
                    <th>Event Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Total Duration(Hours)</th>
                            
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                      $SS = $tpl['startdate'];
                      //   $LL = $tpl['enddate'];
                      
                      
                    //   9-oct-2025 - change by varun
                    //   $st = date("d-m-Y", $SS);
                       $st = date("Y-m-d", $SS);
                       
                      
                      $stuidate = date("m-d-Y", $SS);
                      $lt = date("d-m-Y", $LL ?? 0);

                      ?>
                      
                            <tr>
                            <td class="td">
                            <input readonly required="true" id="startdateui" class="form-control input-sm"  name="Startdateui" size="25" value="<?php echo $stuidate; ?>" title="Date" placeholder="">    
                            <input readonly required="true" id="startdate" class="form-control input-sm"  name="Startdate" size="25" value="<?php echo $st; ?>" title="Date" placeholder="" style = "display:none;">
                            </td>
                            
                                <td class="td"><select id="starttime" name="Starttime"  class="form-control input-sm"style="width: 100px;" onchange="Checkstarttime(this)" >
                                <?php for($i = 0; $i < 24; $i++): ?>
                                    <option value="<?= $i % 24 ? $i % 24 : 24 ?>:00 <?= $i >= 24  ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'PM' : 'AM' ?></option>
                                    <?php endfor ?>
                                </select>
                                 <input id="hidestarttime" class="form-control" type="text" name="hidestarttime"style="display:none;">
                                <input id="hideendtime" class="form-control" type="text" name="hideendtime"  style ="display:none;">
                                </td>
                                <td class="td">
                                    <!-- <input style="WIDTH: 85%;" required="true" type="time" maxlength="2" min="10:00" max="24:00" id="endtime" name="Endtime" class="form-control input-sm" value=""> -->
                                    <select id="endtime" name="Endtimeui" class="form-control input-sm" style="width: 100px;" onchange="calculateTotalHour()">
                                    <?php for ($i = 0; $i < 24; $i++): 
                                        $value = sprintf("%02d:00", $i);
                                        $hour = $i % 12 ? $i % 12 : 12;
                                        $ampm = $i < 12 ? 'AM' : 'PM';
                                        $label = sprintf("%02d:00 %s", $hour, $ampm);
                                    ?>
                                        <option value="<?= $value ?>"><?= $label ?></option>
                                    <?php endfor; ?>
                                </select>
                                
                                </td>
                                <td class="td" style="display:none;">
                                <select id="Your_endtime" name="Endtime"  class="form-control input-sm"style="width: 100px;" >
                                <?php for($i = 0; $i < 24; $i++): ?>
                                    <option value="<?= $i % 24 ? $i % 24 : 24 ?>:00 <?= $i >= 24  ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'PM' : 'AM' ?></option>
                                    <?php endfor ?>
                                </select>
                                </td>
                               
                                <td class="td"><input style="WIDTH: 85%;" required="true" type="number" id="hours" name="Hours" class="form-control input-sm" value="" onchange="CheckHour(this)"></td>
                            </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title"><strong><?php echo __('booking_details'); ?></strong></h3>
        </div>
        <div class="box-body">
            <?php if (empty($_POST['location']) && ($tpl['prices']['calendars_price'] ?? 0) != 0) { ?>

                    <div class="form-group" style="display:none;">
                        <label class="control-label" for=""><?php echo __('calendar_price'); ?>:</label>
                        <span id="calendars_price"><?php echo $tpl['prices']['formated_calendars_price'] ?? ''; ?></span>
                    </div> 

                    <div class="form-group" >
                        <label class="control-label" for=""><?php echo __('total_price'); ?>:</label>
                        <span id="total"><?php echo $tpl['prices']['formated_total'] ?? ''; ?></span>
                    </div>
                    <input type="hidden" name="regmember" id="registrationmember" value="member">
                    <input type="hidden" name="termMember" id="termMember" value="">
                    <input type="hidden" name="term" id="term" value="">
                    <input type="hidden" name="Member_id" id="idmem" value="">
                    <div id="otp-session-verified" style="display:none"><?= htmlspecialchars($_SESSION['otp_verified_member'] ?? '') ?></div>
                    <div id="otp-verified-banner" style="display:none;padding:8px 14px;background:#eafaf1;border:1px solid #b7e4c7;border-radius:5px;color:#1e8449;font-size:13px;font-weight:600;margin-bottom:10px;gap:8px;align-items:center;">
                        <i class="fa fa-check-circle" style="color:#276632;font-size:16px;"></i>
                        <span>Member verified and details auto-filled.</span>
                    </div>
                    <div id="rental-direct-member-verify" style="display:none;"></div>
                    <?php
            } else {
                ?>
                    <div class="form-group" >
                    <select style="transform: translateX(41%);" required="" name="regmember" id="registrationmember"
                                    class="form-control input-sm" aria-required="true" aria-invalid="false" onchange="membercheck(this)" >
                                    <!-- <option value="">Please select Member type</option> -->
                                    <option value="">Durga Bari Member</option>
                                    <option value="member">Yes</option>
                                    <option value="nonmember">No</option>

                                     </select>
                                     </div>
                    <div id="otp-gate" style="display:none;margin:6px 0;">
                        <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;background:#f0f8ff;border:1px solid #b0d0f0;border-radius:5px;padding:8px 12px;">
                            <span><strong>Member Identity Verification:</strong></span>
                            <button type="button" id="otp-gate-btn" class="btn btn-info btn-sm">Verify via OTP</button>
                        </div>
                    </div>
                    <div  id="termdiv" class="form-group" style="display:none;">
                    <input type="text" style="display:none" name="termMember" id="termMember" placeholder="search member here...." class="form-control">  
                    <input type="text" style="transform: translateX(41%);" name="term" id="term" placeholder="search member here...." class="form-control">  
                     </div>
                 
                
                            <div id="memberidtd" style="display:none;" class="form-group">
                        <input id="idmem" oninvalid="this.setCustomValidity(`Please search the name in the autocomplete of member name and select name!`)" style="transform: translateX(41%);" class="form-control input-sm point" type="number" name="Member_id" size="25" value="" title="<?php echo __('Member Id'); ?>" placeholder="<?php echo __('Member Id'); ?>" >
                    </div> 
                    <div style="display:none;" class="form-group">
                    <label class="control-label" style ="color:white;"></label>
                        <input id="MemberSelect" class="form-control input-sm" type="text" name="MemberSelect" size="25" value="" title="<?php echo __('Member Id'); ?>" placeholder="<?php echo __('Member Id'); ?>">
                    </div> 
                    <div class="form-group">
                    <label class="control-label" style ="color:white;">vvv:</label>
                        <select data-rule-required='true' name="location" id="location" onchange="hideDiv(this)" class="form-control input-sm"  style="transform: translateX(-25%);">
                            <option value="">Select Space</option>
                            <option value="Auditorium">Auditorium </option>
                            <option value="Kalabhavan">Kalabhavan </option>
                            <option value="Both">Auditorium & Kalabhavan</option>
                        </select>
                    </div>
                
                    <div id="advanceamount" class="form-group" style="display:none">
                    <select class="form-control input-sm selectpicker" data-live-search="true" id="advanceamount" readonly name="advanceamount" required="" class="form-control input-sm selectpicker" style="transform: translateX(42%);">
                                
                                    <?php
                                    foreach (($tpl['advanceamount'] ?? []) as $key => $value) {
                                        $val = '$ ' . $value['advanceamount'];
                                        ?>
                                
                                        <option value="<?php echo $val; ?>" id="newadvanceamount"><?php echo $val; ?></option> 
                                        <?php
                                    }
                                    ?>
                                    </select>
                    </div>
                
                    <div class="form-group" style="display:none">
                       <select id="category" name="category" required="" class="form-control input-sm selectpicker" style="transform: translateX(42%);">
                                    <option value="">Please select category</option> 
                                    <?php
                                    foreach (($tpl['category'] ?? []) as $key => $value) {
                                        ?>
            
                                        <option value="<?php echo $value['category']; ?>"><?php echo $value['category']; ?></option> 
                                        <?php
                                    }
                                    ?>
                                    </select>
                    </div>


                    <div class="form-group" style="display:none">
                        <label class="control-label" style ="color:white;">vvv:</label>
                        <select data-rule-required='true' name="item" id="item" class="input-sm" class="form-control input-sm"  style="transform: translateX(-25%);">
                            <option value="">Select items</option>
                            <option value="Chair">Chair </option>
                            <option value="Lights">Lights </option>
                      
                        </select>
                    </div>

                    <div class="form-group" id="hide1" style="display:none">
                        <label class="control-label" style ="color:white;">Select Puja Type:</label>
                        <select data-rule-required='true' name="Puja" id="Puja" class="form-control input-sm"  onchange="populate(this.id)" style="transform: translateX(-25%);" >
                            <option value="" data-subtext="">Select Puja Type</option>
                            <option value="21.00" data-subtext="Walk-in Puja">$21.00 ... Walk-in Puja</option>
                            <option value="101.00" data-subtext="Sankalpa Puja">$101.00 ... Sankalpa Puja</option>
                            <!-- <option value="251.00" data-subtext="(Outside)">$251.00 ... Annaprasana</option> -->
                            <option value="201.00" data-subtext="Annaprasana">$201.00 ... Annaprasana</option>
                            <option value="51.00 " data-subtext="Anniversary">$51.00 ... Anniversary</option>
                            <option value="201.00" data-subtext="Batsaric Sapindakaran">$201.00 ... Batsaric Sapindakaran</option>
                            <option value="51.00" data-subtext="Birthday">$51.00 ... Birthday</option>
                            <option value="151.00" data-subtext="Chaturthi Puja">$151.00 ... Chaturthi Puja</option>
                            <!-- <option value="301.00" data-subtext="">$301.00 ... Funeral Service</option> -->
                            <option value="201.00" data-subtext="Grihaprabesh">$201.00 ... Grihaprabesh</option>
                            <option value="101.00 " data-subtext="ePuja">$101.00 ... ePuja</option>
                            <option value="101.00" data-subtext="Mahayagna">$101.00 ... Mahayagna</option>
                            <option value="701.00" data-subtext="Marriage">$701.00 ... Marriage</option>
                            <!-- <option value="1001.00" data-subtext="(Outside)">$1001.00 ... Marriage</option> -->
                            <option value="201.00" data-subtext="Nandimukh">$201.00 ... Nandimukh</option>
                            <option value="51.00" data-subtext="New Vehicle">$51.00 ... New Vehicle</option>
                            <option value="601.00 " data-subtext="Poita / Uponayan">$601.00 ... Poita / Uponayan</option>
                            <option value="301.00" data-subtext="Sraddhanushthan">$301.00 ... Sraddhanushthan</option>
                            <option value="251.00" data-subtext="Sponsoring Maha Pujas">$251.00 ... Sponsoring Maha Pujas</option>
                            <!-- <option value="151.00" data-subtext="">$151.00 ... Sponsoring Pujas</option> -->
                            <option value="21.00 " data-subtext="Tarpan">$21.00 ... Tarpan</option>
                            <option value="301.00" data-subtext="Wedding Engagement">$301.00 ... Wedding Engagement</option>
                            <option value="31.00" data-subtext="Sankalpa Puja ">$31.00 ... Sankalpa Puja (Special Occasion)</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group" id="hide2" style="display:none;">
                        <label  class="control-label" style ="color:white;">Select Puja Type:</label>
                        <select data-rule-required='true' name="Puja2" id="Puja2" class="form-control input-sm" onchange="populate(this.id)" style="transform: translateX(-25%);" >
                            <option value="" data-subtext="">Select Puja Type</option>
                            <option value="126" data-subtext="Sankalpa Puja">$126 ... Sankalpa Puja</option>
                            <option value="251" data-subtext="Annaprasana">$251 ... Annaprasana</option>
                            <option value="63.5" data-subtext="Anniversary">$63.5 ... Anniversary</option>
                            <option value="251" data-subtext="Batsaric Sapindakaran">$251 ... Batsaric Sapindakaran</option>
                            <option value="63.5" data-subtext="Birthday">$63.5 ... Birthday</option>
                            <option value="188.5" data-subtext="Chaturthi Puja">$188.5 ... Chaturthi Puja</option>
                            <option value="301.00" data-subtext="Funeral Service">$301.00 ... Funeral Service</option>
                            <option value="251" data-subtext="Grihaprabesh">$251 ... Grihaprabesh</option>
                            <option value="126 " data-subtext="ePuja">$126 ... ePuja</option>
                            <option value="126" data-subtext="Mahayagna">$126 ... Mahayagna</option>
                            <option value="876" data-subtext="Marriage">$876 ... Marriage</option>
                            <option value="251" data-subtext="Nandimukh">$251 ... Nandimukh</option>
                            <option value="751" data-subtext="Poita / Uponayan">$751 ... Poita / Uponayan</option>
                            <option value="376" data-subtext="Sraddhanushthan">$376 ... Sraddhanushthan</option>
                            <option value="313.5" data-subtext="Sponsoring Maha Pujas">$313.5 ... Sponsoring Maha Pujas</option>
                            <option value="26" data-subtext="Tarpan">$26 ... Tarpan</option>
                            <option value="376" data-subtext="Wedding Engagement">$376 ... Wedding Engagement</option>
                            <option value="38.5" data-subtext="Sankalpa Puja">$38.5 ... Sankalpa Puja (Special Occasion)</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group" style="display:none;">
                        <label class="control-label" for=""><?php echo __('calendar_price'); ?>:</label>
                        <span id="calendars_price"><?php echo $tpl['prices']['formated_calendars_price'] ?? ''; ?></span>
                    </div> 
                    <div class="form-group">
                        <label class="control-label" for="" style ="color:white;margin-top: -16px;"><?php echo __('Total Price:'); ?>:</label>
                        <span id="total" style="transform: translateX(-25%);"><?php echo $tpl['prices']['formated_total'] ?? ''; ?></span>
                    </div>
                    <?php
            }
            ?>
           
            
        </div> 
    </div>
    <?php require 'booking_form.php'; ?>
    <div class="box box-solid box-primary">
        <div class="box-body">
            <?php
            foreach ($_POST as $name => $value) {
                if (!in_array($name, array('confirm_code', 'Puja', 'Puja2', 'location', 'extra_id', 'captcha', 'additional', 'payment_method', 'cc_type', 'cc_num', 'cc_code', 'cc_exp_year', 'cc_exp_month', 'fax', 'country', 'zip', 'state', 'address_2', 'address_1', 'company', 'email', 'phone', 'second_name', 'first_name', 'male', 'title'))) {
                    if (is_array($value)) {
                        foreach ($value as $k => $v) {
                            ?>
                                            <input type="hidden" name="<?php echo $name; ?>[]" value="<?php echo $v ?>" />
                                            <?php
                        }
                    } else {
                        ?>
                                    <input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value ?>" />
                                    <?php
                    }
                }
            }
            ?> 
            <a data-style="expand-left" href="javascript:" class="btn btn-default btn btn-danger ladda-button" id="back_to_calendar_id" autocomplete="off" value="<?php echo __('back'); ?>" name="back" tabindex="9" type="submit">
                <span class="ladda-label"><?php echo __('back'); ?></span>
                <span class="ladda-spinner"></span>
            </a>
            <a data-style="expand-left" href="javascript:" class="btn btn-warning ladda-button  <?php echo (!(count($_SESSION[$this->controller->default_product]['slots'][$_REQUEST['cid']] ?? []) > 0)) ? "disabled" : ""; ?>" id="details_frm_btn_id" autocomplete="off" value="<?php echo __('booking'); ?>" name="submit" tabindex="9" type="submit">
                <span class="ladda-label"><i class="fa fa-gavel"></i>&nbsp;&nbsp;&nbsp;<?php echo __('booking'); ?></span>
                <span class="ladda-spinner"></span>
            </a>
        </div>
    </div>
    <div id='div_session_write' name='div_session_write'></div>
</form>
<script>
    function getSafeResponseInput(res, id, jq) {
        var $jq = jq || (typeof gz$ !== 'undefined' ? gz$ : $);
        var nodes = $jq.parseHTML($jq.trim(res || ''), document, false) || [];
        var $nodes = $jq(nodes);
        var $el = $nodes.filter('input#' + id);
        if (!$el.length) {
            $el = $jq('<div>').append($nodes).find('input#' + id);
        }
        return $el;
    }

$( document ).ready(function() {
    debugger;
//  document.getElementById("starttime").value ="10:00 ";
// $('#endtime').attr('readonly', true)
//  $("#endtime").attr("disabled", "disabled");
setDefaultTime();
});

    var select = document.getElementById("category");
    var textBoxElement = document.getElementById("item");

    function hideDiv(elem) {
        debugger
        var selectedString = select.options[select.selectedIndex].value;

        if (elem.value == "Auditorium" || elem.value == "Kalabhavan" || elem.value == "Both") {
            document.getElementById('advanceamount').style.display = 'block';
            //document.getElementById('hide2').style.display = "none";
            textBoxElement.required = false;
            select.required = false;
            //textBoxElement.style.border="";

        } else
        {
            document.getElementById('advanceamount').style.display = "none";
            textBoxElement.required = true;
            select.required = true;
        }
    }
    sessionStorage.setItem('EICEP', '');
    function populate(membership1)
    {

        var e = document.getElementById(membership1);
        var strUser = e.value;
        var pujaDetail = e.options[e.selectedIndex].text;
        var pujaName = pujaDetail.split("...");
        sessionStorage.setItem('EICEP', strUser);
        document.getElementById("promo_code").value = pujaName[1];

    }
    var select = document.getElementById("registrationmember");
 
 
   
//   28oct2025 new code -by varun
// ✅ Utility function to safely parse date in both input formats
function parseDateInput(dateStr) {
    // Build a local Date object so YYYY-MM-DD does not shift day in US timezones.
    if (!dateStr) return null;
    const parts = dateStr.trim().split("-");

    if (parts.length !== 3) return null;

    if (parts[0].length === 4) {
        return new Date(
            parseInt(parts[0], 10),
            parseInt(parts[1], 10) - 1,
            parseInt(parts[2], 10)
        );
    }

    if (parts[2].length === 4) {
        return new Date(
            parseInt(parts[2], 10),
            parseInt(parts[0], 10) - 1,
            parseInt(parts[1], 10)
        );
    }

    return null;
}

// ✅ Function 1 — Validate Start Time
function Checkstarttime(elem) {

    debugger
    const start = document.getElementById("starttime").value;
    if (!start) return;
    const [startHour] = start.split(":").map(Number);

    const dateInput = document.getElementById("startdate").value;
    const d = parseDateInput(dateInput);
    if (!d || isNaN(d)) {
        alert("Invalid date. Please select a valid date.");
        return;
    }

    const endTime = $("#endtime").val();
    const reset = (msg) => {
        alert(msg);
        document.getElementById("endtime").value = "";
        document.getElementById("starttime").value = "";
        document.getElementById("hours").value = "";
        return false;
    };

    const dayOfWeek = d.getDay(); // 0 = Sun, 6 = Sat

    // Sunday (0)
    if (dayOfWeek === 0) {
        if (startHour < 15) {
            return reset(
                "Bookings on Sunday are allowed only after 3:00 PM (15:00)."
            );
        }
    }

    // Monday–Saturday (1–6)
    if (dayOfWeek !== 0) {
        if (startHour < 10) {
            return reset(
                "Bookings from Monday to Saturday can start only after 10:00 AM."
            );
        }
    }

    if (endTime) {
        calculateTotalHour(); // optional function if defined elsewhere
    }
}

// ✅ Function 2 — Validate Hours and End Time
function CheckHour(elem) {

    debugger
    const txtstarttime = $("#starttime option:selected").text().trim();
    const start = document.getElementById("starttime").value;
    if (!start) return;

    const [startHour] = start.split(":").map(Number);
    const hour = parseInt(document.getElementById("hours").value);
    const endElem = document.getElementById("endtime");
    const dateInput = document.getElementById("startdate").value;
    const d = parseDateInput(dateInput);

    if (!d || isNaN(d)) {
        alert("Invalid date. Please select a valid date.");
        return;
    }

    const reset = (msg) => {
        alert(msg);
        endElem.value = "";
        document.getElementById("starttime").value = "";
        document.getElementById("hours").value = "";
        return false;
    };

    const dayOfWeek = d.getDay();
    const newEndHour = startHour + hour;

    // 1️⃣ Sunday (0)
    if (dayOfWeek === 0) {
        if (startHour < 15) {
            return reset(
                "Bookings on Sunday are allowed only after 3:00 PM (15:00)."
            );
        }
        if (newEndHour > 23) {
            return reset("End time cannot exceed 11:00 PM (23:00).");
        }
        
        if (hour > 4) {
            return reset(
                "Bookings from Monday to Friday and Sunday are limited to 4 hours only."
            );
        }

        endElem.value = `${newEndHour}:00`;
        alert("Sunday booking — weekday rate applies.");
        return true;
    }
    // Saturday (6)
    if (dayOfWeek === 6) {
        if (hour > 8) {
            return reset("Saturday maximum booking allowed is 8 hours.");
        }
        if (startHour < 10 || newEndHour > 23) {
            return reset(
                "Bookings on Saturday can start after 10:00 AM and must end before 11:00 PM."
            );
        }

        endElem.value = `${newEndHour}:00`;
        if (hour > 4) {
            alert("Saturday booking - 8-hour rate applies (over 4 hours).");
        } else {
            alert("Saturday booking - weekday rate applies.");
        }
        return true;
    }
    // Monday–Friday (1–5)
    if (dayOfWeek >= 1 && dayOfWeek <= 5) {
        if (hour > 4) {
            return reset(
                "Bookings from Monday to Friday are limited to 4 hours only."
            );
        }
        if (startHour < 10 || newEndHour > 23) {
            return reset(
                "Bookings from Monday to Friday can start after 10:00 AM and end before 11:00 PM."
            );
        }

        endElem.value = `${newEndHour}:00`;
        alert("Weekday booking — weekday rate applies.");
        return true;
    }

    return reset("Invalid date selection. Please check your inputs.");
}

   
   
    function Checkstarttime_28_oct_2025(elem){
        debugger;
        var start = document.getElementById("starttime").value;
        var newtime = start.split(":");
         var startnewtime = newtime[0];
         
         var startdate = document.getElementById('startdate');
         var date = startdate.value;
         const d = parseDateInput(date);
         if (!d || isNaN(d)) {
            alert("Invalid date. Please select a valid date.");
            document.getElementById('endtime').value = '';
            document.getElementById('starttime').value = '';
            document.getElementById('hours').value = '';
            return;
         }
         let endTime = $("#endtime").val();

        if(d.getDay() == 0 ){
            if (startnewtime < 15) {
            alert("HDBS Kala Bhavan cannot be rented during Sunday from 10:00 AM to 3:00 ");
            document.getElementById('endtime').value = '';
            document.getElementById('starttime').value = '';
             document.getElementById('hours').value = '';
            }
        }
        if(d.getDay() != 0 ){
            if(startnewtime < 10){
                alert("User can only select minimum start time from 10:00 AM  to end time latest by 12:00 pm ");
            document.getElementById('endtime').value = '';
            document.getElementById('starttime').value = '';
            document.getElementById('hours').value = '';
            }
       
           
        } 
        if(endTime){
            calculateTotalHour();
        }
    }


    
    function CheckHour_28_oct_2025(elem) {
        debugger;
        var txtstarttime = $("#starttime option:selected").text().trim();
        var start = document.getElementById("starttime").value;
        var newtime = start.split(":");
         var startnewtime = newtime[0];
         
         var hour = document.getElementById("hours").value;
         var newendtime  = parseInt(startnewtime) + parseInt(hour);


         var startdate = document.getElementById('startdate');
         var date = startdate.value;
         const d = parseDateInput(date);
         if (!d || isNaN(d)) {
            alert("Invalid date. Please select a valid date.");
            document.getElementById('endtime').value = '';
            document.getElementById('starttime').value = '';
            document.getElementById('hours').value = '';
            return;
         }
         
         
          if (d.getDay() != 6) {
            if (hour > 4) {
                alert("You can not select more than 4 hours except on Saturday");
                document.getElementById('endtime').value = '';
                document.getElementById('starttime').value = '';
                document.getElementById('hours').value = '';
                return
            }

        }

         
         if(d.getDay() == 0 ){
            if (startnewtime < 16) {
            alert("HDBS Kala Bhavan cannot be rented during Sunday from 10:00 AM to 4:00 ");
            document.getElementById('endtime').value = '';
            document.getElementById('starttime').value = '';
             document.getElementById('hours').value = '';
            }
            if(hour < 4){
            alert("Please select minimum 4-hour");
             document.getElementById('endtime').value = '';
            document.getElementById('starttime').value = '';
            document.getElementById('hours').value = '';
         }
        }
        if(d.getDay() != 0 ){
            if(startnewtime < 10){
                alert("User can only select minimum start time from 10:00 AM  to end time latest by 12:00 pm ");
            document.getElementById('endtime').value = '';
            document.getElementById('starttime').value = '';
            document.getElementById('hours').value = '';
            }
       } 
        if(hour < 4 ){
            alert("Please select minimum 4-hour");
             document.getElementById('endtime').value = '';
            document.getElementById('starttime').value = '';
            document.getElementById('hours').value = '';

           }

          else if(newendtime > 23 ||newendtime < 10) {
            alert("User can only  select minimum start time from 10:00 AM  to end time latest by 11:00 pm");
            document.getElementById('endtime').value = '';
            document.getElementById('starttime').value = '';
            document.getElementById('hours').value = '';

          }
          else if(newendtime >= 4) {
            document.getElementById("endtime").value = newendtime +':00';
            document.getElementById("Your_endtime").value = newendtime +':00 ';
            
            var endtimetxt = $("#endtime option:selected").text();
            document.getElementById("hidestarttime").value = txtstarttime;
            document.getElementById("hideendtime").value = endtimetxt;
          }
          
    } 

 $(function(){
    $('input[type="text"]').change(function(){
        this.value = $.trim(this.value);
    });
});

 $('#idmem').keydown(function(e) {
    e.preventDefault();
    return false;
 });
 $('#term').on('input', function() {
  $(this).val($(this).val().replace(/[^a-z0-9]/gi, ''));
});

    
$(function() {
    $("#term").autocomplete({
        //source: "http://localhost/HDBS_Payment/PriestMember/ajax-db-search.php",
        source: '<?= INSTALL_URL ?>ajax-db-search.php',
        select: function( event, ui ) {
            event.preventDefault();
            $("#term").val(ui.item.value);
            $("#termMember").val(ui.item.id);
             MemberSelectRental();
        },
        onclick: function( event, ui ) {
            event.preventDefault();
            var name =  ui.item.value;
            var f_name = name.split(",");
            $("#term").val(f_name[0]);
            $("#termMember").val(ui.item.id);
             MemberSelectRental();
          
        },
        onchange: function( event, ui ) {
            event.preventDefault();
            var name =  ui.item.value;
            var f_name = name.split(",");
            $("#term").val(f_name[0]);
            $("#termMember").val(ui.item.id);
             MemberSelectRental();
          
        },
    });
});
function autoFillRentalMemberById(memberId) {
    var serverurl = gz$("#server-id").text();
    if (!memberId) {
        return;
    }
    $("#termMember").val(memberId);
    gz$.ajax({
        type: "POST",
        data: { memberid: memberId },
        url: serverurl + "load.php?controller=Donations&action=AllMemberNew",
        success: function (res) {
            let firstName = "";
            let lastName = "";
            let memberid = "";
            let phoneNo = "";
            let email = "";
            let street = "";
            let resaddress = "";
            let state = "";
            let city = "";
            let zipcode = "";

            let el = getSafeResponseInput(res, "MemberName", gz$);
            if (el.length) firstName = el[0].value;

            el = getSafeResponseInput(res, "last_name", gz$);
            if (el.length) lastName = el[0].value;

            el = getSafeResponseInput(res, "memberid", gz$);
            if (el.length) memberid = el[0].value;

            el = getSafeResponseInput(res, "Tele1", gz$);
            if (el.length) phoneNo = (el[0].value || "").replace(/-/g, "");

            el = getSafeResponseInput(res, "email", gz$);
            if (el.length) email = el[0].value;

            el = getSafeResponseInput(res, "ressidentalAddress", gz$);
            if (el.length) street = el[0].value;

            el = getSafeResponseInput(res, "Address", gz$);
            if (el.length) resaddress = el[0].value;

            el = getSafeResponseInput(res, "state", gz$);
            if (el.length) state = el[0].value;

            el = getSafeResponseInput(res, "city", gz$);
            if (el.length) city = el[0].value;

            el = getSafeResponseInput(res, "zip_code", gz$);
            if (el.length) zipcode = el[0].value;

            $("#first_name").val(firstName);
            $("#second_name").val(lastName);
            $("#idmem").val(memberid || memberId);
            $("#phone").val(phoneNo);
            $("#email").val(email);
            $("#address_1").val($.trim([street, resaddress, state, city, zipcode].join(" ")));
            $("#term").val($.trim([firstName, lastName].join(" ")));
            $("#otp-session-verified").text(memberid || memberId);
        }
    });
}
var isAdminLoggedInForRental = <?php echo $this->controller->isAdmin() ? 'true' : 'false'; ?>;

function membercheck() {
        var selectedString = select.options[select.selectedIndex].value;
        var checkdata = selectedString;

        if (checkdata == "member") {
            document.getElementById('termdiv').style.display = "none";
            document.getElementById('memberidtd').style.display = "none";
            $("#first_name").val("");
            $("#second_name").val("");
            $("#phone").val("");
            $("#email").val("");
            $("#address_1").val("");
            $("#term").val("");
            $("#termMember").val("");
            $("#idmem").val("");
            $("#term").prop('required', false);
            $("#idmem").prop('required', false);
            $('#otp-gate').hide();
            $('#otp-verified-banner').removeClass('otp-show').css('display', 'none');

            if (isAdminLoggedInForRental) {
                document.getElementById('termdiv').style.display = "block";
                document.getElementById('memberidtd').style.display = "block";
                $("#term").prop('required', true);
                $("#idmem").prop('required', true);
                $('#otp-session-verified').text('');
                return;
            }
            if ($.trim($('#otp-session-verified').text())) {
                $('#otp-verified-banner').addClass('otp-show').css('display', 'flex');
                autoFillRentalMemberById($.trim($('#otp-session-verified').text()));
                return;
            }

            if (typeof window.OtpMemberVerify !== 'undefined') {
                window.OtpMemberVerify.open({
                    onVerified: function(memberId) {
                        $('#otp-gate').hide();
                        $('#otp-verified-banner').addClass('otp-show').css('display', 'flex');
                        autoFillRentalMemberById(memberId);
                    }
                });
                window.onOtpModalCancelled = function () {
                    $('#registrationmember').val('');
                    $('#otp-session-verified').text('');
                };
            }

        } else
        {
            document.getElementById('termdiv').style.display = "none";
            document.getElementById('memberidtd').style.display = "none";
            $("#first_name").val("");
            $("#second_name").val("");
            $("#phone").val("");
            $("#email").val("");
            $("#address_1").val("");
            $("#term").val("");
            $("#termMember").val("");
            $("#idmem").val("");
            $("#term").prop('required',false);
            $("#idmem").prop('required',false);
            $('#otp-gate').hide();
            $('#otp-verified-banner').removeClass('otp-show').css('display', 'none');
            $('#otp-session-verified').text('');
        }
    }
    
 function MemberSelectRental() {
            var self = this;
            var serverurl = gz$("#server-id").text();

           
                var data = gz$("#termMember").val();
                const Memberid = data.split("-");
                if(data != "")
                  {  
         gz$.ajax({
             type: "POST",
             data: {
                 memberid: data
             },
             url: serverurl  +"load.php?controller=Donations&action=AllMember&cid=" + 2,
            success: function (res) {
                 debugger;
                 var Membertext = gz$("#MemberSelectValue").text();
                 document.getElementById("MemberSelect").value = Membertext;
                 let MemberName = "";
                
                   const memberNameElement = getSafeResponseInput(res, "MemberName", gz$);
                  if(memberNameElement.length){
                   MemberName = memberNameElement[0].value; 
                  }
                  document.getElementById("first_name").value = MemberName;

                 
                  let LastName = "";
                    const LastNameElement = getSafeResponseInput(res, "last_name", gz$);
                    if(LastNameElement.length){
                        LastName = LastNameElement[0].value; 
                       }
                   document.getElementById("second_name").value = LastName;



                  let memberid = "";
                  const memberElement = getSafeResponseInput(res, "memberid", gz$);
                 if(memberElement.length){
                  memberid = memberElement[0].value; 
                 }
                 document.getElementById("idmem").value = memberid;
     
     
                    let phoneNo = "";
                    let MNo="";
                     const phoneNoElement = getSafeResponseInput(res, "Tele1", gz$);
                    if(phoneNoElement.length){
                       phoneNo = phoneNoElement[0].value;
                       phoneNo= phoneNo.replace("-", "");
                       MNo = phoneNo; 
                       MNo=MNo.replace("-", ""); 
                    }
                    document.getElementById("phone").value = MNo;
     
                    let email = "";
                     const emailElement = getSafeResponseInput(res, "email", gz$);
                    if(emailElement.length){
                        email = emailElement[0].value; 
                    }
                    document.getElementById("email").value = email;

                   let street = "";
                   const streetElement = getSafeResponseInput(res, "ressidentalAddress", gz$);
                  if(streetElement.length){
                    street = streetElement[0].value; 
                  }
                  

                  let resaddress = "";
                   const resaddressElement = getSafeResponseInput(res, "Address", gz$);
                  if(resaddressElement.length){
                    resaddress = resaddressElement[0].value; 
                  }
                 

                  let state = "";
                  const stateElement = getSafeResponseInput(res, "state", gz$);
                 if(stateElement.length){
                   state = stateElement[0].value; 
                 }
               

                 let city = "";
                    const cityElement = getSafeResponseInput(res, "city", gz$);
                   if(cityElement.length){
                      city = cityElement[0].value; 
                   }
                   

                   let zipcode = "";
                    const zipcodeElement = getSafeResponseInput(res, "zip_code", gz$);
                   if(zipcodeElement.length){
                    zipcode = zipcodeElement[0].value; 
                   }
                   
                   document.getElementById("address_1").value = street.concat(" ",resaddress," ",state," ",city," ",zipcode);
     
                 }
             });
         }else{ 
             $("#MemberName").val("");
             $("#phone").val("");
             $("#email").val("");
     
         }
        }
        
        
    //Method for calculate total hour       
    function calculateTotalHour() {
        debugger
    let startTime = $("#starttime").val();
    let endTime = $("#endtime").val();
    if (!startTime) {
        alert("Please select both start time.");
        $("#hours").val('');
        return;
    }

    let startHour = parseInt(startTime.split(":")[0]);
    let endHour = parseInt(endTime.split(":")[0]);

    if (endHour > 23) {
        alert("User can only  select minimum start time from 10:00 AM  to end time latest by 11:00 pm.");
        $("#hours").val('');
        return;
    }

    let totalHours = endHour - startHour;

    if (totalHours < 4) {
        alert("Total hours must be at least 4.");
        $("#hours").val('');
        $("#endtime").val('');
    } else {
        $("#hours").val(totalHours);
    }
    // 20 june
    let startingDate = document.getElementById('startdate').value;
    let day = parseDateInput(startingDate);

    if (!day || isNaN(day)) {
        alert("Invalid date. Please select a valid date.");
        document.getElementById('endtime').value = '';
        document.getElementById('starttime').value = '';
        document.getElementById('hours').value = '';
        return;
    }

    if (day.getDay() == 6) {
        if (totalHours > 8) {
            alert("Saturday maximum booking allowed is 8 hours.");
            document.getElementById('endtime').value = '';
            document.getElementById('starttime').value = '';
            document.getElementById('hours').value = '';
            return;
        }
    } else if (totalHours > 4) {
        alert("You can not select more than 4 hours except on Saturday");
        document.getElementById('endtime').value = '';
        document.getElementById('starttime').value = '';
        document.getElementById('hours').value = '';
        return;
    }
        var endtimetxt = $("#endtime option:selected").text().trim();
        // var endtimetxt = $("#endtime option:selected").text();
        // var txtstarttime = $("#starttime option:selected").text();
        var txtstarttime = $("#starttime option:selected").text().trim();

        document.getElementById("hidestarttime").value = txtstarttime;
        document.getElementById("hideendtime").value = endtimetxt;
    
    
    
}


function setDefaultTime() {
    debugger;
    var startdate = document.getElementById('startdate');
    var date = startdate.value.trim();

    if (!date) return; // Prevent crash on empty date
    let d = parseDateInput(date);
    if (!d) {
        console.error("Unknown date format:", date);
        return;
    }
    if (isNaN(d)) {
        console.error("Invalid date object:", date);
        return;
    }

    const day = d.getDay(); // Sunday = 0

    if (day === 0) {
        // Sunday
        $("#starttime").val("15:00 ");
        $("#endtime").val("19:00");
        $("#hours").val("4");
    } else {
        // Monday–Saturday
        $("#starttime").val("10:00 ");
        $("#endtime").val("14:00");
        $("#hours").val("4");
    }

    setHIddenValue();
}


// code change by varun
function setDefaultTime_28_oct_2025(){
    debugger;
    var startdate = document.getElementById('startdate');
    var date = startdate.value;
    const d = parseDateInput(date);
    if (!d || isNaN(d)) {
        console.error("Invalid date object:", date);
        return;
    }
    if(d.getDay() == 0 ){ 
        $("#starttime").val("15:00");
        $("#endtime").val("19:00");
        $("#hours").val("4");
    }
    else{
        $("#starttime").val("10:00");
        $("#endtime").val("14:00");
        $("#hours").val("4");

    }
    setHIddenValue();
}

  function setHIddenValue(){
        var start = document.getElementById("starttime").value;
        var newtime = start.split(":");
        var startnewtime = newtime[0];
        var hour = document.getElementById("hours").value;
        var newendtime  = parseInt(startnewtime) + parseInt(hour);
        debugger
        document.getElementById("Your_endtime").value = newendtime +':00 ';
        var endtimetxt = $("#endtime option:selected").text().trim();
        var txtstarttime = $("#starttime option:selected").text().trim();
        document.getElementById("hidestarttime").value = txtstarttime;
        document.getElementById("hideendtime").value = endtimetxt;
  }
  
  
  function getLocation() {

        debugger;
        var bookdate = document.getElementById("startdate").value
        var serverurl = gz$("#server-id").text();

        gz$.ajax({
            type: "GET",
            dataType: 'json',
            url: serverurl + "load.php?controller=GzRentalFront&action=GetLocationByDate&date=" + bookdate,

            success: function (res) {

                let location = res.location;
                updateLocationDropdown(location);

            }
        });

    }

    getLocation()



    function updateLocationDropdown(location) {
        var locationDropdown = document.getElementById("location");


        locationDropdown.innerHTML = '<option value="">Select Space</option>';


        if (location === "Auditorium") {

            locationDropdown.innerHTML += '<option value="Kalabhavan">Kalabhavan</option>';
            locationDropdown.innerHTML += '<option style="color: red;"  value="Auditorium" disabled>Auditorium (Booked)</option>';


        } else if (location === "Kalabhavan") {

            locationDropdown.innerHTML += '<option value="Auditorium">Auditorium</option>';
            locationDropdown.innerHTML += '<option style="color: red;" value="Kalabhavan" disabled>Kalabhavan (Booked)</option>';


        } else if (location === "Both") {
            locationDropdown.innerHTML += '<option style="color: red;" value="Auditorium" disabled>Auditorium  (Booked)</option>';
            locationDropdown.innerHTML += '<option style="color: red;" value="Kalabhavan" disabled>Kalabhavan (Booked)</option>';
            locationDropdown.innerHTML += '<option style="color: red;" value="Both" disabled >Auditorium & Kalabhavan (Booked)</option>';

        } else {

            locationDropdown.innerHTML += '<option value="Auditorium">Auditorium</option>';
            locationDropdown.innerHTML += '<option value="Kalabhavan">Kalabhavan</option>';
            locationDropdown.innerHTML += '<option value="Both">Auditorium & Kalabhavan</option>';
        }
    }

  
  
  
  

</script>

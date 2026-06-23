<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<style>
 @media only screen and (max-width: 499px){
		 .right-side {
              margin-left:0px!important;
             }
	}
		@media (min-width: 500px) and (max-width: 767px) {
			.right-side {
              margin-left:0px!important;
             }
		}

		@media (min-width: 768px) and (max-width: 830px) {
            .right-side {
              margin-left:0px!important;
             }
		}

		@media(min-width: 831px) and (max-width: 990px) {
			.right-side {
              margin-left:0px!important;
             }
		}

th {
  border: 1px solid black;
  text-align: left;
  background-color: #f6f6f6;
   border-collapse: collapse;
}

</style>
<section class="content-header">
    <h1>
        <?php echo __('Edit Event'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Eventadmin/index"><?php echo __('title_editevent'); ?></a></li>
        <li class="active"><?php echo __('Edit Event'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
   $eve = $tpl['ticketeventarr']['eventtype'] ?? '';
   $dayeventall = $tpl['ticketeventarr']['eventday'] ?? '';
   $weekday= $tpl['ticketeventarr']['ticketevents'] ?? '';
   $newweek=explode("/",$weekday);
   $weeknewday = $newweek[0] ?? '';
 

?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Eventadmin/ticketedit" method="post" name="ticketedit" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
            <table class="table">
                <tr class="tr"> 
                <td class="td">Type</td>  
                <td class="td">
                            <select  required="" name="eventtype" id="eventtype"
                                class="form-control input-sm" aria-required="true">
                                <option value="">Please select Event type</option>
                                <option value="event">Event</option>
                                <option value="ticket">Ticket</option>
                            </select>
                        </td>
                  </tr>
               </table>
               
                <table class="table">
                    <tr>
                    <th >Event Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Start Time</th>
                    <th>End Time </th>
                    </tr>
                    <tr class="tr">
                        <td class="td"><input   id="ticketevent" class="form-control input-sm" type="text" name="ticketevents" size="25" value="<?php echo $weeknewday; ?>" title="Events" placeholder="Event"></td>
                        <td class="td"><input required="true" id="startickettdate" class="form-control input-sm" type="date" name="ticketStartdate" size="25" value="<?php echo $tpl['ticketeventarr']['ticketStartdate'] ?? ''; ?>" title="Date" placeholder="" readonly></td>
                        <td class="td"><input required="true" id="endticketdate" class="form-control input-sm" type="date" name="ticketEnddate" size="25" value="<?php echo $tpl['ticketeventarr']['ticketEnddate'] ?? ''; ?>" title="Date" placeholder="" readonly></td>
                        <td class="td"><input required="true" type="time" id="starttickettime" name="ticketStarttime" class="form-control input-sm" value="<?php echo $tpl['ticketeventarr']['ticketStarttime'] ?? ''; ?>" readonly></td>
                        <td class="td"><input required="true" type="time" id="endtickettime" name="ticketEndtime" class="form-control input-sm" value="<?php echo $tpl['ticketeventarr']['ticketEndtime'] ?? ''; ?>" readonly></td>
                    </tr>
                    <tr class="tr">
                        <td class="td" colspan="2">
                            <label> Image<span style="color:#ff0000">*</span> </label>
                        </td>
                        </tr>
                </table>
                        <!-- <td class="td" colspan="2" id="img-file-id"> -->
                        <div class="form-group" id="allticketevent" >
                    <?php if (is_file(INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/' . $tpl['ticketeventarr']['ticketavatar'])) { ?>
                        <fieldset>    
                            <div class="view view-tenth">   
                                <img src="<?php echo INSTALL_URL . UPLOAD_PATH . 'avatar/thumb/' . $tpl['ticketeventarr']['ticketavatar']; ?>" />
                                <div class="mask">
                                    <a rev="<?php echo $tpl['ticketeventarr']['id'] ?? ''; ?>" class="info btn btn-app btn-danger gallery-delete" href="<?php echo INSTALL_URL; ?>Eventadmin/deleteEditedticketImage/<?php echo $tpl['ticketeventarr']['id'] ?? ''; ?>"><i class="fa fa-times"></i><?php echo __('remove'); ?></a>
                                </div>
                            </div>
                        </fieldset>
                    <?php } else { ?>
                        <label class="control-label" for="img">
                            <?php echo __('image'); ?>:
                        </label>
                        <input class="form-control" type="file" name="image">
                    <?php } ?>
                </div>
                <div style="border: 1px solid mediumvioletred;" id="desdiv" >
                <p><label for="description">Description:</label></p>
                <textarea id="description" class="form-control input-sm" name="descriptionTable" value="<?php echo $tpl['ticketeventarr']['descriptionTable'] ?? ''; ?>" placeholder="To add message details, put a full stop  after each line."rows="4" cols="50" style="border:1px solid lemonchiffon;"><?php echo $tpl['ticketeventarr']['descriptionTable'] ?? ''; ?></textarea>
                </div>
                <br>
                   
                 <!-- dynamic input field add button -->
                 <div id="ticketaddfield" style = "display:block;">
                 <?php  $arr2=array();?>
                 <?php foreach (($tpl['ticketdayarr'] ?? []) as $key => $value) {
                
                 $itemdaynew = $value['itemeventday'];
                array_push($arr2, $itemdaynew);
                 } ?>   
                 <?php foreach (($tpl['ticketdayarr'] ?? []) as $key => $value) {
                     
                     $itemday = $value['itemeventday'];
                     $price = $value['ticketprice'];
                     $id = $value['id'];
                     
                    ?>    
                <!-- <input type="button" onclick='addMoreField()' class="no add1" value="Add More Field" style="cursor: pointer;"> -->
                <i class="fa fa-plus" id = "addmore" onclick='addMoreField()' style="font-size:25px;color:green;cursor:pointer;">Add Field</i>
                <div class="row"> 
             
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="contactContainername">
                     <label for="contact">Event Day:</label>

                    

                            <div id="contactName_0" class="flex contactname" >
                          <select class="form-control input-sm" id="ticketday" name="itemeventday[]" value="<?php echo $itemday; ?>">
                            <!--   <option id="<?php echo $id; ?>" value="<?php echo $itemday; ?>"><?php echo $itemday; ?></option>  -->
                            <?php foreach ($arr2 as $key => $day) { ?> 
                            <option <?php echo ($itemday  == $day) ? "selected='selected'" : ""; ?> value="<?php echo $day; ?>"><?php echo $day; ?></option> 
                            <?php } ?>
 
                           <!-- <option>Select Event Day</option>
                            <option value="saturday">Saturday(One Day)</option>
                            <option value="sunday">Sunday(One Day)</option>
                            <option value="multiday">Multi Day(Two Days)</option>  -->
                            </select>
                            <br>
                         <!-- <input class="removeButton" type="button" onclick='removeField(0)' value="Remove" style="cursor: pointer;display:none"> -->
                         <i class='fa fa-trash' id='removeButton' onclick='removeField(0)' style="font-size: 20px;color: red;cursor: pointer;position: relative;bottom: 9px;display:none"></i>
                         <br>
                         
                        </div>
                       
                     </div>
                  
                  
                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="contactContainer">
                 
                    <label for="contact">Price:</label>
                    
                        <div id="contactNo_0" class="flex contact">
                        <input  id="<?php echo $id; ?>" name="ticketprice[]" type="text" value="<?php echo $price; ?>"class="form-control" placeholder="$100">
                        <input type="button" class="ar add" value="Add More Field" style="cursor: pointer;" hidden>&nbsp;&nbsp;
                        <div class="ar remove"><label style="cursor: pointer; padding-top: 5px;"><i style="width: 20px; height: 20px; color: lightseagreen;"data-feather="x"></i></label></div>
                       
                      
                     </div>

                      
                </div>
                </div>
                <?php } ?>
				</div>
                  <!-- dynamic input field add button -->
                <fieldset>
                    <input type="hidden" name="edit_ticket" value="1" /> 
                    <input type="hidden" name="id" value="<?php echo $tpl['ticketeventarr']['id'] ?? ''; ?>" />
                    <input type="hidden" name="ticketavatar" value="<?php echo $tpl['ticketeventarr']['ticketavatar'] ?? ''; ?>" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
                </fieldset>
            </fieldset>
        </div>
    </form>
    <div id="dialogDeleteImage" title="<?php echo htmlspecialchars(__('gallery_del_title')); ?>" style="display:none">
        <p><?php echo __('gallery_del_body'); ?></p>
    </div>
</section>
 <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  -->
<script>
 $(document).ready(function() {
    debugger;
    checkevent();
    dayeve();
   
});



var eve = <?php echo(json_encode($eve)); ?>;
function checkevent() {
    debugger;
if(eve !=null || eve == "" || eve == " "){
 $("#eventtype").val(eve);
}
}

var alldayevent = <?php echo(json_encode($dayeventall)); ?>;
function dayeve() {
if(alldayevent !=null || alldayevent == "" || alldayevent == " "){
 $("#dayticket").val(alldayevent);
}
}
var evname = document.getElementById("eventtype");
function subjectevent() {
    debugger;
       
       var selectedevent = evname.options[evname.selectedIndex].value;
        if (selectedevent == "event") {
		    document.getElementById('fisrtevent').style.removeProperty('display');
            document.getElementById('eventsecond').style.display = "none";
            document.getElementById('ticketaddfield').style.display = "none";
            // document.getElementById('desdiv').style.display = "none";
            $("#event").prop('required',true);
            $("#price").prop('required',true);
            $("#startdate").prop('required',true);
            $("#enddate").prop('required',true);
            $("#starttime").prop('required',true);
            $("#endtime").prop('required',true);
           
            $("#ticketevent").prop('required',false);
            $("#ticketprice").prop('required',false);
            $("#dayticket").prop('required',false);
            $("#startickettdate").prop('required',false);
            $("#endticketdate").prop('required',false);
            $("#starttickettime").prop('required',false);
            $("#endtickettime").prop('required',false);
            $("#validationcontact").prop('required',false);
            $("#ticketday").prop('required',false);

        } 
        else if(selectedevent == "ticket")
        {
		 document.getElementById('eventsecond').style.removeProperty('display');
         document.getElementById('ticketaddfield').style.removeProperty('display');
         document.getElementById('fisrtevent').style.display = 'none';
        //  document.getElementById('desdiv').style.removeProperty('display');
         $("#event").prop('required',false);
         $("#price").prop('required',false);
         $("#startdate").prop('required',false);
         $("#enddate").prop('required',false);
         $("#starttime").prop('required',false);
         $("#endtime").prop('required',false);
       
         $("#ticketevent").prop('required',true);
         $("#ticketprice").prop('required',true);
         $("#dayticket").prop('required',true);
         $("#startickettdate").prop('required',true);
         $("#endticketdate").prop('required',true);
         $("#starttickettime").prop('required',true);
         $("#endtickettime").prop('required',true);
         $("#validationcontact").prop('required',true);
         $("#ticketday").prop('required',true);
        }
        else
        {
            document.getElementById('eventsecond').style.display = "none";
            document.getElementById('fisrtevent').style.display = 'none';
        }
    }
function addMoreField() {
    var maxField = 4; 
    var addButton = $('#addmore');
  const $contactContainername = $('#contactContainername');
  const $contactContainerNo = $('#contactContainer');
  const $contactNameinput = $contactContainername.find(".contactname");
  const $contactNoInput = $contactContainerNo.find(".contact");

  const $newContactNameinput = $contactNameinput.eq(0).clone(true);
  $newContactNameinput.find("[name=contactname]").attr("id", `contactNameInput_${$contactNameinput.length}`).val("");
  $newContactNameinput.attr("id", `contactName_${$contactNameinput.length}`);
  const removeButton = $newContactNameinput.find("#removeButton");
  removeButton.attr("onclick", `removeField(${$contactNameinput.length})`);
  removeButton.show();

  const $newContactNoinput = $contactNoInput.eq(0).clone(true);
  $newContactNoinput.attr("id", `contactNo_${$contactNameinput.length}`);
  $newContactNoinput.find("[name=contact]").attr("id", `contactNoInput_${$contactNoInput.length}`).val("");


  $contactContainername.append($newContactNameinput);
  $contactContainerNo.append($newContactNoinput);
}

function removeField(id) {
  if (id === 0) return;
  const $contactContainername = $('#contactContainername');
  const $contactContainerNo = $('#contactContainer');

  const $contactNameinput = $contactContainername.find(`#contactName_${id}`);

  const $contactNoinput = $contactContainerNo.find(`#contactNo_${id}`);

  $contactNameinput.remove();
  $contactNoinput.remove();
}


////Ticket Date time Section start.....///////
var today = new Date();
  // Startdate Previous Date disabled from current date.....
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        $('#startickettdate').attr('min',today);
  // Startdate Previous Date disabled from current date.....

  //End date should be greater than start date........
$("#endticketdate").change(function () {
    var startickettdate = document.getElementById("startickettdate").value;
    var endticketdate = document.getElementById("endticketdate").value;

    if ((Date.parse(startickettdate) > Date.parse(endticketdate))) {
        alert("End date should be greater than Start date");
        document.getElementById("endticketdate").value = "";
    }
});

$("#startickettdate").change(function () {
     debugger;
	 var ticketd1 = document.getElementById("startickettdate").value;
    var ticketd2 = document.getElementById("endticketdate").value;
  let date1 = new Date(ticketd1).getTime();
  let date2 = new Date(ticketd2).getTime();

  if (date1 < date2) {
    //alert("hi");
   
  } else if (date1 > date2) {
    alert("Start date should be less than End date");
    document.getElementById("startickettdate").value = "";;
  } else {
    //alert("by");
  }

});
 ///END time should be greater/................/////
$("#endtickettime").change(function () {
    debugger
    var starttickettime = document.getElementById("starttickettime").value;
    var endtickettime = document.getElementById("endtickettime").value;

   //if ((Date.parse(starttime) > Date.parse(endtime))) {
    if (Date.parse('01/01/2011 '+starttickettime) >= Date.parse('01/01/2011 '+endtickettime)){
        alert("End time should be greater than Start time");
        document.getElementById("endtickettime").value = "";
    }
}); 
 //END time should be greater....////////

////Ticket Date time Section end.....///////



// Find day
function finddate() {
        debugger;
        var date1 = document.getElementById("startickettdate").value;
        var date2 = document.getElementById("endticketdate").value;
        date1 = new Date(date1);
        date2 = new Date(date2);
        var milli_secs = date2.getTime() - date1.getTime();

        // Convert the milli seconds to Days 
        var days = milli_secs / (1000 * 3600 * 24);
        var totalday = Math.round(Math.abs(days));
        $('#ticketday').empty(); //remove all child nodes
        var newOption1 = $('<option value="1">Please select event ticket day</option>');
        $('#ticketday').append(newOption1);

        const date = new Date(date1.getTime());

        const dates = [];
        while (date <= date2) {
            dates.push(new Date(date));
            date.setDate(date.getDate() + 1);

        }
        dates.forEach(function (datenew) {
            var dayweek = "weekday";
            const d =  datenew;
            let day = d.getDay()
            if (day == 0) {
                dayweek = "Sunday" +'-' + convert(datenew); 
               var newOption = $('<option value="' + dayweek + '">' + dayweek + '</option>');
                $('#ticketday').append(newOption);
                $('#ticketday').trigger("chosen:updated");
            } else if (day == 1) {
                dayweek = "Monday" +'-' + convert(datenew); 
               var newOption = $('<option value="' + dayweek + '">' + dayweek + '</option>');
                $('#ticketday').append(newOption);
                $('#ticketday').trigger("chosen:updated");
            }
            else if (day == 2) {
                dayweek = "Tuesday" +'-' + convert(datenew); 
               var newOption = $('<option value="' + dayweek + '">' + dayweek + '</option>');
                $('#ticketday').append(newOption);
                $('#ticketday').trigger("chosen:updated");
            }
            else if (day == 3) {
                dayweek = "Wednesday" +' ' + convert(datenew); 
               var newOption = $('<option value="' + dayweek + '">' + dayweek + '</option>');
                $('#ticketday').append(newOption);
                $('#ticketday').trigger("chosen:updated");
            }
            else if (day == 4) {
                dayweek = "Thursday" +'-' + convert(datenew); 
               var newOption = $('<option value="' + dayweek + '">' + dayweek + '</option>');
                $('#ticketday').append(newOption);
                $('#ticketday').trigger("chosen:updated");
            }
            else if (day == 5) {
                dayweek = "Friday" +'-' + convert(datenew); 
               var newOption = $('<option value="' + dayweek + '">' + dayweek + '</option>');
                $('#ticketday').append(newOption);
                $('#ticketday').trigger("chosen:updated");
            }
            else if (day == 6) {
               dayweek = "Saturday" +'-' + convert(datenew); 
               var newOption = $('<option value="' + dayweek + '">' + dayweek + '</option>');
                $('#ticketday').append(newOption);
                $('#ticketday').trigger("chosen:updated");

            }
        }) 
    }

function convert(str) {
  var date = new Date(str),
    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
    day = ("0" + date.getDate()).slice(-2);
    return [mnth, day, date.getFullYear()].join("/");
  //return [date.getFullYear(), mnth, day].join("/");
}
</script>
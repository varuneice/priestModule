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
$pricename= $tpl['Eventarr']['price'] ?? '';
$name=explode("/",$pricename);
   $first = $name[0] ?? '';
   $last= $name[1] ?? '';
   $eve = $tpl['Eventarr']['eventtype'] ?? '';
   $dayeventall = $tpl['Eventarr']['eventday'] ?? '';
?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Eventadmin/edit" method="post" name="edit" enctype="multipart/form-data">
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
                                 <option value="event2">Event2</option>
                                 <option value="event3">Event3</option>
                                <option value="ticket">Ticket</option>
                            </select>
                        </td>
                  </tr>
               </table>
               <table class="table">
                    <tr>
                    <th >Event Name</th>
                    <th>Donation Price</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Start Time</th>
                    <th>End Time </th>
                    </tr>
                    <tr class="tr">
                        <td class="td"><input required="true" id="event" class="form-control input-sm" type="text" name="events" size="25" value="<?php echo $tpl['Eventarr']['events'] ?? ''; ?>" title="Events" placeholder="Event"></td>
                        <td class="td"><input required="true" id="price" class="form-control input-sm" type="number" name="price" size="25" value="<?php echo $first ?>" title="<?php echo __('price'); ?>" placeholder="price" onchange="amountvalid(this.id)"></td>
                        <td class="td"><input  required="true" id="startdate" class="form-control input-sm" type="date" name="Startdate" size="25" value="<?php echo $tpl['Eventarr']['Startdate'] ?? ''; ?>" title="Date" placeholder=""></td>
                        <td class="td"><input required="true" id="enddate" class="form-control input-sm" type="date" name="Enddate" size="25" value="<?php echo $tpl['Eventarr']['Enddate'] ?? ''; ?>" title="Date" placeholder=""></td>
                        <td class="td"><input required="true" type="time" id="starttime" name="Starttime" class="form-control input-sm" value="<?php echo $tpl['Eventarr']['Starttime'] ?? ''; ?>"></td>
                        <td class="td"><input  required="true" type="time" id="endtime" name="Endtime" class="form-control input-sm" value="<?php echo $tpl['Eventarr']['Endtime'] ?? ''; ?>"></td>
                    </tr>
                    <tr class="tr">
                        <td class="td" colspan="2">
                            <label> Image<span style="color:#ff0000">*</span> </label>
                        </td>
                        </tr>
                </table>
                  <div style="border: 1px solid mediumvioletred;" id="eventdesdiv" >
                <p><label for="description">Description:</label></p>
                <textarea id="description" class="form-control input-sm" name="eventdescription" value="<?php echo $tpl['Eventarr']['eventdescription'] ?? ''; ?>" placeholder="To add message details, put a full stop  after each line. "rows="4" cols="50" style="border:1px solid lemonchiffon;"><?php echo $tpl['Eventarr']['eventdescription'] ?? ''; ?></textarea>
                </div>
                <br>
                
                        <!-- <td class="td" colspan="2" id="img-file-id"> -->
                        <div class="form-group" id="allticketevent" >
                    <?php if (is_file(INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/' . $tpl['Eventarr']['avatar'])) { ?>
                        <fieldset>    
                            <div class="view view-tenth">   
                                <img src="<?php echo INSTALL_URL . UPLOAD_PATH . 'avatar/thumb/' . $tpl['Eventarr']['avatar']; ?>" />
                                <div class="mask">
                                    <a rev="<?php echo $tpl['Eventarr']['id'] ?? ''; ?>" class="info btn btn-app btn-danger gallery-delete" href="<?php echo INSTALL_URL; ?>Eventadmin/deleteEditedticketImage/<?php echo $tpl['Eventarr']['id'] ?? ''; ?>"><i class="fa fa-times"></i><?php echo __('remove'); ?></a>
                                </div>
                            </div>
                        </fieldset>
                    <?php } else { ?>
                        <label class="control-label" for="img">
                            <?php echo __('image'); ?>:
                        </label>
                        <input class="form-control" type="file" name="img">
                    <?php } ?>
                </div>

                <fieldset>
                    <input type="hidden" name="edit_event" value="1" /> 
                    <input type="hidden" name="id" value="<?php echo $tpl['Eventarr']['id'] ?? ''; ?>" />
                    <input type="hidden" name="avatar" value="<?php echo $tpl['Eventarr']['avatar'] ?? ''; ?>" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
                </fieldset>
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
    checkevent();
    //subjectevent();
    dayeve();
});

var eve = <?php echo(json_encode($eve)); ?>;
function checkevent() {
    debugger;
if(eve !=null || eve == "" || eve == " "){
 $("#eventtype").val(eve);
}
}

var evname = document.getElementById("eventtype");
// function subjectevent() {
//     debugger;
       
//        var selectedevent = evname.options[evname.selectedIndex].value;
//         if (selectedevent == "event") {
// 		    document.getElementById('fisrtevent').style.removeProperty('display');
//             document.getElementById('eventsecond').style.display = "none";

//         } 
//         else if(selectedevent == "ticket")
//         {
// 		 document.getElementById('eventsecond').style.removeProperty('display');
//          document.getElementById('fisrtevent').style.display = 'none';
//         }
//         else
//         {
//             document.getElementById('eventsecond').style.display = "none";
//             document.getElementById('fisrtevent').style.display = 'none';
           
//         }
//     }

var alldayevent = <?php echo(json_encode($dayeventall)); ?>;
function dayeve() {
if(alldayevent !=null || alldayevent == "" || alldayevent == " "){
 $("#dayticket").val(alldayevent);
}
}

////Event Date time Section start................................................................................///////
// Startdate Previous Date disabled from current date.....
var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        $('#startdate').attr('min',today);
// Startdate Previous Date disabled from current date.....

//End date should be greater than start date........
$("#enddate").change(function () {
    var startdate = document.getElementById("startdate").value;
    var enddate = document.getElementById("enddate").value;

    if ((Date.parse(startdate) > Date.parse(enddate))) {
        alert("End date should be greater than Start date");
        document.getElementById("enddate").value = "";
    }
});

$("#startdate").change(function () {
     debugger;
     var d1 = document.getElementById("startdate").value;
    var d2 = document.getElementById("enddate").value;
  let date1 = new Date(d1).getTime();
  let date2 = new Date(d2).getTime();

  if (date1 < date2) {
    //alert("hi");
   
  } else if (date1 > date2) {
    alert("Start date should be less than End date");
    document.getElementById("startdate").value = "";;
  } else {
    //alert("by");
  }

});


///END time should be greater/................/////
$("#endtime").change(function () {
    debugger
    var starttime = document.getElementById("starttime").value;
    var endtime = document.getElementById("endtime").value;

   //if ((Date.parse(starttime) >= Date.parse(endtime))) {
    if (Date.parse('01/01/2011 '+starttime) >= Date.parse('01/01/2011 '+endtime)){
        alert("End time should be greater than Start time");
        document.getElementById("endtime").value = "";
    }
});
///END time should be greater....////////
////Event Date time Section end................................................................................///////

  // Validate amount start.....
function amountvalid(){
    debugger;
        const price =  $("#price").val();
        if(price > 0){
            $("#price").prop('required',true);
            $("#submit").removeClass('disabled');
        }
        else{
            alert("Amount will be greater than 0");
            $("#submit").addClass('disabled');
        }
     }
// Validate amount end..... 
    </script>
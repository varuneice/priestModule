<head>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
</head>
<style>
.lblbtn{
    background-color: #03aaf4;
    width:131px;
    font-size: 24px;
    font-weight: bold;
    position: relative;
    bottom: 23px;
    left: 408px;
    border: none;
    border-radius: 9px;
    color: white;
}
   
</style>
<section class="content-header">
    <h1>
        <?php echo __('add_user'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>User/index"><?php echo __('title_users'); ?></a></li>
        <li class="active"><?php echo __('add_user'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<section class="content left width_100">
    <form id="new_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Items/create" method="post" name="create" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <div class="form-group">
                    <!-- <label class="control-label" for="type"><?php echo __('type'); ?>:</label> -->
                <div class="form-group" style="border: 1px solid lightgray; padding: 9px;" >
                    <div>
                      <button type="button" class="lblbtn" style="background-color: #03aaf4;font-size: 22px;font-weight: bold;">Item</button>
                    </div>
                    <label class="control-label">Categories:</label>
                    <select id="category" name="categories" required="" class="form-control input-sm " >
                                <option value="">Please select Category</option> 
                                <?php
                                foreach (($tpl['Categoryname'] ?? []) as $key => $value) {
                                ?>
            
                                <option value="<?php echo $value['id']; ?>"><?php echo $value['category']; ?></option> 
                                <?php
                                 }
                                 ?>
                                </select>
                 
                 <div class="form-group">
                    <!-- <label class="control-label" for="email"><?php echo __('email'); ?>:</label> -->
                    <label class="control-label">Count:</label>
                    <!-- <input id="email" class="form-control input-sm" type="text" name="email" size="25" value="" title="email" placeholder="email"> -->
                    <!-- <div class="quantity"> -->
                       <input id="count" type="number" class="form-control input-sm" name="count" value="" title="count" placeholder="count" min="1" step="1" value="1">
                    <!-- </div> -->
                 </div>
                 <div class="form-group">
                 <label class="control-label">Title:</label>
                    <input id="title" class="form-control input-sm" type="text" name="title" size="25" value="" title="" placeholder="">
                 </div>
                 <div class="form-group">
                 <label class="control-label">Description:</label>
                    <!-- <input id="first" class="form-control input-sm" type="text" name="first" size="25" value="" title="<?php echo __('first'); ?>" placeholder="<?php echo __('first'); ?>"> -->
                    <textarea id="first" class="form-control input-sm" name="description" size="25" value="" rows="4" title="" cols="50"></textarea>
             </div>
                    
                    
                </div>
                <div class="form-group" style="border: 1px solid lightgray; padding: 9px;" >
                <div>
                 
                  <button type="button" class="lblbtn" style="background-color: #03aaf4;font-size: 22px;font-weight: bold;">Price details</button>
                    </div>
               <label class="control-label">Rent by hour:</label>
               <input class="simple" type="checkbox"  id="mybox" value="all" style="position: relative;left: 51px;"/>
               <span style="position: relative;padding: 3px;left: 55px; border: 1px solid black;background-color: lightgray">&#36</span>
                 <input type="text" id="mytext" name="rent_by_hour" style="margin: 20px; position: relative; left: 30px;">
                 <br>
                 <label class="control-label">Rent by day:</label>
                 <input class="simple" type="checkbox"  id="mybox2" value="all" style="position: relative;left: 58px;"/>
                 <span style="position: relative;padding: 3px;left: 61px; border: 1px solid black;background-color: lightgray">&#36</span>
                 <input type="text" id="mytext2" name="rent_by_day" style="margin: 20px; position: relative;left: 37px;">
                 <br> 
                 
                 <label class="control-label">Rent by week:</label>
                 <input class="simple" type="checkbox"  id="mybox3" value="all" style="position: relative;left: 48px;"/>
                 <span style="position: relative;padding: 3px;left: 51px; border: 1px solid black;background-color: lightgray">&#36</span>
                 <input type="text" name="rent_by_week" id="mytext3" style="margin: 20px; position: relative;left: 26px;">
                    
                    
                </div>
                
                <div class="form-group">
                <div class="form-group" style="border: 1px solid lightgray; padding: 9px;" >
                    <div>
                      <button type="button" class="lblbtn" style="background-color: #03aaf4;font-size: 22px;font-weight: bold;">Image</button>
                    </div>
                    <label class="control-label" for="img">
                        <?php echo __('image'); ?>:
                    </label>
                    <input class="form-control" type="file" name="img">
                </div>
                </div>
               
                <fieldset>
                    
                    <input type="hidden" name="create" value="1" /> 
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
                </fieldset>
            </fieldset>
        </div>
    </form>
</section>
<script type="text/javascript">
    ////..............Check one  start.........../////
    $(function () {
    $("#mytext").attr("disabled", "disabled");
        $("#mybox").click(function () {
            if ($(this).is(":checked")) {
                $("#mytext").removeAttr("disabled");
                $("#mytext").focus();
            } else {
                $("#mytext").attr("disabled", "disabled");
            }
        });
    });
//  ////..............Check One  end.........../////
$(function () {
    $("#mytext2").attr("disabled", "disabled");
        $("#mybox2").click(function () {
            if ($(this).is(":checked")) {
                $("#mytext2").removeAttr("disabled");
                $("#mytext2").focus();
            } else {
                $("#mytext2").attr("disabled", "disabled");
            }
        });
    });

    $(function () {
    $("#mytext3").attr("disabled", "disabled");
        $("#mybox3").click(function () {
            if ($(this).is(":checked")) {
                $("#mytext3").removeAttr("disabled");
                $("#mytext3").focus();
            } else {
                $("#mytext3").attr("disabled", "disabled");
            }
        });
    });







 ////.......................... Check Tree  End......................../////
///////.......to show Plus & minus sign or number type......./////
// jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.quantity input');
//     jQuery('.quantity').each(function() {
//       var spinner = jQuery(this),
//         input = spinner.find('input[type="number"]'),
//         btnUp = spinner.find('.quantity-up'),
//         btnDown = spinner.find('.quantity-down'),
//         min = input.attr('min'),
//         max = input.attr('max');

//       btnUp.click(function() {
//         var oldValue = parseFloat(input.val());
//         if (oldValue >= max) {
//           var newVal = oldValue;
//         } else {
//           var newVal = oldValue + 1;
//         }
//         spinner.find("input").val(newVal);
//         spinner.find("input").trigger("change");
//       });

//       btnDown.click(function() {
//         var oldValue = parseFloat(input.val());
//         if (oldValue <= min) {
//           var newVal = oldValue;
//         } else {
//           var newVal = oldValue - 1;
//         }
//         spinner.find("input").val(newVal);
//         spinner.find("input").trigger("change");
//       });

//     });

</script>
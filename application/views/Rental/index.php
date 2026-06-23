<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>HDBS</title>
        <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
        
        
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" /> 
 
 
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
 <!-- Bootstrap Css -->
 <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"> -->
        
        <style>
            .row{
                float: left;
                width: 100%;
                position: relative;
            }
            .navigation{
                padding: 0px;
                margin:0px; 
                box-shadow:0px 0px 0px 5px rgb(255 255 255 / 40%), 0px 4px 10px rgb(0 0 255);
                float: left;
                width: 100%;
            }
            #amc ul, #abc ul{
                padding: 0 20px;
                margin: 10px;
            }

            #amc ul li, #abc ul li{
                margin: 1em;
                margin: 1em 0;
                width: 100%;
            }

            .nav_left{
                width:50% ;
                float: left;
            }
            .nav_right{
                height:50% ;
                float:right;
                padding: 20px;
            }
            .nav_right z{
                font-size: 20px;
                overflow: hidden;
                padding: 10px;
                margin: 5px;

            }
            .btn {
                display: inline-block;
                width: 131px;
                border: 1px solid #2819cd;
                color: #2819cd;
                text-align: center;
                padding: 7px 0px;
                border-radius: 6px;
                margin: 0px 15px;
                font-weight: 700;
                cursor: pointer;
            }
            .container{
                box-shadow: 0px 8px 16px 0px;
                background-color:white;
                width: 750px;
                height:300px;
                border-radius:15px;
                margin-left: 350px;
                font-size:19px;

            }

            #amc{
                width: 20%;
                float: left;
                padding-top: 10px;
            }
            #ndr{
                width: 55%;
                float: left;
                padding-top: 40px;
            }
            #abc{
                width: 25%;
                position: absolute;
                right: 0px;
                padding-top: 30px;
            }
            #gz-abc-main-container .col-sm-4 {
                width: 100% !important;
            }

            /* Tablet: collapse to stacked layout */
            @media only screen and (max-width: 1160px){
                .row{ position: static; }
                #amc{
                    width: 100%;
                    float: none;
                    padding: 15px 30px;
                }
                #ndr{
                    width: 100%;
                    float: none;
                    padding: 10px 30px;
                }
                #abc{
                    width: 100%;
                    position: static;
                    float: none;
                    padding: 10px 30px;
                }
                ul li z{ min-height: auto; }
            }

            /* Mobile */
            @media only screen and (max-width: 768px){
                #amc, #ndr, #abc{
                    padding: 10px 15px;
                }
                h2{ font-size: 1.4rem; }
                p{ font-size: 15px; }
                ul li z{ padding: 0.7em; }
            }

            h2 {
                font-weight: bold;
                font-size: 2rem;
            }
            p {
                font-size: 19px;
                margin-top:-23px;
                font-family: 'Reenie Beanie';

            }
            ul,li{
                list-style:none;
            }
            ul{
                display: flex;
                flex-wrap: wrap;
                /* / justify-content: center; / */
            }
            ul li z{
                text-decoration:none;
                color:#000;
                background:#ffc;
                display:block;
                min-height:29em;
                width:100%;
                padding:1em;
                word-break: keep-all;
                box-shadow: 5px 5px 7px rgba(33,33,33,.7);
                transform: rotate(0deg);
                transition: transform .15s linear;
            }

            .amd z{
                transform:rotate(0deg);
                position:relative;
                top:5px;
                background:#ffc;
            }
            .ab z{
                transform:rotate(0deg);
                position:relative;
                top:-5px;
                background:#cfc!important;
            }
            ul li:nth-child(5n) z{
                transform:rotate(0deg);
                position:relative;
                top:-10px;
            }

            ul li z:hover,ul li z:focus{
                box-shadow:10px 10px 7px rgba(0,0,0,.7);
                transform: scale(1.25);
                position:relative;
                z-index:5;
            }  

            .gzABCalButton {
                display:none!important;
            }
            .gzABCalCellSlots{
                display:none!important;
            }

            ul li{
                margin:1em;
            }
            .w3-display-topright {
                position: absolute;
                right: -132px;
                top: 0;
                color: white;
                background-color: royalblue;
            }
            .hdb{
                font-size:25px;
            }
            
            
            /*13june */
           #gz-abc-main-container-2 .gzABCalendarTable .gzABCalColorKB .gzABCalDate {
            border-radius: 50%;
            height: 40px;
            margin: 0 auto;
            width: 60%;

            background-color: #FFAC1C;
            color: rgba(255, 255, 255, 1);
            font-size: 14px;
            font-family: Arial;
            font-weight: normal;
        }


        #gz-abc-main-container-2 .gzABCalendarTable .gzABCalColorAD .gzABCalDate {
            border-radius: 50%;
            height: 40px;
            margin: 0 auto;
            width: 60%;

            background-color: rgb(255, 28, 206);
            color: rgba(255, 255, 255, 1);
            font-size: 14px;
            font-family: Arial;
            font-weight: normal;
        }


        #gz-abc-main-container-2 .gzABCalendarTable .gzABCalColorKBBlocked .gzABCalDate {
            border-radius: 50%;
            height: 40px;
            margin: 0 auto;
            width: 60%;

            background-color: #FFAC1C;
            color: rgba(255, 255, 255, 1);
            font-size: 14px;
            font-family: Arial;
            font-weight: normal;
        }


        #gz-abc-main-container-2 .gzABCalendarTable .gzABCalColorADBlocked .gzABCalDate {
            border-radius: 50%;
            height: 40px;
            margin: 0 auto;
            width: 60%;

            background-color: rgb(255, 28, 206);
            color: rgba(255, 255, 255, 1);
            font-size: 14px;
            font-family: Arial;
            font-weight: normal;
        }

        .gzABCalColorADLegend {
            /*background-color: #6666ff;*/
            background-color: rgb(255, 28, 206);
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            float: right;
        }

        .gzABCalColorKBLegend {
            /*background-color: #6666ff;*/
            background-color: #FFAC1C;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            float: right;
        }

       

        /*td.gzABCalCellDayOff, */
        /*        td.gzABCalCellReserved, */
        /*        td.gzABCalColorADBlocked, */
        /*        td.gzABCalColorKBBlocked {*/
        /*            background-color: #d6d3d1 !important;*/
        /*        }*/

        #gz-abc-main-container-2 .gzABCalendarTable .gzABCalCellReservedBlocked .gzABCalDate {
            border-radius: 50%;
            height: 40px;
            margin: 0 auto;
            width: 60%;

            background-color: #e56462;
            color: rgba(255, 255, 255, 1);
            font-size: 14px;
            font-family: Arial;
            font-weight: normal;
        }

        /*td.gzABCalCellDayOff,*/
        /*td.gzABCalCellEvent ,*/
        td.gzABCalColorADBlocked,
        td.gzABCalCellReservedBlocked,
        td.gzABCalColorKBBlocked {
            background-color: #d6d3d1 !important;
        }
            
        </style>
    </head>
    <body>
    <div class="row">
    <div class="col-lg-6 col-xs-2">
        <div class="navigation">
            <div class="nav_left">
                <img src="../full_logo.png">
            </div>
            <div class="nav_right">
                <a class="btn"href='<?= INSTALL_URL ?>Rental/index'>Home</a>
                <!--<a class="btn"href='<?= INSTALL_URL ?>Admin/login'>Login</a>&nbsp;  
                <a  class="btn" href='<?= INSTALL_URL ?>Member/create'>Register</a>-->
            </div>
        </div>
        </div>
        </div>
        <!-- Sticker section start -->
        <div class="row">
            
<marquee behavior="scroll" style="margin-top: 30px;" direction="left">At least two (2) weeks before the event the customer must pay the  
total rent to use the facility. HDBS the right to cancel the reservation if not 
paid in full and the renters will lose all the deposits as well as security deposit.</marquee>
            <div class="col-sm-12 col-lg-4 col-md-4 amd" id="amc">
                <ul>
                    <li>
                        <z href="#">
                            <h2 class="hdb">HDBS Rental Request Reservation</h2>&nbsp;&nbsp;<br><br>
                            <span>
                                <p>
                                    Please select a date on the Calendar to start making your reservation. If you do not hear back from us within 48hrs, please contact HDBS Rental Committee.
                                    The Rental office is open every Sunday from 11am-1pm in the Auditorium Lobby .<br><br>
                                    <b> Contact <span style="color:#005a9c;"><a href='mailto:rental@durgabari.org'> rental@durgabari.org</a></span> if you have questions before making the reservation.</b>
                                </p>
                            </span>
        </z>
                    </li>
                </ul>
            </div>

            <div class="col-sm-12 col-lg-4 col-md-4" id="ndr" >

             <script type="text/javascript" src="<?php echo INSTALL_URL; ?>index.php?controller=GzRentalFront&action=load&cid[]=<?php echo (empty($_REQUEST['calendars_id'])) ? $tpl['arr'][1]['id'] : implode('&cid[]=', ($_POST['calendars_id'] ?? '') ); ?>&view_month=<?php echo (empty($_POST['months'])) ? '1' : $_POST['months']; ?>"></script>
            </div>

            <div class="col-sm-12 col-lg-4 col-md-4 ab" id="abc" >
                <ul>
                    <li style="margin-top:6px; width: 100%;">
                        <z href="#">
                            <h2>Reservation Steps</h2>&nbsp;
                            <span> 
                                <p><b>You can reserve any Rental Space in 3 simple steps:</b><br>
                                    1. Select date by clicking on the calendar.<br>
                                    2. Fill Start Time & End Time.<br>
                                    3. Fill in the details and make payment.<br>
                                    You will receive a confirmation receipt once the reservation is done.For more details, please see the video.</p>
                            </span>
                            <!-- <a class="fa fa-video-camera" id="vid"  onclick="document.getElementById('id01').style.display = 'block'" style="color:#1e90ff;font-size: x-large;float:left;"></a> </br> -->
        </z>
                    </li>
                </ul>
                <!-- <i class="fa fa-video-camera" id="vid"  onclick="document.getElementById('id01').style.display = 'block'" style="color:#1e90ff;font-size:-webkit-xxx-large; margin-top: -49px; margin-left:64px;"></i>  -->
            </div>
        </div>

        <div class="w3-container">
            <div id="id01" class="w3-modal">
                <div class="w3-modal-content">
                    <div class="w3-container">
                        <span onclick="document.getElementById('id01').style.display = 'none'" class="w3-button w3-display-topright">&times;</span>
                        <img src="../book_REC.gif" alt="Trulli" width="120%" height="120%">
                    </div>
                </div>
            </div>   
        </div> 
    </body>
</html>
<script>
    $(document).ready(function () {
        all_notes = $("li a");

        all_notes.on("keyup", function () {
            note_title = $(this).find("h2").text();
            note_content = $(this).find("p").text();

            item_key = "list_" + $(this).parent().index();

            data = {
                title: note_title,
                content: note_content
            };

            window.localStorage.setItem(item_key, JSON.stringify(data));
        });

        all_notes.each(function (index) {
            data = JSON.parse(window.localStorage.getItem("list_" + index));

            if (data !== null) {
                note_title = data.title;
                note_content = data.content;

                $(this).find("h2").text(note_title);
                $(this).find("p").text(note_content);
            }
        });
    });

</script>
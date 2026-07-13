<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>HDBS</title>
        <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
                <a class="btn"href='<?= INSTALL_URL ?>Preview/index'>Home</a>
                <!--<a class="btn"href='<?= INSTALL_URL ?>Admin/login'>Login</a>&nbsp;  
                <a  class="btn" href='<?= INSTALL_URL ?>Member/create'>Register</a>-->
            </div>
        </div>
        </div>
        </div>
        <!-- Sticker section start -->
        <div class="row">
            <marquee behavior="scroll" style="margin-top: 30px;" direction="left">Please arrive  5 mins before your scheduled time.If you arrive more than 15 mins after your scheduled start time, we will not be able to perform/complete your Puja.Thanks in advance for your understanding and cooperation!</marquee>
            <div class="col-sm-12 col-lg-4 col-md-4 amd" id="amc">
                <ul>
                    <li>
                        <z href="#">
                            <h2 class="hdb">HDBS Priest Service Reservation</h2>&nbsp;&nbsp;<br><br>
                            <span>
                                <p>
                                    Please select a date on the Calendar to start making your reservation. Please read detailed instructions.<br><br>
                                    <b> Contact <span style="color:#005a9c;"><a href='mailto:priest@durgabari.org'> priest@durgabari.org</a></span> if you have questions before making the reservation.</b>
                                </p>
                            </span>
        </z>
                    </li>
                </ul>
            </div>

            <div class="col-sm-12 col-lg-4 col-md-4" id="ndr" >
                <script type="text/javascript" src="<?php echo INSTALL_URL; ?>index.php?controller=GzFront&action=load&cid[]=<?php echo (empty($_REQUEST['calendars_id'])) ? ($tpl['arr'][0]['id'] ?? '') : implode('&cid[]=', ($_POST['calendars_id'] ?? '') ); ?>&view_month=<?php echo (empty($_POST['months'])) ? '1' : $_POST['months']; ?>"></script>
            </div>

            <div class="col-sm-12 col-lg-4 col-md-4 ab" id="abc" >
                <ul>
                    <li style="margin-top:6px; width: 100%;">
                        <z href="#">
                            <h2>Reservation Steps</h2>&nbsp;
                            <span> 
                                <p><b>You can reserve any Puja in 3 simple steps:</b><br>
                                    1. Select Puja date by clicking on the calendar.<br>
                                    2. Select a Puja slot.<br>
                                    3. Fill in the details and make payment.<br>
                                    You will receive a confirmation receipt once the reservation is done.For more details, please see the video.</p>
                            </span>
                            <a class="fa fa-video-camera" id="vid"  onclick="document.getElementById('id01').style.display = 'block'" style="color:#1e90ff;font-size: x-large;float:left;"></a> </br>
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
    <!-- Base URL for JS modules -->
    <div id="container-abc-url-id" style="display:none"><?= INSTALL_URL ?></div>

    <!-- OTP Member Verification Modal -->
    <style>
        .otp-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.55);z-index:9000;justify-content:center;align-items:center}
        .otp-overlay.otp-active{display:flex}
        .otp-modal{background:#fff;border-radius:8px;width:380px;max-width:95vw;box-shadow:0 8px 32px rgba(0,0,0,0.22);overflow:hidden;position:relative;font-family:Arial,sans-serif}
        .otp-modal-header{background:#357ca5;padding:18px 20px 14px;text-align:center;position:relative}
        .otp-modal-header h4{color:#fff;margin:0 0 4px;font-size:18px}
        .otp-modal-header p{color:rgba(255,255,255,0.88);font-size:13px;margin:0}
        .otp-close-btn{position:absolute;top:10px;right:14px;background:none;border:none;color:#fff;font-size:22px;cursor:pointer;line-height:1;padding:0}
        .otp-modal-body{padding:22px 24px 18px}
        #otp-screen-2{display:none}
        .otp-field-group{margin-bottom:14px}
        .otp-field-group label{display:block;font-size:13px;font-weight:600;margin-bottom:5px;color:#333}
        .otp-field-group input[type=text]{width:100%;padding:9px 12px;border:1px solid #ccc;border-radius:5px;font-size:14px;box-sizing:border-box}
        .otp-field-group input[type=text]:focus{border-color:#357ca5;outline:none;box-shadow:0 0 0 2px rgba(53,124,165,0.18)}
        .otp-method-toggle{display:flex;gap:10px}
        .otp-method-btn{flex:1;padding:8px 0;border:2px solid #ccc;border-radius:5px;background:#f5f5f5;font-size:13px;font-weight:600;cursor:pointer;transition:all .15s}
        .otp-method-btn:hover{border-color:#357ca5;color:#357ca5}
        .otp-method-btn.otp-selected{background:#357ca5;color:#fff;border-color:#357ca5}
        .otp-submit-btn{width:100%;padding:10px;background:#357ca5;color:#fff;border:none;border-radius:5px;font-size:15px;font-weight:700;cursor:pointer;margin-top:4px}
        .otp-submit-btn:hover{background:#2a6185}
        .otp-submit-btn:disabled{opacity:.6;cursor:not-allowed}
        .otp-security-note{text-align:center;font-size:12px;color:#888;margin-top:10px}
        .otp-alert{display:none;padding:9px 12px;border-radius:5px;font-size:13px;margin-bottom:10px}
        .otp-alert.otp-show{display:block}
        .otp-alert-error{background:#fdecea;color:#c0392b;border:1px solid #f5c6cb}
        .otp-alert-success{background:#eafaf1;color:#1e8449;border:1px solid #b7e4c7}
        .otp-digits{display:flex;gap:8px;justify-content:center;margin-top:8px}
        .otp-digit-input{width:42px;height:48px;text-align:center;font-size:20px;font-weight:700;border:2px solid #ccc;border-radius:6px;background:#fff;box-sizing:border-box;-moz-appearance:textfield}
        .otp-digit-input::-webkit-outer-spin-button,.otp-digit-input::-webkit-inner-spin-button{-webkit-appearance:none;margin:0}
        .otp-digit-input:focus{outline:none;border-color:#357ca5;box-shadow:0 0 0 2px rgba(53,124,165,.18)}
        .otp-digit-input.otp-filled{border-color:#357ca5;background:#f0f7fb}
        .otp-digit-input.otp-error-border{border-color:#ff5252}
        .otp-sent-to{text-align:center;font-size:14px;color:#555;margin-bottom:14px}
        .otp-resend-row{display:flex;justify-content:space-between;align-items:center;font-size:13px;margin:10px 0}
        .otp-resend-link{color:#357ca5;cursor:pointer;display:none;font-weight:600}
        .otp-resend-link.otp-show{display:inline}
        .otp-change-link{color:#357ca5;cursor:pointer;font-size:12px;margin-left:6px}
        .otp-req{color:#e74c3c}
    </style>

    <div id="otp-overlay" class="otp-overlay">
        <div class="otp-modal">
            <div class="otp-modal-header">
                <button class="otp-close-btn" id="otp-close-btn" type="button">&times;</button>
                <h4>Verify Your Membership</h4>
                <p id="otp-modal-subtitle">Please verify your identity to access member details.</p>
            </div>
            <div class="otp-modal-body">
                <div id="otp-alert" class="otp-alert"></div>
                <div id="otp-screen-1">
                    <div class="otp-field-group">
                        <label>Email or Phone Number <span class="otp-req">*</span></label>
                        <input type="text" id="otp-lookup" placeholder="Enter your email or phone number" autocomplete="off" />
                    </div>
                    <div class="otp-field-group">
                        <label>Receive OTP via <span class="otp-req">*</span></label>
                        <div class="otp-method-toggle">
                            <button type="button" class="otp-method-btn" data-method="email"><i class="fa fa-envelope"></i> Email</button>
                            <button type="button" class="otp-method-btn" data-method="sms"><i class="fa fa-mobile"></i> SMS</button>
                        </div>
                    </div>
                    <button type="button" class="otp-submit-btn" id="otp-send-btn">Send OTP</button>
                    <div class="otp-security-note"><i class="fa fa-lock"></i> Your information is secure and will not be shared.</div>
                </div>
                <div id="otp-screen-2" style="display:none;">
                    <div class="otp-sent-to">OTP has been sent to<br><strong id="otp-masked-destination"></strong>&nbsp;<a class="otp-change-link" id="otp-change-link">Change</a></div>
                    <div class="otp-field-group">
                        <label>Enter OTP <span class="otp-req">*</span></label>
                        <div class="otp-digits">
                            <input class="otp-digit-input" type="number" maxlength="1" min="0" max="9" data-index="0" />
                            <input class="otp-digit-input" type="number" maxlength="1" min="0" max="9" data-index="1" />
                            <input class="otp-digit-input" type="number" maxlength="1" min="0" max="9" data-index="2" />
                            <input class="otp-digit-input" type="number" maxlength="1" min="0" max="9" data-index="3" />
                            <input class="otp-digit-input" type="number" maxlength="1" min="0" max="9" data-index="4" />
                            <input class="otp-digit-input" type="number" maxlength="1" min="0" max="9" data-index="5" />
                        </div>
                    </div>
                    <div class="otp-resend-row">
                        <span id="otp-resend-timer">Resend OTP in <span id="otp-countdown">00:45</span></span>
                        <a class="otp-resend-link" id="otp-resend-link">Resend OTP</a>
                    </div>
                    <button type="button" class="otp-submit-btn" id="otp-verify-btn">Verify OTP</button>
                    <div class="otp-security-note"><i class="fa fa-lock"></i> Your information is secure and will not be shared.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Zelle Instructions Modal -->
    <div id="zelle-modal-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:9100;justify-content:center;align-items:center;">
        <div style="background:#fff;border-radius:8px;width:660px;max-width:96vw;max-height:90vh;overflow-y:auto;box-shadow:0 8px 32px rgba(0,0,0,0.25);position:relative;font-family:Arial,sans-serif;">
            <div style="background:#357ca5;padding:16px 20px 12px;text-align:center;position:relative;border-radius:8px 8px 0 0;">
                <button id="zelle-modal-close" type="button" style="position:absolute;top:10px;right:14px;background:none;border:none;color:#fff;font-size:24px;cursor:pointer;line-height:1;padding:0;opacity:0.85;">&times;</button>
                <h4 style="color:#fff;margin:0;font-size:18px;font-weight:bold;">Pay via Zelle</h4>
                <p style="color:rgba(255,255,255,0.88);margin:4px 0 0;font-size:13px;">Scan QR or send to treasurer@durgabari.org</p>
            </div>
            <div style="padding:20px 24px 10px;text-align:center;">
                <img id="zelle-modal-img" src="" alt="Zelle QR Code" style="max-width:580px;width:100%;height:auto;border-radius:4px;">
            </div>
            <div style="padding:0 24px 16px;font-size:14px;color:#333;line-height:1.8;">
                <b>Step 1</b> — Open your bank app and navigate to Zelle.<br>
                <b>Step 2</b> — Send your payment amount to <b>treasurer@durgabari.org</b>.<br>
                <b>Step 3</b> — After sending, click <b>"I've Completed Zelle Payment"</b> below.
            </div>
            <div style="padding:0 24px 22px;display:flex;gap:12px;justify-content:center;">
                <button id="zelle-modal-paid-btn" type="button" class="btn btn-primary" style="min-width:200px;font-size:15px;">I've Completed Zelle Payment</button>
                <button id="zelle-modal-cancel-btn" type="button" class="btn btn-default" style="min-width:120px;font-size:15px;background:#f5f5f5;border:1px solid #ccc;">Cancel</button>
            </div>
        </div>
    </div>

    <script>
(function ($) {
    function previewMemberCheck() {
        var value = $('#registrationmember').val();
        var isMember = value === 'member';
        $('#termdiv, #memberidtd').toggle(isMember);
        $('#term, #idmem').prop('required', isMember);

        $('#first_name, #second_name, #phone, #email, #address_1, #term, #termMember, #idmem').val('');
        if (!isMember) {
            $('#otp-verified-banner').removeClass('otp-show').hide();
            $('#otp-session-verified').text('');
        }
    }

    window.membercheck = previewMemberCheck;
    $(document).on('change', '#registrationmember', previewMemberCheck);
})(jQuery);
</script>
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

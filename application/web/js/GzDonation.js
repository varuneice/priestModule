(function ($) {
    $(function () {
        var url = $("#container-abc-url-id").text();
        var otpSessionVerifiedValue = $.trim($('#otp-session-verified').text());
        var otpSessionVerified = otpSessionVerifiedValue !== '' && otpSessionVerifiedValue !== '0';

        function getMemberInput(res, id) {
            var nodes = $.parseHTML($.trim(res || ''), document, false) || [];
            var $nodes = $(nodes);
            var $el = $nodes.filter('input#' + id);
            if (!$el.length) {
                $el = $('<div>').append($nodes).find('input#' + id);
            }
            return $el;
        }

        function getMemberInputValue(res, id) {
            var $el = getMemberInput(res, id);
            return $el.length ? $.trim($el.val()) : '';
        }
        function fillFormFromOtp() {
            var $banner = $('#otp-verified-banner');
            $banner.html('<i class="fa fa-spinner fa-spin" style="color:#357ca5;font-size:16px;"></i> Loading member data…')
                   .addClass('otp-show');
            $('#IDMembertd').addClass('disabledbutton');

            $.ajax({
                type: 'POST',
                url: url + 'load.php?controller=Donations&action=AllMemberNew',
                data: {},
                success: function (res) {
                    var trimmed = $.trim(res);
                    if (!trimmed || trimmed === '0 results') {
                        $banner.html('<i class="fa fa-exclamation-circle" style="color:#c0392b;font-size:16px;"></i> Member not found. Please try verifying again.');
                        otpSessionVerified = false;
                        $('#registrationmember').val('');
                        $('#IDMembertd').addClass('disabledbutton');
                        return;
                    }

                    function val(id) {
                        return getMemberInputValue(res, id);
                    }

                    var first  = val('MemberName');
                    var last   = val('last_name');
                    var spouse = $.trim(val('Spouse') + ' ' + val('Spouselast'));

                    document.getElementById('Your_Name').value          = $.trim(first + ' ' + last);
                    document.getElementById('demmember').value           = val('memberid');
                    document.getElementById('spousename').value          = spouse;
                    document.getElementById('Street').value              = val('ressidentalAddress');
                    document.getElementById('ressidentalAddress').value  = val('Address');
                    document.getElementById('city').value                = val('city');
                    document.getElementById('state').value               = val('state');
                    document.getElementById('zip_code').value            = val('zip_code');
                    document.getElementById('phone').value               = val('Tele1');
                    document.getElementById('email').value               = val('email');
                    document.getElementById('ltd1').value                = val('ltd');
                    document.getElementById('ytd1').value                = val('ytd');
                    document.getElementById('MembCategory').value        = val('membercategory');

                    $('#termMember').val(val('memberid'));
                    $('#term').val($.trim(first + ' ' + last)).prop('readonly', true);

                    $banner.html('<i class="fa fa-check-circle" style="color:#276632;font-size:16px;"></i> Verified &amp; auto-filled: <strong>' + $('<span>').text($.trim(first + ' ' + last)).html() + '</strong>');
                    $('#IDMembertd').removeClass('disabledbutton');
                },
                error: function () {
                    $banner.html('<i class="fa fa-exclamation-circle" style="color:#c0392b;font-size:16px;"></i> Could not load member data. Please refresh the page and try again.');
                    $('#IDMembertd').removeClass('disabledbutton');
                }
            });
        }

        if ($('#stripe_secret_key_id').length > 0) {
            var stripe_publish_key = $("#stripe_secret_key_id").text();
            var stripe = Stripe(stripe_publish_key);
        }
         //let emailvalid = true;
         //let phonevalid = true;
        // For Member Search option...........................
     function MemberSelect() {
        var self = this;
        var data = $("#termMember").val();
        var term = $("#term").val();
        if (term != "") {
        const Memberid = data.split("-");
        //var url = gz$("#container-abc-url-id").text(); 
        if (term.trim() != "") {
            $.ajax({
                type: "POST",
                data: {
                    memberid: data
                },
                //url: self.options.server  +"load.php?controller=Donations&action=AllMember&cid=" + self.options.cal_id,
                url: url + "load.php?controller=Donations&action=AllMember&cid",
                success: function (res) {
                    let MemberName = "";
                    const memberNameElement = getMemberInput(res, "MemberName");
                    if (memberNameElement.length) {
                        MemberName = memberNameElement[0].value;
                    }
                    let LastName = "";
                    const LastNameElement = getMemberInput(res, "last_name");
                    if (LastNameElement.length) {
                        LastName = LastNameElement[0].value;
                    }
   
                    document.getElementById("Your_Name").value =  MemberName.concat(" ", LastName);;



                    let memberid = "";
                    const memberElement = getMemberInput(res, "memberid");
                    if (memberElement.length) {
                        memberid = memberElement[0].value;
                    }
                    document.getElementById("demmember").value = memberid;
                    // if(memberid != ""){
                    // document.getElementById("demmember").value = memberid;
                    // var url ="https://durgabari.org/HDBS_PaymentNew/Member/membermaintenance/" +memberid
                    // window.location.assign(url);
                    // }
                    let spouseName = "";
                     let spouseLastName = "";
                    const spouseNameElement = getMemberInput(res, "Spouse");
                    const spouseLastNameElement = getMemberInput(res, "Spouselast");
                     if(spouseLastNameElement.length){
                     spouseLastName = spouseLastNameElement[0].value; 
                     }
                     if(spouseNameElement.length){
                     spouseName = spouseNameElement[0].value; 
                     }
                      document.getElementById("spousename").value = spouseName.concat(" ",spouseLastName);

                      let street = "";
                            const streetElement = getMemberInput(res, "ressidentalAddress");
                          if(streetElement.length){
                           street = streetElement[0].value; 
                           }
                           document.getElementById("Street").value = street;

                           let resaddress = "";
                   const resaddressElement = getMemberInput(res, "Address");
                  if(resaddressElement.length){
                    resaddress = resaddressElement[0].value; 
                  }
                  document.getElementById("ressidentalAddress").value = resaddress;

                  let state = "";
                  const stateElement = getMemberInput(res, "state");
                 if(stateElement.length){
                   state = stateElement[0].value; 
                 }
                 document.getElementById("state").value = state;
                 

                 let city = "";
                    const cityElement = getMemberInput(res, "city");
                   if(cityElement.length){
                      city = cityElement[0].value; 
                   }
                   document.getElementById("city").value = city;

                   let zipcode = "";
                    const zipcodeElement = getMemberInput(res, "zip_code");
                   if(zipcodeElement.length){
                    zipcode = zipcodeElement[0].value; 
                   }
                   document.getElementById("zip_code").value = zipcode;

                   let phoneNo = "";
                    const phoneNoElement = getMemberInput(res, "Tele1");
                   if(phoneNoElement.length){
                      phoneNo = phoneNoElement[0].value; 
                   }
                   document.getElementById("phone").value = phoneNo;

                   let email = "";
                    const emailElement = getMemberInput(res, "email");
                   if(emailElement.length){
                       email = emailElement[0].value; 
                   }
                   document.getElementById("email").value = email;

                   let ltd = "";
                    const ltdElement = getMemberInput(res, "ltd");
                   if(ltdElement.length){
                    ltd = ltdElement[0].value; 
                   }
                   document.getElementById("ltd1").value = ltd;

                   let ytd = "";
                   const ytdElement = getMemberInput(res, "ytd");
                  if(ytdElement.length){
                    ytd = ytdElement[0].value; 
                  }
                  document.getElementById("ytd1").value = ytd;
                  

                  let cat = "";
                  const catElement = getMemberInput(res, "membercategory");
                 if(catElement.length){
                   cat = catElement[0].value; 
                 }
                 document.getElementById("MembCategory").value = cat;


                }
            
            });
        } else {
            $("#MemberName").val("");
            $("#phone").val("");
            $("#Your_E-mail").val("");
            $("#memberid").val("");Member_id
           
            $("#spousename").val("");
            $("#Street").val("");
            $("#ressidentalAddress").val("");
            $("#state").val("");
            $("#city").val("");
            $("#zip_code").val("");
            $("#phone").val("");
            $("#email").val("");
            $("#ltd1").val("");
            $("#ytd1").val("");
            $("#MembCategory").val("");

        }
       }
    }
        
        $(document).delegate('#reset-btn-id', 'click',  function (e) {
             $('#donation-frm-id')[0].reset();
        }).delegate('#Donation_Type', 'change', function (e) {
            var val = $(this).val();

            if (val === '1') {
                $('#hide1').hide();
            } else {
                $('#hide1').show();
            }
        }).delegate('#PaymentOption', 'change', function (e) {
            var val = $(this).val();

            if (val == 'stripe') {
                $("#others_details").hide();
                $("#zelle-inline-instructions").hide();
                $("#stripe_details").show();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";
                $("#MemberID").hide().prop('required', false);
                $('#MemberID').empty().append('<option value="">Please select your Zelle transaction</option>');
                $('#zelle_donor_name').val('');
                $('#zelle_date').val('');
                $('#zelle-no-match').hide();
                $('#payment_btn_id').prop('disabled', false);
                $("#payment_btn_id").removeClass('disabled');
                var elements = stripe.elements();

                var style = {
                    base: {
                        // Add your base input styles here. For example:
                        fontSize: '16px',
                        color: "#32325d",
                    }
                };

                var card = elements.create('card', {style: style});

                card.mount('#card-element');

                card.addEventListener('change', function (event) {
                    var displayError = document.getElementById('card-errors');
                    if (event.error) {
                        displayError.textContent = event.error.message;
                    } else {
                        displayError.textContent = '';
                    }
                });


                var form = document.getElementById('donation-frm-id');

                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    stripe.createToken(card).then(function (result) {
                        if (result.error) {
                            var errorElement = document.getElementById('card-errors');
                            errorElement.textContent = result.error.message;
                        } else {
                            $("#stripeToken").val(result.token.id);
                            form.submit();
                        }
                    });
                });
            } else if (val == 'others') {
                $("#stripe_details").hide();
                $("#others_details").hide();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";
                $("#MemberID").hide().prop('required', true);
                $("#zelle-no-match").hide();
                $('#MemberID').empty().append('<option value="">Please select your Zelle transaction</option>');
                $('#payment_btn_id').prop('disabled', true).addClass('disabled');
                $('#zelle-modal-overlay').css('display', 'flex');
                // Silently import latest Zelle emails to DB in background while user reads instructions
                $.post(url + 'load.php?controller=GzFront&action=importZelleAndSearch', {});
            } else {
                $("#stripe_details").hide();
                $("#others_details").hide();
                $("#MemberID1").hide();
                $("#MemberID").hide().prop('required', false);
                $('#MemberID').empty().append('<option value="">Please select your Zelle transaction</option>');
                $('#zelle_donor_name').val('');
                $('#zelle_date').val('');
                $('#zelle-no-match').hide();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
            }
        }).delegate('#confirm_code', 'change', function (event) {
            var frm = $("#payment-form");
            $("#error_code1").css('display', 'none');
            $("#error_codeimg").css('display', 'none');
            $.ajax({
                type: "POST",
                data: frm.serialize(),
                url: url + "load.php?controller=GzFront&action=checkCode",
                success: function (res) {
                    var check = res.includes("Your payment code is matched you can book");

                    if (check == true) {
                        $("#payment_btn_id").removeClass('disabled');
                    } else {
                        $("#payment_btn_id").addClass('disabled');
                    }
                    $('#error_code').html(res);
                }
            });
            }).delegate('#checkPaymentData', 'click', function (event) {
            var donorName = $.trim($('#zelle_donor_name').val());
            var zelleAmt  = $.trim($('#total').val());
            var zelleDate = $.trim($('#zelle_date').val());

            if (!donorName) {
                alert('Please enter your name as used in Zelle.');
                $('#zelle_donor_name').focus();
                return;
            }
            if (!zelleAmt) {
                alert('Please enter the donation amount first.');
                $('#total').focus();
                return;
            }

            $('#zelle-no-match').hide();
            $('#MemberID').hide().empty().append('<option value="">Please select your Zelle transaction</option>');
            $('#payment_btn_id').prop('disabled', true).addClass('disabled');
            $.LoadingOverlay('show');

            $.ajax({
                type: 'POST',
                url: url + 'load.php?controller=GzFront&action=checkCodeDD',
                data: { donor_name: donorName, zelle_amount: zelleAmt, zelle_date: zelleDate },
                success: function (res) {
                    $.LoadingOverlay('hide');
                    var trimmed = $.trim(res);
                    if (!trimmed || trimmed === 'NO_MATCH') {
                        $('#zelle-no-match').show();
                        $('#payment_btn_id').prop('disabled', true).addClass('disabled');
                        return;
                    }
                    var $opts = $(trimmed);
                    $('#MemberID').empty().append('<option value="">Please select your Zelle transaction</option>').append($opts).show();
                    $('#zelle-action-btns').show();
                    $('#zelle-manual-fields').hide();
                    $('#zelle-no-match').hide();
                    if ($opts.length === 1) {
                        $('#MemberID').val($opts.first().val()).trigger('change');
                    }
                },
                error: function () {
                    $.LoadingOverlay('hide');
                    alert('Could not verify Zelle payment. Please try again.');
                }
            });
        }).delegate('#MemberID', 'change', function (event) {
            var dd = $("#MemberID").val();
          
            var parts = dd.split("/");
            var cmCode = parts[3];
            var name =parts[1];
            var price =parts[2].replace(/ /gi,'').trim();;
          
            var newp =price.replace('$', "");
             var newprice = newp.replace(',','').trim();
            //var totalprice =   $("#total").text();
            var totalprice =   $("#total").val();
            var tot = totalprice.replace(/ /gi,'').trim();
           
           if(cmCode !=null){
                $("#Zellecode").val(cmCode);
                }
            
                    if(tot===newprice){
                         $('#payment_btn_id').prop("disabled", false);
                         $("#payment_btn_id").removeClass('disabled');
                       // $("#payment_btn_id").removeClass('disabled');
                    }
                    else{
                      
                        $("#payment_btn_id").addClass('disabled');
                        alert('Total price and select  price is not same please select correct payment');
                    }
            //$.LoadingOverlay("show");

            // $.ajax({
            //     type: "POST",
            //     data: {
            //         code: cmCode
            //     },
            //     url: self.options.server + "load.php?controller=GzFront&action=UpdateCodeData&cid=" + self.options.cal_id,
            //     success: function (res) {
            //         $("#details_frm_btn_id").removeClass('disabled');
            //         $('#error_code').html(res);
            //     }

            // });

        }).delegate('#registrationmember', 'change', function (event) {
            var regmember = $("#registrationmember").val();
            selectVal = $('#registrationmember').val();

            function clearFormFields() {
                document.getElementById("spousename").value = "";
                document.getElementById("Street").value = "";
                document.getElementById("ressidentalAddress").value = "";
                document.getElementById("city").value = "";
                document.getElementById("state").value = "";
                document.getElementById("zip_code").value = "";
                document.getElementById("email").value = "";
                document.getElementById("phone").value = "";
                document.getElementById("ltd1").value = "";
                document.getElementById("ytd1").value = "";
                document.getElementById("namenonmember").value = "";
                document.getElementById("MembCategory").value = "";
                document.getElementById("term").value = "";
                document.getElementById("demmember").value = "";
            }

            if (selectVal == "member") {
                clearFormFields();
                $("#IDMembertd").addClass("disabledbutton");
                $('#otp-verified-banner').removeClass('otp-show');
                $('#nonmembername').hide();
                $('#fieldtest').hide();
                $('#namemeemberregister').show();
                $('#IDMembertd').show();
                $("#namenonmember").prop('required', false);
                $("#term").prop('required', true);
                $("#demmember").prop('required', true);

                if (otpSessionVerified) {
                    fillFormFromOtp();
                    return;
                }

                OtpMemberVerify.open({
                    onVerified: function () {
                        otpSessionVerified = true;
                        fillFormFromOtp();
                    }
                });

                window.onOtpModalCancelled = function () {
                    $('#registrationmember').val('');
                    $("#IDMembertd").addClass("disabledbutton");
                };
            }

            if (selectVal == "nonmember") {
                clearFormFields();
                $("#IDMembertd").addClass("disabledbutton");
                $('#otp-verified-banner').removeClass('otp-show');
                $('#namemeemberregister').hide();
                $('#IDMembertd').hide();
                $('#nonmembername').show();
                $('#fieldtest').show();
                $("#fieldtest").prop('readonly', true);
                $("#namenonmember").prop('required', true);
                $("#term").prop('required', false);
                $("#demmember").prop('required', false);
            }

            if (selectVal == "" || selectVal == " ") {
                clearFormFields();
                $('#otp-verified-banner').removeClass('otp-show');
                $("#IDMembertd").addClass("disabledbutton");
            }

        }).delegate('#confirm_code', 'change', function (event) {
            var frm = $("#donation-frm-id");
           
            $.ajax({
                type: "POST",
                data: frm.serialize(),
                url: url + "load.php?controller=GzFront&action=checkCode",
                success: function (res) {
                    var check = res.includes("Your payment code is matched you can book");
                    
                    if (check == true) {
                        $("#payment_btn_id").prop("disabled", false);
                        $("#payment_btn_id").removeClass('disabled');
                    } else {
                        $("#payment_btn_id").prop("disabled", true);
                        $("#payment_btn_id").addClass('disabled');
                    }
                    $('#error_code').html(res);
                }
            });
    }).delegate("#term1", "keypress", function (e) {
        e.stopImmediatePropagation();
     if (e.keyCode === 13 || e.which === 13) {
          MemberSelect();
     }
      
       e.preventDefault();
   }).delegate("#term1", "change", function (e) {
        e.stopImmediatePropagation();
     
       MemberSelect.call(self);
       e.preventDefault();
   }).delegate("#term1", "click", function (e) {
        e.stopImmediatePropagation();

       MemberSelect.call(self);
       e.preventDefault();

    });

    // Zelle action buttons — Retry: show manual fields
    $('#zelle-retry-btn').on('click', function () {
        $('#zelle-action-btns').hide();
        $('#zelle-manual-fields').show();
        $('#MemberID').hide().empty().append('<option value="">Please select your Zelle transaction</option>');
        $('#zelle-no-match').hide();
        $('#payment_btn_id').prop('disabled', true).addClass('disabled');
    });

    // Zelle modal — "I've Completed Zelle Payment"
    $('#zelle-modal-paid-btn').on('click', function () {
        $('#zelle-modal-overlay').hide();
        doZelleImportSearch();
    });

    // Zelle modal — Cancel / X close
    $('#zelle-modal-cancel-btn, #zelle-modal-close').on('click', function () {
        $('#zelle-modal-overlay').hide();
        $('#PaymentOption').val('').trigger('change');
        $('#payment_btn_id').prop('disabled', false).removeClass('disabled');
    });

    function doZelleImportSearch() {
        var zelleAmt = $.trim($('#total').val());
        if (!zelleAmt) {
            alert('Please enter donation amount before selecting Zelle.');
            $('#PaymentOption').val('').trigger('change');
            $('#total').focus();
            return;
        }

        var regVal    = $('#registrationmember').val();
        var donorName = '';

        if (regVal === 'member') {
            donorName = $.trim($('#Your_Name').val());
            if (!donorName) {
                $('#MemberID1').show();
                $('#zelle-manual-fields').show();
                $('#zelle-action-btns').hide();
                document.getElementById('error_code1').style.display = 'block';
                document.getElementById('error_code1').style.color = '#c0392b';
                $('#error_code1').html('Please complete OTP verification first, then search your Zelle transaction manually below.');
                return;
            }
        } else if (regVal === 'nonmember') {
            donorName = $.trim($('#namenonmember').val());
            if (!donorName) {
                $('#MemberID1').show();
                $('#zelle-manual-fields').show();
                $('#zelle-action-btns').hide();
                document.getElementById('error_code1').style.display = 'block';
                document.getElementById('error_code1').style.color = '#c0392b';
                $('#error_code1').html('Please enter your full name above, then search your Zelle transaction manually below.');
                $('#namenonmember').focus();
                return;
            }
        } else {
            $('#MemberID1').show();
            $('#zelle-manual-fields').show();
            $('#zelle-action-btns').hide();
            document.getElementById('error_code1').style.display = 'block';
            document.getElementById('error_code1').style.color = '#c0392b';
            $('#error_code1').html('Please select whether you are a Durga Bari member, then search your Zelle transaction manually below.');
            $('#registrationmember').focus();
            return;
        }

        document.getElementById('error_code1').style.display = 'block';
        document.getElementById('error_code1').style.marginLeft = '163px';
        document.getElementById('error_code1').style.paddingTop = '12px';
        document.getElementById('error_code1').style.color = '#357ca5';
        $('#error_code1').html('<i class="fa fa-spinner fa-spin"></i> Searching your Zelle transaction…');
        $('#MemberID1').show();
        $('#zelle-no-match').hide();
        $('#MemberID').hide().empty().append('<option value="">Please select your Zelle transaction</option>');
        $('#payment_btn_id').prop('disabled', true).addClass('disabled');
        $.LoadingOverlay('show');

        // Fire import silently in background (non-blocking)
        $.post(url + 'load.php?controller=GzFront&action=importZelleAndSearch', {});

        var today = new Date().toISOString().split('T')[0]; // YYYY-MM-DD
        $.ajax({
            type: 'POST',
            url: url + 'load.php?controller=GzFront&action=checkCodeDD',
            data: { donor_name: donorName, zelle_amount: zelleAmt, zelle_date: today },
            success: function (res) {
                $.LoadingOverlay('hide');
                var trimmed = $.trim(res);
                if (!trimmed || trimmed === 'NO_MATCH') {
                    document.getElementById('error_code1').style.color = '#c0392b';
                    $('#error_code1').html('Transaction not found . Enter your name and date above, then click <b>Verify Zelle Payment</b>.');
                    if (donorName) { $('#zelle_donor_name').val(donorName); }
                    $('#MemberID1').show();
                    $('#zelle-manual-fields').show();
                    $('#zelle-action-btns').hide();
                    return;
                }

                var $opts = $(trimmed);
                var count = $opts.length;

                $('#MemberID').append($opts).show();
                $('#MemberID1').show();
                $('#zelle-action-btns').show();
                $('#zelle-manual-fields').hide();

                if (count === 1) {
                    $('#MemberID').val($opts.first().val()).trigger('change');
                    document.getElementById('error_code1').style.color = '#276632';
                    $('#error_code1').html('<i class="fa fa-check-circle"></i> Zelle transaction matched and selected automatically.');
                } else {
                    document.getElementById('error_code1').style.color = '#276632';
                    $('#error_code1').html('Multiple possible matches found. Please select your transaction.');
                }
            },
            error: function () {
                $.LoadingOverlay('hide');
                document.getElementById('error_code1').style.color = '#c0392b';
                $('#error_code1').html('Could not search Zelle transactions. Enter your name and date below to search manually.');
            }
        });
    }

     });

}(jQuery));

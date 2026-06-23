(function ($) {
    $(function () {
        //debugger;
        var url = $("#container-abc-url-id").text();
     
        var selcetsubj = null;
        if ($('#stripe_secret_key_id').length > 0) {
            var stripe_publish_key = $("#stripe_secret_key_id").text();
            var stripe = Stripe(stripe_publish_key);
        }

        function fillStudentFormFromOtp(memberId) {
            $('#otp-session-verified').text(memberId || '');
            $('#otp-gate').hide();
            $('#otp-verified-banner').addClass('otp-show').css('display', 'table-row');
            $('#IDMembertd').addClass('disabledbutton');

            $.ajax({
                type: 'POST',
                url: url + 'load.php?controller=Donations&action=AllMemberNew',
                data: { member_id: memberId || $('#otp-session-verified').text().trim() },
                success: function (res) {
                    var trimmed = $.trim(res);
                    if (!trimmed || trimmed === '0 results') {
                        $('#otp-verified-banner').html('<i class="fa fa-exclamation-circle" style="color:#c0392b;font-size:16px;"></i> Member not found. Please verify again.');
                        return;
                    }

                    function val(id) {
                        var el = $(res).filter('input#' + id);
                        return el.length ? $.trim(el[0].value) : '';
                    }

                    var first = val('MemberName');
                    var last = val('last_name');
                    var fullName = $.trim(first + ' ' + last);

                    $('#Your_Name').val(fullName);
                    $('#term').val(fullName).prop('readonly', true);
                    $('#termMember').val(val('memberid') || memberId || '');
                    $('#demmember').val(val('memberid') || memberId || '');
                    $('#Your_E-mail').val(val('email'));
                    $('#Your_Number').val(val('Tele1'));
                    $('#cattype').val(val('membercategory'));
                    $('#otp-verified-banner').html('<i class="fa fa-check-circle" style="color:#276632;font-size:16px;"></i> Verified &amp; auto-filled: <strong>' + $('<span>').text(fullName).html() + '</strong>');
                },
                error: function () {
                    $('#otp-verified-banner').html('<i class="fa fa-exclamation-circle" style="color:#c0392b;font-size:16px;"></i> Could not load member data. Please refresh and try again.');
                }
            });
        }

        var verifiedMemberIdOnLoad = $.trim($('#otp-session-verified').text());
        if ($('#registrationmember').val() === 'member' && verifiedMemberIdOnLoad) {
            fillStudentFormFromOtp(verifiedMemberIdOnLoad);
        }

        function doStudentZelleImportSearch() {
            var zelleAmount = ($('#Amount').val() || '').replace(/[$,\s]/g, '').trim();
            if (!zelleAmount) {
                alert('Please select fee so the amount is calculated.');
                $('#payment_method').val('').trigger('change');
                return;
            }

            var regVal = $('#registrationmember').val();
            var donorName = '';
            if (regVal === 'member') {
                donorName = ($('#Your_Name').val() || '').trim();
                if (!donorName) {
                    showStudentZelleManual('Please complete OTP verification first, then search your Zelle transaction manually below.');
                    return;
                }
            } else if (regVal === 'nonmember') {
                donorName = ($('#namenonmember').val() || '').trim();
                if (!donorName) {
                    showStudentZelleManual('Please enter your full name above, then search your Zelle transaction manually below.');
                    $('#namenonmember').focus();
                    return;
                }
            } else {
                showStudentZelleManual('Please select whether you are a Durga Bari member, then search your Zelle transaction manually below.');
                $('#registrationmember').focus();
                return;
            }

            $('#error_code1').css({'display':'block','color':'#357ca5'}).html('<i class="fa fa-spinner fa-spin"></i> Searching your Zelle transaction...');
            $('#MemberID1').show();
            $('#zelle-no-match').hide();
            $('#zelleid').hide().empty().append('<option value="">Please select your Zelle transaction</option>');
            $('#payment_btn_id').prop('disabled', true).addClass('disabled');
            $.post(url + 'load.php?controller=GzFront&action=importZelleAndSearch', {});

            var today = new Date().toISOString().split('T')[0];
            $.ajax({
                type: 'POST',
                data: { donor_name: donorName, zelle_amount: zelleAmount, zelle_date: today },
                url: url + 'load.php?controller=GzFront&action=checkCodeDD',
                success: function(res) {
                    var trimmed = $.trim(res);
                    if (!trimmed || trimmed === 'NO_MATCH') {
                        $('#error_code1').css('color', '#c0392b').html('Transaction not found automatically. Enter your name and date below, then click <b>Verify Zelle Payment</b>.');
                        $('#zelle_donor_name').val(donorName);
                        showStudentZelleManual('');
                        return;
                    }
                    var opts = $(trimmed);
                    $('#zelleid').empty()
                        .append('<option value="">Please select your Zelle transaction</option>')
                        .append(opts).show();
                    $('#zelle-action-btns').show();
                    $('#zelle-manual-fields').hide();
                    $('#zelle-no-match').hide();
                    if (opts.length === 1) {
                        $('#zelleid').val(opts.first().val()).trigger('change');
                        $('#error_code1').css('color', '#276632').html('<i class="fa fa-check-circle"></i> Zelle transaction matched and selected automatically.');
                    } else {
                        $('#error_code1').css('color', '#276632').html(opts.length + ' transactions found. Please select yours, then click <b>Verify Selected Transaction</b>.');
                    }
                },
                error: function() {
                    $('#error_code1').css('color', '#c0392b').html('Could not search Zelle transactions. Enter your name and date below to search manually.');
                    $('#zelle_donor_name').val(donorName);
                    $('#zelle-manual-fields').show();
                }
            });
        }

        function showStudentZelleManual(msg) {
            $('#MemberID1').show();
            $('#zelle-manual-fields').show();
            $('#zelle-action-btns').hide();
            if (msg) {
                $('#error_code1').css({'display':'block','color':'#c0392b'}).html(msg);
            }
        }
        
        function zelleDropDownUpdate() {
            var self = this;
            //debugger
            var frm = $("#payment-form");
            //$.LoadingOverlay("show");
            var cal_id = $("#calendar_id").val();
            $.ajax({
                type: "POST",
                data: frm.serialize(),
                url: url + "load.php?controller=GzFront&action=checkCodeDD&cid=" + cal_id,
                success: function (res) {

                    //var myString = res.replace("echo", '');
                    var myString1 = res.replace("", '');
                    //= myString.replace("",'');
                    $('#zelleid').empty(); //remove all child nodes
                    var newOption = $(myString1);
                    var newOption1 = $('<option value="1">Please select your payment details</option>');
                    $('#zelleid').append(newOption1);
                    $('#zelleid').append(newOption);
                    $('#zelleid').trigger("chosen:updated");
                    var dd = $("#zelleid").val();

                    if (dd == "1") {
                        // gz$("#member_btn_id").addClass('disabled');
                        document.getElementById("payment_btn_id").disabled = true;
                    }
                    //  var parts = myString1.split("/"); 
                    //  var cmCode =parts[3];
                }
            });
        }

        function MemberSelect() {
            //debugger
            var self = this;
            var term = $("#termMember").val();
            var data = $("#termMember").val();
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
                        //debugger;
                        //var Membertext = $("#MemberSelectValue").text();
                        //document.getElementById("MemberSelect").value = Membertext;
                        let MemberName = "";
                        const memberNameElement = $(res).filter("input#MemberName");
                        if (memberNameElement.length) {
                            MemberName = memberNameElement[0].value;
                        }

                        let LastName = "";
                        const LastNameElement = $(res).filter("input#last_name");
                        if (LastNameElement.length) {
                            LastName = LastNameElement[0].value;
                        }
                        document.getElementById("Your_Name").value = MemberName.concat(" ", LastName);
                        //    document.getElementById("second_name").value = LastName;



                        let memberid = "";
                        const memberElement = $(res).filter("input#memberid");
                        if (memberElement.length) {
                            memberid = memberElement[0].value;
                        }
                        document.getElementById("demmember").value = memberid;


                        let phoneNo = "";
                        let MNo = "";
                        const phoneNoElement = $(res).filter("input#Tele1");
                        if (phoneNoElement.length) {
                            phoneNo = phoneNoElement[0].value;
                            phoneNo = phoneNo.replace("-", "");
                            MNo = phoneNo;
                            MNo = MNo.replace("-", "");
                        }
                        document.getElementById("Your_Number").value = MNo;

                        let email = "";
                        const emailElement = $(res).filter("input#email");
                        if (emailElement.length) {
                            email = emailElement[0].value;
                        }
                        document.getElementById("Your_E-mail").value = email;
                        
                        
                        let cat1 = "";
                        const catElement = $(res).filter("input#membercategory");
                        if (catElement.length) {
                            cat1 = catElement[0].value;
                        }
                           // var cat = $("#cat").val(cat1);
                        document.getElementById("cattype").value = cat1;
                    }
                });
            } else {
                $("#MemberName").val("");
                $("#phone").val("");
                $("#Your_E-mail").val("");

            }
        }
        //student delete code
        $("#gzhotel-booking-booking-id").delegate('a.icon-delete', 'click', function (e) {
            // debugger;
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
            $('#dialogDelete').dialog('open');
        });
        if ($("#dialogDelete").length > 0) {
            // debugger;
            $("#dialogDelete").dialog({
                autoOpen: false,
                resizable: false,
                draggable: false,
                height: 220,
                modal: true,
                close: function () {
                    $('#record_id').text('');
                },
                buttons: [{
                    html: "<i class='fa fa-trash-o'></i>&nbsp; Delete item",
                    "class": "btn btn-danger",
                    click: function () {
                        $.ajax({
                            type: "POST",
                            data: {
                                id: $('#record_id').text(),
                                controller: 'Student',
                                action: 'delete'
                            },
                            url: url + "index.php?controller=Student&action=delete",
                            beforeSend: function () {
                                $(".overlay").css('display', 'block');
                                $(".loading-img").css('display', 'block');
                            },
                            success: function (res) {
                                $("#gzhotel-booking-booking-id").html(res);
                                $(".overlay").css('display', 'none');
                                $(".loading-img").css('display', 'none');

                                $('#gzhotel-booking-booking-id').dataTable({
                                    "aoColumnDefs": [
                                       // { 'bSortable': false, 'aTargets': [5, 6] }
                                    ]
                                });
                            }
                        });
                        $(this).dialog('close');

                    }
                }, {
                    html: "<i class='fa fa-times'></i>&nbsp; Cancel",
                    "class": "btn btn-default",
                    click: function () {
                        $(this).dialog('close');
                    }
                }]
            });
        }

        if ($('#MemberID').length > 0) {
            $('#MemberID').selectpicker();
        }



        $(document).delegate('#reset-btn-id', 'click', function (e) {
            $('#new_student')[0].reset();
            $('#edit_student')[0].reset();
        }).delegate('#payment_method', 'change', function (e) {
            var val = $(this).val();
            if (val == 'stripe') {
                $("#others_details").hide();
                $("#stripe_details").show();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";
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

                var card = elements.create('card', { style: style });

                card.mount('#card-element');

                card.addEventListener('change', function (event) {
                    var displayError = document.getElementById('card-errors');
                    if (event.error) {
                        displayError.textContent = event.error.message;
                    } else {
                        displayError.textContent = '';
                    }
                });


                var form = document.getElementById('new_student');

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
                $('#error_codeimg').empty().hide();
                $('#zelleid').hide().empty().append('<option value="">Please select your Zelle transaction</option>');
                $('#zelle-action-btns').hide();
                $('#zelle-manual-fields').hide();
                $('#zelle-no-match').hide();
                $('#Zellecode').val('');
                $('#payment_btn_id').prop('disabled', true);
                $('#stripe_details').hide();
                $('#others_details').hide();
                $('#MemberID1').show();
                $('#error_code1').html('').hide();
                $('#zelle-modal-img').attr('src', url + 'zelle.png');
                $('#zelle-modal-overlay').css('display', 'flex');
                $.post(url + 'load.php?controller=GzFront&action=importZelleAndSearch', {});
            } else {
                $("#stripe_details").hide();
                $("#others_details").hide();
            }
        }).delegate('#confirm_code', 'change', function (event) {
            //debugger;
            var frm = $("#payment-form");
            $("#error_code1").css('display', 'none');
            $("#error_codeimg").css('display', 'none');
            $.ajax({
                type: "POST",
                data: frm.serialize(),
                url: url + "load.php?controller=GzFront&action=checkCode",
                success: function (res) {
                    //debugger;
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
            event.preventDefault();
            var donorName = ($('#zelle_donor_name').val() || '').trim();
            var zelleAmount = ($('#Amount').val() || '').replace(/[$,\s]/g, '').trim();
            var zelleDate = ($('#zelle_date').val() || '').trim();
            if (!donorName) {
                alert('Please enter your name as used in Zelle.');
                $('#zelle_donor_name').focus();
                return false;
            }
            if (!zelleAmount) {
                alert('Please select fee so the amount is calculated.');
                return false;
            }
            $('#error_code1').html('<em>Searching&hellip;</em>').show();
            $('#zelle-no-match').hide();
            $('#zelleid').hide().empty().append('<option value="">Please select your Zelle transaction</option>');
            $('#Zellecode').val('');
            $('#payment_btn_id').prop('disabled', true).addClass('disabled');
            $.post(url + 'load.php?controller=GzFront&action=importZelleAndSearch', {});
            $.ajax({
                type: 'POST',
                data: { donor_name: donorName, zelle_amount: zelleAmount, zelle_date: zelleDate },
                url: url + 'load.php?controller=GzFront&action=checkCodeDD',
                success: function(res) {
                    var trimmed = $.trim(res);
                    if (!trimmed || trimmed === 'NO_MATCH') {
                        $('#error_code1').html('No matching Zelle transactions found.').show();
                        $('#zelle-no-match').show();
                        return;
                    }
                    var opts = $(trimmed).filter('option');
                    if (opts.length === 0) {
                        opts = $(trimmed);
                    }
                    if (opts.length === 0) {
                        $('#error_code1').html('No matching Zelle transactions found.').show();
                        $('#zelle-no-match').show();
                    } else {
                        $('#zelleid').empty()
                            .append('<option value="">Please select your Zelle transaction</option>')
                            .append(opts).show();
                        $('#zelle-action-btns').show();
                        $('#zelle-manual-fields').hide();
                        $('#error_code1').html('').hide();
                        if (opts.length === 1) {
                            $('#zelleid').val(opts.first().val()).trigger('change');
                        }
                    }
                },
                error: function() {
                    $('#error_code1').html('Could not reach Zelle service.').show();
                }
            });
        }).delegate('#zelleid', 'change', function (event) {
            var dd = $('#zelleid').val();
            if (!dd) return;
            var parts = dd.split('/');
            var cmCode = parts[3];
            var newprice = parseFloat((parts[2] || '').replace(/[$,\s]/g, ''));
            var tot = parseFloat(($('#Amount').val() || '').replace(/[$,\s]/g, ''));
            if (cmCode) { $('#Zellecode').val(cmCode); }
            if (!isNaN(tot) && !isNaN(newprice) && tot === newprice) {
                $('#payment_btn_id').prop('disabled', false).removeClass('disabled');
            } else {
                $('#payment_btn_id').prop('disabled', true).addClass('disabled');
                if (dd) { alert('Total price and selected price do not match. Please select the correct payment.'); }
            }
        }).delegate('#zelle-verify-btn', 'click', function(event) {
            $('#zelleid').trigger('change');
        }).delegate('#zelle-retry-btn', 'click', function(event) {
            $('#zelle-action-btns').hide();
            $('#zelleid').hide().val('');
            $('#zelle-no-match').hide();
            $('#zelle-manual-fields').show();
            $('#Zellecode').val('');
            $('#payment_btn_id').prop('disabled', true);
        }).delegate('#zelle-modal-paid-btn', 'click', function(event) {
            $('#zelle-modal-overlay').hide();
            doStudentZelleImportSearch();
        }).delegate('#zelle-modal-cancel-btn, #zelle-modal-close', 'click', function(event) {
            $('#zelle-modal-overlay').hide();
            $('#payment_method').val('').trigger('change');
            $('#payment_btn_id').prop('disabled', false).removeClass('disabled');
        }).delegate('#otp-gate-btn', 'click', function(event) {
            if (typeof window.OtpMemberVerify === 'undefined') return;
            window.OtpMemberVerify.open({
                onVerified: function(memberId) {
                    fillStudentFormFromOtp(memberId);
                }
            });
        }).delegate('#confirm_code', 'change', function (event) {
            var frm = $("#new_student");

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
        }).delegate("#term1", "change", function (e) {

            e.preventDefault();
            MemberSelect.call(self);

        }).delegate("#term1", "click", function (e) {

            e.preventDefault();
            MemberSelect.call(self);
        }).delegate("#term1", "keyup", function (e) {

            e.preventDefault();
            MemberSelect.call(self);
        }).delegate('#registrationtype', 'change', function (event) {
            //debugger;
            var regtype = $("#registrationtype").val();
            document.getElementById("fee").value = "";
            document.getElementById("Amount").value = "";
            if (regtype == "workshops" || regtype == "library") {
                //$("#type").prop('readonly', true);
                $("#typecheck").prop('required', false);
                $("#type1").prop('required', false);
                document.getElementById('allsubject').style.display = 'none';
                $('#subjectrow').hide();
                //document.getElementById('type1').style.display = 'none';
            } else {
                document.getElementById('allsubject').style.removeProperty('display');
                $('#subjectrow').show();
                //document.getElementById('type1').style.removeProperty('display');
            }

            $.ajax({
                type: "POST",
                data: {
                    regtype: regtype
                },
                url: url + "load.php?controller=Student&action=subjectsstudent",
                success: function (res) {

                    //debugger;
                    $('#typecheck').empty(); //remove all child nodes
                    $('#type1').empty();  //remove all child nodes
                    var newOption = $(res);
                    var secondOption = $(res);
                    $('#typecheck').append(newOption);
                    $('#typecheck').trigger("chosen:updated");
                    $('#type1').append(secondOption);
                    $('#type1').trigger("chosen:updated");
                    $('#registrationmember').change();
                }
            });
        });
    }).delegate("#typecheck", "change", function (e) {
        debugger;
        e.stopImmediatePropagation();
        var typemember = $("#registrationmember").val();
        var regtype = $("#registrationtype").val();
        var typec = $("#typecheck").val();
        let date =  new Date().getFullYear();
        let latefeedate= '01'+'/03/'+date;
        let currentdaydate = formatDate(new Date());
         if(typec == ""){
             document.getElementById("Amount").value = "";
           
         }
         if (regtype = "" || typemember == "") {
            alert("Please Select Registration Type/ Member Type First");
            return false;
         }
        //e.stopImmediatePropagation();
        var selected = [];
        for (var option of document.getElementById('typecheck').options) {
            if (option.selected) {
                selected.push(option.value);
            }
        }
        selcetsubj = selected;
        var retype = $("#registrationtype").val();
        var dd2 = $("#type1").val();
        if (retype == 'BanglaSchool') {
            if (selcetsubj.length > 1) {
                selcetsubj.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only one subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }
        if (retype == 'Kalabhavan') {
            if (selcetsubj.length > 2) {
                selcetsubj.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only two subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }
        var cat = $("#cattype").val();
        var price = $("#fee").val();
        if (dd2 == "") {

            var test =document.getElementById("typecheck").value;
            if (selcetsubj.length > 1 && dd2 == "") {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
              if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     // Avinash new code for late fee
                //     var courceCount = selcetsubj.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}

                //document.getElementById("Amount").value = totalprice;
              
            }
            else if (selcetsubj.length > 0 && dd2 == "") {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
                var totalprice = amount;

                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = selcetsubj.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
                //document.getElementById("Amount").value = totalprice;
             
            }
        } else {
            var newsubjectrec = selcetsubj.concat(subjectsecond);
            if (selcetsubj.length > 1 && subjectsecond.length == 0) {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
               if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }

                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = selcetsubj.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
                //document.getElementById("Amount").value = totalprice;
                
            }
            else if (selcetsubj.length > 0 && subjectsecond.length == 0) {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
                var totalprice = amount;

                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = selcetsubj.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
                //document.getElementById("Amount").value = totalprice;
              
            }
            else if (newsubjectrec.length > 3) {
                var courceCount = newsubjectrec.length;
                var amount = courceCount * price;
               if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 20;
                }
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = newsubjectrec.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
               // document.getElementById("Amount").value = totalprice;
               

            }
            else if (newsubjectrec.length > 2) {
                var courceCount = newsubjectrec.length;
                var amount = courceCount * price;
                if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = newsubjectrec.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
                //document.getElementById("Amount").value = totalprice;
             
            }
            else if (selcetsubj.length > 0 && subjectsecond.length > 0) {
                var totalsub = selcetsubj.concat(subjectsecond);
                var courceCount = totalsub.length
                var amount = courceCount * price;
                if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = totalsub.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
                //document.getElementById("Amount").value = totalprice;
              
            }
        }



    }).delegate("#typecheck", "click", function (e) {
       debugger;
        e.stopImmediatePropagation();
        var typemember = $("#registrationmember").val();
        var regtype = $("#registrationtype").val();
        var typec = $("#typecheck").val();
        let date =  new Date().getFullYear();
        let latefeedate= '01'+'/03/'+date;
        let currentdaydate = formatDate(new Date());
         if(typec == ""){
             document.getElementById("Amount").value = "";
           
         }
         if (regtype = "" || typemember == "") {
            alert("Please Select Registration Type/ Member Type First");
            return false;
         }
        //e.stopImmediatePropagation();
        var selected = [];
        for (var option of document.getElementById('typecheck').options) {
            if (option.selected) {
                selected.push(option.value);
            }
        }
        selcetsubj = selected;
        var retype = $("#registrationtype").val();
        var dd2 = $("#type1").val();
        if (retype == 'BanglaSchool') {
            if (selcetsubj.length > 1) {
                selcetsubj.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only one subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }
        if (retype == 'Kalabhavan') {
            if (selcetsubj.length > 2) {
                selcetsubj.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only two subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }
        var cat = $("#cattype").val();
        var price = $("#fee").val();
        if (dd2 == "") {

            var test =document.getElementById("typecheck").value;
            if (selcetsubj.length > 1 && dd2 == "") {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
              if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = selcetsubj.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}

                //document.getElementById("Amount").value = totalprice;
              
            }
            else if (selcetsubj.length > 0 && dd2 == "") {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
                var totalprice = amount;

                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = selcetsubj.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
                //document.getElementById("Amount").value = totalprice;
             
            }
        } else {
            var newsubjectrec = selcetsubj.concat(subjectsecond);
            if (selcetsubj.length > 1 && subjectsecond.length == 0) {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
               if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }

                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = selcetsubj.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
                //document.getElementById("Amount").value = totalprice;
                
            }
            else if (selcetsubj.length > 0 && subjectsecond.length == 0) {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
                var totalprice = amount;

                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = selcetsubj.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
                //document.getElementById("Amount").value = totalprice;
              
            }
            else if (newsubjectrec.length > 3) {
                var courceCount = newsubjectrec.length;
                var amount = courceCount * price;
               if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 20;
                }
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = newsubjectrec.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                // }
                //document.getElementById("Amount").value = totalprice;
               

            }
            else if (newsubjectrec.length > 2) {
                var courceCount = newsubjectrec.length;
                var amount = courceCount * price;
                if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = newsubjectrec.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 ///}

                //document.getElementById("Amount").value = totalprice;
             
            }
            else if (selcetsubj.length > 0 && subjectsecond.length > 0) {
                var totalsub = selcetsubj.concat(subjectsecond);
                var courceCount = totalsub.length
                var amount = courceCount * price;
                if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }

                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = totalsub.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
                //document.getElementById("Amount").value = totalprice;
              
             }
        }

}).delegate("#SecondStudentName", "keyup", function (e) {
           e.stopImmediatePropagation();

         var stu2 = $("#SecondStudentName").val();
        //  var schoolregisternew = $("#registrationtype").val();
        //  if (schoolregisternew == "Kalabhavan" || schoolregisternew == "BanglaSchool") {
        //     if (studentFirst != "" && studentSecond == "") {
        //         document.getElementById("type1").value = "";
        //     }}
        let date =  new Date().getFullYear();
        let latefeedate= '01'+'/03/'+date;
        let currentdaydate = formatDate(new Date());

        var first = $("#FirstStudentName").val();
        if(first == "" || first == null){
            alert("Please fill First Student Name first");
            $("#SecondStudentName").val('');
            return;
        }
        
        if ($(this).val().length != 0) {
            //debugger;
            $('#type1').attr('disabled', false);
            var schoolregister = $("#registrationtype").val();
            var amountfee = $("#fee").val();
            var studentSecond = $("#SecondStudentName").val();
            var studentFirst = $("#FirstStudentName").val();

            
            if (schoolregister == "workshops" || schoolregister == "library") {
                if (studentFirst.trim() != "" && studentSecond.trim() != "") {

                    var tot = amountfee;
                    var amount = tot * 2;
                    var totalprice = amount;
                    document.getElementById("Amount").value = totalprice;
                    
                }
                
                 e.stopImmediatePropagation();
                
            }
            

        }
        else {
          
            $('#type1').attr('disabled', true);
            var schoolregistercheck = $("#registrationtype").val();
            var stu1 = $("#FirstStudentName").val();
            var stu2 = $("#SecondStudentName").val();
            var getvalueseconddubject = $("#type1").val();
            var getvaluefirstdubject = $("#typecheck").val();
            var amountfeenew = $("#fee").val(); 
             var cat = $("#cattype").val();
            if (schoolregistercheck == "BanglaSchool"){
                if((stu1.trim() !="") && (stu2.trim() =="")){
                    document.getElementById("type1").value = "";
                    // if(currentdaydate < latefeedate){ 

                    //     document.getElementById("Amount").value = amountfeenew + 10;
                    //  }
                    //  else{
                    //     document.getElementById("Amount").value = amountfeenew;
                    //  }
                    document.getElementById("Amount").value = amountfeenew;  
                }
                
              }

              if (schoolregistercheck == "Kalabhavan"){
                if((stu2.trim() =="")){
                    document.getElementById("type1").value = "";
                    var len = getvaluefirstdubject.length;
                    if(len == 2){
                    var getvaluefirstdubject = amountfeenew * 2
                   if(cat=="GD" || cat=="GC"){
                     var discountprice =  getvaluefirstdubject;
                    }else{
                    var discountprice =  getvaluefirstdubject - 10;
                    }
                    
                    document.getElementById("Amount").value = discountprice;   
                     
                    }else{
                        document.getElementById("Amount").value = amountfeenew;  
                    }
                    
                }
              }
         if (schoolregistercheck == "workshops" || schoolregistercheck == "library"){
            if(stu1!=""){
                document.getElementById("Amount").value = amountfeenew;

            }
         }
        }
    }).delegate("#SecondStudentName", "click", function (e) {
       debugger
       var amountfee = $("#fee").val();
        e.stopImmediatePropagation();
         var stu2 = $("#SecondStudentName").val();
         let date =  new Date().getFullYear();
         let latefeedate= '01'+'/03/'+date;
         let currentdaydate = formatDate(new Date());

        //  if(stu2==""){
        //      document.getElementById("Amount").value = "";
        //       // $("#FirstStudentName").val("");
        //  }
        // var schoolregisternew = $("#registrationtype").val();
        // if (schoolregisternew == "Kalabhavan" || schoolregisternew == "BanglaSchool") {
        //    if (studentFirst != "" && studentSecond == "") {
        //        document.getElementById("type1").value = "";
        //    }}
        if ($(this).val().length != 0) {
            //debugger;
            $('#type1').attr('disabled', false);
            var schoolregister = $("#registrationtype").val();
            var amountfee = $("#fee").val();
            var studentSecond = $("#SecondStudentName").val();
            var studentFirst = $("#FirstStudentName").val();


            if (schoolregister == "workshops" || schoolregister == "library") {
                if (studentFirst.trim() != "" && studentSecond.trim() != "") {

                    var tot = amountfee;
                    var amount = tot * 2;
                    var totalprice = amount;
                    document.getElementById("Amount").value = totalprice;
                }
                
                    
                
            }

        }
        else {
            $('#type1').attr('disabled', true);
            var stu1 = $("#FirstStudentName").val();
            var stu2 = $("#SecondStudentName").val();
            var schoolregistercheck = $("#registrationtype").val();
            var amountfeenew = parseInt($("#fee").val());
            var getvalueseconddubject = $("#type1").val();
            var getvaluefirstdubject = $("#typecheck").val();
             var cat = $("#cattype").val()
            if (schoolregistercheck == "BanglaSchool"){
                if((stu1.trim() !="") && (stu2.trim() =="")){
                    document.getElementById("type1").value = "";
                    document.getElementById("Amount").value = amountfeenew;  
                }
              }

              if (schoolregistercheck == "Kalabhavan"){
                if((stu2.trim() =="")){
                    document.getElementById("type1").value = "";
                    var len = getvaluefirstdubject.length;
                    if(len == 2){
                    var getvaluefirstdubject = amountfeenew * 2
                   if(cat=="GD" || cat=="GC"){
                     var discountprice =  getvaluefirstdubject;
                    }else{
                    var discountprice =  getvaluefirstdubject - 10;
                    }
                    //document.getElementById("Amount").value = discountprice;  
                    if(currentdaydate < latefeedate){ 
                        var courceCount = getvaluefirstdubject.length;
                        var totallatefee =  courceCount * 10;
                        document.getElementById("Amount").value = discountprice + totallatefee;
                     }
                     else{
                        document.getElementById("Amount").value = discountprice;
                     } 
                    }else{
                        //document.getElementById("Amount").value = amountfeenew; 
                        // if(currentdaydate < latefeedate){ 
                        //     var courceCount = getvaluefirstdubject.length;
                        //     var totallatefee =  courceCount * 10;
                        //     document.getElementById("Amount").value = amountfeenew + totallatefee;
                        //  }
                        //  else{
                            document.getElementById("Amount").value = amountfeenew;
                         //} 
                    }
                    
                }
              }
             if (schoolregistercheck == "workshops" || schoolregistercheck == "library"){
                //debugger;
                if(stu1.trim() !=""){
                    document.getElementById("Amount").value = amountfeenew;
                }
             }
        }
        e.preventDefault();
    }).delegate("#SecondStudentName", "change", function (e) {
        //debugger;
       var stu2 = $("#SecondStudentName").val();
       var amountfee = $("#fee").val();
        let date =  new Date().getFullYear();
        let latefeedate= '01'+'/03/'+date;
        let currentdaydate = formatDate(new Date());
        e.stopImmediatePropagation();
        var first = $("#FirstStudentName").val();
       
        if(first == "" || first == null){
            alert("Please fill First Student Name first");
            $("#SecondStudentName").val('');
            return;
        }
        //if (first.trim() = "") {
        //   alert("Please fill first student name.");
        //}
        var fname = first.replace(/^\s+|\s+$/gm,'');
        if (fname= "") {
           alert("Please fill first student name.");
        }
        
        
        

        if ($(this).val().length != 0) {
            //debugger;
            $('#type1').attr('disabled', false);
            var schoolregister = $("#registrationtype").val();
            var amountfee = parseInt($("#fee").val());
            var studentSecond = $("#SecondStudentName").val();
            var studentFirst = $("#FirstStudentName").val();

            var second = $("#SecondStudentName").val();
            if (second.trim() == "") {

                document.getElementById("Amount").value = "";

            }
            if (schoolregister == "workshops" || schoolregister == "library") {
                if (studentFirst.trim() != "" && studentSecond.trim() != "") {

                    var tot = amountfee;
                    var amount = tot * 2;
                    var totalprice = amount;
                    document.getElementById("Amount").value = totalprice;
                }
                
                
            }

        }
        else {
           // debugger;
            $('#type1').attr('disabled', true);
            var stu1 = $("#FirstStudentName").val();
            var stu2 = $("#SecondStudentName").val();
            var schoolregistercheck = $("#registrationtype").val();
            var amountfeenew = parseInt($("#fee").val());
            var getvalueseconddubject = $("#type1").val();
            var getvaluefirstdubject = $("#typecheck").val();
             var cat = $("#cattype").val();
            if (schoolregistercheck == "BanglaSchool"){
                if((stu1.trim() !="") && (stu2.trim() =="")){
                    document.getElementById("type1").value = "";
                    document.getElementById("Amount").value = amountfeenew;  
                }
              }

              if (schoolregistercheck == "Kalabhavan"){
                //debugger;
                if((stu2.trim() =="")){
                    document.getElementById("type1").value = "";
                    var len = getvaluefirstdubject.length;
                    if(len == 2){
                    var getvaluefirstdubject = amountfeenew * 2
                     if(cat=="GD" || cat=="GC"){
                     var discountprice =  getvaluefirstdubject;
                    }else{
                    var discountprice =  getvaluefirstdubject - 10;
                    }
                    //document.getElementById("Amount").value = discountprice;
                    // if(currentdaydate > latefeedate){ 
                    //     var courceCount = getvaluefirstdubject.length;
                    //     var totallatefee =  courceCount * 10;
                    //     document.getElementById("Amount").value = discountprice + totallatefee;
                    //  }
                    //  else{
                        document.getElementById("Amount").value = discountprice;
                     //}
                    
                    }else{
                        //document.getElementById("Amount").value = amountfeenew;  
                        // if(currentdaydate > latefeedate){ 
                        //     var courceCount = getvaluefirstdubject.length;
                        //     var totallatefee =  courceCount * 10;
                        //     document.getElementById("Amount").value = amountfeenew + totallatefee;
                        //  }
                        //  else{
                            document.getElementById("Amount").value = amountfeenew;
                         //}
                    }
                    
                }
              }
             if (schoolregistercheck == "workshops" || schoolregistercheck == "library"){
                //debugger;
                if(stu1.trim() !=""){
                    document.getElementById("Amount").value = amountfeenew;
                }
             }
        }
        e.preventDefault();
    }).delegate("#FirstStudentName", "click", function (e) {
        e.preventDefault();
        var schoolregister = $("#registrationtype").val();
        var amountfee = $("#fee").val();
        var studentSecond = $("#SecondStudentName").val();
        var studentFirst = $("#FirstStudentName").val();



        if ((schoolregister == "workshops" || schoolregister == "library")) {
            if (studentFirst.trim() != "" && studentSecond.trim() == "") {
                document.getElementById("Amount").value = amountfee;
            }
        }
        e.preventDefault();
    }).delegate("#FirstStudentName", "change", function (e) {
        e.stopImmediatePropagation();
        var stu1 = $("#FirstStudentName").val();
         if(stu1.trim() ==""){
             document.getElementById("Amount").value = "";
         }
        //debugger;
        var regtype = $("#registrationtype").val();
        var typemember = $("#registrationmember").val();
        if (regtype.trim() == "" || typemember.trim() == "") {
            alert("Please Select Registration Type/ Member Type First");
            return false;

        } else {

            var schoolregister = $("#registrationtype").val();
            var amountfee = $("#fee").val();
            var studentSecond = $("#SecondStudentName").val();
            var studentFirst = $("#FirstStudentName").val();



            if ((schoolregister == "workshops" || schoolregister == "library")) {
                if (studentFirst.trim() != "" && studentSecond.trim() == "") {
                    document.getElementById("Amount").value = amountfee;
                }
            }
        }
        e.preventDefault();
       
    }).delegate("#type1", "change", function (e) {
       
        var typemember = $("#registrationmember").val();
         var type = $("#type1").val();
         if(type==""){
             document.getElementById("Amount").value = "";
         }
 

        var selected1 = [];
        for (var option of document.getElementById('type1').options) {
            if (option.selected) {
                selected1.push(option.value);
            }
        }
        subjectsecond = selected1;
 //alert(subjectsecond);
 // alert(selected1);
        var retype = $("#registrationtype").val();
        //debugger;
        if (retype == 'BanglaSchool') {
              
            if (subjectsecond.length > 1) {
               
                subjectsecond.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only one subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }
        if (retype == 'Kalabhavan') {
            
            if (subjectsecond.length > 2) {
                 
                subjectsecond.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only two subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }

        //debugger;
        var newsubjectrec = selcetsubj.concat(subjectsecond);
        var price = $("#fee").val();
        var cat = $("#cattype").val();
        if (selcetsubj.length > 1 && subjectsecond.length == 0) {
            var courceCount = selcetsubj.length;
            var amount = courceCount * price;
           if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                let date =  new Date().getFullYear();
                let latefeedate= '01'+'/03/'+date;
                let currentdaydate = formatDate(new Date());
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = selcetsubj.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
           // document.getElementById("Amount").value = totalprice;
            
        }
        else if (selcetsubj.length > 0 && subjectsecond.length == 0) {
            var courceCount = selcetsubj.length;
            var amount = courceCount * price;
            var totalprice = amount;
            let date =  new Date().getFullYear();
            let latefeedate= '01'+'/03/'+date;
            let currentdaydate = formatDate(new Date());
            // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
            //     var courceCount = selcetsubj.length;
            //     var totallatefee =  courceCount * 10;
            //     document.getElementById("Amount").value = totalprice + totallatefee;
            //  }
           //  else{
                document.getElementById("Amount").value = totalprice;
             //}
            //document.getElementById("Amount").value = totalprice;
           
        }
        else if (newsubjectrec.length > 3) {
            var courceCount = newsubjectrec.length;
            var amount = courceCount * price;
           if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 20;
                }
                let date =  new Date().getFullYear();
                let latefeedate= '01'+'/03/'+date;
                let currentdaydate = formatDate(new Date());
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = newsubjectrec.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
            //document.getElementById("Amount").value = totalprice;
         

        }
        else if (newsubjectrec.length > 2) {
            var courceCount = newsubjectrec.length;
            var amount = courceCount * price;
            if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                let date =  new Date().getFullYear();
                let latefeedate= '01'+'/03/'+date;
                let currentdaydate = formatDate(new Date());
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = newsubjectrec.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
            //document.getElementById("Amount").value = totalprice;
        
        }
        else if (selcetsubj.length > 0 && subjectsecond.length > 0) {
            var totalsub = selcetsubj.concat(subjectsecond);
            var courceCount = totalsub.length
            var amount = courceCount * price;
            if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                let date =  new Date().getFullYear();
                let latefeedate= '01'+'/03/'+date;
                let currentdaydate = formatDate(new Date());
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = totalsub.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                // }
            //document.getElementById("Amount").value = totalprice;
          
        }


    }).delegate("#type1", "click", function (e) {
       
        var typemember = $("#registrationmember").val();
         var type = $("#type1").val();
         let date =  new Date().getFullYear();
         let latefeedate= '01'+'/03/'+date;
         let currentdaydate = formatDate(new Date());

         if(type==""){
             document.getElementById("Amount").value = "";
         }
 

        var selected1 = [];
        for (var option of document.getElementById('type1').options) {
            if (option.selected) {
                selected1.push(option.value);
            }
        }
        subjectsecond = selected1;
 //alert(subjectsecond);
 // alert(selected1);
        var retype = $("#registrationtype").val();
        //debugger;
        if (retype == 'BanglaSchool') {
              
            if (subjectsecond.length > 1) {
               
                subjectsecond.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only one subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }
        if (retype == 'Kalabhavan') {
            
            if (subjectsecond.length > 2) {
                 
                subjectsecond.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only two subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }

        //debugger;
        var newsubjectrec = selcetsubj.concat(subjectsecond);
        var price = $("#fee").val();
        var cat = $("#cattype").val();
        if (selcetsubj.length > 1 && subjectsecond.length == 0) {
            var courceCount = selcetsubj.length;
            var amount = courceCount * price;
           if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = selcetsubj.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
            //document.getElementById("Amount").value = totalprice;
            
        }
        else if (selcetsubj.length > 0 && subjectsecond.length == 0) {
            var courceCount = selcetsubj.length;
            var amount = courceCount * price;
            var totalprice = amount;
            if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 

                document.getElementById("Amount").value = totalprice + 10;
             }
             else{
                document.getElementById("Amount").value = totalprice;
             }
            //document.getElementById("Amount").value = totalprice;
           
        }
        else if (newsubjectrec.length > 3) {
            var courceCount = newsubjectrec.length;
            var amount = courceCount * price;
           if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 20;
                }
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = newsubjectrec.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                // }
            //document.getElementById("Amount").value = totalprice;
         

        }
        else if (newsubjectrec.length > 2) {
            var courceCount = newsubjectrec.length;
            var amount = courceCount * price;
            if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = newsubjectrec.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
            //document.getElementById("Amount").value = totalprice;
        
        }
        else if (selcetsubj.length > 0 && subjectsecond.length > 0) {
            var totalsub = selcetsubj.concat(subjectsecond);
            var courceCount = totalsub.length
            var amount = courceCount * price;
           if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                // if(currentdaydate > latefeedate && retype == 'Kalabhavan'){ 
                //     var courceCount = totalsub.length;
                //     var totallatefee =  courceCount * 10;
                //     document.getElementById("Amount").value = totalprice + totallatefee;
                //  }
                //  else{
                    document.getElementById("Amount").value = totalprice;
                 //}
            //document.getElementById("Amount").value = totalprice;
          
        }


    }).delegate('#registrationmember', 'change', function (event) {
        debugger;
        //var regmember = $("#registrationmember").val();
        var typeregistration = $("#registrationtype").val();
         var schoolregister = $("#registrationtype").val();
        if (schoolregister == "workshops" || schoolregister == "library") {
            $("#SecondStudentName").val('');
            $("#FirstStudentName").val('');
        }
        selectVal = $('#registrationmember').val();
        if (selectVal == "member") {
            $("#IDMembertd").addClass("disabledbutton");
            document.getElementById("Amount").value = "";
             document.getElementById("FirstStudentName").value = "";
             document.getElementById("SecondStudentName").value = "";
            document.getElementById("type1").value = "";
            document.getElementById("typecheck").value = "";
            document.getElementById("namenonmember").value = "";
            document.getElementById("demmember").value = "";
            document.getElementById("Your_E-mail").value = "";
            document.getElementById("Your_Number").value = "";
            document.getElementById("term").value = "";
            document.getElementById("termMember").value = "";
             document.getElementById("cattype").value = "";
            $('#nonmembername').hide();
            $('#fieldtest').hide();
            $('#namemeemberregister').show();
            $('#IDMembertd').show();
            $("#namenonmember").prop('required',false);
             $("#term").prop('required',true);
            $("#demmember").prop('required',true);
            $('#otp-verified-banner').removeClass('otp-show').css('display', 'none');
            if ($.trim($('#otp-session-verified').text())) {
                $('#otp-gate').hide();
                fillStudentFormFromOtp($.trim($('#otp-session-verified').text()));
            } else {
                $('#otp-gate').show();
            }
        }
      //FirstStudentName
        if (selectVal == "nonmember") {
            $("#IDMembertd").addClass("disabledbutton");
            document.getElementById("Amount").value = "";
             document.getElementById("FirstStudentName").value = "";
             document.getElementById("SecondStudentName").value = "";
            document.getElementById("type1").value = "";
            document.getElementById("typecheck").value = "";
            document.getElementById("namenonmember").value = "";
            document.getElementById("demmember").value = "";
            document.getElementById("Your_E-mail").value = "";
            document.getElementById("Your_Number").value = "";
            document.getElementById("term").value = "";
            document.getElementById("termMember").value = "";
              document.getElementById("cattype").value = "";
            //$('#IDMembertd').find(':input').prop("disabled", true);
             $('#namemeemberregister').hide();
            $('#IDMembertd').hide();
            $('#nonmembername').show();
            $('#fieldtest').show();
            $("#fieldtest").prop('readonly',true);
            $("#namenonmember").prop('required',true);
             $("#term").prop('required',false);
            $("#demmember").prop('required',false);
            $('#otp-gate').hide();
            $('#otp-verified-banner').removeClass('otp-show').css('display', 'none');
        }
        if (selectVal.trim() == "" ) {
            $("#IDMembertd").removeClass("disabledbutton");
            document.getElementById("Amount").value = "";
            document.getElementById("type1").value = "";
            document.getElementById("typecheck").value = "";
            document.getElementById("namenonmember").value = "";
            document.getElementById("demmember").value = "";
            document.getElementById("Your_E-mail").value = "";
            document.getElementById("Your_Number").value = "";
            document.getElementById("term").value = "";
            document.getElementById("termMember").value = "";
            document.getElementById("cattype").value = "";
            document.getElementById("FirstStudentName").value = "";
            document.getElementById("SecondStudentName").value = "";
            $('#otp-gate').hide();
            $('#otp-verified-banner').removeClass('otp-show').css('display', 'none');
        }
       
        $.blockUI();
        // $.LoadingOverlay("show");
        var url = $("#container-abc-url-id").text();
        $.ajax({
            type: "POST",
            data: {
                regmember: selectVal,
                typeregistration: typeregistration,
            },
            url: url + "load.php?controller=Student&action=feeprice&cid=regmember",
            success: function (res) {
                //  $.LoadingOverlay("hide");
                $.unblockUI();
                //debugger;
                $('#fee').empty(); //remove all child nodes
                var feenewOption = $(res);
                $('#fee').append(feenewOption);
                $('#fee').trigger("chosen:updated");
                $('#FirstStudentName').click();
                $('#SecondStudentName').click();
            }
        });
    }).delegate('#IDMember22', 'change', function (event) {
        //debugger; 
        var Memberid = $("#IDMember22").val();
        var url = $("#container-abc-url-id").text();
        if ((Memberid != "GD") && (Memberid != "")) {
            $.ajax({
                type: "POST",
                data: {
                    memberid: Memberid
                },
                //url: url  +"load.php?controller=Member&action=AllMember",
                url: url + "load.php?controller=Student&action=AllMember",
                success: function (res) {
                    //debugger;
                    let memberid = "";
                    const memberElement = $(res).filter("input#memberid");
                    if (memberElement.length) {
                        memberid = memberElement[0].value;
                    }
                    document.getElementById("demmember").value = memberid;


                    let phoneNo = "";
                    const phoneNoElement = $(res).filter("input#Tele1");
                    if (phoneNoElement.length) {
                        phoneNo = phoneNoElement[0].value;
                    }
                    document.getElementById("Your_Number").value = phoneNo;

                    let email = "";
                    const emailElement = $(res).filter("input#email");
                    if (emailElement.length) {
                        email = emailElement[0].value;
                    }
                    document.getElementById("Your_E-mail").value = email;

                }
            });
        } else {
            $("#MemberName").val("");
            $("#phone").val("");
            $("#email").val("");

        }
    });
	function padTo2Digits(num) {
        return num.toString().padStart(2, '0');
      }
      
      function formatDate(date) {
        return [
          padTo2Digits(date.getDate()),
          padTo2Digits(date.getMonth() + 1),
          date.getFullYear(),
        ].join('/');
      }
	
}(jQuery));


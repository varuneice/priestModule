(function ($) {
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

    $(function () {
        var url = $("#container-abc-url-id").text();

        if ($('#stripe_secret_key_id').length > 0) {
            var stripe_publish_key = $("#stripe_secret_key_id").text();
            var stripe = Stripe(stripe_publish_key);
        }

        if ($('#tab-1-table-id').length > 0) {
            $('#tab-1-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 7]}
                ]
            });
        }

        if ($('#tab-2-table-id').length > 0) {
            $('#tab-2-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 7]}
                ]
            });
        }

        if ($('#tab-3-table-id').length > 0) {
            $('#tab-3-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 7]}
                ]
            });
        }

        if ($('#tab-4-table-id').length > 0) {
            $('#tab-4-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 7]}
                ]
            });
        }

        if ($('#tab-5-table-id').length > 0) {
            $('#tab-5-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 7]}
                ]
            });
        }

        if ($('#tab-6-table-id').length > 0) {
            $('#tab-6-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 7]}
                ]
            });
        }

        if ($('#tab-7-table-id').length > 0) {
            $('#tab-7-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 7]}
                ]
            });
        }
        if ($('#tab-8-table-id').length > 0) {
            $('#tab-8-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 7]}
                ]
            });
        }

        function calculateSelectedMemberPrice() {
            var frm = $('#payment-form');

            console.log('[calculateSelectedMemberPrice] called. form found:', frm.length, 'rate checked:', $('input:radio[name=rate]:checked').length);

            if (!frm.length || !$('input:radio[name=rate]:checked').length) {
                return;
            }

            console.log('[calculateSelectedMemberPrice] request url:', url + "load.php?controller=Member&action=calculatePrice", 'data:', frm.serialize());

            $.ajax({
                type: "POST",
                data: frm.serialize(),
                dataType: 'json',
                url: url + "load.php?controller=Member&action=calculatePrice",
                success: function (json) {
                    console.log('[calculateSelectedMemberPrice] success response:', json);
                    $("#gmi_amount").val(json.gmi_amount);
                    $("#gmf_amount").val(json.gmf_amount);
                    $("#lm_amount").val(json.lm_amount);
                    $("#bf_amount").val(json.bf_amount);
                    $("#pm_amount").val(json.pm_amount);
                    $("#lm_h_amount").val(json.lm_h_amount);
                    $("#total").val(json.total);
                },
                error: function (xhr, status, err) {
                    console.error('[calculateSelectedMemberPrice] ajax FAILED. status:', status, 'error:', err, 'http status:', xhr.status, 'response body:', xhr.responseText);
                }
            });
        }

        function selectMemberRate(rateValue) {
            var $rate = $('input:radio[name=rate][value="' + rateValue + '"]');
            if (!$rate.length) {
                return;
            }

            if ($.fn.iCheck) {
                $rate.iCheck('check');
            } else {
                $rate.prop('checked', true).trigger('change');
            }
            calculateSelectedMemberPrice();
        }

        $('input:radio[name=rate]').on('ifChanged change', function (event) {
            calculateSelectedMemberPrice();
        });

        $('#donation').on('change keyup', function () {
            calculateSelectedMemberPrice();
        });

        calculateSelectedMemberPrice();

        var ignoreChange = false;
        let selectedSize;
        $('input:radio[name=membership_type]').on('ifChanged', function (event) {
            debugger;
           // var frm = $('#payment-form');
           const radioButtons = document.querySelectorAll('input[name="membership_type"]');
            if (ignoreChange) {
                ignoreChange = false;
                return;
            }
            debugger;
            for (const radioButton of radioButtons) {
                if (radioButton.checked) {
                    selectedSize = radioButton.value;
                    break;
                }
            }
            var mtype = "";
           const memtype = document.querySelectorAll('input[name="membership_type"]')
           for (const m of memtype) {
             if (m.checked) {
                mtype=m.value;
             }
           } 

            if (mtype == "IND") {
                debugger;
                 document.getElementById('children').style.display = 'none';
                document.getElementById('pricemembership').style.display = 'none';
                document.getElementById('memberindividual').style.removeProperty('display');
                $("#Spousefirst").prop('required',false);
                $("#Spouselast").prop('required',false);
                $("#Spousefirst").prop('readonly',true);
                $("#Spouselast").prop('readonly',true);
                selectMemberRate('gmi_1');
            } else{
              document.getElementById('children').style.removeProperty('display');
                document.getElementById('pricemembership').style.removeProperty('display');
                document.getElementById('memberindividual').style.display = 'none';
                $("#Spousefirst").prop('required',true);
                $("#Spouselast").prop('required',true);
                 $("#Spousefirst").prop('readonly',false);
                $("#Spouselast").prop('readonly',false);
                selectMemberRate('gmf_1');
            }
           
        });
         // For Member Search option...........................

        function MemberSelect() {
            debugger
            var self = this;

            var data = $("#termMember").val();
            const Memberid = data.split("-");
            //var url = gz$("#container-abc-url-id").text(); 
            if (data != "") {
                $.ajax({
                    type: "POST",
                    data: {
                        memberid: data
                    },
                    //url: self.options.server  +"load.php?controller=Donations&action=AllMember&cid=" + self.options.cal_id,
                    url: url + "load.php?controller=Donations&action=AllMember&cid",
                    success: function (res) {
                        debugger;
                        //var Membertext = $("#MemberSelectValue").text();
                        //document.getElementById("MemberSelect").value = Membertext;
                        let MemberName = "";
                        const memberNameElement = getSafeResponseInput(res, "MemberName", $);
                        if (memberNameElement.length) {
                            MemberName = memberNameElement[0].value;
                        }
                          //document.getElementById("second_name").value = MemberName;

                          let LastName = "";
                          const LastNameElement = getSafeResponseInput(res, "last_name", $);
                          if (LastNameElement.length) {
                              LastName = LastNameElement[0].value;
                          }
                          document.getElementById("Your_Name").value = MemberName.concat(" ", LastName);

                        let memberid = "";
                        const memberElement = getSafeResponseInput(res, "memberid", $);
                        if (memberElement.length) {
                            memberid = memberElement[0].value;
                        }
                        document.getElementById("demmember").value = memberid;
                        // if(memberid != ""){
                        // document.getElementById("demmember").value = memberid;
                        // var url ="http://localhost/HDBS_Payment/priestModule/Member/membermaintenance/" +memberid
                        // window.location.assign(url);
                        // }
                    let spouseName = "";
                    let spouseLastName = "";
                    const spouseNameElement = getSafeResponseInput(res, "Spouse", $);
                    const spouseLastNameElement = getSafeResponseInput(res, "Spouselast", $);
                     if(spouseLastNameElement.length){
                     spouseLastName = spouseLastNameElement[0].value; 
                     }
                     if(spouseNameElement.length){
                     spouseName = spouseNameElement[0].value; 
                     }
                      document.getElementById("spousename").value = spouseName.concat(" ",spouseLastName);

                      let street = "";
                            const streetElement = getSafeResponseInput(res, "ressidentalAddress", $);
                          if(streetElement.length){
                           street = streetElement[0].value; 
                           }
                           document.getElementById("Street").value = street;

                           let resaddress = "";
                   const resaddressElement = getSafeResponseInput(res, "Address", $);
                  if(resaddressElement.length){
                    resaddress = resaddressElement[0].value; 
                  }
                  document.getElementById("ressidentalAddress").value = resaddress;

                  let state = "";
                  const stateElement = getSafeResponseInput(res, "state", $);
                 if(stateElement.length){
                   state = stateElement[0].value; 
                 }
                 document.getElementById("state").value = state;
                 

                 let city = "";
                    const cityElement = getSafeResponseInput(res, "city", $);
                   if(cityElement.length){
                      city = cityElement[0].value; 
                   }
                   document.getElementById("city").value = city;

                   let zipcode = "";
                    const zipcodeElement = getSafeResponseInput(res, "zip_code", $);
                   if(zipcodeElement.length){
                    zipcode = zipcodeElement[0].value; 
                   }
                   document.getElementById("zip_code").value = zipcode;

                   let phoneNo = "";
                    const phoneNoElement = getSafeResponseInput(res, "Tele1", $);
                   if(phoneNoElement.length){
                      phoneNo = phoneNoElement[0].value; 
                   }
                   document.getElementById("phone").value = phoneNo;

                   let email = "";
                    const emailElement = getSafeResponseInput(res, "email", $);
                   if(emailElement.length){
                       email = emailElement[0].value; 
                   }
                   document.getElementById("email").value = email;
                   
                   let uniqueid = "";
                   const uniqueidElement = getSafeResponseInput(res, "tableid", $);
                  if(uniqueidElement.length){
                      uniqueid = uniqueidElement[0].value; 
                  }
                  document.getElementById("Your_id").value = uniqueid;

                 let ltd = "";
                    const ltdElement = getSafeResponseInput(res, "ltd", $);
                   if(ltdElement.length){
                    ltd = ltdElement[0].value; 
                   }
                   document.getElementById("ltd1").value = ltd;

                   let ytd = "";
                   const ytdElement = getSafeResponseInput(res, "ytd", $);
                  if(ytdElement.length){
                    ytd = ytdElement[0].value; 
                  }
                  document.getElementById("ytd1").value = ytd;

                  let dateupdate = "";
                  const dateupdateElement = getSafeResponseInput(res, "updatedate", $);
                 if(dateupdateElement.length){
                  dateupdate = dateupdateElement[0].value; 
                  var newupdate = dateupdate.split("-");
                  var newupdatedate = newupdate[0];
                       var finalupdatedate  = Number(newupdatedate);
                 }
   
                 
                 
                 let payfor = "";
                  const payforElement = getSafeResponseInput(res, "payfor", $);
                 if(payforElement.length){
                  payfor = payforElement[0].value;
                  let text = payfor;
                  var result = text.includes("Maintenance"); 
                 }

                  let cat = "";
                  const catElement = getSafeResponseInput(res, "membercategory", $);
                 if(catElement.length){
                   cat = catElement[0].value; 
                 }
                 document.getElementById("MembCategory").value = cat;
                 
                 let membertype = "";
                 const membertypeElement = getSafeResponseInput(res, "membershiptype", $);
                if(membertypeElement.length){
                    membertype = membertypeElement[0].value; 
                }
                document.getElementById("membershiptypehide").value = membertype;
                let current_date = new Date();
                let currentyeardate = current_date.getFullYear();
                const membercategorytype =  $("#membershiptypehide").val();
                const categ =  $("#MembCategory").val();
                var currentdaydate = new Date();
                let date =  new Date().getFullYear();
                let maintenancedatePrev= '31'+'/03/'+date;
                
                 if(categ == 'GD' && membercategorytype == 'IND'){
                    document.getElementById('familyradio').style.display = 'none';
                     document.getElementById("amountlabel").value ="Membership Renewal"; 
                    $('#individual_membershipradio').parent().attr('aria-checked', 'true').addClass('checked');
                    document.getElementById('indvidualradio').style.removeProperty('display');
                    if (currentdaydate  < maintenancedatePrev){
                        document.getElementById("total").value ="150"
                    }
                    else{
                        document.getElementById("total").value ="165" 
                       
                    }
                  }
                 else if(categ == 'GD' && membercategorytype == 'FAM'){
                    document.getElementById('indvidualradio').style.display = 'none';
                     document.getElementById("amountlabel").value ="Membership Renewal"; 
                    $('#family_membershipradio').parent().attr('aria-checked', 'true').addClass('checked');
                    document.getElementById('familyradio').style.removeProperty('display');
                    if (currentdaydate  < maintenancedatePrev){
                        document.getElementById("total").value ="200"
                        
                    }
                    else{
                       
                        document.getElementById("total").value ="220"
                    }
                  }
                  
                  else if((categ == 'LM' || categ == 'PM' || categ == 'BF' || categ == 'FM' || categ == 'FP') && (membercategorytype == 'IND')){
                    document.getElementById('familyradio').style.display = 'none';
                    document.getElementById("amountlabel").value ="Annual Maintenance";
                    document.getElementById("total").value = "120";
                      $('#individual_membershipradio').parent().attr('aria-checked', 'true').addClass('checked');
                    document.getElementById('indvidualradio').style.removeProperty('display');
                    
                   
                    if((finalupdatedate < currentyeardate) || (finalupdatedate == "" || finalupdatedate ==" ")){
                        document.getElementById('paymentdrop').style.removeProperty('display');
                    document.getElementById('member_btn_id').style.removeProperty('display');
                        
                     }else{
                        document.getElementById('paymentdrop').style.display = 'none';
                        //document.getElementById('Payment_method').style.display = 'none';
                        document.getElementById('member_btn_id').style.display = 'none';
                    }
                }
                  else if((categ == 'LM' || categ == 'PM' || categ == 'BF' || categ == 'FM' || categ == 'FP') && (membercategorytype == 'FAM')){
                    document.getElementById('indvidualradio').style.display = 'none';
                    document.getElementById("amountlabel").value ="Annual Maintenance";
                    document.getElementById("total").value ="120";
                    $('#family_membershipradio').parent().attr('aria-checked', 'true').addClass('checked');
                    document.getElementById('familyradio').style.removeProperty('display');
                    
                     if((finalupdatedate < currentyeardate) || (finalupdatedate == "" || finalupdatedate ==" ")){ 
                        document.getElementById('paymentdrop').style.removeProperty('display');
                                document.getElementById('member_btn_id').style.removeProperty('display');
                             
                        }
                            else{
                                document.getElementById('paymentdrop').style.display = 'none';
                                //document.getElementById('Payment_method').style.display = 'none';
                                document.getElementById('member_btn_id').style.display = 'none';
                            }
                        }
                  else if(categ == 'GM'){
                    document.getElementById('paymentdrop').style.display = 'none';
                    document.getElementById('member_btn_id').style.display = 'none';
                    	
                  }

                }


                });
            } else {
                $("#MemberName").val("");
                $("#phone").val("");
                $("#Your_E-mail").val("");
                $("#memberid").val("");

            }
        }

        // var ignoreChange2 = false;
        // let selectedSize2;
        // $('input:radio[name=information]').on('ifChanged', function (event) {
        //    // var frm = $('#payment-form');
        //    const radioButtons = document.querySelectorAll('input[name="information"]');
        //     if (ignoreChange2) {
        //         ignoreChange2 = false;
        //         return;
        //     }
        //     debugger
        //     for (const radioButton of radioButtons) {
        //         if (radioButton.checked) {
        //             selectedSize = radioButton.value;
        //             break;
        //         }
        //     }
        //     if (selectedSize == "renewal") {
        //         document.getElementById('renewmembership').style.display = 'block';
        //         document.getElementById('membernew').style.display = 'none';
        //     } else{
        //         document.getElementById('membernew').style.display = 'block';
        //         document.getElementById('renewmembership').style.display = 'none';
        //     }
           
        // });
        // var ignoreChange2 = false;
        // let selectedSize2;
        // $('input:radio[name=information]').on('ifChanged', function (event) {
        //    // var frm = $('#payment-form');
        //    const radioButtons = document.querySelectorAll('input[name="information"]');
        //     if (ignoreChange2) {
        //         ignoreChange2 = false;
        //         return;
        //     }
        //     debugger
        //     for (const radioButton of radioButtons) {
        //         if (radioButton.checked) {
        //             selectedSize = radioButton.value;
        //             break;
        //         }
        //     }
        //     if (selectedSize == "renewal") {
        //         document.getElementById('renew').style.display = 'block';
        //         document.getElementById('new').style.display = 'none';
        //     } else{
        //         document.getElementById('new').style.display = 'block';
        //         document.getElementById('renew').style.display = 'none';
        //     }
           
        // });
        let emailvalid = true;
        let phonevalid = true;

        var ignoreChange = false;
        let selectedSize1;
        $('input:radio[name=GovtissueID]').on('ifChanged', function (event) {
           // var frm = $('#payment-form');
           const radioButtons = document.querySelectorAll('input[name="GovtissueID"]');
            if (ignoreChange) {
                ignoreChange = false;
                return;
            }
            //debugger
            for (const radioButton of radioButtons) {
                if (radioButton.checked) {
                    selectedSize1 = radioButton.value;
                    break;
                }
            }
            if (selectedSize1 == "checked") {
                document.getElementById('govtid').style.display = 'block';
            } else{
                document.getElementById('govtid').style.display = 'none';
            }
           
        });

        $(document).delegate("a.gallery-delete", 'click', function (e) {
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
            $('#dialogDeleteImage').dialog('open');
        }).delegate('#reset-btn-id', 'click',  function (e) {
            $('#payment-form')[0].reset();
       }).delegate('#donation', 'change', function (e) {
            var frm = $('#payment-form');

            $.ajax({
                type: "POST",
                data: frm.serialize(),
                dataType: 'json',
                url: url + "load.php?controller=Member&action=calculatePrice",
                success: function (json) {
                    $("#gmi_amount").val(json.gmi_amount);
                    $("#gmf_amount").val(json.gmf_amount);
                    $("#lm_amount").val(json.lm_amount);
                    $("#bf_amount").val(json.bf_amount);
                    $("#pm_amount").val(json.pm_amount);
                    $("#lm_h_amount").val(json.lm_h_amount);
                    $("#total").val(json.total);
                }
            });
        }).delegate('#Payment_method', 'change', function (e) {
            debugger;
            var val = $(this).val();
             var totalpriceamount =   $("#total").val();

            if(totalpriceamount.trim() == ""){
              alert('please Select Fill Member Details');
              $("#total").prop('required',true);
              document.getElementById("Payment_method").value = "";
             
              return;
                }

            if (val == 'stripe') {
                $("#others_details").hide();
                $("#stripe_details").show();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";
                $("#MemberID").prop('required',false);
                $('#member_btn_id').prop('disabled', false).removeClass('disabled');
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

                var form = document.getElementById('payment-form');

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
                $('#MemberID').hide().empty().append('<option value="">Please select your Zelle transaction</option>');
                $('#zelle-action-btns').hide();
                $('#zelle-manual-fields').hide();
                $('#zelle-no-match').hide();
                $('#Zellecode').val('');
                $('#member_btn_id').prop('disabled', true).addClass('disabled');
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
        }).delegate("a.icon-delete", 'click', function (e) {
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
            $('#cat_id').text($(this).attr('cat'));
            $('#dialogDelete').dialog('open');
        }).delegate("#term1", "keyup", function (e) {
             e.stopImmediatePropagation();
          
            MemberSelect.call(self);
            e.preventDefault();
        }).delegate("#term1", "change", function (e) {
             e.stopImmediatePropagation();
          
            MemberSelect.call(self);
            e.preventDefault();
        }).delegate("#term1", "click", function (e) {
             e.stopImmediatePropagation();
          
            MemberSelect.call(self);
            e.preventDefault();
        }).delegate("#mark-all-id", 'click', function (e) {
            if ($(this).prop('checked')) {
                $(".mark").prop('checked', true);
            } else {
                $(".mark").prop('checked', false);
            }
        }).delegate('#delete-selected-id', 'click', function (e) {
            $('#dialogDeleteSelected').dialog('open');
        }).delegate("#search-drop-btn-id", "click", function (e) {
            e.preventDefault();

            if ($('#search-booking-frm-id').is(':visible')) {
                $('#search-booking-frm-id').slideUp();
            } else {
                $('#search-booking-frm-id').slideDown();
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
                    //debugger;
                    var check = res.includes("Your payment code is matched you can book");

                    if (check == true) {
                       
                        $("#member_btn_id").removeClass('disabled');
                    } else {
                        $("#member_btn_id").addClass('disabled');
                    }
                    $('#error_code').html(res);
                }
            });
        }).delegate('#checkPaymentData', 'click', function (event) {
            var donorName = ($('#zelle_donor_name').val() || '').trim();
            var zelleAmount = ($('#total').val() || '').replace(/[$,\s]/g, '').trim();
            var zelleDate = $('#zelle_date').val() || '';

            if (!donorName) {
                alert('Please enter your name as used in Zelle.');
                return;
            }
            $('#zelle-no-match').hide();
            $('#error_code1').html('<em>Searching&hellip;</em>').show();
            $.LoadingOverlay('show');

            $.ajax({
                type: 'POST',
                data: { donor_name: donorName, zelle_amount: zelleAmount, zelle_date: zelleDate },
                url: url + 'load.php?controller=GzFront&action=checkCodeDD',
                success: function(res) {
                    $.LoadingOverlay('hide');
                    var trimmed = $.trim(res);
                    if (!trimmed || trimmed === 'NO_MATCH') {
                        $('#error_code1').html('').hide();
                        $('#zelle-no-match').show();
                    } else {
                        var opts = $(trimmed);
                        $('#zelle-manual-fields').hide();
                        $('#MemberID').empty()
                            .append('<option value="">Please select your Zelle transaction</option>')
                            .append(opts)
                            .show();
                        $('#zelle-action-btns').show();
                        $('#error_code1').html('').hide();
                        if (opts.length === 1) {
                            $('#MemberID').val(opts.first().val()).trigger('change');
                        }
                    }
                },
                error: function() {
                    $.LoadingOverlay('hide');
                    $('#error_code1').html('').hide();
                    $('#zelle-no-match').show();
                }
            });
        }).delegate('#MemberID', 'change', function (event) {
            var dd = $('#MemberID').val();
            if (!dd) return;
            var parts = dd.split('/');
            var cmCode = parts[3];
            var price = parseFloat((parts[2] || '').replace(/[$,\s]/g, ''));
            var tot = parseFloat(($('#total').val() || '').replace(/[$,\s]/g, ''));

            if (cmCode) {
                $('#Zellecode').val(cmCode);
            }
            if (!isNaN(tot) && !isNaN(price) && tot === price) {
                $('#member_btn_id').prop('disabled', false).removeClass('disabled');
                $('#error_code1').css({'display':'block','color':'#276632'}).html('<i class="fa fa-check-circle"></i> Zelle transaction verified.');
            } else {
                $('#member_btn_id').prop('disabled', true).addClass('disabled');
                alert('Total price and selected Zelle amount do not match. Please select the correct transaction.');
            }

        }).delegate('#zelle-verify-btn', 'click', function(event) {
            $('#MemberID').trigger('change');
        }).delegate('#zelle-retry-btn', 'click', function(event) {
            $('#zelle-action-btns').hide();
            $('#MemberID').hide().val('');
            $('#zelle-no-match').hide();
            $('#zelle-manual-fields').show();
            $('#Zellecode').val('');
            $('#member_btn_id').prop('disabled', true).addClass('disabled');
        }).delegate('#zelle-modal-paid-btn', 'click', function(event) {
            $('#zelle-modal-overlay').hide();
            doMemberZelleImportSearch();
        }).delegate('#zelle-modal-cancel-btn, #zelle-modal-close', 'click', function(event) {
            $('#zelle-modal-overlay').hide();
            $('#Payment_method').val('').trigger('change');
            $('#member_btn_id').prop('disabled', false).removeClass('disabled');
        }).delegate('#otp-gate-btn', 'click', function(event) {
            if (typeof window.OtpMemberVerify === 'undefined') return;
            window.OtpMemberVerify.open({
                onVerified: function(memberId) {
                    if (window.MemberLookupOtpFlow && typeof window.MemberLookupOtpFlow.onVerified === 'function') {
                        window.MemberLookupOtpFlow.onVerified(memberId);
                        return;
                    }
                    $('#otp-gate').hide();
                    $('#otp-verified-banner').addClass('otp-show').css('display', 'flex');
                }
            });
        }).delegate('#email', 'change', function (event) {
            //debugger;
               var email = $("#email").val(); 
               if(!!email){
                             $.ajax({
                            type: "POST",
                            data: {
                                     email: email,
                                 },
                                url: url  + "load.php?controller=Member&action=Membercheck&cid=email",
                                success: function (res) {
                                        let emailaddress = "";
                                        const EmailElement = getSafeResponseInput(res, "email", $);
                                            if(EmailElement.length){
                                                emailaddress = EmailElement[0].value; 
                                                if(emailaddress == 'true') {
                                                    alert('Email Already Registered');
                                                     $("#member_btn_id").addClass('disabled');
                                                    emailvalid = false;
                                                } 
                                                else{
                                                    if(!!phonevalid){ 
                                                    $("#member_btn_id").removeClass('disabled');
                                                }
                                                else{
                                                    $("#member_btn_id").addClass('disabled');
                                                }
                                                  emailvalid = true;
                                                 // $("#member_btn_id").removeClass('disabled');
                                            }
                                }
                        }
                     });
                }else{
                    $("#member_btn_id").addClass('disabled');
                    emailvalid = undefined;
                }
                   }).delegate('#phone_mobile', 'change', function (event) {
                    //debugger; 
                    var Tele = $("#phone_mobile").val();
                        if(!!Tele){   
                            $.ajax({
                            type: "POST",
                            data: {
                                 Tele: Tele
                                },
                                url: url  + "load.php?controller=Member&action=memberphone&cid=Tele",
                                success: function (res) {
                                    //debugger;
                                    let mobile = "";
                                    const PhoneElement = getSafeResponseInput(res, "phone_mobile", $);
                                     if(PhoneElement.length){
                                         mobile = PhoneElement[0].value; 
                                            if(mobile == 'true') {
                                                alert('Mobile No Already Registered');
                                                $("#member_btn_id").addClass('disabled');
                                                phonevalid = false;

                                             } 
                                            else{
                                                if(!!emailvalid){ 
                                                    $("#member_btn_id").removeClass('disabled');
                               
                                                }
                                                else{
                                                    $("#member_btn_id").addClass('disabled');
                                                }
                                                 phonevalid = true;
                                            }
                                        }
                                    }
                                });
                            }
                            else{
                                    $("#member_btn_id").addClass('disabled');
                                    phonevalid = undefined;
                                }
                        }).delegate('#status', 'change', function (event) {
                    //debugger;
                       var MemberId  = $("#Member_id").val();
                       var status  = $("#status").val(); 
                      
                       if(status == 'E'){
                        //document.getElementById("late").style.display = "block";
                                     $.ajax({
                                    type: "POST",
                                    data: {
                                        MemberId: MemberId,
                                         },
                                        url: url  + "load.php?controller=Member&action=getmemberfirstnamelastname",
                                         success: function (res) {
                                            //$("late").css('display', 'block');
                                           document.getElementById("late").style.display = "block";
                                             let latemem1 = "";
                                             const latememElement = getSafeResponseInput(res, "latemem", $);
                                             if (latememElement.length) {
                                                latemem1 = latememElement[0].value;
                                             }
                                             
                                              let spousesalfield = "";
                                             const spousesalfieldElement = getSafeResponseInput(res, "spousesalfield", $);
                                             if (spousesalfieldElement.length) {
                                                spousesalfield = spousesalfieldElement[0].value;
                                             }

                                             let firstSalfield = "";
                                             const firstSalfieldElement = getSafeResponseInput(res, "firstSalfield", $);
                                             if (firstSalfieldElement.length) {
                                                firstSalfield = firstSalfieldElement[0].value;
                                             }
                                             
                                             var myString = latemem1.split("/");
                                             var firtname =myString[0];
                                             var secondname =myString[1];
                                             //remove all child nodes
                                             var newOption = $('<option value="1">Please select member name</option>');
                                             var expire = $('<option value="1">Both Person Expired &nbsp;</option>');
                                             var newOption1 = $("<option value='" + firtname + "'>" + firtname + " &nbsp;</option>");
                                             var newOption2 = $("<option value='" + secondname + "'>" + secondname + " &nbsp;</option>");
                                             var newOption3 = $('<option value="both">Both Expired &nbsp;</option>');
                                             $('#late').empty();
                                             if(MemberId != 0 ){
                                             if(firstSalfield != "Late" ){
                                             $('#late').append(newOption);
                                             $('#late').append(newOption1);
                                             }
                                             
                                               if(secondname != " " && spousesalfield !='Late'){
                                                $('#late').append(newOption2);
                                                 $('#late').append(newOption3);
                                               }
                                               if(firstSalfield == "Late" && spousesalfield =='Late'){
                                                $('#late').append(expire);
                                                
                                               }
                                            
                                             $('#late').trigger("chosen:updated");
                                            }


                                         }
                                     });
                        }else{
                            document.getElementById("late").style.display = "none";
                            // $("#member_btn_id").addClass('disabled');
                            // emailvalid = undefined;
                        }
                           });

        $(document).delegate(".gzTimeSlotButtonPlusClass", "click", function (e) {
            var slot = $(this).attr('data-start-time');
            var date = $(this).attr('data-date');
            var cal_id = $("#calendar_id").val();
            var count = 1;

            $.ajax({
                type: "POST",
                data: {
                    date: date,
                    slot: slot,
                    count: count,
                    cal_id: cal_id
                },
                url: url + "load.php?controller=Booking&action=addTimeSlot&cid=" + cal_id,
                success: function (res) {
                }
            });

            $(this).removeClass();
            $(this).addClass('gzTimeSlotButtonMinusClass fa fa-fw fa-minus-square');
        }).delegate(".gzTimeSlotDropDownClass", "change", function (e) {
            var slot = $(this).attr('data-start-time');
            var date = $(this).attr('data-date');
            var cal_id = $("#calendar_id").val();
            var count = $(this).val();

            $.ajax({
                type: "POST",
                data: {
                    date: date,
                    slot: slot,
                    count: count,
                    cal_id: cal_id
                },
                url: url + "load.php?controller=Booking&action=addTimeSlot&cid=" + cal_id,
                success: function (res) {
                }
            });
        }).delegate(".gzTimeSlotButtonMinusClass", "click", function (e) {
            var slot = $(this).attr('data-start-time');
            var date = $(this).attr('data-date');
            var cal_id = $("#calendar_id").val();
            var count = 1;

            $.ajax({
                type: "POST",
                data: {
                    date: date,
                    slot: slot,
                    count: count,
                    cal_id: cal_id
                },
                url: url + "load.php?controller=Booking&action=removeTimeSlot&cid=" + cal_id,
                success: function (res) {
                }
            });

            $(this).removeClass();
            $(this).addClass('gzTimeSlotButtonPlusClass fa fa-fw fa-plus-square');
        }).delegate(".gzRemoveTimeSlotClass", "click", function (e) {
            var slot = $(this).attr('data-start-time');
            var date = $(this).attr('data-date');
            var cal_id = $("#calendar_id").val();
            var count = 1;

            $.ajax({
                type: "POST",
                data: {
                    date: date,
                    slot: slot,
                    count: count,
                    cal_id: cal_id
                },
                url: url + "load.php?controller=Booking&action=removeTimeSlot&cid=" + cal_id,
                success: function (res) {
                }
            });
            $(this).parent().parent().remove();
        });
        if ($('#search-booking-frm-id').length > 0) {
            $('#from_start_time').datepicker({
                firstDay: $('#from_start_time').attr('first-day'),
                format: $('#start_time').attr('data-format'),
                onSelect: function (selectedDate) {
                    $('#project_to_start_time').datepicker('option', 'minDate', selectedDate);
                }
            });
            $('#to_start_time').datepicker({
                firstDay: $('#to_start_time').attr('first-day'),
                format: $('#to_start_time').attr('data-format'),
            });
            $('#from_end_time').datepicker({
                firstDay: $('#from_end_time').attr('first-day'),
                format: $('#from_end_time').attr('data-format'),
                onSelect: function (selectedDate) {
                    $('#to_end_time').datepicker('option', 'minDate', selectedDate);
                }
            });
            $('#to_end_time').datepicker({
                firstDay: $('#to_end_time').attr('first-day'),
                format: $('#to_end_time').attr('data-format'),
            });
        }
        if ($('#select_date').length > 0) {
            $('#select_date').datepicker({
                firstDay: $('#select_date').attr('first-day'),
                format: $('#select_date').attr('data-format'),
            }).on('changeDate', function (e) {
                var frm = $("#new_booking, #edit_booking");
                $.ajax({
                    type: "POST",
                    data: frm.serialize(),
                    url: url + "index.php?controller=Booking&action=getSlots",
                    success: function (res) {
                        $('#dialogSlotsDivId').html(res);
                        $("#dialogSlots").dialog('open');
                    }
                });
                $(this).datepicker('hide');
            });
        }
        if ($('#gz-abc-member-ID').length > 0) {
            $('#gz-abc-member-ID').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [0, 6, 7, 8]}
                ]
            });
        }

        if ($("#dialogDelete").length > 0) {
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
                            $(".overlay").css('display', 'block');
                            $(".loading-img").css('display', 'block');

                            var cat = $('#cat_id').text();

                            $.ajax({
                                type: "POST",
                                data: {
                                    id: $('#record_id').text(),
                                    cat: cat,
                                    controller: 'Member',
                                    action: 'delete'
                                },
                                url: url + "index.php?controller=Member&action=delete",
                                success: function (res) {

                                    if (cat === '1') {
                                        $('#tab_1').html(res);

                                        if ($('#tab-1-table-id').length > 0) {
                                            $('#tab-1-table-id').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [6, 7]}
                                                ]
                                            });
                                        }
                                    } else if (cat === '2') {
                                        $('#tab_2').html(res);

                                        if ($('#tab-2-table-id').length > 0) {
                                            $('#tab-2-table-id').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [6, 7]}
                                                ]
                                            });
                                        }
                                    } else if (cat === '3') {
                                        $('#tab_3').html(res);

                                        if ($('#tab-3-table-id').length > 0) {
                                            $('#tab-3-table-id').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [6, 7]}
                                                ]
                                            });
                                        }
                                    } else if (cat === '4') {
                                        $('#tab_4').html(res);

                                        if ($('#tab-4-table-id').length > 0) {
                                            $('#tab-4-table-id').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [6, 7]}
                                                ]
                                            });
                                        }
                                    } else if (cat === '5') {
                                        $('#tab_5').html(res);

                                        if ($('#tab-5-table-id').length > 0) {
                                            $('#tab-5-table-id').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [6, 7]}
                                                ]
                                            });
                                        }
                                    } else if (cat === '6') {
                                        $('#tab_6').html(res);

                                        if ($('#tab-6-table-id').length > 0) {
                                            $('#tab-6-table-id').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [6, 7]}
                                                ]
                                            });
                                        }
                                    }
                                    else if (cat === '7') {
                                        $('#tab_7').html(res);

                                        if ($('#tab-7-table-id').length > 0) {
                                            $('#tab-7-table-id').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [6, 7]}
                                                ]
                                            });
                                        }
                                    }
                                    else if (cat === '8') {
                                        $('#tab_8').html(res);

                                        if ($('#tab-8-table-id').length > 0) {
                                            $('#tab-8-table-id').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [6, 7]}
                                                ]
                                            });
                                        }
                                    }

                                    $(".overlay").css('display', 'none');
                                    $(".loading-img").css('display', 'none');
                                }
                            });
                            $(this).dialog('close');
                        }
                    }, {
                        html: "<i class='fa fa-times'></i>&nbsp; Cancel",
                        "class": "btn btn-default",
                        click: function () {
                            $(this).dialog("close");
                        }
                    }]
            });
        }

        if ($("#dialogDeleteSelected").length > 0) {
            $("#dialogDeleteSelected").dialog({
                autoOpen: false,
                resizable: false,
                draggable: false,
                height: 220,
                modal: true,
                buttons: [{
                        html: "<i class='fa fa-trash-o'></i>&nbsp; Delete selected",
                        "class": "btn btn-danger",
                        click: function () {
                            $(".overlay").css('display', 'block');
                            $(".loading-img").css('display', 'block');

                            $("#table-frm-id").ajaxForm({
                                target: '#table-frm-id',
                                success: function () {
                                    if ($('#gz-abc-member-ID').length > 0) {
                                        $('#gz-abc-member-ID').dataTable({
                                            "aoColumnDefs": [
                                                {'bSortable': false, 'aTargets': [0, 6, 7, 8]}
                                            ]
                                        });
                                    }
                                    $(".overlay").css('display', 'none');
                                    $(".loading-img").css('display', 'none');
                                }
                            }).submit();
                            $(this).dialog('close');
                        }
                    }, {
                        html: "<i class='fa fa-times'></i>&nbsp; Cancel",
                        "class": "btn btn-default",
                        click: function () {
                            $(this).dialog("close");
                        }
                    }]
            });
        }


        if ($("#dialogDeleteSelected").length > 0) {
            $("#dialogDeleteSelected").dialog({
                autoOpen: false,
                resizable: false,
                draggable: false,
                height: 220,
                modal: true,
                buttons: [{
                        html: "<i class='fa fa-trash-o'></i>&nbsp; Delete selected",
                        "class": "btn btn-danger",
                        click: function () {
                            $(".overlay").css('display', 'block');
                            $(".loading-img").css('display', 'block');

                            $("#table-frm-id").ajaxForm({
                                target: '#table-frm-id',
                                success: function () {
                                    if ($('#gz-abc-member-ID').length > 0) {
                                        $('#gz-abc-member-ID').dataTable({
                                            "aoColumnDefs": [
                                                {'bSortable': false, 'aTargets': [0, 6, 7, 8]}
                                            ]
                                        });
                                    }
                                    $(".overlay").css('display', 'none');
                                    $(".loading-img").css('display', 'none');
                                }
                            }).submit();
                            $(this).dialog('close');
                        }
                    }, {
                        html: "<i class='fa fa-times'></i>&nbsp; Cancel",
                        "class": "btn btn-default",
                        click: function () {
                            $(this).dialog("close");
                        }
                    }]
            });
        }

        $("body").delegate(".calculate-price-class", "click", function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                dataType: 'json',
                data: $(".booking-frm-class").serialize(),
                url: url + "index.php?controller=Booking&action=calculatePrice",
                success: function (json) {

                    $("#calendars_price").val(json.calendars_price);
                    $("#extra_price").val(json.extra_price);
                    $("#tax").val(json.tax);
                    $("#security").val(json.security);
                    $("#deposit").val(json.deposit);
                    $("#discount").val(json.discount);
                    $("#total").val(json.total);
                }
            });
        });

        if ($("#new_booking").length > 0) {
            $("#new_booking").validate();
        }

        $("#new_booking").delegate("#payment_method", "change", function (e) {

            if ($(this).val() == 'credit_card') {
                $("#credit_card_details").show();
            } else {
                $("#credit_card_details").hide();
            }
        });

        $("#cal-container").delegate(".calendar", "click", function (e) {
            e.preventDefault();
        });

        $("#cal-container").delegate(".reserved", "click", function (e) {
            e.preventDefault();
            var $this = $(this);
            $.ajax({
                type: "post",
                data: {
                    timestamp: $this.attr('rev')
                },
                url: url + "index.php?controller=Booking&action=getBooking",
                success: function (result) {
                    $("#booking_container").html(result);
                }
            });
        });
        
        if ($("#dialogDeleteImage").length > 0) {
            $("#dialogDeleteImage").dialog({
                autoOpen: false,
                resizable: false,
                draggable: false,
                height: 220,
                modal: true,
                close: function() {
                    $('#record_id').text('');
                },
                buttons: {
                    "Delete": function() {
                        $.ajax({
                            type: "POST",
                            data: {
                                id: $('#record_id').text(),
                                controller: 'Member',
                                action: 'deleteEditedImage'
                            },
                            url: url + "index.php?controller=Member&action=deleteEditedImage",
                            success: function(res) {
                                $("#img-file-id").html(res);
                            }
                        });
                        $(this).dialog('close');
                    },
                    'Cancel': function() {
                        $(this).dialog('close');
                    }
                }
            });
        }

        function doMemberZelleImportSearch() {
            var zelleAmount = ($('#total').val() || '').replace(/[$,\s]/g, '').trim();
            if (!zelleAmount) {
                alert('Please select membership type so the amount is calculated.');
                $('#Payment_method').val('').trigger('change');
                return;
            }

            var donorName = $.trim([
                $('[name="F_Name"]').val(),
                $('[name="M_Name"]').val(),
                $('[name="L_Name"]').val()
            ].join(' ')).replace(/\s+/g, ' ');
            if (!donorName) {
                donorName = $.trim($('#Your_Name').val() || $('[name="membername"]').val() || '');
            }

            if (!donorName) {
                $('#MemberID1').show();
                $('#zelle-manual-fields').show();
                $('#zelle-action-btns').hide();
                $('#error_code1').css({'display':'block','color':'#c0392b'}).html('Please enter your member name, then search your Zelle transaction manually below.');
                $('[name="F_Name"]').focus();
                return;
            }

            $('#error_code1').css({'display':'block','color':'#357ca5'}).html('<i class="fa fa-spinner fa-spin"></i> Searching your Zelle transaction...');
            $('#MemberID1').show();
            $('#zelle-no-match').hide();
            $('#MemberID').hide().empty().append('<option value="">Please select your Zelle transaction</option>');
            $('#member_btn_id').prop('disabled', true).addClass('disabled');
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
                        $('#zelle-manual-fields').show();
                        $('#zelle-action-btns').hide();
                        return;
                    }
                    var opts = $(trimmed);
                    $('#MemberID').empty()
                        .append('<option value="">Please select your Zelle transaction</option>')
                        .append(opts)
                        .show();
                    $('#zelle-action-btns').show();
                    $('#zelle-manual-fields').hide();
                    $('#zelle-no-match').hide();
                    if (opts.length === 1) {
                        $('#MemberID').val(opts.first().val()).trigger('change');
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

        if ($("#email_message_id").length > 0) {
            tinymce.init({
                file_browser_callback: function (field, url, type, win) {
                    tinyMCE.activeEditor.windowManager.open({
                        file: 'core/libs/kcfinder/browse.php?opener=tinymce4&field=' + field + '&type=' + type,
                        title: 'KCFinder',
                        width: 700,
                        height: 500,
                        inline: true,
                        close_previous: false
                    }, {
                        window: win,
                        input: field
                    });
                    return false;
                },
                selector: "textarea",
                theme: "modern",
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "emoticons template paste textcolor colorpicker textpattern"
                ],
                toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                toolbar2: "print preview media | forecolor backcolor emoticons",
                image_advtab: true,
                templates: [
                    {title: 'Test template 1', content: 'Test 1'},
                    {title: 'Test template 2', content: 'Test 2'}
                ],
                relative_urls: false,
                remove_script_host: false,
                convert_urls: true,
            });
        }
    });
}(jQuery));

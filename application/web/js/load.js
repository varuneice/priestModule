/*!
 * Time Slot Booking Calendar v1.0
 * http://gzscripts.com/home.html
 *
 * Copyright 2015, GzScript Ltd.
 *
 * Date: Mon March 2 23:42:58 2014 +0300
 */

var gz$ = jQuery.noConflict();
var flag = false;
(function (window, undefined) {
    "use strict";
    window.GzAvailabilityCalendar = GzAvailabilityCalendar;

    var server = gz$("#server-id").text();
    function stopLaddaSoon() {
        Ladda.stopAll();
        setTimeout(function () {
            Ladda.stopAll();
        }, 0);
    }
    function resetZelleUi(hideSection) {
        gz$('#Zellecode').val('');
        gz$('#MemberID').hide().empty().append('<option value="">Please select your Zelle transaction</option>').prop('required', false);
        gz$('#zelle-action-btns').hide();
        gz$('#zelle-manual-fields').hide();
        gz$('#zelle-no-match').hide();
        gz$('#error_code1').empty().hide();
        gz$('#error_codeimg').empty().hide();
        gz$('#checkPaymentData').show();
        if (hideSection) {
            gz$('#MemberID1').hide();
        }
    }

    gz$('.gzABCalCell').tooltipster({
        contentAsHTML: true,
        multiple: true,
        animation: 'grow',
        delay: 200
    });
    gz$("#gz-abc-main-container").delegate(".gz-current", "click", function (e) {
        e.preventDefault();

        if (gz$("#first-languages").is(':visible')) {
            gz$("#first-languages").slideUp();
        } else {
            gz$("#first-languages").slideDown();
        }
    }).delegate("#first-languages a", "click", function (e) {
        var lang = gz$(this).attr('rel');
        var request = gz$.ajax({
            type: "GET",
            data: gz$("#lang-frm-id").serialize(),
            url: server + "load.php?controller=GzFront&action=calendars&lang=" + lang,
            beforeSend: function () {
            },
            success: function (res) {
                gz$("#gz-abc-main-container").html(res);
                gz$.each(GzAvailabilityCalendarObj, function (key, value) {
                    GzAvailabilityCalendarObj[key] = new GzAvailabilityCalendar(value.options);
                });
            }
        });
    });

    function GzAvailabilityCalendar(options) {
        if (!(this instanceof GzAvailabilityCalendar)) {
            return new GzAvailabilityCalendar(options);
        }
        this.reset.call(this);
        this.init.call(this, options);
        return this;
    }
    GzAvailabilityCalendar.inObject = function (val, obj) {
        var key;
        for (key in obj) {
            if (obj.hasOwnProperty(key)) {
                if (obj[key] == val) {
                    return true;
                }
            }
        }
        return false;
    };
    GzAvailabilityCalendar.size = function (obj) {
        var key,
            size = 0;
        for (key in obj) {
            if (obj.hasOwnProperty(key)) {
                size += 1;
            }
        }
        return size;
    };
    GzAvailabilityCalendar.compare = function (obj1, obj2) {
        var p;
        for (p in obj1) {
            if (obj2[p] === undefined) {
                return false;
            }
        }
        for (p in obj1) {
            if (obj1[p]) {
                switch (typeof (obj1[p])) {
                    case 'object':
                        if (!obj1[p].equals(obj2[p])) {
                            return false;
                        }
                        break;
                    case 'function':
                        if (obj2[p] === undefined || (p != 'equals' && obj1[p].toString() != obj2[p].toString())) {
                            return false;
                        }
                        break;
                    default:
                        if (obj1[p] != obj2[p]) {
                            return false;
                        }
                }
            } else {
                if (obj2[p]) {
                    return false;
                }
            }
        }
        for (p in obj2) {
            if (obj1[p] === undefined) {
                return false;
            }
        }
        return true;
    };

    GzAvailabilityCalendar.prototype = {
        reset: function () {
            this.lang = null;
            this.$container = null;
            this.container = null;
            this.date = null;
            this.dateTo = null;
            this.promo_code = null;
            this.selectorClick = ".gzABCalCellAvil, .gzABCalCellPending, .gzABCalCellReserved";
          
            this.slot = null;
            this.date = null;
            this.count = null;
            this.options = {};
            return this;
        },
        init: function (opts) {
            var self = this;
            this.options = opts;

            this.$gzCalContainer = gz$("#gz-abc-main-container-" + this.options.cal_id);
            this.$gzABCalendar = gz$("#gz-abc-calendar-container-" + this.options.cal_id);

            setTimeout(function () {
                gz$(".overlay").hide();
            }, 2000);

            Ladda.bind('#booking_frm_btn_id');

            if (self.options.stripe_allow === '1' && self.options.stripe_publish_key !== '') {

                var stripe_publish_key = self.options.stripe_publish_key;
                self.stripe = Stripe(stripe_publish_key);
                var elements = self.stripe.elements();
            }

            this.$gzCalContainer.delegate("#Puja", "change", function (e) {
                self.calculatePrice.call(self, this);
            }).delegate("#Puja2", "change", function (e) {
                self.calculatePrice.call(self, this);
            }).delegate("#Puja3", "change", function (e) {
                self.calculatePrice.call(self, this);
            }).delegate("#radioForm", "change", function (e) {
               
               
                e.preventDefault();  // Prevent form submission or other default actions

    var selectedValue = gz$('input[name="option"]:checked').val(); 
    self.getTimeSlotLocation.call(self, e.target, selectedValue);
            }).delegate('#confirm_code', 'change', function (event) {
                self.checkCode.call(self, this);
            }).delegate('#MemberID', 'change', function (event) {
                self.checkCodeDDSelect.call(self, this);
            }).delegate('#Puja', 'change', function (event) {
                self.blankpaymentDD.call(self, this);
            }).delegate('#checkamount', 'change', function (e) {
            e.stopImmediatePropagation();
           
            var checkamount = gz$("#checkamount").val();
            var Totala = gz$("#total").text(); 
            var totalprice = Totala.replace(/[^0-9.]/g, '').trim(); 
          
            if( checkamount != totalprice ){
                alert('puja price and check amount not same please fill correct amount');
                gz$("#payment_btn_id").addClass('disabled');
            }
            else{
                // added newly
                gz$("#payment_btn_id").prop("disabled", false);
                gz$("#payment_btn_id").removeClass('disabled');
            }

        }).delegate(self.selectorClick, "click", function (e) {
                e.preventDefault();
                self.date = gz$(this).attr('data-timestamp');
                self.getTimeSlot.call(self, this);
                //  document.getElementById("timeSlot").style.display = "block"
            }).delegate("#back_to_calendar_id", "click", function (e) {
                e.preventDefault();
                self.ABCCalendar.call(self, this);
            }).delegate("#booking_frm_btn_id", "click", function (e) {
                e.preventDefault();
                self.ABCBookingForm.call(self);
            }).delegate("#details_frm_btn_id", "click", function (e) {
                e.preventDefault();
                if (gz$(this).hasClass('disabled') || gz$(this).prop('disabled')) {
                    stopLaddaSoon();
                    return false;
                }
                if (gz$('#payment_method').val() === 'others' && !gz$.trim(gz$('#Zellecode').val() || '')) {
                    stopLaddaSoon();
                    gz$('#MemberID1').show();
                    gz$('#zelle-manual-fields').show();
                    gz$('#error_code1').css({'display':'block','color':'#c0392b'}).html('Please verify and select your Zelle transaction before continuing.');
                    return false;
                }
                var selectedValue = gz$('input[name="option"]:checked').val(); 
                self.ABCDetailForm.call(self , selectedValue);
            }).delegate("#back_to_booking_frm_id", "click", function (e) {
                e.preventDefault();
                self.ABCBookingForm.call(self);
            }).delegate("#back_booking_frm_btn_id", "click", function (e) {
                e.preventDefault();
                self.ABCBackToBookingForm.call(self, this);
            }).delegate("#checkout_frm_btn_id", "click", function (e) {
                e.preventDefault();
                if (gz$(this).hasClass('disabled') || gz$(this).prop('disabled')) {
                    stopLaddaSoon();
                    return false;
                }
                if (gz$('#payment_method').val() === 'others' && !gz$.trim(gz$('#Zellecode').val() || '')) {
                    stopLaddaSoon();
                    alert('Please go back and verify your Zelle transaction before booking.');
                    return false;
                }
                self.ABCCheckoutForm.call(self, this);
            }).delegate("#change-date-id", "click", function (e) {
                e.preventDefault();
                self.ABCCalendar.call(self, this);
            }).delegate("#terms_link", 'click', function (e) {
                e.preventDefault();
                gz$("#dialogTerms").dialog({
                    autoOpen: true,
                    resizable: false,
                    draggable: false,
                    width: 600,
                    modal: true
                });
            }).delegate(".gzABCalCellArrow", "click", function (e) {
                self.options.month = gz$(this).attr('data-month');
                self.options.year = gz$(this).attr('data-year');
                self.ABCCalendar.call(self, this);
            }).delegate("#payment_method", "change", function (e) {

                if (gz$(this).val() == 'credit_card') {
                    resetZelleUi(true);
                    gz$("#details_frm_btn_id").prop('disabled', false).removeClass('disabled');
                    gz$("#bank_acount_details").hide();
                    gz$("#others_details").hide();
                    gz$("#credit_card_details").show();
                } else if (gz$(this).val() == 'bank_acount') {
                    resetZelleUi(true);
                    gz$("#details_frm_btn_id").prop('disabled', false).removeClass('disabled');
                    gz$("#bank_acount_details").show();
                    gz$("#credit_card_details").hide();
                    gz$("#stripe_details").hide();
                    gz$("#others_details").hide();
                } else if (gz$(this).val() == 'others') {
                    resetZelleUi(false);
                    gz$("#stripe_details").hide();
                    gz$("#others_details").hide();
                    gz$("#bank_acount_details").hide();
                    gz$("#credit_card_details").hide();
                    gz$("#checkdata").hide();
                    gz$('#details_frm_btn_id').prop('disabled', true).addClass('disabled');
                    gz$('#zelle-modal-img').attr('src', gz$("#container-abc-url-id").text() + 'zelle.png');
                    gz$('#zelle-modal-overlay').css('display', 'flex');
                    gz$.post(gz$("#container-abc-url-id").text() + 'load.php?controller=GzFront&action=importZelleAndSearch', {});
                } else if (gz$(this).val() == 'stripe') {
                    resetZelleUi(true);
                    gz$("#details_frm_btn_id").prop('disabled', false).removeClass('disabled');
                    gz$("#others_details").hide();
                    gz$("#bank_acount_details").hide();
                    gz$("#credit_card_details").hide();
                    gz$("#stripe_details").show();
                    if (gz$(".StripeElement").length > 0) {
                    } else {
                        var elements = self.stripe.elements();
                        self.card = elements.create('card');
                        self.card.mount('#stripe_details');
                    }
                }
                else if (gz$(this).val() == 'check') {
                resetZelleUi(true);
                gz$("#stripe_details").hide();
                gz$("#others_details").hide();
                gz$("#checkdata").show();
                gz$("#details_frm_btn_id").prop('disabled', false).removeClass('disabled');

                gz$("#checkbankname").val("");
                gz$("#checkno").val("");
                gz$("#checkamount").val("");
                gz$("#checkdate").val("");
                gz$("#checkbankname").prop('required', true);
                gz$("#checkno").prop('required', true);
                gz$("#checkamount").prop('required', true);
                gz$("#checkdate").prop('required', true);

                gz$("#MemberID").prop('required', false);
            }
                else {
                    resetZelleUi(true);
                    gz$("#details_frm_btn_id").prop('disabled', false).removeClass('disabled');
                    gz$("#bank_acount_details").hide();
                    gz$("#credit_card_details").hide();
                    gz$("#others_details").hide();
                    gz$("#stripe_details").hide();

                }
            }).delegate(".gzTimeSlotDropDownClass", "change", function (e) {
                self.slot = gz$(this).attr('data-start-time');
                self.date = gz$(this).attr('data-date');
                self.count = gz$(this).val();
                self.addTimseSlot.call(self, this);
                gz$('#booking_frm_btn_id').removeClass("disabled");
            }).delegate(".gzTimeSlotButtonPlusClass", "click", function (e) {
                
                debugger;
                self.slot = gz$(this).attr('data-start-time');
                self.date = gz$(this).attr('data-date');
                self.count = 1;
                
                self.addTimseSlot.call(self, this);

                // gz$(this).removeClass();
                let selectedLocation1 = gz$('input[name="option"]:checked').val(); 
                if(selectedLocation1 == "2")
                    {
                        const checkboxes = document.querySelectorAll('[location="outside"]');

                            checkboxes.forEach(box => {
                             box.classList.remove('fa-minus-square', 'gzTimeSlotButtonMinusClass');
                             box.classList.add('fa-plus-square', 'gzTimeSlotButtonPlusClass');
                            });

                            e.target.classList.remove('fa-plus-square', 'gzTimeSlotButtonPlusClass');
                            e.target.classList.add('fa-minus-square', 'gzTimeSlotButtonMinusClass');
    
                    }
                    else
                    {gz$(this).removeClass();
                        gz$(this).addClass('gzTimeSlotButtonMinusClass fa fa-fw fa-minus-square');
                    }
                // gz$(this).addClass('gzTimeSlotButtonMinusClass fa fa-fw fa-minus-square');

                gz$('#booking_frm_btn_id').removeClass("disabled");
            }).delegate(".gzTimeSlotButtonMinusClass", "click", function (e) {
                self.slot = gz$(this).attr('data-start-time');
                self.date = gz$(this).attr('data-date');
                self.count = 1;
                self.removeTimseSlot.call(self, this);

                // gz$(this).removeClass();
                let selectedLocation2 = gz$('input[name="option"]:checked').val();
                
                if(selectedLocation2 == "2")
                {
                    const checkboxes = document.querySelectorAll('[location="outside"]');
  
   
                    checkboxes.forEach(box => {
                            box.classList.remove('fa-minus-square', 'gzTimeSlotButtonMinusClass');
                            box.classList.add('fa-plus-square', 'gzTimeSlotButtonPlusClass');
                        });
    
                }

                else
                { 
                    gz$(this).removeClass();
                    gz$(this).addClass('gzTimeSlotButtonPlusClass fa fa-fw fa-plus-square');
                }

                if(selectedLocation2 == "1")
                {
                    const matchingATags = document.querySelectorAll('a.gzTimeSlotButtonMinusClass[data-location="1"]');
                    const count = matchingATags.length;
                    if(count < 1)
                    {
                        gz$('#booking_frm_btn_id').addClass("disabled");
                    }
                }

                else
                {
                    gz$('#booking_frm_btn_id').addClass("disabled");
                }

                


                // gz$(this).addClass('gzTimeSlotButtonPlusClass fa fa-fw fa-plus-square');
            }).delegate(".gzRemoveTimeSlotClass", "click", function (e) {
                self.slot = gz$(this).attr('data-start-time');
                self.date = gz$(this).attr('data-date');
                self.count = 1;
                self.removeTimseSlot.call(self, this);
                gz$(this).parent().parent().remove();

                if (!(gz$(".gzRemoveTimeSlotClass").length > 0)) {
                    gz$("#details_frm_btn_id").addClass('disabled');
                }
            }).delegate(".showMinCalendar", "click", function (e) {

                if (gz$(this).find('i').hasClass('fa-angle-down')) {
                    gz$(this).find('i').removeClass('fa-angle-down');
                    gz$(this).find('i').addClass('fa-angle-up');
                    gz$("#miniCalendarId").show();
                } else {
                    gz$(this).find('i').addClass('fa-angle-down');
                    gz$(this).find('i').removeClass('fa-angle-up');
                    gz$("#miniCalendarId").hide();
                }
            }).delegate(".recalculate", "click", function (e) {
                e.preventDefault();
                self.calculatePrice.call(self, this);
            });
        },
        checkCode: function (e) {
            debugger
            var self = this;
            gz$("#error_code1").css('display', 'none');
            gz$("#error_codeimg").css('display', 'none');
            var frm = gz$("#gz-time-slot-booking-form-id");
            gz$.LoadingOverlay("show");
            //gz$(".overlay").css('display', 'block');
            //gz$(".loading-img").css('display', 'block');
            gz$.ajax({
                type: "POST",
                data: frm.serialize(),
                url: self.options.server + "load.php?controller=GzFront&action=checkCode&cid=" + self.options.cal_id,
                success: function (res) {

                    gz$.LoadingOverlay("hide");
                    //gz$(".overlay").css('display', 'none');
                    //gz$(".loading-img").css('display', 'none');
                    var check = res.includes("Your payment code is matched you can book");
                    if (check == true) {
                        gz$("#details_frm_btn_id").removeClass('disabled');


                    }
                    else {
                        gz$("#details_frm_btn_id").addClass('disabled');


                    }
                    gz$('#error_code').html(res);

                }
            });
        },
        blankpaymentDD: function (e) {
            
                    gz$('#MemberID').empty(); //remove all child nodes
                    var newOption1 = gz$('<option value="1">Please select your payment details</option>');
                    gz$('#MemberID').append(newOption1);
                   
                    gz$('#MemberID').trigger("chosen:updated");
                     
                    
                
           
        },
        checkCode1: function (e) {
            var self = this;
            gz$("#error_code1").css('display', 'none');
            gz$("#error_codeimg").css('display', 'none');
            var frm = gz$("#gz-time-slot-booking-form-id");
            gz$.LoadingOverlay("show");
            //gz$(".overlay").css('display', 'block');
            //gz$(".loading-img").css('display', 'block');
            gz$.ajax({
                type: "POST",
                data: frm.serialize(),
                url: self.options.server + "load.php?controller=GzFront&action=checkCode&cid=" + self.options.cal_id,
                success: function (res) {
                    gz$.LoadingOverlay("hide");
                    //gz$(".overlay").css('display', 'none');
                    //gz$(".loading-img").css('display', 'none');
                    var check = res.includes("Your payment code is matched you can book");
                    if (check == true) {
                        gz$("#details_frm_btn_id").removeClass('disabled');


                    }
                    else {
                        gz$("#details_frm_btn_id").addClass('disabled');


                    }
                    gz$('#error_code').html(res);

                }
            });
        },
        checkCodeDD: function (e) {
            var self = this;
            gz$("#details_frm_btn_id").addClass('disabled');
            var frm = gz$("#gz-time-slot-booking-form-id");
            //gz$.LoadingOverlay("show");

            gz$.ajax({
                type: "POST",
                data: frm.serialize(),
                url: self.options.server + "load.php?controller=GzFront&action=checkCodeDD&cid=" + self.options.cal_id,
                success: function (res) {
                    gz$("#details_frm_btn_id").removeClass('disabled');
                    gz$("#details_frm_btn_id").removeClass('disabled');
                    var myString = res.replace("echo", '');
                    var myString1 = myString.replace("", '');
                    //= myString.replace("",'');
                    gz$('#MemberID').empty(); //remove all child nodes
                    var newOption = gz$(myString1);
                    var newOption1 = gz$('<option value="1">Please select your payment details</option>');
                    gz$('#MemberID').append(newOption1);
                    gz$('#MemberID').append(newOption);
                    gz$('#MemberID').trigger("chosen:updated");
                    var dd = gz$("#MemberID").val();
                   
                    if (dd == "1") {
                        gz$("#details_frm_btn_id").addClass('disabled');
                    }
                    //  var parts = myString1.split("/"); 
                    //  var cmCode =parts[3];
                }
            });
        },
         checkCodeDDSelect: function (e) {

            var dd = gz$("#MemberID").val();
            gz$("#Zellecode").val('');
            gz$("#details_frm_btn_id").prop('disabled', true).addClass('disabled');

            if (!dd || dd === "1") {
                return;
            }

            var parts = dd.split("/");
            var cmCode = gz$.trim(parts[3] || '');
            var name =parts[1];
            var price = parts[2] ? parseFloat(parts[2].replace(/[$,\s]/g, '').trim()) : NaN;
            var tot   = parseFloat(gz$("#total").text().replace(/[$,\s]/g, '').trim());
            if(cmCode){
                gz$("#Zellecode").val(cmCode);
                }

                    if(!isNaN(tot) && !isNaN(price) && tot === price && cmCode){
                        gz$('#error_code1').empty().hide();
                        gz$('#zelle-no-match').hide();
                        gz$('#zelle-manual-fields').hide();
                        gz$('#zelle-action-btns').hide();
                        gz$("#details_frm_btn_id").prop('disabled', false).removeClass('disabled');
                    }
                    else{

                        gz$("#Zellecode").val('');
                        gz$("#details_frm_btn_id").prop('disabled', true).addClass('disabled');
                        gz$('#zelle-no-match').hide();
                        gz$('#error_code1').css({'display':'block','color':'#c0392b'}).html('Selected Zelle amount does not match the booking amount. Please select the correct transaction.');
                        alert('Total price and selected Zelle amount do not match. Please select the correct transaction.');
                    }
            //gz$.LoadingOverlay("show");

            // gz$.ajax({
            //     type: "POST",
            //     data: {
            //         code: cmCode
            //     },
            //     url: self.options.server + "load.php?controller=GzFront&action=UpdateCodeData&cid=" + self.options.cal_id,
            //     success: function (res) {
            //         gz$("#details_frm_btn_id").removeClass('disabled');
            //         gz$('#error_code').html(res);
            //     }

            // });
        },
        addTimseSlot: function (e) {
            var self = this;
            var selectedValue = gz$('input[name="option"]:checked').val(); 
            debugger;

            gz$.ajax({
                type: "POST",
                data: {
                    date: self.date,
                    slot: self.slot,
                    count: self.count,
                    cal_id: self.options.cal_id ,
                    cal_location : selectedValue
                },
                url: self.options.server + "load.php?controller=GzFront&action=addTimeSlot&cid=" + self.options.cal_id,
                success: function (res) {
                }
            });
        },
        removeTimseSlot: function (e) {
            var self = this;

            gz$.ajax({
                type: "POST",
                data: {
                    date: self.date,
                    slot: self.slot,
                    count: self.count,
                    cal_id: self.options.cal_id
                },
                url: self.options.server + "load.php?controller=GzFront&action=removeTimeSlot&cid=" + self.options.cal_id,
                success: function (res) {

                    self.calculatePrice.call(self, this);
                }
            });
        },
        getTimeSlot: function (e) {
            debugger;
            var self = this;
            gz$.ajax({
                type: "POST",
                data: {
                    date: self.date,
                    cal_id: self.options.cal_id
                    
                },
                url: self.options.server + "load.php?controller=GzFront&action=getTimeSlot&cid=" + self.options.cal_id,
                success: function (res) {
                    gz$(self.$gzABCalendar).html(res);

                    Ladda.bind('#booking_frm_btn_id');
                    Ladda.bind('#back_to_calendar_id');
                    
                }
            });
        },
        getTimeSlotLocation: function (e,selectedValue) {
           var self = this;
          
            gz$.ajax({
                type: "POST",
                data: {
                    date: self.date,
                    cal_id: self.options.cal_id,
                    cal_locationID: selectedValue  // The selected value of the radio button
                },
                url: self.options.server + "load.php?controller=GzFront&action=getTimeSlot&cid=" + self.options.cal_id,
                
                success: function (res) {
                   console.log(res);
                    gz$(self.$gzABCalendar).html(res);
                    gz$('input[name="option"][value="' + selectedValue + '"]').prop('checked', true);
                     Ladda.bind('#booking_frm_btn_id');
                     Ladda.bind('#back_to_calendar_id');
                     document.getElementById("timeSlot").style.display = "block"
                    
                }
            });
        },
        
        ABCBookingForm: function () {
            var self = this;
            var selectedValue = gz$('input[name="option"]:checked').val(); 
            debugger
            var slote;
            slote = flag ? 360 : 0;
            gz$.ajax({
                type: "POST",
                data: {
                    start_date: self.start_date,
                    end_date: self.end_date,
                    cal_id: self.options.cal_id ,
                    location :selectedValue,
                    time_slote :slote
                },

                url: self.options.server + "load.php?controller=GzFront&action=booking_form&cid=" + self.options.cal_id,
                success: function (res) {
                    debugger

                    gz$(self.$gzABCalendar).html(res);
                    self.galleryBind.call(self);

                    if (gz$("#payment_method").val() === 'stripe') {

                        gz$("#stripe_details").show();

                        if (gz$(".StripeElement").length > 0) {
                        } else {
                            var elements = self.stripe.elements();
                            self.card = elements.create('card');
                            self.card.mount('#stripe_details');
                        }
                    }

                    Ladda.bind('#details_frm_btn_id');
                    Ladda.bind('#back_to_calendar_id');

                }
            });

        },
        ABCBackToBookingForm: function () {
            var self = this;
            var frm = gz$("#gz-abc-form-id");

            gz$.ajax({
                type: "POST",
                data: frm.serialize(),
                url: self.options.server + "load.php?controller=GzFront&action=booking_form&cid=" + self.options.cal_id,
                success: function (res) {
                    gz$(self.$gzABCalendar).html(res);
                    self.galleryBind.call(self);

                    if (gz$("#payment_method").val() === 'stripe') {

                        gz$("#stripe_details").show();

                        if (gz$(".StripeElement").length > 0) {
                        } else {
                            var elements = self.stripe.elements();
                            self.card = elements.create('card');
                            self.card.mount('#stripe_details');
                        }
                    }

                    Ladda.bind('#booking_frm_btn_id');
                    Ladda.bind('#back_to_calendar_id');
                }
            });
        },
        ABCCalendar: function () {
            var self = this;

            gz$.ajax({
                type: "POST",
                data: {
                    cal_id: self.options.cal_id,
                    month: self.options.month,
                    year: self.options.year
                },
                url: self.options.server + "load.php?controller=GzFront&action=calendar&cid=" + self.options.cal_id + "&view_month=" + self.options.view_month,
                success: function (res) {
                    gz$(self.$gzABCalendar).html(res);
                    if (self.start_date != null) {
                        var $this = gz$("[data-timestamp='" + self.start_date + "']");
                        $this.addClass('gzABCalFirstSelect');
                        $this.addClass('gzABCalCellSelected');
                    }
                    gz$('.gzABCalCell').tooltipster({
                        contentAsHTML: true,
                        multiple: true,
                        animation: 'grow',
                        delay: 200
                    });
                    Ladda.bind('#booking_frm_btn_id');
                }
            })
        },
        ABCDetailForm: function () {
            var self = this;
            var dd = gz$("#MemberID").val();

            var frm = gz$("#gz-time-slot-booking-form-id");
            if (gz$('#payment_method').val() === 'others' && !gz$.trim(gz$('#Zellecode').val() || '')) {
                stopLaddaSoon();
                gz$('#MemberID1').show();
                gz$('#zelle-manual-fields').show();
                gz$('#error_code1').css({'display':'block','color':'#c0392b'}).html('Please verify and select your Zelle transaction before continuing.');
                return false;
            }
            if (dd != null) {
                var parts = dd.split("/");
                var cmCode = parts[3];
            }
            //gz$.LoadingOverlay("show");

            // gz$.ajax({
            //     type: "POST",
            //     data: {
            //         code: cmCode
            //     },
            //     url: self.options.server + "load.php?controller=GzFront&action=UpdateCodeData&cid=" + self.options.cal_id,
            //     success: function (res) {
            //         gz$("#details_frm_btn_id").removeClass('disabled');
            //         gz$('#error_code').html(res);
            //     }

            // });
            
            var frm = gz$("#gz-time-slot-booking-form-id");
            //jQuery.validator.methods.matches = function (value, element, params)
            gz$.validator.methods.matches = function (value, element, params) {
                var re = new RegExp(params);
                // window.console.log(re);
                // window.console.log(value);
                // window.console.log(re.test( value ));
                return this.optional(element) || re.test(value);
            }
            //jQuery.validator.addMethod("lettersonly", function (value, element)
            gz$.validator.addMethod("lettersonly", function (value, element) {
                return this.optional(element) || /^[a-z]+$/i.test(value);
            }, "Letters only please");

            frm.validate({
                rules: {
                    first_name: { lettersonly: true },
                    second_name: { lettersonly: true },
                    phone: {
                        matches: "^(\\d|\\s)+$",
                    }
                }
            });

            if (frm.valid()) {

                if (gz$('#payment_method').val() == 'stripe') {

                    self.createToken.call(self, this);
                } else {

                    gz$.ajax({
                        type: "POST",
                       
                        data: frm.serialize(),
                        url: self.options.server + "load.php?controller=GzFront&action=booking_details&cid=" + self.options.cal_id,
                        timeout: 45000,
                        success: function (res) {
                            Ladda.stopAll();
                            if (!gz$.trim(res)) {
                                alert('Could not continue booking. Please verify the form and try again.');
                                return;
                            }
                            gz$(self.$gzABCalendar).html(res);

                            Ladda.bind('#back_booking_frm_btn_id');
                            Ladda.bind('#checkout_frm_btn_id');
                        },
                        error: function () {
                            Ladda.stopAll();
                            alert('Could not submit booking. Please try again.');
                        }
                    });
                }
            } else {
                stopLaddaSoon();
            }
        },
        ABCCheckoutForm: function () {
            var self = this;
            debugger
            var frm = gz$("#gz-abc-form-id");
            if (gz$('#payment_method').val() === 'others' && !gz$.trim(gz$('#Zellecode').val() || '')) {
                stopLaddaSoon();
                alert('Please go back and verify your Zelle transaction before booking.');
                return false;
            }

            gz$.ajax({
                type: "POST",
                data: frm.serialize(),
                url: self.options.server + "load.php?controller=GzFront&action=checkout&cid=" + self.options.cal_id,
                timeout: 60000,
                success: function (res) {
                    Ladda.stopAll();
                    if (!gz$.trim(res)) {
                        alert('Could not complete booking. Please try again.');
                        return;
                    }
                    gz$(self.$gzABCalendar).html(res);
                    if (gz$("#gz-hotel-booking-pay-frm-id").length > 0) {
                        gz$("#gz-hotel-booking-pay-frm-id").submit();
                    }
                },
                error: function () {
                    Ladda.stopAll();
                    alert('Could not complete booking. Please try again.');
                }
            });
        },
        createToken: function (status, response) {
            var self = this;

            self.stripe.createToken(self.card).then(function (result) {

                var err = result.error;
                if (typeof result.error !== "undefined") {



                    var $el = "<div> <label class='error' style='width: 100%; margin-top:508px; padding:13px;'>" + result.error.message + "</label></div>"
                    gz$(".card-errors").html($el);

                    Ladda.stopAll();
                } else {

                    var token = result.token;
                    var frm = gz$("#gz-time-slot-booking-form-id");
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', token.id);
                    frm.append(hiddenInput);

                    if (frm.valid()) {
                        gz$.ajax({
                            type: "POST",
                            data: frm.serialize(),
                            url: self.options.server + "load.php?controller=GzFront&action=booking_details&cid=" + self.options.cal_id,
                            success: function (res) {
                                gz$(self.$gzABCalendar).html(res);

                                Ladda.bind('#back_booking_frm_btn_id');
                                Ladda.bind('#checkout_frm_btn_id');
                            }
                        });
                    } else {
                        Ladda.stopAll();
                    }
                }
            });
        },
        galleryBind: function () {
            gz$(".gz-gallery-first").each(function (i, obj) {

                var gclass = gz$(this).attr('rel');
                gz$("." + gclass + "").colorbox({ rel: gclass, transition: "none", width: "85%", height: "85%" });
            });
        },
        calculatePrice: function () {
            var self = this;

            var frm = gz$('#gz-time-slot-booking-form-id');
            var promo_code = 0;

            if (typeof gz$('#promo_code') !== 'undefined') {

                promo_code = gz$('#promo_code').val();
            }

            gz$(".overlay").show();

            gz$.ajax({
                type: "POST",
                dataType: 'json',
                data: frm.serialize(),
                url: self.options.server + "index.php?controller=GzFront&action=calculatePrice&cid=" + self.options.cal_id,
                success: function (json) {

                    if (gz$("#calendars_price").length > 0) {
                        gz$("#calendars_price").html(json.formated_calendars_price);
                    }
                    if (gz$("#tax").length > 0) {
                        gz$("#tax").html(json.formated_tax);
                    }
                    if (gz$("#security").length > 0) {
                        gz$("#security").html(json.formated_security);
                    }
                    if (gz$("#deposit").length > 0) {
                        gz$("#deposit").html(json.formated_deposit);
                    }
                    if (gz$("#discount").length > 0) {
                        gz$("#discount").html(json.formated_discount);
                    }
                    if (gz$("#total").length > 0) {
                        gz$("#total").html(json.formated_total);
                    }
                    if (typeof promo_code !== 'undefined' && promo_code.length > 0 && json.discount == 0) {
                        gz$("#invalid_promo_code").show();
                    } else {
                        gz$("#invalid_promo_code").hide();
                    }

                    gz$(".overlay").hide();
                }
            });
        }
    }

    window.GzAvailabilityCalendar = GzAvailabilityCalendar;
})(window);

// ── OTP + Zelle Flow for Priest Booking ───────────────────────────────────────
(function ($) {
    var baseUrl = '';

    function getBaseUrl() {
        return $('#container-abc-url-id').text().trim() || gz$("#container-abc-url-id").text().trim();
    }

    function fillBookingFormFromOtp(memberId) {
        baseUrl = getBaseUrl();
        if (memberId) {
            $('#otp-session-verified').text(memberId);
        }
        var $banner = $('#otp-verified-banner');
        $banner.html('<i class="fa fa-spinner fa-spin" style="color:#357ca5;font-size:16px;"></i> Loading member data…').css('display', 'flex');

        $.ajax({
            type: 'POST',
            url: baseUrl + 'load.php?controller=Donations&action=AllMemberNew',
            data: {
                member_id: memberId || $('#otp-session-verified').text().trim(),
                memberid: memberId || $('#otp-session-verified').text().trim()
            },
            success: function (res) {
                if (!$.trim(res)) {
                    $banner.html('Could not load member data. Please refresh and try again.').css('display', 'flex');
                    return;
                }
                function val(id) {
                    var el = $(res).filter('input#' + id);
                    return el.length ? $.trim(el[0].value) : '';
                }
                var first = val('MemberName');
                var last  = val('last_name');
                var memberId = val('memberid');
                var address = $.grep([
                    val('ressidentalAddress'),
                    val('Address'),
                    val('state'),
                    val('city'),
                    val('zip_code')
                ], function (item) {
                    return !!item;
                }).join(' ');
                $('#first_name').val(first).prop('readonly', true);
                $('#second_name').val(last).prop('readonly', true);
                $('#phone').val(val('Tele1'));
                $('#email').val(val('email'));
                $('#address_1').val(address);
                $('#termMember').val(memberId);
                $('#idmem').val(memberId);
                $('#term').val($.trim(first + ' ' + last)).prop('readonly', true);
                if (memberId) {
                    $('#otp-session-verified').text(memberId);
                }
                $banner.html('<i class="fa fa-check-circle" style="color:#276632;font-size:16px;"></i> Verified &amp; auto-filled: <strong>' + $('<span>').text($.trim(first + ' ' + last)).html() + '</strong>').css('display', 'flex');
            },
            error: function () {
                $banner.html('Could not load member data. Please refresh and try again.').css('display', 'flex');
            }
        });
    }

    // OTP — member type change
    $(document).on('change', '#registrationmember', function () {
        baseUrl = getBaseUrl();
        var otpVerifiedMemberId = $('#otp-session-verified').text().trim();
        var otpSessionVerified  = !!otpVerifiedMemberId;
        var selectVal = $(this).val();

        if (selectVal === 'member') {
            $('#otp-verified-banner').css('display', 'none');
            if (otpSessionVerified) {
                fillBookingFormFromOtp(otpVerifiedMemberId);
                return;
            }
            window.OtpMemberVerify.open({
                onVerified: function (memberId) {
                    fillBookingFormFromOtp(memberId);
                }
            });
            window.onOtpModalCancelled = function () {
                $('#registrationmember').val('');
            };
        } else {
            $('#otp-verified-banner').css('display', 'none');
            $('#first_name').prop('readonly', false);
            $('#second_name').prop('readonly', false);
        }
    });

    $(function () {
        var $memberSelect = $('#registrationmember');
        if ($memberSelect.is('select')) {
            $memberSelect.val('');
            $('#otp-verified-banner').css('display', 'none');
        }
    });

    // Zelle modal — "I've Completed Zelle Payment"
    $(document).on('click', '#zelle-modal-paid-btn', function () {
        $('#zelle-modal-overlay').hide();
        doZelleImportSearch();
    });

    // Zelle modal — Cancel / X close
    $(document).on('click', '#zelle-modal-cancel-btn, #zelle-modal-close', function () {
        $('#zelle-modal-overlay').hide();
        $('#payment_method').val('').trigger('change');
        $('#details_frm_btn_id').prop('disabled', false).removeClass('disabled');
    });

    // Zelle — Verify selected transaction
    $(document).on('click', '#zelle-verify-btn', function () {
        $('#MemberID').trigger('change');
    });

    // Zelle — Retry: show manual fields
    $(document).on('click', '#zelle-retry-btn', function () {
        $('#zelle-action-btns').hide();
        $('#zelle-manual-fields').show();
        $('#MemberID').hide().empty().append('<option value="">Please select your Zelle transaction</option>');
        $('#zelle-no-match').hide();
        $('#error_code1').empty().hide();
        $('#checkPaymentData').show();
        $('#Zellecode').val('');
        $('#details_frm_btn_id').prop('disabled', true).addClass('disabled');
    });

    // Zelle — Manual verify button
    $(document).on('click', '#checkPaymentData', function (e) {
        e.preventDefault();
        baseUrl = getBaseUrl();
        var donorName = $.trim($('#zelle_donor_name').val());
        var zelleAmt  = gz$("#total").text().replace(/\s/g, '').trim();
        var zelleDate = $.trim($('#zelle_date').val());

        if (!donorName) { alert('Please enter your name as used in Zelle.'); $('#zelle_donor_name').focus(); return; }
        if (!zelleAmt)  { alert('Please select your Puja type first so the amount is calculated.'); return; }

        $('#zelle-no-match').hide();
        $('#error_code1').empty().hide();
        $('#checkPaymentData').show();
        $('#MemberID').hide().empty().append('<option value="">Please select your Zelle transaction</option>');
        $('#Zellecode').val('');
        $('#details_frm_btn_id').prop('disabled', true).addClass('disabled');

        $.ajax({
            type: 'POST',
            url: baseUrl + 'load.php?controller=GzFront&action=checkCodeDD',
            data: { donor_name: donorName, zelle_amount: zelleAmt, zelle_date: zelleDate },
            success: function (res) {
                var trimmed = $.trim(res);
                if (!trimmed || trimmed === 'NO_MATCH') { $('#zelle-no-match').show(); return; }
                var $opts = $(trimmed);
                $('#MemberID').empty().append('<option value="">Please select your Zelle transaction</option>').append($opts).show();
                $('#zelle-action-btns').show();
                $('#zelle-manual-fields').hide();
                $('#zelle-no-match').hide();
                $('#error_code1').empty().hide();
                $('#Zellecode').val('');
                $('#details_frm_btn_id').prop('disabled', true).addClass('disabled');
                if ($opts.length === 1) { $('#MemberID').val($opts.first().val()).trigger('change'); }
            },
            error: function () { alert('Could not verify Zelle payment. Please try again.'); }
        });
    });

    function doZelleImportSearch() {
        baseUrl = getBaseUrl();
        var zelleAmt = gz$("#total").text().replace(/\s/g, '').trim();
        if (!zelleAmt) {
            alert('Please select your Puja type first so the amount is calculated.');
            return;
        }

        var regVal    = $('#registrationmember').val();
        var donorName = '';

        if (regVal === 'member') {
            donorName = ($.trim($('#first_name').val()) + ' ' + $.trim($('#second_name').val())).trim();
            if (!donorName) {
                showZelleManual('Please complete OTP verification first, then search your Zelle transaction manually below.');
                return;
            }
        } else if (regVal === 'nonmember') {
            donorName = ($.trim($('#first_name').val()) + ' ' + $.trim($('#second_name').val())).trim();
            if (!donorName) {
                showZelleManual('Please enter your name above, then search your Zelle transaction manually below.');
                $('#first_name').focus();
                return;
            }
        } else {
            showZelleManual('Please select whether you are a Durga Bari member above, then search your Zelle transaction manually below.');
            $('#registrationmember').focus();
            return;
        }

        $('#error_code1').css({'display':'block','color':'#357ca5'}).html('<i class="fa fa-spinner fa-spin"></i> Searching your Zelle transaction…');
        $('#MemberID1').show();
        $('#zelle-no-match').hide();
        $('#MemberID').hide().empty().append('<option value="">Please select your Zelle transaction</option>');
        $('#Zellecode').val('');
        $('#details_frm_btn_id').prop('disabled', true).addClass('disabled');

        $.post(baseUrl + 'load.php?controller=GzFront&action=importZelleAndSearch', {});

        var today = new Date().toISOString().split('T')[0];
        $.ajax({
            type: 'POST',
            url: baseUrl + 'load.php?controller=GzFront&action=checkCodeDD',
            data: { donor_name: donorName, zelle_amount: zelleAmt, zelle_date: today },
            success: function (res) {
                var trimmed = $.trim(res);
                if (!trimmed || trimmed === 'NO_MATCH') {
                    $('#error_code1').css('color', '#c0392b').html('Transaction not found automatically. Enter your name and date below, then click <b>Verify Zelle Payment</b>.');
                    if (donorName) { $('#zelle_donor_name').val(donorName); }
                    showZelleManual('');
                    return;
                }
                var $opts = $(trimmed);
                $('#MemberID').append($opts).show();
                $('#MemberID1').show();
                $('#zelle-action-btns').show();
                $('#zelle-manual-fields').hide();
                $('#Zellecode').val('');
                $('#details_frm_btn_id').prop('disabled', true).addClass('disabled');
                if ($opts.length === 1) {
                    $('#MemberID').val($opts.first().val()).trigger('change');
                    $('#error_code1').css('color', '#276632').html('<i class="fa fa-check-circle"></i> Zelle transaction matched and selected automatically.');
                } else {
                    $('#error_code1').css('color', '#276632').html($opts.length + ' transactions found. Please select yours, then click <b>Verify</b>.');
                }
            },
            error: function () {
                $('#error_code1').css('color', '#c0392b').html('Could not search Zelle transactions. Enter your name and date below to search manually.');
            }
        });
    }

    function showZelleManual(msg) {
        $('#MemberID1').show();
        $('#zelle-manual-fields').show();
        $('#zelle-action-btns').hide();
        $('#zelle-no-match').hide();
        $('#checkPaymentData').show();
        $('#Zellecode').val('');
        $('#details_frm_btn_id').prop('disabled', true).addClass('disabled');
        if (msg) {
            $('#error_code1').css({'display':'block','color':'#c0392b'}).html(msg);
        }
    }

}(jQuery));
// ── End OTP + Zelle Flow ──────────────────────────────────────────────────────



$(document).on('click', '[location="outside"]', function(event) {
    const checkboxes = document.querySelectorAll('[location="outside"]');
  
  
    // checkboxes.forEach(box => {
    //     box.classList.remove('fa-minus-square', 'gzTimeSlotButtonMinusClass');
    //     box.classList.add('fa-plus-square', 'gzTimeSlotButtonPlusClass');
    // });
    

    // event.target.classList.remove('fa-plus-square', 'gzTimeSlotButtonPlusClass');
    // event.target.classList.add('fa-minus-square', 'gzTimeSlotButtonMinusClass');

    
    
    if(!event.target.getAttribute('onclick')) {
        flag = false;
    }
})




  




// document.addEventListener('DOMContentLoaded', ()=>{
//     const checkboxes = document.querySelectorAll('[data-date]');
//     if(checkboxes.length > 0) {
//         checkboxes.forEach(check => check.addEventListener('click', (event) => {
            
//             event.target.classList.add('fa-minus-square');
//         }))
//     }
// });


// location="other"

  


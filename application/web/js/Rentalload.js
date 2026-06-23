/*!
 * Time Slot Booking Calendar v1.0
 * http://gzscripts.com/home.html
 *
 * Copyright 2015, GzScript Ltd.
 *
 * Date: Mon March 2 23:42:58 2014 +0300
 */

var gz$ = jQuery.noConflict();
(function (window, undefined) {
    "use strict";
    window.GzAvailabilityCalendar = GzAvailabilityCalendar;

    var server = gz$("#server-id").text();

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
            url: server + "load.php?controller=GzRentalFront&action=calendars&lang=" + lang,
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
            }).delegate('#confirm_code', 'change', function (event) {
                self.checkCode.call(self, this);
            }).delegate('#MemberID', 'click', function (event) {
                self.checkCodeDD.call(self, this);
            }).delegate('#MemberID', 'change', function (event) {
                self.checkCodeDDSelect.call(self, this);
            }).delegate('#Puja', 'change', function (event) {
                self.blankpaymentDD.call(self, this);
            }).delegate("#checkPaymentData", "click", function (e) {
                e.preventDefault();
                self.checkCode.call(self);
            }).delegate(self.selectorClick, "click", function (e) {
                e.preventDefault();
                self.date = gz$(this).attr('data-timestamp');
                self.getTimeSlot.call(self, this);
            }).delegate("#back_to_calendar_id", "click", function (e) {
                e.preventDefault();
                self.ABCCalendar.call(self, this);
            }).delegate("#booking_frm_btn_id", "click", function (e) {
                e.preventDefault();
                self.ABCBookingForm.call(self);
            }).delegate("#details_frm_btn_id", "click", function (e) {
                e.preventDefault();
                self.ABCDetailForm.call(self);
            }).delegate("#back_to_booking_frm_id", "click", function (e) {
                e.preventDefault();
                self.ABCBookingForm.call(self);
            }).delegate("#back_booking_frm_btn_id", "click", function (e) {
                e.preventDefault();
                self.ABCBackToBookingForm.call(self, this);
            }).delegate("#checkout_frm_btn_id", "click", function (e) {
                e.preventDefault();
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
                    gz$("#bank_acount_details").hide();
                    gz$("#others_details").hide();
                    gz$("#credit_card_details").show();
                } else if (gz$(this).val() == 'bank_acount') {
                    gz$("#bank_acount_details").show();
                    gz$("#credit_card_details").hide();
                    gz$("#stripe_details").hide();
                    gz$("#others_details").hide();
                } else if (gz$(this).val() == 'others') {
                    var elem = document.createElement("img");
                    elem.setAttribute("src", gz$("#container-abc-url-id").text() + "zelle.png");
                    elem.setAttribute("height", "600");
                    elem.setAttribute("width", "600");

                    elem.setAttribute("alt", "Flower");
                    gz$('#error_codeimg').html(elem);
                    document.getElementById("error_codeimg").style.marginLeft = "52px";
                    document.getElementById("error_code1").style.marginLeft = "183px";
                    document.getElementById("error_code1").style.paddingTop = "12px";
                    document.getElementById("checkPaymentData").style.display = "block";
                    document.getElementById("MemberID1").style.display = "block";
                    document.getElementById("error_code1").style.display = "block";
                    document.getElementById("error_codeimg").style.display = "block";
                    gz$('#error_code1').html("Step 1 - Send your Zelle payment to treasurer@durgabari.org;" + "<br>" + "Step 2 - Click get zelle payment details button."+ "<br>" + "Step 3 - Select your payment details from  dropdown.");


                    gz$("#bank_acount_details").hide();
                    gz$("#others_details").show();
                    gz$("#stripe_details").hide();
                    gz$("#stripe_details").hide();
                } else if (gz$(this).val() == 'stripe') {
                     gz$("#details_frm_btn_id").removeClass('disabled');
                    gz$("#others_details").hide();
                    gz$("#bank_acount_details").hide();
                    gz$("#credit_card_details").hide();
                    gz$("#stripe_details").show();
                    document.getElementById("error_code1").style.display = "none";
                    document.getElementById("error_codeimg").style.display = "none";
                    document.getElementById("checkPaymentData").style.display = "none";
                    document.getElementById("MemberID1").style.display = "none";
                    if (gz$(".StripeElement").length > 0) {
                    } else {
                        var elements = self.stripe.elements();
                        self.card = elements.create('card');
                        self.card.mount('#stripe_details');
                    }
                } else {
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
                self.slot = gz$(this).attr('data-start-time');
                self.date = gz$(this).attr('data-date');
                self.count = 1;
                self.addTimseSlot.call(self, this);

                gz$(this).removeClass();
                gz$(this).addClass('gzTimeSlotButtonMinusClass fa fa-fw fa-minus-square');
                gz$('#booking_frm_btn_id').removeClass("disabled");
            }).delegate(".gzTimeSlotButtonMinusClass", "click", function (e) {
                self.slot = gz$(this).attr('data-start-time');
                self.date = gz$(this).attr('data-date');
                self.count = 1;
                self.removeTimseSlot.call(self, this);

                gz$(this).removeClass();
                gz$(this).addClass('gzTimeSlotButtonPlusClass fa fa-fw fa-plus-square');
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
        decorate: function (el) {
            var index;
            var hover_date;
            var element;
            var timestamp;
            var self = this;
            var $el = gz$(el);

            if (self.start_date !== null && self.end_date === null) {

                hover_date = parseInt($el.data("timestamp"), 10);
                //loop all cell on motnh
                self.$gzABCalendar.find(self.selector).each(function (i, item) {

                    element = gz$(item);
                    timestamp = parseInt(element.data("timestamp"), 10);
                    index = gz$.inArray(timestamp, self.selectedTimeArr);

                    if ((self.start_date > hover_date && timestamp <= self.start_date && timestamp >= hover_date) ||
                            (self.start_date < hover_date && timestamp >= self.start_date && timestamp <= hover_date)) {

                        if (element.attr("class").match("gzABCalCellReserved") !== null && element.attr("class").match("gzABCalCellReservedNights") === null) {
                            //log('Reserved');
                        } else if (element.attr("class").match("gzABCalCellPending") !== null && element.attr("class").match("gzABCalCellPendingNights") === null) {
                            //log('Pending');
                        } else if (element.attr("class").match("gzABCalCellNightsReservedPending") !== null) {
                            //log('Pending');
                        } else if (element.attr("class").match("gzABCalCellNightsPendingReserved") !== null) {
                            //log('Pending');
                        } else if (element.attr("class").match("gzABCalCellNightsPendingPending") !== null) {
                            //log('Pending');
                        } else if (element.attr("class").match("gzABCalCellNightsReservedReserved") !== null) {
                            //log('Pending');
                        } else {
                            element.addClass("gzABCalCellSelected");
                        }
                        if (index === -1) {
                            self.selectedTimeArr.push(timestamp);
                            self.selectedClassArr.push(element.attr("class"));

                        }
                    } else if (self.start_date != timestamp) {
                        element.removeClass("gzABCalCellSelected");

                        if (index !== -1) {
                            self.selectedTimeArr.splice(index, 1);
                            self.selectedClassArr.splice(index, 1);

                        }
                    }
                });
            }
        },
        select: function (el) {
            var daysCount, end_date, i, iCnt,
                    $el = gz$(el),
                    nightsStart = 0,
                    nightsEnd = 0,
                    pendingStart = false,
                    pendingEnd = false,
                    pendingReserved = false,
                    reservedPending = false,
                    partial = false,
                    timestamp = parseInt($el.data("timestamp"), 10);

            if (this.start_date === null && this.end_date === null) {
                // first click 
                this.firstClick.call(this, $el, timestamp);
                return;
            } else {
                // second click 
                end_date = timestamp;
                this.secondClick.call(this, $el, end_date);
                return;
            }
        },
        firstClick: function ($el, timestamp) {
            this.start_date = timestamp;
            this.$firstCell = $el;
        },
        secondClick: function ($el, timestamp) {
            var self = this;

            if (!this.end_date) {
                $el.addClass('gzABCalLastSelect');

                this.end_date = timestamp;
                this.$secondCell = $el;

                var check = true;

                if (this.end_date == this.start_date) {
                    check = false;
                } else {
                    check = this.checkDates.call(self, $el.get(0));
                }

                if (check) {
                    self.ABCExtraForm.call(self);
                } else {
                    $el.find(".gzABCalCellDivInner").tooltipster('show');
                }
            } else {
                self.clearDate.call(self, this);
            }
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
                url: self.options.server + "load.php?controller=GzRentalFront&action=checkCode&cid=" + self.options.cal_id,
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
            
                    $('#MemberID').empty(); //remove all child nodes
                    var newOption1 = $('<option value="1">Please select your payment details</option>');
                    $('#MemberID').append(newOption1);
                   
                    $('#MemberID').trigger("chosen:updated");
                     
                    
                
           
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
                url: self.options.server + "load.php?controller=GzRentalFront&action=checkCode&cid=" + self.options.cal_id,
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
                url: self.options.server + "load.php?controller=GzRentalFront&action=checkCodeDD&cid=" + self.options.cal_id,
                success: function (res) {
                    gz$("#details_frm_btn_id").removeClass('disabled');
                    gz$("#details_frm_btn_id").removeClass('disabled');
                    var myString = res.replace("echo", '');
                    var myString1 = myString.replace("", '');
                    //= myString.replace("",'');
                    $('#MemberID').empty(); //remove all child nodes
                    var newOption = $(myString1);
                    var newOption1 = $('<option value="1">Please select your payment details</option>');
                    $('#MemberID').append(newOption1);
                    $('#MemberID').append(newOption);
                    $('#MemberID').trigger("chosen:updated");
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
          
            debugger
            var dd = gz$("#MemberID").val();
          
            var parts = dd.split("/");
            var cmCode = parts[3];
            var name =parts[1];
            var price =parts[2].replace(/ /gi,'').trim();;
          
            var totalprice =   gz$("#total").text();
            var tot = totalprice.replace(/ /gi,'').trim();
          
            
                    if(tot===price){
                        gz$("#details_frm_btn_id").removeClass('disabled');
                    }
                    else{
                      
                        gz$("#details_frm_btn_id").addClass('disabled');
                        alert('Total price and select  price is not same please select correct payment');
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

            gz$.ajax({
                type: "POST",
                data: {
                    date: self.date,
                    slot: self.slot,
                    count: self.count,
                    cal_id: self.options.cal_id
                },
                url: self.options.server + "load.php?controller=GzRentalFront&action=addTimeSlot&cid=" + self.options.cal_id,
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
                url: self.options.server + "load.php?controller=GzRentalFront&action=removeTimeSlot&cid=" + self.options.cal_id,
                success: function (res) {

                    self.calculatePrice.call(self, this);
                }
            });
        },
        getTimeSlot: function (e) {
            var self = this;

            gz$.ajax({
                type: "POST",
                data: {
                    date: self.date,
                    cal_id: self.options.cal_id
                },
                url: self.options.server + "load.php?controller=GzRentalFront&action=getTimeSlot&cid=" + self.options.cal_id,
                success: function (res) {
                    gz$(self.$gzABCalendar).html(res);

                    Ladda.bind('#booking_frm_btn_id');
                    Ladda.bind('#back_to_calendar_id');
                }
            });
        },
        ABCBookingForm: function () {
            var self = this;
            debugger
            gz$.ajax({
                type: "POST",
                data: {
                    start_date: self.start_date,
                    end_date: self.end_date,
                    cal_id: self.options.cal_id
                },
                url: self.options.server + "load.php?controller=GzRentalFront&action=booking_form&cid=" + self.options.cal_id,
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
                url: self.options.server + "load.php?controller=GzRentalFront&action=booking_form&cid=" + self.options.cal_id,
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
                url: self.options.server + "load.php?controller=GzRentalFront&action=calendar&cid=" + self.options.cal_id + "&view_month=" + self.options.view_month,
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
            if (dd != null) {
                var parts = dd.split("/");
                var cmCode = parts[3];
            }
            //gz$.LoadingOverlay("show");

            gz$.ajax({
                type: "POST",
                data: {
                    code: cmCode
                },
                url: self.options.server + "load.php?controller=GzRentalFront&action=UpdateCodeData&cid=" + self.options.cal_id,
                success: function (res) {
                    gz$("#details_frm_btn_id").removeClass('disabled');
                    gz$('#error_code').html(res);
                }

            });
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
                        url: self.options.server + "load.php?controller=GzRentalFront&action=booking_details&cid=" + self.options.cal_id,
                        success: function (res) {
                            gz$(self.$gzABCalendar).html(res);

                            Ladda.bind('#back_booking_frm_btn_id');
                            Ladda.bind('#checkout_frm_btn_id');
                        }
                    });
                }
            } else {
                Ladda.stopAll();
            }
        },
        ABCCheckoutForm: function () {
            var self = this;
            debugger
            var frm = gz$("#gz-abc-form-id");

            gz$.ajax({
                type: "POST",
                data: frm.serialize(),
                url: self.options.server + "load.php?controller=GzRentalFront&action=checkout&cid=" + self.options.cal_id,
                success: function (res) {

                    gz$(self.$gzABCalendar).html(res);
                    if (gz$("#gz-hotel-booking-pay-frm-id").length > 0) {
                        gz$("#gz-hotel-booking-pay-frm-id").submit();
                    }
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
                            url: self.options.server + "load.php?controller=GzRentalFront&action=booking_details&cid=" + self.options.cal_id,
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
                url: self.options.server + "index.php?controller=GzRentalFront&action=calculatePrice&cid=" + self.options.cal_id,
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
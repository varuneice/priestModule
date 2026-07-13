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
    function getRentalAdvanceAmount() {
        var amount = gz$('select[name="advanceamount"]').filter(':visible').val()
            || gz$('select[name="advanceamount"]').val()
            || gz$('#total').text()
            || gz$('#total').val()
            || '';
        return amount.replace(/[$,\s]/g, '').trim();
    }
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

    gz$(function () {
        var $memberSelect = gz$('#registrationmember');
        if ($memberSelect.is('select')) {
            $memberSelect.val('');
            gz$('#otp-verified-banner').removeClass('otp-show').css('display', 'none');
        }

        var $directMemberVerify = gz$('#rental-direct-member-verify');
        if (!$directMemberVerify.length) {
            return;
        }

        function completeRentalOtp(memberId) {
            gz$('#otp-session-verified').text(memberId || '');
            gz$('#otp-verified-banner').addClass('otp-show').css('display', 'flex');
            if (typeof window.autoFillRentalMemberById === 'function') {
                window.autoFillRentalMemberById(memberId);
            }
        }

        var verifiedMemberId = gz$.trim(gz$('#otp-session-verified').text());
        if (verifiedMemberId) {
            completeRentalOtp(verifiedMemberId);
            return;
        }

        if (typeof window.OtpMemberVerify === 'undefined') {
            return;
        }

        window.OtpMemberVerify.open({
            onVerified: completeRentalOtp
        });
        window.onOtpModalCancelled = function () {
            gz$('#registrationmember').val('');
            gz$('#otp-session-verified').text('');
        };
    });

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
            this.start_date = null;
            this.end_date = null;
            this.date = null;
            this.dateTo = null;
            this.promo_code = null;
            //this.selectorClick = ".gzABCalCellAvil, .gzABCalCellPending, .gzABCalCellReserved";
            // this.selectorClick = ".gzABCalCellAvil, .gzABCalCellPending, .gzABCalColorPartial";
              this.selectorClick = ".gzABCalCellAvil, .gzABCalCellPending , .gzABCalColorAD , .gzABCalColorKB";
            this.slot = null;
            this.date = null;
            this.count = null;
            this.options = {};
            this.selectedClassArr = [];
            this.selectedTimeArr = [];

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
            self.$gzCalContainer.on("click", self.selectorClick, function (e) {
                if (self.start_date == null) {
                    self.selectedTimeArr = [];
                    self.selectedClassArr = [];
                    gz$(this).addClass('gzABCalFirstSelect');
                    gz$(this).addClass('gzABCalCellSelected');
                }
                self.getTimeSlot.call(self, this);
            }).on("mouseenter", this.selector, function (e) {
                self.decorate.call(self, this);
            });
            

            if (self.options.stripe_allow === '1' && self.options.stripe_publish_key !== '') {

                var stripe_publish_key = self.options.stripe_publish_key;
                self.stripe = Stripe(stripe_publish_key);
                var elements = self.stripe.elements();
            }
            function showRentalZelleManual(msg) {
                gz$('#MemberID1').show();
                gz$('#zelle-manual-fields').show();
                gz$('#zelle-action-btns').hide();
                gz$('#zelle-no-match').hide();
                gz$('#checkPaymentData').show();
                gz$('#Zellecode').val('');
                gz$('#details_frm_btn_id').prop('disabled', true).addClass('disabled');
                if (msg) {
                    gz$('#error_code1').css({'display':'block','color':'#c0392b'}).html(msg);
                }
            }
            function runRentalZelleAutoSearch() {
                var donorName = gz$.trim(gz$('#first_name').val() + ' ' + gz$('#second_name').val());
                var zelleAmount = getRentalAdvanceAmount();
                var today = new Intl.DateTimeFormat('en-CA', {
            timeZone: 'America/Chicago',
            year: 'numeric',
            month: '2-digit',
            day: '2-digit'
        }).format(new Date());

                gz$('#MemberID1').show();
                gz$('#zelle-manual-fields').hide();
                gz$('#zelle-action-btns').hide();
                gz$('#zelle-no-match').hide();
                gz$('#MemberID').hide().empty().append('<option value="">Please select your Zelle transaction</option>');
                gz$('#Zellecode').val('');
                gz$('#details_frm_btn_id').prop('disabled', true).addClass('disabled');

                if (!donorName) {
                    showRentalZelleManual('Please enter your name above, then search your Zelle transaction manually below.');
                    gz$('#first_name').focus();
                    return;
                }
                if (!zelleAmount) {
                    showRentalZelleManual('Please select the rental amount first, then search your Zelle transaction manually below.');
                    return;
                }

                gz$('#zelle_donor_name').val(donorName);
                gz$('#error_code1').css({'display':'block','color':'#357ca5'}).html('<i class="fa fa-spinner fa-spin"></i> Searching your Zelle transaction...');
                gz$.post(self.options.server + 'load.php?controller=GzFront&action=importZelleAndSearch', {});
                gz$.ajax({
                    type: 'POST',
                    data: { donor_name: donorName, zelle_amount: zelleAmount, zelle_date: today },
                    url: self.options.server + 'load.php?controller=GzFront&action=checkCodeDD',
                    success: function(res) {
                        var trimmed = gz$.trim(res);
                        if (!trimmed || trimmed === 'NO_MATCH') {
                            gz$('#error_code1').css('color', '#c0392b').html('Transaction not found automatically. Enter your name and date below, then click <b>Verify Zelle Payment</b>.');
                            showRentalZelleManual('');
                            return;
                        }
                        var opts = gz$(trimmed);
                        gz$('#MemberID').empty()
                            .append('<option value="">Please select your Zelle transaction</option>')
                            .append(opts).show();
                        gz$('#zelle-action-btns').show();
                        gz$('#zelle-manual-fields').hide();
                        gz$('#zelle-no-match').hide();
                        gz$('#Zellecode').val('');
                        gz$('#details_frm_btn_id').prop('disabled', true).addClass('disabled');
                        if (opts.length === 1) {
                            gz$('#MemberID').val(opts.first().val()).trigger('change');
                        } else {
                            gz$('#error_code1').css('color', '#276632').html(opts.length + ' transactions found. Please select yours, then click <b>Verify</b>.');
                        }
                    },
                    error: function() {
                        gz$('#error_code1').css('color', '#c0392b').html('Could not search Zelle transactions. Enter your name and date below to search manually.');
                        showRentalZelleManual('');
                    }
                });
            }
            
            this.$gzCalContainer.delegate("#Puja", "change", function (e) {
                self.calculatePrice.call(self, this);
            }).delegate("#Puja2", "change", function (e) {
                self.calculatePrice.call(self, this);
            }).delegate('#confirm_code', 'change', function (event) {
                self.checkCode.call(self, this);
            }).delegate('#MemberID', 'change', function (event) {
                self.checkCodeDDSelect.call(self, this);
            }).delegate('#zelle-verify-btn', 'click', function(event) {
                gz$('#MemberID').trigger('change');
            }).delegate('#zelle-modal-paid-btn', 'click', function(event) {
                gz$('#zelle-modal-overlay').hide();
                runRentalZelleAutoSearch();
            }).delegate('#zelle-modal-cancel-btn, #zelle-modal-close', 'click', function(event) {
                gz$('#zelle-modal-overlay').hide();
                gz$('#payment_method').val('').trigger('change');
                gz$('#details_frm_btn_id').prop('disabled', false).removeClass('disabled');
            }).delegate('#zelle-retry-btn', 'click', function(event) {
                gz$('#zelle-action-btns').hide();
                gz$('#MemberID').hide().empty().append('<option value="">Please select your Zelle transaction</option>');
                gz$('#zelle-no-match').hide();
                gz$('#error_code1').empty().hide();
                gz$('#zelle-manual-fields').show();
                gz$('#checkPaymentData').show();
                gz$('#Zellecode').val('');
                gz$('#details_frm_btn_id').prop('disabled', true).addClass('disabled');
            }).delegate('#otp-gate-btn', 'click', function(event) {
                if (typeof window.OtpMemberVerify === 'undefined') return;
                window.OtpMemberVerify.open({
                    onVerified: function(memberId) {
                        gz$('#otp-gate').hide();
                        gz$('#otp-verified-banner').addClass('otp-show').css('display', 'flex');
                        gz$('#otp-session-verified').text(memberId || '');
                        if (typeof window.autoFillRentalMemberById === 'function') {
                            window.autoFillRentalMemberById(memberId);
                        }
                    }
                });
            }).delegate('#registrationmember', 'change', function(event) {
                var val = gz$(this).val();
                if (val === 'member') {
                    gz$('#otp-gate').hide();
                    gz$('#otp-verified-banner').removeClass('otp-show').css('display', 'none');
                } else {
                    gz$('#otp-gate').hide();
                    gz$('#otp-verified-banner').removeClass('otp-show').css('display', 'none');
                }
            }).delegate("#checkPaymentData", "click", function (e) {
                e.preventDefault();
                var donorName = (gz$('#zelle_donor_name').val() || '').trim();
                var zelleAmount = getRentalAdvanceAmount();
                var zelleDate = (gz$('#zelle_date').val() || '').trim();
                var serverUrl = self.options.server;
                if (!donorName) {
                    alert('Please enter your name as used in Zelle.');
                    gz$('#zelle_donor_name').focus();
                    return;
                }
                if (!zelleAmount) {
                    alert('Please select the rental amount first.');
                    return;
                }
                gz$('#error_code1').html('<em>Searching&hellip;</em>').show();
                gz$('#zelle-no-match').hide();
                gz$('#Zellecode').val('');
                gz$('#details_frm_btn_id').prop('disabled', true).addClass('disabled');
                gz$.ajax({
                    type: 'POST',
                    data: { donor_name: donorName, zelle_amount: zelleAmount, zelle_date: zelleDate },
                    url: serverUrl + 'load.php?controller=GzFront&action=checkCodeDD',
                    success: function(res) {
                        var trimmed = gz$.trim(res);
                        if (!trimmed || trimmed === 'NO_MATCH') {
                            gz$('#error_code1').html('No matching Zelle transactions found.').show();
                            gz$('#zelle-no-match').show();
                        } else {
                            var opts = gz$(trimmed);
                            gz$('#MemberID').empty()
                                .append('<option value="">Please select your Zelle transaction</option>')
                                .append(opts).show();
                            gz$('#zelle-action-btns').show();
                            gz$('#zelle-manual-fields').hide();
                            gz$('#error_code1').html('').hide();
                            gz$('#zelle-no-match').hide();
                            gz$('#Zellecode').val('');
                            gz$('#details_frm_btn_id').prop('disabled', true).addClass('disabled');
                            if (opts.length === 1) {
                                gz$('#MemberID').val(opts.first().val()).trigger('change');
                            }
                        }
                    },
                    error: function() {
                        gz$('#error_code1').html('Could not reach Zelle service.').show();
                    }
                });
            }).delegate(self.selectorClick, "click", function (e) {
               debugger
                e.preventDefault();
                self.date = gz$(this).attr('data-timestamp');
                var elem = document.querySelector("#\\32 _1672790400 > div > div");
            elem.classList.add("gzABCalCellSelected");
                self.getTimeSlot.call(self, this);
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
                self.ABCDetailForm.call(self);
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
                    gz$('#details_frm_btn_id').prop('disabled', true).addClass('disabled');
                    gz$('#bank_acount_details').hide();
                    gz$('#others_details').show();
                    gz$('#stripe_details').hide();
                    gz$('#MemberID1').hide();
                    gz$('#zelle-manual-fields').hide();
                    gz$('#zelle_donor_name').val(gz$.trim(gz$('#first_name').val() + ' ' + gz$('#second_name').val()));
                    gz$('#zelle-modal-img').attr('src', self.options.server + 'zelle.png');
                    gz$('#zelle-modal-overlay').css('display', 'flex');
                    gz$.post(self.options.server + 'load.php?controller=GzFront&action=importZelleAndSearch', {});
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
                } else {
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
                    gz$("#details_frm_btn_id").prop('disabled', true).addClass('disabled');
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
                self.$gzCalContainer.find(self.selector).each(function (i, item) {

                    element = gz$(item);
                    timestamp = parseInt(element.data("timestamp"), 10);
                    index = gz$.inArray(timestamp, self.selectedTimeArr);

                    if ((self.start_date > hover_date && timestamp <= self.start_date && timestamp >= hover_date) ||
                            (self.start_date < hover_date && timestamp >= self.start_date && timestamp <= hover_date)) {

                        if (element.attr("class").match("gzABCalCellReserved") !== null && element.attr("class").match("gzABCalCellReservedNights") === null) {
                            //log('Reserved');
                        } else if (element.attr("class").match("gzABCalCellPending") !== null && element.attr("class").match("gzABCalCellPendingNights") === null) {
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
       
        getTimeSlot: function (el) {
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

            if (this.start_date === null) {
                // first click 
                this.secondClick.call(this, $el, timestamp);
                return;
            } 
        },
        firstClick: function ($el, timestamp) {
            this.start_date = timestamp;
            this.$firstCell = $el;
        },
        secondClick: function ($el, timestamp) {
            var self = this;
            
            if (!this.start_date) {
                $el.addClass('gzABCalCellSelected');

                this.start_date = timestamp;
                this.$secondCell = $el;

                var check = true;

                check = this.checkDates.call(self, $el.get(0));

                if (check) {
                    //self.ABCCheckoutForm.call(self);
                    self.ABCBookingForm.call(self);
                    //self.ABCDetailForm.call(self);
                } else {
                    $el.find(".gzABCalCellDivInner").tooltipster('show');
                }
            } else {
                self.clearDate.call(self, this);
            }
        },
        checkDates: function (el) {
            var self = this;
            var tdays, end_dt, i, cnt,
                    $el = gz$(el),
                    nightsStart = 0,
                    nightsEnd = 0,
                    pStart = false,
                    pEnd = false,
                    pendingReserved = false,
                    reservedPending = false,
                    partial = false,
                    time = parseInt($el.data("time"), 10);

            for (i = 0, cnt = self.selectedClassArr.length; i < cnt; i += 1) {

                if (self.selectedClassArr[i].match("gzABCalCellReserved") !== null && self.selectedClassArr[i].match("gzABCalCellReservedNights") === null) {
                    return false;
                }
                if (self.selectedClassArr[i].match("gzABCalCellReservedNightsStart") !== null) {
                    nightsStart += 1;
                }
                if (self.selectedClassArr[i].match("gzABCalCellReservedNightsEnd") !== null) {
                    nightsEnd += 1;
                }
                if (self.selectedClassArr[i].match("gzABCalCellPending") !== null && self.selectedClassArr[i].match("gzABCalCellPendingNights") === null) {
                    return false;
                }
            }
            return true;
        },
        clearDate: function () {
            var self = this;

            self.start_date = null;
            self.end_date = null;
            self.selectedTime = [];
            self.selectedElement = [];

            self.$gzABCalendar.find("td").removeClass("gzABCalCellSelected gzABCalFirstSelect");
            self.$gzABCalendar.find("td").removeClass("gzABCalCellSelected gzABCalLastSelect");
        },
        getEvents: function (e) {
            var self = this;
            gz$.ajax({
                type: "POST",
                data: {
                    start_date: self.start_date,
                    end_date: self.end_date
                },
                url: self.options.server + "load.php?controller=GzRentalFront&action=getEvents&local=" + self.options.local,
                success: function (res) {
                    self.$gzCalContainer.html(res);
                    
                    self.galleryBind.call(self);
                    
                    gz$("div.gzHolder").jPages({
                        containerID: "gzItemContainer",
                        perPage: self.options.items_per_page,
                        previous: 'prev',
                        next: 'next'
                    });

                    gz$("#category-id").selectmenu({
                        change: function () {

                            self.CheckAvailability.call(self, this);
                        }
                    });
                    gz$("#start-hours-id").selectmenu({
                        change: function () {
                            self.CheckAvailability.call(self);
                        }
                    });
                    gz$("#start-minutes-id").selectmenu({
                        change: function () {
                            self.CheckAvailability.call(self);
                        }
                    });
                    gz$("#end-hours-id").selectmenu({
                        change: function () {
                            self.CheckAvailability.call(self);
                        }
                    });
                    gz$("#end-minutes-id").selectmenu({
                        change: function () {
                            self.CheckAvailability.call(self);
                        }
                    });
                    gz$(".select-price").selectmenu({
                        change: function () {
                            self.item_id = gz$(this).attr('rev');
                            self.count = gz$(this).val();
                            self.start_date = gz$("#start_date").val();
                            self.start_hours = gz$("#start-hours-id").val();
                            self.start_minutes = gz$("#start-minutes-id").val();
                            self.end_date = gz$("#end_date").val();
                            self.end_hours = gz$("#end-hours-id").val();
                            self.end_minutes = gz$("#end-minutes-id").val();
                            self.getItemPrice.call(self);
                        }
                    });

                    gz$("#start_date").datepicker({
                        dateFormat: gz$("#start_date").attr('date-format'),
                        minDate: 0,
                        onSelect: function (selected) {
                            gz$("#end_date").datepicker("option", "minDate", selected);
                            self.CheckAvailability.call(self);
                        }
                    });
                    gz$("#end_date").datepicker({
                        dateFormat: gz$("#end_date").attr('date-format'),
                        minDate: 0,
                        onSelect: function (selected) {
                            gz$("#start_date").datepicker("option", "maxDate", selected);
                            self.CheckAvailability.call(self);
                        }
                    });

                    Ladda.bind('#booking_frm_btn_id');
                    Ladda.bind('#back_to_calendar_id');
                    self.start_date = null;
                    self.end_date = null;
                }
            });
        },
        backToItemEvents: function (e) {
            var self = this;
            var frm = gz$("#gz-rental-booking-form-id");
            gz$.ajax({
                type: "POST",
                data: frm.serialize(),
                url: self.options.server + "load.php?controller=GzRentalFront&action=getEvents&local=" + self.options.local,
                success: function (res) {
                    self.$gzCalContainer.html(res);
                    self.galleryBind.call(self);
                    gz$("div.gzHolder").jPages({
                        containerID: "gzItemContainer",
                        perPage: self.options.items_per_page,
                        previous: 'prev',
                        next: 'next',
                    });
                    gz$("#category-id").selectmenu({
                        change: function () {
                            self.CheckAvailability.call(self, this);
                        }
                    });
                    gz$("#start-hours-id").selectmenu({
                        change: function () {
                            self.CheckAvailability.call(self);
                        }
                    });
                    gz$("#start-minutes-id").selectmenu({
                        change: function () {
                            self.CheckAvailability.call(self);
                        }
                    });
                    gz$("#end-hours-id").selectmenu({
                        change: function () {
                            self.CheckAvailability.call(self);
                        }
                    });
                    gz$("#end-minutes-id").selectmenu({
                        change: function () {
                            self.CheckAvailability.call(self);
                        }
                    });
                    gz$(".select-price").selectmenu({
                        change: function () {
                            self.item_id = gz$(this).attr('rev');
                            self.count = gz$(this).val();
                            self.start_date = gz$("#start_date").val();
                            self.start_hours = gz$("#start-hours-id").val();
                            self.start_minutes = gz$("#start-minutes-id").val();
                            self.end_date = gz$("#end_date").val();
                            self.end_hours = gz$("#end-hours-id").val();
                            self.end_minutes = gz$("#end-minutes-id").val();
                            self.getItemPrice.call(self);
                        }
                    });

                    gz$("#start_date").datepicker({
                        dateFormat: gz$("#start_date").attr('date-format'),
                        minDate: 0,
                        onSelect: function (selected) {
                            gz$("#end_date").datepicker("option", "minDate", selected);
                            self.CheckAvailability.call(self);
                        }
                    });
                    gz$("#end_date").datepicker({
                        dateFormat: gz$("#end_date").attr('date-format'),
                        minDate: 0,
                        onSelect: function (selected) {
                            gz$("#start_date").datepicker("option", "maxDate", selected);
                            self.CheckAvailability.call(self);
                        }
                    });

                    Ladda.bind('#booking_frm_btn_id');
                    Ladda.bind('#back_to_calendar_id');
                    self.start_date = null;
                    self.end_date = null;

                    var count = 0;
                    gz$.each(gz$(".select-price"), function (key, value) {
                        if (!isNaN(gz$(this).val()) && gz$(this).val() > 0) {
                            count += gz$(this).val();
                            gz$(".booking_frm_btn").removeClass('disabled');
                            return count;
                        }
                    });
                    if (count < 1) {
                        gz$(".booking_frm_btn").addClass('disabled');
                    }
                }
            });
        },
        getItemPrice: function () {
            var self = this;
            gz$.ajax({
                type: "POST",
                dataType: 'json',
                data: {
                    id: self.item_id,
                    count: self.count,
                    start_date: self.start_date,
                    start_hours: self.start_hours,
                    start_minutes: self.start_minutes,
                    end_date: self.end_date,
                    end_hours: self.end_hours,
                    end_minutes: self.end_minutes
                },
                url: self.options.server + "load.php?controller=GzRentalFront&action=getItemPrice&local=" + self.options.local,
                success: function (json) {
                    gz$("#item-price-" + self.item_id).text(json.formated_total);
                    var count = 0;
                    gz$.each(gz$(".select-price"), function (key, value) {
                        if (!isNaN(gz$(this).val()) && gz$(this).val() > 0) {
                            count += gz$(this).val();
                            gz$(".booking_frm_btn").removeClass('disabled');
                            return count;
                        }
                    });
                    if (count < 1) {
                        gz$(".booking_frm_btn").addClass('disabled');
                    }
                }
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
            if (!dd || dd === '1') return;
            var parts = dd.split("/");
            var cmCode = gz$.trim(parts[3] || '');
            var newprice = parseFloat((parts[2] || '').replace(/[$,\s]/g, ''));
            var tot = parseFloat(getRentalAdvanceAmount());
            if (cmCode) { gz$("#Zellecode").val(cmCode); }
            if (!isNaN(tot) && !isNaN(newprice) && tot === newprice && cmCode) {
                gz$('#error_code1').empty().hide();
                gz$('#zelle-no-match').hide();
                gz$('#zelle-manual-fields').hide();
                gz$('#zelle-action-btns').hide();
                gz$("#details_frm_btn_id").prop('disabled', false).removeClass('disabled');
            } else {
                gz$("#Zellecode").val('');
                gz$("#details_frm_btn_id").prop('disabled', true).addClass('disabled');
                gz$('#zelle-no-match').hide();
                gz$('#error_code1').css({'display':'block','color':'#c0392b'}).html('Selected Zelle amount does not match the booking amount. Please select the correct transaction.');
                if (dd) { alert('Total price and selected price do not match. Please select the correct payment.'); }
            }
            //gz$.LoadingOverlay("show");

            // gz$.ajax({
            //     type: "POST",
            //     data: {
            //         code: cmCode
            //     },
            //     url: self.options.server + "load.php?controller=GzRentalFront&action=UpdateCodeData&cid=" + self.options.cal_id,
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
        getTimeSlot1: function (e) {
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
        CheckAvailability: function () {
            var self = this;

            var frm = gz$("#item-frm-id");

            gz$.ajax({
                type: "POST",
                data: frm.serialize(),
                url: self.options.server + "load.php?controller=GzFront&action=CheckAvailability&local=" + self.options.local,
                success: function (res) {
                    gz$("#items-container-id").html(res);
                    gz$("div.gzHolder").jPages({
                        containerID: "gzItemContainer",
                        perPage: self.options.items_per_page,
                        previous: 'prev',
                        next: 'next'
                    });
                    gz$(".select-price").selectmenu({
                        change: function () {
                            self.item_id = gz$(this).attr('rev');
                            self.count = gz$(this).val();
                            self.start_date = gz$("#start_date").val();
                            self.start_hours = gz$("#start-hours-id").val();
                            self.start_minutes = gz$("#start-minutes-id").val();
                            self.end_date = gz$("#end_date").val();
                            self.end_hours = gz$("#end-hours-id").val();
                            self.end_minutes = gz$("#end-minutes-id").val();
                            self.getItemPrice.call(self);
                        }
                    });
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
                    //start_date: '1672963200',
                    
                    //end_date: '1672963200',
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
            debugger
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
            
            var input = document.getElementById("first_name").value;
            var output = input.replace(/\s+/g, '');
            document.getElementById("first_name").value = output;

            var inputsecond = document.getElementById("second_name").value;
            var outputsecond = inputsecond.replace(/\s+/g, '');
            document.getElementById("second_name").value = outputsecond;
            
            //gz$.LoadingOverlay("show");

            // gz$.ajax({
            //     type: "POST",
            //     data: {
            //         code: cmCode
            //     },
            //     url: self.options.server + "load.php?controller=GzRentalFront&action=UpdateCodeData&cid=" + self.options.cal_id,
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
                        url: self.options.server + "load.php?controller=GzRentalFront&action=booking_details&cid=" + self.options.cal_id,
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
                url: self.options.server + "load.php?controller=GzRentalFront&action=checkout&cid=" + self.options.cal_id,
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

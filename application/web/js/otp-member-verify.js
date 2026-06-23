(function ($) {

    var otpState = {
        lookup: null,
        method: null,
        memberId: null,
        countdownTimer: null,
        onVerified: null
    };

    // ── Open / Close ────────────────────────────────────────────────
    function openModal() {
        resetToScreen1();
        $('.otp-method-toggle').closest('.otp-field-group').hide();
        $('#otp-overlay').addClass('otp-active');
        $('#otp-lookup').focus();
    }

    function closeModal() {
        $('#otp-overlay').removeClass('otp-active');
        clearCountdown();
    }

    // ── Screen navigation ────────────────────────────────────────────
    function showScreen1() {
        $('#otp-screen-1').show();
        $('#otp-screen-2').hide();
        $('#otp-modal-subtitle').text('Please verify your identity to access member details.');
        clearAlert();
    }

    function showScreen2() {
        $('#otp-screen-1').hide();
        $('#otp-screen-2').show();
        $('#otp-modal-subtitle').text('');
        clearAlert();
        clearDigits();
        startCountdown(45);
        setTimeout(function () {
            $('.otp-digit-input').first().focus();
        }, 100);
    }

    function resetToScreen1() {
        $('#otp-lookup').val('');
        otpState.lookup = null;
        otpState.method = null;
        otpState.memberId = null;
        $('.otp-method-btn').removeClass('otp-selected');
        clearDigits();
        clearCountdown();
        clearAlert();
        showScreen1();
    }

    // ── Alert helpers ────────────────────────────────────────────────
    function showAlert(msg, type) {
        var $a = $('#otp-alert');
        $a.removeClass('otp-alert-error otp-alert-success otp-show');
        $a.addClass('otp-alert-' + type + ' otp-show').text(msg);
    }

    function clearAlert() {
        $('#otp-alert').removeClass('otp-alert-error otp-alert-success otp-show').text('');
    }

    // ── OTP Method toggle ────────────────────────────────────────────
    $(document).on('click', '.otp-method-btn', function () {
        $('.otp-method-btn').removeClass('otp-selected');
        $(this).addClass('otp-selected');
        otpState.method = $(this).data('method');
    });

    // ── Send OTP (Screen 1 submit) ────────────────────────────────────
    $(document).on('click', '#otp-send-btn', function () {
        clearAlert();
        var lookup = ($('#otp-lookup').val() || '').trim();
        var method = lookup.indexOf('@') !== -1 ? 'email' : 'sms';

        if (!lookup) {
            showAlert('Please enter your email or phone number.', 'error');
            $('#otp-lookup').focus();
            return;
        }

        otpState.lookup = lookup;
        otpState.method = method;

        var $btn = $('#otp-send-btn');
        $btn.prop('disabled', true).text('Sending…');

        $.ajax({
            type: 'POST',
            url: $('#container-abc-url-id').text() + 'send-otp.php',
            data: { lookup: lookup, method: method },
            dataType: 'json',
            success: function (res) {
                $btn.prop('disabled', false).text('Send OTP');
                if (res.success) {
                    otpState.memberId = res.member_id;
                    $('#otp-masked-destination').text(res.masked || lookup);
                    showScreen2();
                } else {
                    showAlert(res.message || 'Failed to send OTP. Please try again.', 'error');
                }
            },
            error: function () {
                $btn.prop('disabled', false).text('Send OTP');
                showAlert('Something went wrong. Please try again.', 'error');
            }
        });
    });

    // ── Change link (go back to Screen 1) ────────────────────────────
    $(document).on('click', '#otp-change-link', function () {
        clearCountdown();
        showScreen1();
        $('#otp-lookup').val(otpState.lookup);
    });

    // ── 6-digit box UX ───────────────────────────────────────────────
    $(document).on('input', '.otp-digit-input', function () {
        var $el  = $(this);
        var val  = $el.val().replace(/\D/g, '').slice(-1);
        $el.val(val);

        if (val !== '') {
            $el.addClass('otp-filled');
            var next = parseInt($el.data('index')) + 1;
            var $next = $('.otp-digit-input[data-index="' + next + '"]');
            if ($next.length) $next.focus();
        } else {
            $el.removeClass('otp-filled');
        }
    });

    $(document).on('keydown', '.otp-digit-input', function (e) {
        var $el = $(this);
        if (e.key === 'Backspace' && $el.val() === '') {
            var prev = parseInt($el.data('index')) - 1;
            var $prev = $('.otp-digit-input[data-index="' + prev + '"]');
            if ($prev.length) { $prev.val('').removeClass('otp-filled').focus(); }
        }
    });

    $(document).on('paste', '.otp-digit-input', function (e) {
        e.preventDefault();
        var pasted = (e.originalEvent.clipboardData || window.clipboardData)
                        .getData('text').replace(/\D/g, '').slice(0, 6);
        var digits = pasted.split('');
        $('.otp-digit-input').each(function (i) {
            if (digits[i] !== undefined) {
                $(this).val(digits[i]).addClass('otp-filled');
            }
        });
        var focusIdx = Math.min(digits.length, 5);
        $('.otp-digit-input[data-index="' + focusIdx + '"]').focus();
    });

    function clearDigits() {
        $('.otp-digit-input').val('').removeClass('otp-filled otp-error-border');
    }

    function getOtpValue() {
        var otp = '';
        $('.otp-digit-input').each(function () { otp += $(this).val(); });
        return otp;
    }

    // ── Countdown timer ───────────────────────────────────────────────
    function startCountdown(seconds) {
        clearCountdown();
        $('#otp-resend-timer').show();
        $('#otp-resend-link').removeClass('otp-show');

        var remaining = seconds;
        updateCountdownDisplay(remaining);

        otpState.countdownTimer = setInterval(function () {
            remaining--;
            if (remaining <= 0) {
                clearCountdown();
                $('#otp-resend-timer').hide();
                $('#otp-resend-link').addClass('otp-show');
            } else {
                updateCountdownDisplay(remaining);
            }
        }, 1000);
    }

    function updateCountdownDisplay(sec) {
        var m = Math.floor(sec / 60);
        var s = sec % 60;
        $('#otp-countdown').text(
            (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s
        );
    }

    function clearCountdown() {
        if (otpState.countdownTimer) {
            clearInterval(otpState.countdownTimer);
            otpState.countdownTimer = null;
        }
    }

    // ── Resend OTP ────────────────────────────────────────────────────
    $(document).on('click', '#otp-resend-link', function () {
        clearAlert();
        clearDigits();

        $.ajax({
            type: 'POST',
            url: $('#container-abc-url-id').text() + 'send-otp.php',
            data: { lookup: otpState.lookup, method: otpState.method },
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    startCountdown(45);
                    showAlert('OTP resent successfully.', 'success');
                } else {
                    showAlert(res.message || 'Failed to resend OTP.', 'error');
                }
            },
            error: function () {
                showAlert('Something went wrong. Please try again.', 'error');
            }
        });
    });

    // ── Verify OTP (Screen 2 submit) ──────────────────────────────────
    $(document).on('click', '#otp-verify-btn', function () {
        clearAlert();
        $('.otp-digit-input').removeClass('otp-error-border');

        var otp = getOtpValue();
        if (otp.length < 6) {
            showAlert('Please enter the complete 6-digit OTP.', 'error');
            $('.otp-digit-input').addClass('otp-error-border');
            return;
        }

        var $btn = $('#otp-verify-btn');
        $btn.prop('disabled', true).text('Verifying…');

        $.ajax({
            type: 'POST',
            url: $('#container-abc-url-id').text() + 'verify-otp.php',
            data: { member_id: otpState.memberId || '', lookup: otpState.lookup || '', otp: otp },
            dataType: 'json',
            success: function (res) {
                $btn.prop('disabled', false).text('Verify OTP');
                if (res.success) {
                    clearCountdown();
                    closeModal();
                    $('#otp-verified-banner').addClass('otp-show');
                    if (typeof otpState.onVerified === 'function') {
                        otpState.onVerified(res.member_id || otpState.memberId);
                    }
                } else {
                    showAlert(res.message || 'Invalid OTP. Please try again.', 'error');
                    $('.otp-digit-input').addClass('otp-error-border');
                }
            },
            error: function () {
                $btn.prop('disabled', false).text('Verify OTP');
                showAlert('Something went wrong. Please try again.', 'error');
            }
        });
    });

    // ── Close button & overlay click ─────────────────────────────────
    $(document).on('click', '#otp-close-btn', function () {
        closeModal();
        // Reset the member dropdown back to default if user cancels
        if (typeof window.onOtpModalCancelled === 'function') {
            window.onOtpModalCancelled();
        }
    });

    $(document).on('click', '#otp-overlay', function (e) {
        if ($(e.target).is('#otp-overlay')) {
            closeModal();
            if (typeof window.onOtpModalCancelled === 'function') {
                window.onOtpModalCancelled();
            }
        }
    });

    // ── Public API ────────────────────────────────────────────────────
    window.OtpMemberVerify = {
        open: function (options) {
            otpState.onVerified = (options && options.onVerified) ? options.onVerified : null;
            openModal();
        },
        close: closeModal
    };

}(jQuery));

<!-- OTP Member Verification Modal -->
<style>
.otp-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.55);
    z-index: 9000;
    justify-content: center;
    align-items: center;
}
.otp-overlay.otp-active {
    display: flex;
}
.otp-modal {
    background: #fff;
    border-radius: 8px;
    width: 380px;
    max-width: 95vw;
    box-shadow: 0 8px 32px rgba(0,0,0,0.22);
    overflow: hidden;
    position: relative;
    font-family: Arial, sans-serif;
}
.otp-modal-header {
    background: #357ca5;
    padding: 18px 20px 14px;
    text-align: center;
    position: relative;
}
.otp-modal-header h4 {
    color: #fff;
    margin: 0 0 4px;
    font-size: 18px;
    font-weight: bold;
}
.otp-modal-header p {
    color: rgba(255,255,255,0.88);
    margin: 0;
    font-size: 13px;
}
.otp-close-btn {
    position: absolute;
    top: 10px;
    right: 14px;
    background: none;
    border: none;
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    line-height: 1;
    padding: 0;
    opacity: 0.8;
}
.otp-close-btn:hover { opacity: 1; }

.otp-modal-body {
    padding: 22px 24px 18px;
}

/* ---- Screen 1 ---- */
#otp-screen-1 {}
#otp-screen-2 { display: none; }

.otp-field-group {
    margin-bottom: 14px;
}
.otp-field-group label {
    display: block;
    font-size: 13px;
    font-weight: bold;
    color: #444;
    margin-bottom: 5px;
}
.otp-field-group label span.otp-req {
    color: #ff5252;
}
.otp-field-group input[type="text"],
.otp-field-group input[type="number"] {
    width: 100%;
    height: 36px;
    padding: 6px 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    color: #555;
    background: #f9fcfa;
    box-sizing: border-box;
    transition: border-color 0.15s;
}
.otp-field-group input:focus {
    outline: none;
    border-color: #357ca5;
    box-shadow: 0 0 0 2px rgba(53,124,165,0.15);
}
.otp-field-group input.otp-error-border {
    border-color: #ff5252;
}

/* OTP Method Toggle */
.otp-method-toggle {
    display: flex;
    gap: 10px;
    margin-top: 4px;
}
.otp-method-btn {
    flex: 1;
    padding: 8px 0;
    border: 2px solid #ccc;
    border-radius: 5px;
    background: #f5f5f5;
    color: #666;
    font-size: 13px;
    font-weight: bold;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    transition: all 0.18s;
}
.otp-method-btn:hover {
    border-color: #357ca5;
    color: #357ca5;
}
.otp-method-btn.otp-selected {
    border-color: #357ca5;
    background: #357ca5;
    color: #fff;
}

/* Send / Verify button */
.otp-submit-btn {
    width: 100%;
    padding: 10px;
    background: #357ca5;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 15px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 6px;
    transition: background 0.18s;
}
.otp-submit-btn:hover { background: #2a6185; }
.otp-submit-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Security note */
.otp-security-note {
    text-align: center;
    font-size: 11.5px;
    color: #888;
    margin-top: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
}
.otp-security-note i { color: #357ca5; }

/* Error / Alert messages */
.otp-alert {
    padding: 8px 12px;
    border-radius: 4px;
    font-size: 13px;
    margin-bottom: 12px;
    display: none;
}
.otp-alert.otp-alert-error {
    background: #fdecea;
    border: 1px solid #f5c6cb;
    color: #c0392b;
}
.otp-alert.otp-alert-success {
    background: #eaf6ec;
    border: 1px solid #c3e6cb;
    color: #276632;
}
.otp-alert.otp-show { display: block; }

/* ---- Screen 2 ---- */
.otp-sent-to {
    text-align: center;
    font-size: 13px;
    color: #555;
    margin-bottom: 16px;
    line-height: 1.5;
}
.otp-sent-to strong {
    color: #333;
}
.otp-change-link {
    color: #357ca5;
    font-weight: bold;
    text-decoration: none;
    cursor: pointer;
    font-size: 13px;
}
.otp-change-link:hover { text-decoration: underline; }

/* 6-digit OTP boxes */
.otp-digits {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin: 10px 0 14px;
}
.otp-digit-input {
    width: 42px;
    height: 48px;
    text-align: center;
    font-size: 22px;
    font-weight: bold;
    border: 2px solid #ccc;
    border-radius: 6px;
    color: #333;
    background: #f9fcfa;
    transition: border-color 0.15s;
    -moz-appearance: textfield;
}
.otp-digit-input::-webkit-outer-spin-button,
.otp-digit-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
.otp-digit-input:focus {
    outline: none;
    border-color: #357ca5;
    box-shadow: 0 0 0 2px rgba(53,124,165,0.15);
}
.otp-digit-input.otp-filled {
    border-color: #357ca5;
    background: #f0f7fb;
}
.otp-digit-input.otp-error-border { border-color: #ff5252; }

/* Resend */
.otp-resend-row {
    text-align: center;
    font-size: 12.5px;
    color: #777;
    margin-bottom: 6px;
}
.otp-resend-link {
    color: #357ca5;
    font-weight: bold;
    cursor: pointer;
    text-decoration: none;
    display: none;
}
.otp-resend-link:hover { text-decoration: underline; }
.otp-resend-link.otp-show { display: inline; }
#otp-countdown { font-weight: bold; color: #357ca5; }

/* Success banner (shown in main form after modal closes) */
#otp-verified-banner {
    display: none;
    padding: 8px 14px;
    background: #eaf6ec;
    border: 1px solid #c3e6cb;
    color: #276632;
    border-radius: 4px;
    font-size: 13px;
    margin: 6px 0 4px;
}
#otp-verified-banner.otp-show {
    display: flex;
    align-items: center;
    gap: 8px;
}
</style>

<!-- Overlay + Modal -->
<div id="otp-overlay" class="otp-overlay" role="dialog" aria-modal="true" aria-labelledby="otp-modal-title">
    <div class="otp-modal">

        <!-- Header -->
        <div class="otp-modal-header">
            <button class="otp-close-btn" id="otp-close-btn" type="button" aria-label="Close">&times;</button>
            <h4 id="otp-modal-title">Verify Your Membership</h4>
            <p id="otp-modal-subtitle">Please verify your identity to access member details.</p>
        </div>

        <div class="otp-modal-body">

            <!-- Alert box (shared by both screens) -->
            <div id="otp-alert" class="otp-alert"></div>

            <!-- ======= Screen 1: Enter Details ======= -->
            <div id="otp-screen-1">

                <div class="otp-field-group">
                    <label for="otp-lookup">Email or Phone Number <span class="otp-req">*</span></label>
                    <input type="text" id="otp-lookup" placeholder="Enter your email or phone number" autocomplete="off" />
                </div>

                <div class="otp-field-group">
                    <label>Receive OTP via <span class="otp-req">*</span></label>
                    <div class="otp-method-toggle">
                        <button type="button" class="otp-method-btn" id="otp-method-email" data-method="email">
                            <i class="fa fa-envelope"></i> Email
                        </button>
                        <button type="button" class="otp-method-btn" id="otp-method-sms" data-method="sms">
                            <i class="fa fa-mobile"></i> SMS
                        </button>
                    </div>
                </div>

                <button type="button" class="otp-submit-btn" id="otp-send-btn">Send OTP</button>

                <div class="otp-security-note">
                    <i class="fa fa-lock"></i>
                    Your information is secure and will not be shared.
                </div>

            </div>
            <!-- ======= End Screen 1 ======= -->

            <!-- ======= Screen 2: Enter OTP ======= -->
            <div id="otp-screen-2">

                <div class="otp-sent-to">
                    OTP has been sent to<br>
                    <strong id="otp-masked-destination"></strong>
                    &nbsp;<a class="otp-change-link" id="otp-change-link">Change</a>
                </div>

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

                <div class="otp-security-note">
                    <i class="fa fa-lock"></i>
                    Your information is secure and will not be shared.
                </div>

            </div>
            <!-- ======= End Screen 2 ======= -->

        </div>
        <!-- end otp-modal-body -->

    </div>
    <!-- end otp-modal -->
</div>
<!-- end otp-overlay -->

<!-- Success banner shown in the main form after verification -->
<div id="otp-verified-banner">
    <i class="fa fa-check-circle" style="color:#276632;font-size:16px;"></i>
    Verification successful! You can now search and select member.
</div>

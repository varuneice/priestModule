<?php

function enforceOtpVerifiedSessionLimit($limitSeconds = 300) {
    if (
        !empty($_SESSION['otp_verified_member']) &&
        !empty($_SESSION['otp_verified_at']) &&
        (time() - (int) $_SESSION['otp_verified_at']) > $limitSeconds
    ) {
        unset($_SESSION['otp_verified_member'], $_SESSION['otp_verified_at']);
    }
}

enforceOtpVerifiedSessionLimit(30 * 60);


<?php
session_name('TimeSlotBookingCalendarPHP');
session_start();

unset($_SESSION['otp_verified_member'], $_SESSION['otp_verified_at']);

echo 'OTP session cleared';

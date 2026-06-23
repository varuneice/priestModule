<?php
$status = __('status');
$notice = __('notice');
$err = __('err');
$install_status = __('install_status');
$warning = __('warning');

if (isset($_SESSION['notice'])) {
    Util::printNotice($notice[$_SESSION['notice']], 'alert-success');
    unset($_SESSION['notice']);
} else {
    if(isset($_SESSION['status'])){
        $statusMsg = isset($status[$_SESSION['status']]) ? $status[$_SESSION['status']] : (string)$_SESSION['status'];
        Util::printNotice($statusMsg, 'alert-success');
        unset($_SESSION['status']);
    }
    if (isset($_SESSION['err'])) {
        Util::printNotice($err[$_SESSION['err']], 'alert-danger');
        unset($_SESSION['err']);
    }
    if (isset($tpl['warning'])) {
        Util::printNotice($warning[$tpl['warning']], 'alert-danger');
    }
    if (isset($tpl['status']) && $tpl['status'] != 'ok') {
        Util::printNotice($install_status[$tpl['status']], 'alert-warning');
    }
    if (isset($tpl['err_arr'])) {
        foreach (($tpl['err_arr'] ?? []) as $err) {
            Util::printNotice(ucfirst($err[0]) . " '<strong>" . $err[1] . "</strong>' is not writable.<br /><br />" . $err[2] . " '<strong>" . $err[1] . "</strong>'", 'alert-warning');
        }
    }
}
?>
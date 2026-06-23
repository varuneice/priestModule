<?php

require_once CONTROLLERS_PATH . 'App.php';

class Discount extends App {

    var $layout = 'admin';
    var $option_arr = null;

    function beforeFilter() {

        GzObject::loadFiles('Model', 'Option');
        $OptionModel = new OptionModel();
        $this->option_arr = $OptionModel->getAllPairValues();
        $this->tpl['option_arr'] = $OptionModel->getAllPairs();
        $this->tpl['option_arr_values'] = $this->option_arr;

        $this->tpl['js_format'] = Util::getJsDateFormta($this->tpl['option_arr_values']['date_format']);
        $this->tpl['iso_format'] = Util::getISODateFormta($this->tpl['option_arr_values']['date_format']);

        $tz = $this->tpl['option_arr_values']['timezone'] ?? '';
        if ($tz) {
            date_default_timezone_set($tz);
        }

        if (!($this->isLoged()) && ($_REQUEST['action'] ?? '') != 'login') {
            $_SESSION['err'] = 2;
            Util::redirect(INSTALL_URL . "Admin/login");
        }
        
        if ($this->isMember() ) {
            $_SESSION['err'] = 2;
            Util::redirect(INSTALL_URL . "Admin/login");
        }

        $this->css[] = array('file' => 'admin/gzstyling/bootstrap.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/font-awesome.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/ionicons.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/daterangepicker/daterangepicker-bs3.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'ui-custom.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/admin.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/gzstyle.css', 'path' => CSS_PATH);

        $this->js[] = array('file' => 'jquery/jquery-1.9.1.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/bootstrap.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/jquery.dataTables.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/dataTables.bootstrap.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/gzadmin/app.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery.ui.core.min.js', 'path' => LIBS_PATH . 'jquery/ui/js/');
        $this->js[] = array('file' => 'jquery.ui.widget.min.js', 'path' => LIBS_PATH . 'jquery/ui/js/');
        $this->js[] = array('file' => 'jquery.ui.button.min.js', 'path' => LIBS_PATH . 'jquery/ui/js/');
        $this->js[] = array('file' => 'jquery.ui.position.min.js', 'path' => LIBS_PATH . 'jquery/ui/js/');
        $this->js[] = array('file' => 'jquery.ui.dialog.min.js', 'path' => LIBS_PATH . 'jquery/ui/js/');
        $this->js[] = array('file' => 'jquery/jquery-validation-1.13.0/dist/jquery.validate.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/daterangepicker/daterangepicker.js', 'path' => JS_PATH);

        switch (@$_REQUEST['action']) {
            case 'discount':
                $this->js[] = array('file' => '/ajax-upload/jquery.form.js', 'path' => JS_PATH);
                break;
        }

        $this->js[] = array('file' => 'admin.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'GzDiscount.js', 'path' => JS_PATH);
    }

    function discount() {

        GzObject::loadFiles('Model', array('Discount', 'Calendar'));
        $DiscountModel = new DiscountModel();
        $CalendarModel = new CalendarModel();

        $opts = array();
        $this->tpl['discounts'] = array();

        $discounts = $DiscountModel->getAll($opts, 'id desc');

        foreach ($discounts as $key => $value) {

            $opts = array();
            $calendar = array();

            $opts[$CalendarModel->getTable() . '.id'] = $value['calendar_id'];
            if ($this->isEditor()) {
                $opts[$CalendarModel->getTable() . '.user_id'] = $this->getUserId();
            }
            $calendar = $CalendarModel->getI18nAll($opts);

            if ($this->isEditor()) {
                if (!empty($calendar[0])) {
                    if ($calendar[0]['user_id'] == $this->getUserId()) {

                        $this->tpl['discounts'][$key] = $value;
                        $this->tpl['discounts'][$key]['calendar'] = $calendar[0];
                    }
                }
            } else {
                $this->tpl['discounts'][$key] = $value;
                $this->tpl['discounts'][$key]['calendar'] = $calendar[0];
            }
        }

        $opts = array();
        if ($this->isEditor()) {
            $opts['user_id'] = $this->getUserId();
        }
        $this->tpl['calendars'] = $CalendarModel->getI18nAll($opts);
    }

    function get_discount_table() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Discount'));
        $DiscountModel = new DiscountModel();

        $opts = array();

        $discounts = $DiscountModel->getAll($opts, 'id desc');

        foreach ($discounts as $key => $value) {

            $opts = array();
            $calendar = array();

            $opts[$CalendarModel->getTable() . '.id'] = $value['calendar_id'];
            if ($this->isEditor()) {
                $opts[$CalendarModel->getTable() . '.user_id'] = $this->getUserId();
            }
            $calendar = $CalendarModel->getI18nAll($opts);

            if ($this->isEditor()) {
                if ($calendar[0]['user_id'] == $this->getUserId()) {

                    $this->tpl['discounts'][$key] = $value;
                    $this->tpl['discounts'][$key]['calendar'] = $calendar[0];
                }
            } else {
                $this->tpl['discounts'][$key] = $value;
                $this->tpl['discounts'][$key]['calendar'] = $calendar[0];
            }
        }
    }

    function add_discount() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Discount', 'Calendar'));
        $DiscountModel = new DiscountModel();
        $CalendarModel = new CalendarModel();

        $DiscountModel->save($_POST);

        $opts = array();

        $this->tpl['discounts'] = array();

        $discounts = $DiscountModel->getAll($opts, 'id desc');

        foreach ($discounts as $key => $value) {

            $opts = array();
            $calendar = array();

            $opts[$CalendarModel->getTable() . '.id'] = $value['calendar_id'];
            if ($this->isEditor()) {
                $opts['user_id'] = $this->getUserId();
            }
            $calendar = $CalendarModel->getI18nAll($opts);

            if ($this->isEditor()) {
                if (!empty($calendar[0]) && $calendar[0]['user_id'] == $this->getUserId()) {

                    $this->tpl['discounts'][$key] = $value;
                    $this->tpl['discounts'][$key]['calendar'] = $calendar[0];
                }
            } else {
                $this->tpl['discounts'][$key] = $value;
                $this->tpl['discounts'][$key]['calendar'] = $calendar[0] ?? [];
            }
        }

        $opts = array();
        if ($this->isEditor()) {
            $opts['user_id'] = $this->getUserId();
        }
        $this->tpl['calendars'] = $CalendarModel->getI18nAll($opts);
    }

    function get_frm_edit_discount() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Discount', 'Calendar'));
        $DiscountModel = new DiscountModel();
        $CalendarModel = new CalendarModel();

        if (!empty($_REQUEST['id'])) {
            $this->tpl['discount'] = $DiscountModel->get($_REQUEST['id']);
        }

        $opts = array();
        if ($this->isEditor()) {
            $opts['user_id'] = $this->getUserId();
        }
        $this->tpl['calendars'] = $CalendarModel->getI18nAll($opts);
    }

    function edit() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Discount', 'Calendar'));
        $DiscountModel = new DiscountModel();
        $CalendarModel = new CalendarModel();

        $data = array();

        $DiscountModel->update(array_merge($data, $_POST));

        $opts = array();

        $this->tpl['discounts'] = array();

        $discounts = $DiscountModel->getAll($opts, 'id desc');

        foreach ($discounts as $key => $value) {

            $opts = array();
            $calendar = array();

            $opts[$CalendarModel->getTable() . '.id'] = $value['calendar_id'];
            if ($this->isEditor()) {
                $opts['user_id'] = $this->getUserId();
            }
            $calendar = $CalendarModel->getI18nAll($opts);

            if ($this->isEditor()) {
                if ($calendar[0]['user_id'] == $this->getUserId()) {

                    $this->tpl['discounts'][$key] = $value;
                    $this->tpl['discounts'][$key]['calendar'] = $calendar[0];
                }
            } else {
                $this->tpl['discounts'][$key] = $value;
                $this->tpl['discounts'][$key]['calendar'] = $calendar[0];
            }
        }
    }

    function delete() {
        $this->isAjax = true;

        $id = $_REQUEST['id'];

        GzObject::loadFiles('Model', array('Discount', 'Calendar'));
        $DiscountModel = new DiscountModel();
        $CalendarModel = new CalendarModel();

        $DiscountModel->deleteFrom($DiscountModel->getTable())
                ->where('id', $id)->execute();

        $opts = array();

        $this->tpl['discounts'] = array();

        $discounts = $DiscountModel->getAll($opts, 'id desc');

        foreach ($discounts as $key => $value) {

            $opts = array();
            $calendar = array();

            $opts[$CalendarModel->getTable() . '.id'] = $value['calendar_id'];
            if ($this->isEditor()) {
                $opts['user_id'] = $this->getUserId();
            }
            $calendar = $CalendarModel->getI18nAll($opts);

            if ($this->isEditor()) {
                if ($calendar[0]['user_id'] == $this->getUserId()) {

                    $this->tpl['discounts'][$key] = $value;
                    $this->tpl['discounts'][$key]['calendar'] = $calendar[0];
                }
            } else {
                $this->tpl['discounts'][$key] = $value;
                $this->tpl['discounts'][$key]['calendar'] = $calendar[0];
            }
        }
    }

}

?>


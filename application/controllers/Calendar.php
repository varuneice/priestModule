<?php

require_once CONTROLLERS_PATH . 'App.php';

class Calendar extends App {

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
        $this->css[] = array('file' => 'ui-custom.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/daterangepicker/daterangepicker-bs3.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'gzadmin/plugins/colorpicker/dist/css/bootstrap-colorpicker.min.css', 'path' => JS_PATH);
        $this->css[] = array('file' => 'admin/admin.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/gzstyle.css', 'path' => CSS_PATH);

        $this->js[] = array('file' => 'jquery/jquery-1.9.1.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/bootstrap.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/jquery.dataTables.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/dataTables.bootstrap.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/gzadmin/app.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery-ui.min.js', 'path' => LIBS_PATH . 'jquery/ui/');
        $this->js[] = array('file' => 'gzadmin/plugins/daterangepicker/daterangepicker.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery/tinymce/tinymce.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery/jquery-validation-1.13.0/dist/jquery.validate.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'load.js?v=' . time(), 'path' => JS_PATH);

        switch (@$_REQUEST['action']) {
            case 'index':
                $this->js[] = array('file' => '/ajax-upload/jquery.form.js', 'path' => JS_PATH);
                break;
            case 'edit':
                $this->js[] = array('file' => '/ajax-upload/jquery.form.js', 'path' => JS_PATH);
                break;
            case 'cropImage':
                $this->css[] = array('file' => 'admin/jcrop/main.css', 'path' => CSS_PATH);
                $this->css[] = array('file' => 'admin/jcrop/jquery.Jcrop.css', 'path' => CSS_PATH);

                $this->js[] = array('file' => '/jcrop/jquery.Jcrop.js', 'path' => JS_PATH);
                break;
        }
        $this->js[] = array('file' => 'gzadmin/plugins/colorpicker/dist/js/bootstrap-colorpicker.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery/tinymce/tinymce.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'admin.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'GzCalendar.js', 'path' => JS_PATH);
    }

    function index() {
        GzObject::loadFiles('Model', array('Calendar'));
        $CalendarModel = new CalendarModel();

        $opts = array();

        if ($this->isEditor()) {
            $opts['user_id'] = $this->getUserId();
        }
        
        if ($this->isRental()) {
            $opts['user_id'] = $this->getUserId();
        }
        
        $arr = $CalendarModel->getI18nAll($opts);
        $result = array();

        foreach ($arr as $key => $value) {
            $result[$key] = $value;
            $opts = array();

            $opts['calendar_id'] = $value['id'];
        }
        $this->tpl['arr'] = $result;
    }

    function create() {
        GzObject::loadFiles('Model', array('Field', 'Calendar', 'User', 'Option'));
        $UserModel = new UserModel();
        $CalendarModel = new CalendarModel();
        $OptionModel = new OptionModel();

        if (!empty($_POST['create_calendar'])) {
            $FieldModel = new FieldModel();
            $data = array();

            $data['title'] = $_POST['title'][$this->tpl['default_language']['id']];

            $id = $CalendarModel->save(array_merge($data, $_POST));

            if (!empty($id)) {
                
                $opts = array();
                if (!empty($_POST['option_id'])) {
                    $opts['calendar_id'] = $_POST['option_id'] ?? '';
                } else {
                    $opts['calendar_id'] = 1;
                }
                $options = $OptionModel->getAll($opts, 'order');

                foreach ($options as $option) {

                    $data = array();

                    $data['key'] = $option['key'];
                    $data['tab_id'] = $option['tab_id'];
                    $data['group'] = $option['group'];
                    $data['value'] = $option['value'];
                    $data['title'] = $option['title'];
                    $data['description'] = $option['description'];
                    $data['label'] = $option['label'];
                    $data['type'] = $option['type'];
                    $data['order'] = $option['order'];
                    $data['calendar_id'] = $id;

                    $OptionModel->save($data);
                }

                $data = array();

                $data['title'] = $_POST['title'] ?? '';

                $FieldModel->saveI18n($id, $data, $CalendarModel->getTable());
                $_SESSION['status'] = 1;
            } else {
                $_SESSION['status'] = 2;
            }

            Util::redirect(INSTALL_URL . "Calendar/index");
        }
        if (!$this->isEditor()) {
            $this->tpl['users'] = $UserModel->getAll();
        }
        $opts = array();
        if ($this->isEditor()) {
            $opts['user_id'] = $this->getUserId();
        }
        $this->tpl['calendars'] = $CalendarModel->getI18nAll($opts);
    }

    function edit() {

        GzObject::loadFiles('Model', array('Calendar', 'Field', 'User'));
        $CalendarModel = new CalendarModel();
        $FieldModel = new FieldModel();
        $UserModel = new UserModel();

        $this->tpl['users'] = $UserModel->getAll();

        if (isset($_POST['edit_calendar'])) {

            $data['title'] = $_POST['title'][$this->tpl['default_language']['id']];
            $CalendarModel->update(array_merge($data, $_POST));

            $data = array();
            $data['title'] = $_POST['title'] ?? '';

            $FieldModel->deleteFrom($FieldModel->getTable())
                    ->where('table_name', $CalendarModel->getTable())
                    ->where('in_id', $_POST['id'] ?? '')->execute();

            $FieldModel->saveI18n($_POST['id'], $data, $CalendarModel->getTable());

            $_SESSION['status'] = 5;
            Util::redirect(INSTALL_URL . "Calendar/index");
        } else {
            $id = $_GET['id'] ?? '';

            $arr = $CalendarModel->getI18n($id);

            if (count($arr) === 0) {
                $_SESSION['status'] = 8;
                Util::redirect(INSTALL_URL . "Calendar/index");
            }
            if ($this->isEditor()) {
                if ($this->getUserId() != $arr['user_id']) {
                    $_SESSION['status'] = 8;
                    Util::redirect(INSTALL_URL . "Calendar/index");
                }
            }
            $this->tpl['arr'] = $arr;
        }
    }

    function delete() {

        $this->isAjax = true;

        $id = $_REQUEST['id'];

        GzObject::loadFiles('Model', array('Calendar', 'Field', 'Option'));
        $CalendarModel = new CalendarModel();
        $FieldModel = new FieldModel();
        $OptionModel = new OptionModel();

        if ($this->isEditor()) {
            $arr = $CalendarModel->get($id);
            if ($arr && $this->getUserId() != $arr['user_id']) {
                die();
            }
        }

        $CalendarModel->deleteFrom($CalendarModel->getTable())
                ->where('id', $id)->execute();
        $OptionModel->deleteFrom($OptionModel->getTable())
                ->where('calendar_id', $id)->execute();
        $FieldModel->deleteFrom($FieldModel->getTable())
                ->where('in_id', $id)->where('table_name', $CalendarModel->getTable())->execute();

        $opts = array();

        $arr = $CalendarModel->getAll($opts, 'date asc');

        $this->index();
    }

    function deleteSelected() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Calendar'
            , 'Field', 'Option'));
        $CalendarModel = new CalendarModel();
        $FieldModel = new FieldModel();
        $OptionModel = new OptionModel();

        if (!empty($_POST['mark'])) {

            $CalendarModel->deleteFrom($CalendarModel->getTable())
                    ->where('id', $_POST['mark'] ?? '')->execute();

            $OptionModel->deleteFrom($OptionModel->getTable())
                    ->where('calendar_id', $_POST['mark'] ?? '')->execute();

            $FieldModel->deleteFrom($FieldModel->getTable())
                    ->where('in_id', $_POST['mark'] ?? '')->where('table_name', $FieldModel->getTable())->execute();
        }

        $this->index();
    }

    function settings() {
        $opts = array();

        GzObject::loadFiles('Model', array('Option'));
        $OptionModel = new OptionModel();

        if (isset($_POST['update_option'])) {

            $_arr = $OptionModel->getAll();
            $options = array();

            foreach ($_arr as $key => $value) {
                $options[$value['key']] = $value;
            }

            foreach ($_POST as $key => $value) {

                if (array_key_exists($key, $options)) {
                    $sql_value = $OptionModel->escape($value, null, $options[$key]['type']);

                    $query = "UPDATE `" . $OptionModel->getTable() . "` SET `value` = ? WHERE `key` = ? AND `calendar_id` = ? LIMIT 1";
                    $pdo = $OptionModel->getPdo();

                    $stmt = $pdo->prepare($query);

                    $stmt->execute([$sql_value, $key, $_GET['id'] ?? '']);
                    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }

            $_SESSION['status'] = 29;
        }

        $opts = array();

        $opts['tab_id'] = 1;
        $opts['calendar_id'] = $_GET['id'] ?? '';

        $this->tpl['general'] = $OptionModel->getAll($opts, 'order');

        $query = $OptionModel->from($OptionModel->getTable())
                ->where(array('`calendar_id` = ?' => $_GET['id'] ?? ''))
                ->where(array('`tab_id` = ?' => 2))
                ->where(array('`group`= ?' => 'options'))
                ->orderBy("`order`");

        $this->tpl['booking']['options'] = $query->fetchAll();

        $query = $OptionModel->from($OptionModel->getTable())
                ->where(array('`calendar_id` = ?' => $_GET['id'] ?? ''))
                ->where(array('`tab_id` = ?' => 2))
                ->where(array('`group` = ?' => 'booking_form'))
                ->orderBy("`order`");

        //echo $query->getQuery();
        $this->tpl['booking']['booking_form'] = $query->fetchAll();

        $query = $OptionModel->from($OptionModel->getTable())
                ->where(array('`calendar_id` = ?' => $_GET['id'] ?? ''))
                ->where(array('`tab_id` = ?' => 3))
                ->orderBy("`order`");

        $this->tpl['payment'] = $query->fetchAll();

        $query = $OptionModel->from($OptionModel->getTable())
                ->where(array('`calendar_id` = ?' => $_GET['id'] ?? ''))
                ->where(array('`tab_id` = ?' => 4))
                ->where(array('`group` = ?' => 'client'))
                ->orderBy("`order`");

        $this->tpl['emails']['client'] = $query->fetchAll();

        $query = $OptionModel->from($OptionModel->getTable())
                ->where(array('`calendar_id` = ?' => $_GET['id'] ?? ''))
                ->where(array('`tab_id` = ?' => 4))
                ->where(array('`group` = ?' => 'admin'))
                ->orderBy("`order`");

        $this->tpl['emails']['admin'] = $query->fetchAll();
        
        $query = $OptionModel->from($OptionModel->getTable())
                ->where(array('`calendar_id` = ?' => $_GET['id'] ?? ''))
                ->where(array('`tab_id` = ?' => 4))
                ->where(array('`group` = ?' => 'member'))
                ->orderBy("`order`");
        
        $this->tpl['emails']['member'] = $query->fetchAll();
        
        $query = $OptionModel->from($OptionModel->getTable())
                ->where(array('`calendar_id` = ?' => $_GET['id'] ?? ''))
                ->where(array('`tab_id` = ?' => 8))
                ->where(array('`group` = ?' => 'forgot'))
                ->orderBy("`order`");
        
        $this->tpl['emails']['forget'] = $query->fetchAll();

        $query = $OptionModel->from($OptionModel->getTable())
                ->where(array('`calendar_id` = ?' => $_GET['id'] ?? ''))
                ->where(array('`tab_id` = ?' => 5))
                ->orderBy("`order`");

        $this->tpl['terms'] = $query->fetchAll();

        $query = $OptionModel->from($OptionModel->getTable())
                ->where(array('`calendar_id` = ?' => $_GET['id'] ?? ''))
                ->where(array('`tab_id` = ?' => 6))
                ->where(array('`group` = ?' => 'template'))
                ->orderBy("`order`");

        $this->tpl['invoice']['template'] = $query->fetchAll();

        $query = $OptionModel->from($OptionModel->getTable())
                ->where(array('`calendar_id` = ?' => $_GET['id'] ?? ''))
                ->where(array('`tab_id` = ?' => 6))
                ->where(array('`group` = ?' => 'company'))
                ->orderBy("`order`");

        $this->tpl['invoice']['company'] = $query->fetchAll();

        $query = $OptionModel->from($OptionModel->getTable())
                ->where(array('`calendar_id` = ?' => $_GET['id'] ?? ''))
                ->where(array('`tab_id` = ?' => 7))
                ->orderBy("`order`");

        $this->tpl['appearance']['options'] = $query->fetchAll();
    }

    function view() {

        $this->layout = 'empty';
    }

}

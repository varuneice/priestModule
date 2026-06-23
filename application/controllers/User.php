<?php

require_once CONTROLLERS_PATH . 'App.php';

class User extends App {

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
        if ((!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login') || (!$this->isAdmin() && !in_array(($_REQUEST['action'] ?? ''), array('edit')))) {
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
        $this->js[] = array('file' => 'jquery-ui.min.js', 'path' => LIBS_PATH . 'jquery/ui/');
        $this->js[] = array('file' => 'ajax-upload/das.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'ajax-upload/jquery.form.js', 'path' => JS_PATH);

        $this->js[] = array('file' => 'jquery/jquery-validation-1.13.0/dist/jquery.validate.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);

        $this->js[] = array('file' => 'gzadmin/plugins/daterangepicker/daterangepicker.js', 'path' => JS_PATH);

        $this->js[] = array('file' => 'admin.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'GzUser.js', 'path' => JS_PATH);
    }

    function create() {
        GzObject::loadFiles('Model', array('User'));
        $UserModel = new UserModel();

        if (!empty($_POST['create_user'])) {

            $data = array();

            if (!empty($_FILES['img'])) {

                require_once APP_PATH . 'helpers/uploader/class.upload.php';

                $handle = new upload($_FILES['img']);

                $img_name = time();

                if ($handle->uploaded) {

                    $thumb_dest = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';

                    $handle->file_new_name_body = $img_name;
                    $handle->image_resize = true;
                    $handle->image_x = 200;
                    $handle->image_ratio_y = true;
                    $handle->allowed = array('image/*');
                    $handle->process($thumb_dest);

                    if ($handle->processed) {
                        $handle->clean();
                    } else {
                        echo 'error : ' . $handle->error;
                    }
                    $data['avatar'] = $handle->file_dst_name;
                }
            }

            $data['password'] = md5($_POST['password'] ?? '');
            unset($_POST['password']);

            $id = $UserModel->save(array_merge($_POST, $data));

            if (!empty($id)) {

                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "User/index");
        }
    }

    function edit() {

        GzObject::loadFiles('Model', array('User'));
        $UserModel = new UserModel();
        
        if (!$this->isAdmin() && $_REQUEST['id'] != $this->getUserId()) {
            $_SESSION['err'] = 2;
            Util::redirect(INSTALL_URL . "Admin/login");
        }

        if (!empty($_POST['edit_user'])) {
            $data = array();

            if (!empty($_FILES['img'])) {

                require_once APP_PATH . 'helpers/uploader/class.upload.php';

                $handle = new upload($_FILES['img']);

                $img_name = time();

                if ($handle->uploaded) {

                    $thumb_dest = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';

                    $handle->file_new_name_body = $img_name;
                    $handle->image_resize = true;
                    $handle->image_x = 200;
                    $handle->image_ratio_y = true;
                    $handle->allowed = array('image/*');
                    $handle->process($thumb_dest);

                    if ($handle->processed) {
                        $handle->clean();
                    } else {
                        echo 'error : ' . $handle->error;
                    }
                    $data['avatar'] = $handle->file_dst_name;
                }
            }

            if (!empty($_POST['password'])) {
                $data['password'] = md5($_POST['password'] ?? '');
                unset($_POST['password']);
            }

            $id = $UserModel->update(array_merge($data, $_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "User/index");
            }
        }
        $id = $_GET['id'] ?? '';
        $arr = $UserModel->get($id);

        $this->tpl['arr'] = $arr;
    }

    function index() {

        GzObject::loadFiles('Model', array('User'));
        $UserModel = new UserModel();

        $opts = array();

        $arr = $UserModel->getAll(array_merge($opts));

        $this->tpl['arr'] = $arr;
    }

    function delete() {
        $this->isAjax = true;

        $id = $_REQUEST['id'];

        GzObject::loadFiles('Model', array('User'));
        $UserModel = new UserModel();

        $UserModel->deleteFrom($UserModel->getTable())
                ->where('id', $id)->execute();

        $opts = array();

        $arr = $UserModel->getAll($opts);

        $this->tpl['arr'] = $arr;
    }

    function deleteSelected() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('User'));
        $UserModel = new BookingModel();

        if (!empty($_POST['mark'])) {

            $UserModel->deleteFrom($UserModel->getTable())
                    ->where('id', $_POST['mark'] ?? '')->execute();
        }

        $arr = $UserModel->getAll();

        $this->tpl['arr'] = $arr;
    }

    function deleteImage() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('User'));
        $UserModel = new UserModel();

        if (!empty($_POST['id'])) {

            $id = $_POST['id'] ?? '';

            $user = $UserModel->get($id);

            $dest = INSTALL_PATH . UPLOAD_PATH . "avatar/thumb/" . $user['avatar'];
            if (is_file($dest)) {
                unlink($dest);
            }

            $data = array();
            $data['avatar'] = '';

            $UserModel->update(array_merge($_POST, $data));
        }

        $opts = array();

        $this->tpl['arr'] = $UserModel->getAll($opts, 'id desc');
    }

    function deleteEditedImage() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('User'));
        $UserModel = new UserModel();

        if (!empty($_POST['id'])) {

            $id = $_POST['id'] ?? '';

            $user = $UserModel->get($id);

            $dest = INSTALL_PATH . UPLOAD_PATH . "avatar/thumb/" . $user['avatar'];
            if (is_file($dest)) {
                unlink($dest);
            }

            $data = array();
            $data['avatar'] = '';

            $UserModel->update(array_merge($_POST, $data));
        }
    }

}

?>


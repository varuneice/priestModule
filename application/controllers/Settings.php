<?php

require_once CONTROLLERS_PATH . 'App.php';

class Settings extends App {

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

        if (!($this->isLoged() && ($this->isAdmin() || $this->isEditor())) && ($_REQUEST['action'] ?? '') != 'login') {
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

        $this->js[] = array('file' => 'jquery/tinymce/tinymce.min.js', 'path' => LIBS_PATH);

        $this->js[] = array('file' => 'admin.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'GzSettings.js', 'path' => JS_PATH);
    }

    function index() {
        Util::redirect(INSTALL_URL . "Settings/languages");
    }

    function languages() {
        
    }

    function add_local() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Languages', 'Local'));
        $LanguagesModel = new LanguagesModel();
        $LocalModel = new LocalModel();

        $LocalModel->save($_POST);

        $this->tpl['languages'] = $LanguagesModel->getAll(null, 'order');

        foreach ($this->tpl['languages'] as $k => $v) {
            $this->tpl['local'][$v['id']] = $LocalModel->getAll(array('language_id' => $v['id']));
        }
    }

    function updaet_local() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Languages', 'Local'));
        $LanguagesModel = new LanguagesModel();
        $LocalModel = new LocalModel();

        $LocalModel->update($_POST);

        $this->tpl['languages'] = $LanguagesModel->getAll(null, 'order');

        foreach ($this->tpl['languages'] as $k => $v) {
            $this->tpl['local'][$v['id']] = $LocalModel->getAll(array('language_id' => $v['id']));
        }
    }

    function active_language() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Languages'));
        $LanguagesModel = new LanguagesModel();

        if (!empty($_POST['id'])) {

            $data = array();
            $data['isdefault'] = '0';

            $LanguagesModel->update($data);

            $data = array();
            $data['isdefault'] = '1';
            $data['id'] = $_POST['id'] ?? '';

            $LanguagesModel->update($data);
        }
        $this->tpl['languages'] = $LanguagesModel->getAll(null, 'order');
    }

    function edit_language() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Languages', 'Local'));
        $LanguagesModel = new LanguagesModel();

        if (!empty($_POST['id'])) {

            $data = array();

            if (!empty($_FILES['flag'])) {

                require_once APP_PATH . 'helpers/uploader/class.upload.php';

                $handle = new upload($_FILES['flag']);

                $img_name = $_POST['language'] ?? '';

                if ($handle->uploaded) {

                    $thumb_dest = INSTALL_PATH . UPLOAD_PATH . 'flag';

                    $handle->file_new_name_body = $img_name;
                    $handle->image_resize = true;
                    $handle->image_x = 16;
                    $handle->image_ratio_y = true;
                    $handle->allowed = array('image/*');
                    $handle->process($thumb_dest);

                    if ($handle->processed) {
                        // $handle->clean();
                    }
                    $data['flag'] = $handle->file_dst_name;
                }
            }
            unset($_POST['flag']);

            $lang = $LanguagesModel->get($_POST['id'] ?? '');

            $dest = INSTALL_PATH . UPLOAD_PATH . "flag/" . $lang['flag'];
            if (is_file($dest)) {
                unlink($dest);
            }

            $data['isdefault'] = (!empty($_POST['isdefault'])) ? 1 : 0;
            
            if($data['isdefault'] == 1){
                $LanguagesModel->update(array('isdefault' => 0));
            }
            
            $LanguagesModel->update(array_merge($_POST, $data));
            
            if($data['isdefault'] == 0){
                $opts = array();
                $opts['isdefault'] = 1;
                $langs = $LanguagesModel->getAll($opts);
                
                if(empty($langs)){
                    $data['isdefault'] = 1;
                    $LanguagesModel->update(array_merge($_POST, $data));
                }
            }
        }
        $this->tpl['languages'] = $LanguagesModel->getAll(null, 'order');
    }

    function get_frm_edit_language() {
        $this->isAjax = true;
        if (!empty($_POST['id'])) {

            GzObject::loadFiles('Model', array('Languages'));
            $LanguagesModel = new LanguagesModel();

            $this->tpl['language'] = $LanguagesModel->get($_POST['id'] ?? '');
        }
    }

    function add_language() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Languages', 'Local'));
        $LanguagesModel = new LanguagesModel();
        $LocalModel = new LocalModel();

        $data = array();

        if (!empty($_FILES['flag'])) {

            require_once APP_PATH . 'helpers/uploader/class.upload.php';

            $handle = new upload($_FILES['flag']);

            $img_name = $_POST['language'] ?? '';

            if ($handle->uploaded) {

                $thumb_dest = INSTALL_PATH . UPLOAD_PATH . 'flag';

                $handle->file_new_name_body = $img_name;
                $handle->image_resize = true;
                $handle->image_x = 16;
                $handle->image_ratio_y = true;
                $handle->allowed = array('image/*');
                $handle->process($thumb_dest);

                if ($handle->processed) {
                    // $handle->clean();
                }
                $data['flag'] = $handle->file_dst_name;
            }
        }

        unset($_POST['flag']);
        $data['order'] = count($LanguagesModel->getAll()) + 1;

        $id = $LanguagesModel->save(array_merge($_POST, $data));

        if (!empty($id)) {

            $query = "
        SELECT *
        FROM `" . $LocalModel->getTable() . "`
        WHERE `language_id` = :id
    ";
            $ins = '';
            $vals = '';
            $_arr = array();
            $pdo = $LanguagesModel->getPdo();

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $this->tpl['default_language']['id']);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Re-build a new MySQL query by
            // looping all columns within the row,
            // updating any columns with new values
            // if required.
            $bindings = array();

            foreach ($res as $val) {

                $_arr[] = "('" . $id . "','" . $val['type'] . "','" . $val['layout'] . "','" . $val['value'] . "','" . $val['field'] . "','" . $val['key'] . "','" . $val['arr_key'] . "')";
            }

            // Run the new query to
            // insert the "copied" row.
            $new_query = "
            INSERT INTO `" . $LocalModel->getTable() . "`
                (`language_id`, `type`, `layout`, `value`, `field`, `key`, `arr_key`)
            VALUES " . implode(',', $_arr) . ";";

            $new_stmt = $pdo->prepare($new_query);
            $new_stmt->execute($bindings);
        }

        $this->tpl['languages'] = $LanguagesModel->getAll(null, 'order');
    }

    function delete_language() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Languages', 'Local', 'Field'));
        $LanguagesModel = new LanguagesModel();
        $FieldModel = new FieldModel();
        $LocalModel = new LocalModel();

        if (!empty($_POST['id'])) {
            $query = $LanguagesModel->deleteFrom($LanguagesModel->getTable())
                    ->ignore()
                    ->where('id', $_POST['id'] ?? '');
            $query->execute();

            $query = $FieldModel->deleteFrom($FieldModel->getTable())
                    ->ignore()
                    ->where('language_id', $_POST['id'] ?? '');
            $query->execute();

            $query = $LocalModel->deleteFrom($LocalModel->getTable())
                    ->ignore()
                    ->where('language_id', $_POST['id'] ?? '');
            $query->execute();
        }
        $this->tpl['languages'] = $LanguagesModel->getAll(null, 'order');
    }

    function sort_languages() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Languages'));
        $LanguagesModel = new LanguagesModel();

        if (!empty($_POST['order'])) {
            $data['order'] = 1;
            foreach (($_POST['order'] ?? []) as $id) {
                $data['id'] = $id;
                $LanguagesModel->update($data);
                $data['order'] ++;
            }
        }
        $this->tpl['languages'] = $LanguagesModel->getAll(null, 'order');
    }
    
    function general() {
        $opts = array();

        GzObject::loadFiles('Model', array('GlobalOption'));
        $GlobalOptionModel = new GlobalOptionModel();

        if (isset($_POST['update_option'])) {

            $option_arr = $GlobalOptionModel->getAllPairValues();

            $_arr = $GlobalOptionModel->getAll();
            $options = array();

            foreach ($_arr as $key => $value) {
                $options[$value['key']] = $value;
            }

            foreach ($_POST as $key => $value) {

                if (array_key_exists($key, $options)) {
                    if ($key == 'smtp_pass' && $value == '') {
                        $value = $option_arr['smtp_pass'];
                    }

                    $sql_value = $GlobalOptionModel->escape($value, null, $options[$key]['type']);

                    $query = "UPDATE `" . $GlobalOptionModel->getTable() . "` SET `value` = '$sql_value' WHERE `key` = '$key' LIMIT 1";
                    $pdo = $GlobalOptionModel->getPdo();

                    $stmt = $pdo->prepare($query);

                    $stmt->execute();
                    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }

            $_SESSION['status'] = 29;
        }

        $this->option_arr = $GlobalOptionModel->getAllPairValues();
        $this->tpl['global_option_arr'] = $GlobalOptionModel->getAllPairs();
        $this->tpl['global_option_arr_values'] = $this->option_arr;

        $opts = array();

        $this->tpl['general'] = $GlobalOptionModel->getAll($opts, 'order');
    }
    

}

?>



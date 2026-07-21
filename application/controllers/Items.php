<?php

require_once CONTROLLERS_PATH . 'App.php';

class Items extends App {

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
        $action = $_REQUEST['action'] ?? '';
        if ((!$this->isLoged() && $action != 'login') || (!$this->isAdmin() && !in_array($action, array('edit')))) {
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
        $this->js[] = array('file' => 'GzItems.js', 'path' => JS_PATH);

    }
    
    function create() {
        GzObject::loadFiles('Model', array('Items', 'Category'));
        $ItemsModel = new ItemsModel();
        $CategoryModel = new CategoryModel();
        $arr= $CategoryModel->getcategory();
        $this->tpl['Categoryname'] =  $arr;

        if (!empty($_POST['create'])) {


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
           // $data = array();
            $item = $_POST['items'] ?? '';
            //$price = $_POST['price'] ?? '';
            
           // $id = $ItemsModel->getMaxid() + 1;
           // $_POST['id'] = $id;
            
            $id = $ItemsModel->save(array_merge($_POST, $data));

            if (!empty($id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "Items/index");
        }

    }
    

    function edit() {
        GzObject::loadFiles('Model', array('Items', 'Category'));
        $ItemsModel = new ItemsModel();
        $CategoryModel = new CategoryModel();
        $arr= $CategoryModel->getcategory();
        $this->tpl['Categoryname'] =  $arr;
    
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

            if (empty($_FILES['img'])) {
                $avat = $_POST['avatar'] ?? '';
                //$event = $_POST['events'];
                $item = $_POST['items'] ?? '';
                //$price = $_POST['price'] ?? '';
                //$eventprice = $price."/".$event."/". $avat;
                //$_POST['price'] = $eventprice;
                //$_POST['events'] = $eventprice;
                $id = $ItemsModel->update(array_merge($data, $_POST));
            } else {
                $item = $_POST['items'] ?? '';
                //$price = $_POST['price'] ?? '';
                $avat = $data['avatar'];
                //$_POST['avatar'] = $avat;
                //$eventprice = $price."/".$event."/". $avat;
                //$_POST['price'] = $eventprice;
                //$_POST['events'] = $eventprice;
                $id = $ItemsModel->update(array_merge($data, $_POST));
                
            }
            //$data = array();
            

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "Items/index");
            }
        }
        $id = $_GET['id'] ?? '';
        $Itemsarr = $ItemsModel->get($id);
        $this->tpl['Itemsarr'] = $Itemsarr;

    }


    function index() {
        GzObject::loadFiles('Model', array('Items'));
        $ItemsModel = new ItemsModel();
        
        $opts = array();
        $Itemsarr = $ItemsModel->getAll($opts);
        $this->tpl['Itemsarr'] = $Itemsarr;
        
    } 

    // function itemindex() {

    //     GzObject::loadFiles('Model', array('Eventname'));
    //     $ItemsModel = new ItemsModel();
     
    //     $opts = array();
    //     //$Eventdonationarr = $EventnameModel->getAll($opts);
    //     //$this->tpl['Eventdonationarr'] = $Eventdonationarr;
    //    }
      

    function export() {

        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Items'));
        $ItemsModel = new ItemsModel();
        
        //$BookingSlotModel = new BookingSlotModel();

        $output = "";

        $query = $ItemsModel->from($ItemsModel->getTable());

        $Items = $query->fetchAll();

        if (empty($Items)) { header('Content-Type: text/html; charset=utf-8'); echo 'No data to export.'; exit; }

        foreach ($Items[0] as $k => $v) {
            $output .= '"' . $k . '",';
        }
        $output .= "\n";

        foreach ($Items as $key => $value) {

            $opts = array();
            $opts['member_id'] = $value['id'];
            $slots = $ItemsModel->getAll($opts);

            foreach ($value as $k => $v) {
                if ($k == 'date') {
                    $output .= '"' . date("Y-m-d H:i", $v) . '",';
                } else {
                    $output .= '"' . $v . '",';
                }
            }
            // foreach($slots as $slot){
            //     foreach($slot as $k => $s){
            //         if($k != 'id' && $k != 'calendar_id' && $k != 'booking_id'){
            //             if($k == 'timestamp'){
            //                 $output .='"' . date("Y-m-d H:i", $s) . '",';
            //             }else{
            //                 $output .='"' . $s . '",';
            //             }
            //         }
            //     }
            // }
            $output .= "\n";
        }

        $filename = "Itemsrecords_" . time() . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        echo $output;
        exit;
    }

    function delete() {
        $this->isAjax = true;

        $id = $_REQUEST['id'];

        GzObject::loadFiles('Model', array('Items'));
        $ItemsModel = new ItemsModel();

        $ItemsModel->deleteFrom($ItemsModel->getTable())
                ->where('id', $id)->execute();

        $opts = array();
        //$this->eventindex();
        Util::redirect(INSTALL_URL . "Items/index");
        //$arr = $EventnameModel->getAll($opts);
        //$this->tpl['arr'] = $arr;
    }

    function deleteImage() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Items'));
        $ItemsModel = new ItemsModel();

        if (!empty($_POST['id'])) {

            $id = $_POST['id'] ?? '';

            $Items = $ItemsModel->get($id);

            $dest = INSTALL_PATH . UPLOAD_PATH . "avatar/thumb/" . $Items['avatar'];
            if (is_file($dest)) {
                unlink($dest);
            }

            $data = array();
            $data['avatar'] = '';

            $ItemsModel->update(array_merge($_POST, $data));
        }

        $opts = array();

        $this->tpl['Itemsarr'] = $ItemsModel->getAll($opts, 'id desc');
    }


    function deleteEditedImage() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Items'));
        $ItemsModel = new ItemsModel();

        if (!empty($_POST['id'])) {

            $id = $_POST['id'] ?? '';

            $Items = $ItemsModel->get($id);

            $dest = INSTALL_PATH . UPLOAD_PATH . "avatar/thumb/" . $Items['avatar'];
            if (is_file($dest)) {
                unlink($dest);
            }

            $data = array();
            $data['avatar'] = '';

            $ItemsModel->update(array_merge($_POST, $data));
        }
    }



    function import() {
        if (!empty($_POST['import'])) {
            if (!empty($_FILES['csv_file'])) {
                $filename = time() . '_' . $_FILES['csv_file']['name'];
    
                $path = INSTALL_PATH . UPLOAD_PATH . 'csv/' . $filename;
    
                $this->tpl['Itemsarr'] = array();
    
                if (move_uploaded_file($_FILES['csv_file']['tmp_name'], $path)) {
                    $row = 0;
                    if (($handle = fopen($path, "r")) !== false) {
                        while (($data = fgetcsv($handle, 1000, ",", '"', '\\')) !== false) {
                            $num = count($data);
                            if (!empty($num) && $num > 1 && !empty($data)) {
                                if ($data[0] != 'id') {
                                    $row++;
                                   // if($row == 1 ){
                                    //     continue;
                                    //        }
                                    $this->tpl['Itemsarr'][$row] = array();
    
                                    for ($c = 0; $c < $num; $c++) {
                                        $this->tpl['Itemsarr'][$row][] = $data[$c];
                                    }
                                } else {
                                    continue;
                                }
                            }
                        }
                        fclose($handle);
                    }
                    $this->tpl['row_count'] = $row;
                }
            }
        } elseif (!empty($_POST['save'])) {
            if (!empty($_POST['id'])) {
                GzObject::loadFiles('Model', array('Items'));
                $ItemsModel = new ItemsModel();
                // $BookingSlotModel = new BookingSlotModel();
    
                foreach (($_POST['id'] ?? []) as $k => $v) {
                    $data = array();
    
                    $data['id']=$data[' ']=$_POST['id'][$k];
                    $data['categories']=$_POST['categories'][$k];
                    $data['count']=$_POST['count'][$k];
                    $data['title']=$_POST['title'][$k];
                    $data['description']=$_POST['description'][$k];
                    $data['rent_by_hour']=$_POST['rent_by_hour'][$k];
                    $data['rent_by_day']=$_POST['rent_by_day'][$k];
                    $data['rent_by_week']=$_POST['rent_by_week'][$k];

                    
                    $id = $ItemsModel->save($data);
    
                    // if(!empty($_POST['timestamp'][$v])){
                        //     foreach ($_POST['timestamp'][$v] as $key => $value) {
                        //         $data = array();
                        //         $data['calendar_id'] = $_POST['calendar_id'][$k];
                        //         $data['booking_id'] = $id;
                        //         $data['timestamp'] = strtotime($value);
                        //         $data['count'] = $_POST['count'][$v][$key];
                        //         $data['timecreated'] = time();
    
                        //         $BookingSlotModel->save($data);
                        //     }
                    // }
                }
                $status = 30;
                $_SESSION['status'] = $status;
    
                Util::redirect(INSTALL_URL . "Items/index");
            }
        }
    }
    
    

}

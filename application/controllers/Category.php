<?php

require_once CONTROLLERS_PATH . 'App.php';

class Category extends App
{

    var $layout = 'admin';
    var $option_arr = null;

    function beforeFilter()
    {
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

        if (!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login') {

            if (($_REQUEST['action'] ?? '') != 'edit') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
        }
       
        $this->css[] = array('file' => 'front/style.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/bootstrap.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/font-awesome.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/ionicons.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/gzstyle.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/daterangepicker/daterangepicker-bs3.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'ui-custom.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/admin.css', 'path' => CSS_PATH);

        $this->js[] = array('file' => 'jquery/jquery-1.9.1.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/bootstrap.min.js', 'path' => JS_PATH);

        $this->js[] = array('file' => 'gzadmin/plugins/datatables/jquery.dataTables.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/dataTables.bootstrap.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/gzadmin/app.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery-ui.min.js', 'path' => LIBS_PATH . 'jquery/ui/');
        $this->js[] = array('file' => 'ajax-upload/das.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'ajax-upload/jquery.form.js', 'path' => JS_PATH);

        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);

        $this->js[] = array('file' => 'gzadmin/plugins/daterangepicker/daterangepicker.js', 'path' => JS_PATH);

        $this->js[] = array('file' => 'admin.js', 'path' => JS_PATH);

        $this->js[] = array('file' => 'GzCategory.js', 'path' => JS_PATH);      
        // $this->js[] = array('file' => 'loadingoverlay.js', 'path' => JS_PATH);
        
    }

    function create()
    {
        GzObject::loadFiles('Model', array('Category'));
        $CategoryModel = new CategoryModel();

        if (!empty($_POST['create'])) {


            // $data = array();

            $id = $CategoryModel->save(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "Category/index");
        }

    }
    function rentalcreate()
    {
        GzObject::loadFiles('Model', array('rentaladvancepayment'));
        $rentaladvancepaymentModel = new rentaladvancepaymentModel();

        if (!empty($_POST['rentalcreate'])) {


            // $data = array();

            $id = $rentaladvancepaymentModel->save(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "Category/index");
        }

    }

    // function edit(){
    //     $this->isAjax = true;
        
    //     GzObject::loadFiles('Model', array('Category', 'Calendar'));
    //     $CategoryModel = new CategoryModel();
    //     $CalendarModel = new CalendarModel();
        
    //     if(!empty($_POST['id'])){
            
    //         //$_POST['is_day_off'] = (!empty($_POST['is_day_off'])) ? 1 : 0;
    //         //$_POST['timestamp'] = Util::dateToTimestamp('m/d/Y', $_POST['timestamp']);
    //        // $_POST['timestamp_end'] = Util::dateToTimestamp('m/d/Y', $_POST['timestamp_end']);
            
    //         $CategoryModel->update($_POST);
    //     }
        
    //     $this->tpl['Categoryarr'] = $CategoryModel->getAll();

    //     // foreach ($this->tpl['arr'] as $k => $v) {
    //     //     $this->tpl['arr'][$k]['calendar'] = $CalendarModel->getI18n($v['calendar_id']);
    //     // }
    // }
   
    function edit(){
    
        GzObject::loadFiles('Model', array('Category', 'rentaladvancepayment'));
        $CategoryModel = new CategoryModel();
		$rentaladvancepaymentModel = new rentaladvancepaymentModel();

      if (!empty($_POST['edit_Category'])) {

            $data = array();
            $id = $CategoryModel->update(array_merge($data, $_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "Category/index");
            }
        }
        $id = $_GET['id'] ?? '';
        $Categoryarr = $CategoryModel->get($id);

        $this->tpl['Categoryarr'] = $Categoryarr;
        if (!empty($_POST['edit_addamount'])) {

            $data = array();
            $id = $rentaladvancepaymentModel->update(array_merge($data, $_POST));
    

            if (!empty($bong)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "Category/index");
            }

        }
        $id = $_GET['id'] ?? '';
        $rentalarr = $rentaladvancepaymentModel->get($id);

        $this->tpl['rentalarr'] = $rentalarr;
     
    }



    function index()
    {
        GzObject::loadFiles('Model', array('Category', 'rentaladvancepayment'));
        $CategoryModel = new CategoryModel();
        $rentaladvancepaymentModel = new rentaladvancepaymentModel();

        $opts = array();
        $Categoryarr = $CategoryModel->getAll($opts);
        $this->tpl['Categoryarr'] = $Categoryarr;


        $opts = array();
        $advanceamountarr = $rentaladvancepaymentModel->getAll($opts);
        $this->tpl['advanceamountarr'] = $advanceamountarr;

    }






    function delete()
    {
        $this->isAjax = true;

        $id = $_REQUEST['id'];

        GzObject::loadFiles('Model', array('Category'));
        $CategoryModel = new CategoryModel();

        $CategoryModel->deleteFrom($CategoryModel->getTable())
            ->where('id', $id)->execute();

        $opts = array();
        Util::redirect(INSTALL_URL . "Category/index");
        // $arr = $CategoryModel->getAll($opts);
        //  $this->tpl['arr'] = $arr;
    }

    function export()
    {

        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Member', 'Category'));
        $CategoryModel = new CategoryModel();



        $output = "";

        $query = $CategoryModel->from($CategoryModel->getTable());


        $members = $query->fetchAll();

        if (empty($members)) { header('Content-Type: text/html; charset=utf-8'); echo 'No data to export.'; exit; }

        foreach ($members[0] as $k => $v) {
            $output .= '"' . $k . '",';
        }
        $output .= "\n";

        foreach ($members as $key => $value) {

            $opts = array();
            $opts['member_id'] = $value['id'];
            $slots = $CategoryModel->getAll($opts);

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

        $filename = "category_" . time() . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        echo $output;
        exit;
    }


    function import()
    {
        if (!empty($_POST['import'])) {
            if (!empty($_FILES['csv_file'])) {
                $filename = time() . '_' . $_FILES['csv_file']['name'];

                $path = INSTALL_PATH . UPLOAD_PATH . 'csv/' . $filename;

                $this->tpl['categoryarr'] = array();

                if (move_uploaded_file($_FILES['csv_file']['tmp_name'], $path)) {
                    $row = 0;
                    if (($handle = fopen($path, "r")) !== false) {
                        while (($data = fgetcsv($handle, 1000, ",", '"', '\\')) !== false) {
                            $num = count($data);
                            if (!empty($num) && $num > 1 && !empty($data)) {
                                if ($data[0] != 'id') {
                                    $row++;
                                     //if($row == 1 ){
                                        //continue;
                                           // }
                                    $this->tpl['categoryarr'][$row] = array();

                                    for ($c = 0; $c < $num; $c++) {
                                        $this->tpl['categoryarr'][$row][] = $data[$c];
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
                GzObject::loadFiles('Model', array('Category'));
                $CategoryModel = new CategoryModel();
              
                foreach (($_POST['id'] ?? []) as $k => $v) {
                    $data = array();

                    $data['id'] = $data[' '] = $_POST['id'][$k];
                    $data['category'] = $_POST['category'][$k];

                    $id = $CategoryModel->save($data);

                    // if(!empty($_POST['timestamp'][$v])){
                    //     foreach (($_POST['timestamp'][$v] ?? []) as $key => $value) {
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

                Util::redirect(INSTALL_URL . "Category/index");
            }
        }

    }

}

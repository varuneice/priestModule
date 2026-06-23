<?php

require_once CONTROLLERS_PATH . 'App.php';
class Eventadmin extends App {

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

        $this->js[] = array('file' => 'GzEvent.js', 'path' => JS_PATH);      
       // $this->js[] = array('file' => 'loadingoverlay.js', 'path' => JS_PATH);
    }
    
    function create() {
        GzObject::loadFiles('Model', array('Eventname', 'ticketeventname','ticketeventday'));
        $EventnameModel = new EventnameModel();
        $ticketeventnameModel = new ticketeventnameModel();
        $ticketeventdayModel = new ticketeventdayModel();
        if (!empty($_POST['create'])) {
            $eventval = $_POST['eventtype'] ?? '';
            if($eventval == 'ticket'){

                    if (!empty($_FILES['image'])) {

                        require_once APP_PATH . 'helpers/uploader/class.upload.php';
        
                        $handle = new upload($_FILES['image']);
        
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
                            $data['ticketavatar'] = $handle->file_dst_name;
                        }
                    }
                    //$data = array();
                    $newp = $_POST['ticketprice'] ?? [];

                    $names_str =  implode("/",$newp);
                    $_POST['ticketprice'] = $names_str;

                    $day = $_POST['itemeventday'] ?? [];
                    $new =  implode("/",$day);
                    $_POST['itemeventday'] = $new;


                    $event = $_POST['ticketevents'] ?? '';
                    $avat = $data['ticketavatar'] ?? '';
                    $_POST['ticketavatar'] = $avat;
                 
        
                    $eventprice = $event."/".$avat;
                    $_POST['ticketevents'] = $eventprice;
                    $id = $ticketeventnameModel->save(array_merge($_POST));
                    $newid = $id;
                   $i = 0;
                  if($newid !=""){
                    foreach ($newp as $z) {
                           
                    $_POST['eventid'] = $newid;
                    $_POST['ticketprice'] = $z;
                    $_POST['itemeventday'] = $day[$i];
                    $id = $ticketeventdayModel->save(array_merge($_POST));
                        $i++;                   
                                           
                        }
                    
                    }
                    if (!empty($id)) {
                        $_SESSION['status'] = 16;
                    } else {
                        $_SESSION['status'] = 17;
                    }
                    Util::redirect(INSTALL_URL . "Eventadmin/eventindex");
                }
            
            else{
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
            $event = $_POST['events'] ?? '';
            $price = $_POST['price'] ?? '';
            $avat = $data['avatar'] ?? '';
            $_POST['avatar'] = $avat;

            $eventprice = $price."/".$event."/".$avat;
            $_POST['price'] = $eventprice;
            //$_POST['events'] = $eventprice;
            $id = $EventnameModel->save(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "Eventadmin/eventindex");
        }
      }
    }
    
    function createbackup18() {
        GzObject::loadFiles('Model', array('Eventname', 'ticketeventname','ticketeventday'));
        $EventnameModel = new EventnameModel();
        $ticketeventnameModel = new ticketeventnameModel();
        $ticketeventdayModel = new ticketeventdayModel();
        if (!empty($_POST['create'])) {
            $eventval = $_POST['eventtype'] ?? '';
            if($eventval == 'ticket'){

                    if (!empty($_FILES['image'])) {

                        require_once APP_PATH . 'helpers/uploader/class.upload.php';
        
                        $handle = new upload($_FILES['image']);
        
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
                            $data['ticketavatar'] = $handle->file_dst_name;
                        }
                    }
                    //$data = array();
                    $newp = $_POST['ticketprice'] ?? [];

                    $names_str =  implode("/",$newp);
                    $_POST['ticketprice'] = $names_str;

                    $day = $_POST['itemeventday'] ?? [];
                    $new =  implode("/",$day);
                    $_POST['itemeventday'] = $new;


                    $event = $_POST['ticketevents'] ?? '';
                    $avat = $data['ticketavatar'] ?? '';
                    $_POST['ticketavatar'] = $avat;
                 
        
                    $eventprice = $event."/".$avat;
                    $_POST['ticketevents'] = $eventprice;
                    $id = $ticketeventnameModel->save(array_merge($_POST));
                    $newid = $id;
                   $i = 0;
                  if($newid !=""){
                    foreach ($newp as $z) {
                           
                    $_POST['eventid'] = $newid;
                    $_POST['ticketprice'] = $z;
                    $_POST['itemeventday'] = $day[$i];
                    $id = $ticketeventdayModel->save(array_merge($_POST));
                        $i++;                   
                                           
                        }
                    
                    }
                    if (!empty($id)) {
                        $_SESSION['status'] = 16;
                    } else {
                        $_SESSION['status'] = 17;
                    }
                    Util::redirect(INSTALL_URL . "Eventadmin/eventindex");
                }
            
            else{
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
            $event = $_POST['events'] ?? '';
            $price = $_POST['price'] ?? '';
            $avat = $data['avatar'] ?? '';
            $_POST['avatar'] = $avat;

            $eventprice = $price."/".$event."/".$avat;
            $_POST['price'] = $eventprice;
            //$_POST['events'] = $eventprice;
            $id = $EventnameModel->save(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "Eventadmin/eventindex");
        }
      }
    }
    

    function edit() {
        GzObject::loadFiles('Model', array('Eventname'));
        $EventnameModel = new EventnameModel();
       
    
        if (!empty($_POST['edit_event'])) {
            $data = array();
            if (!empty($_FILES['image'])) {

                require_once APP_PATH . 'helpers/uploader/class.upload.php';

                $handle = new upload($_FILES['image']);

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

            if (empty($_FILES['image'])) {
                $avat = $_POST['avatar'] ?? '';
                $event = $_POST['events'] ?? '';
                $price = $_POST['price'] ?? '';
                $eventprice = $price."/".$event."/". $avat;
                $_POST['price'] = $eventprice;
                //$_POST['events'] = $eventprice;
                $id = $EventnameModel->update(array_merge($data, $_POST));
               
                    
                    
            } else {
                $event = $_POST['events'] ?? '';
                $price = $_POST['price'] ?? '';
                $avat = $data['avatar'];
                $_POST['avatar'] = $avat;
                $eventprice = $price."/".$event."/". $avat;
                $_POST['price'] = $eventprice;
                //$_POST['events'] = $eventprice;
                $id = $EventnameModel->update(array_merge($data, $_POST));
                
                
            }
            //$data = array();
            

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin() && !$this->isEvents()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "Eventadmin/eventindex");
            }
        }
        $id = $_GET['id'] ?? '';
        $Eventarr = $EventnameModel->get($id);

        $this->tpl['Eventarr'] = $Eventarr;

    }

    function deletechlid($deleteid)
    {

        $conn = gz_mysqli_connect(DEFAULT_HOST, DEFAULT_USER, DEFAULT_PASS, DEFAULT_DB);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
           }
           $sql = "DELETE  FROM ticketevevetday WHERE eventid  = '$deleteid'";
           mysqli_query($conn, $sql);
          
        $retval = mysqli_query($conn, $sql);
        //$checkdata = $retval;
        return $retval;

    }

    function ticketedit() {
        GzObject::loadFiles('Model', array('ticketeventname', 'ticketeventday'));
        $ticketeventnameModel = new ticketeventnameModel();
        $ticketeventdayModel = new ticketeventdayModel();
        if (!empty($_POST['edit_ticket'])) {
            $data = array();
            if (!empty($_FILES['image'])) {

                require_once APP_PATH . 'helpers/uploader/class.upload.php';

                $handle = new upload($_FILES['image']);

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
                    $data['ticketavatar'] = $handle->file_dst_name;
                }
            }

            if (empty($_FILES['image'])) {
                $avat = $_POST['ticketavatar'] ?? '';
                $event = $_POST['ticketevents'] ?? '';
                $newp = $_POST['ticketprice'] ?? '';
                $day = $_POST['itemeventday'] ?? [];
                $new =  implode("/", is_array($day) ? $day : []);
                $_POST['itemeventday'] = $new;
                
                $eventprice =$event."/". $avat;
                //$_POST['ticketprice'] = $eventprice;
                $id = $ticketeventnameModel->update(array_merge($data, $_POST));
                $deleteid = $_POST['id'] ?? '';
                //$ticketeventdayModel->ticketdelete($deleteid);
                 $retval = $this->deletechlid($deleteid);
                if ($retval == true) {
                    $i = 0;
                    if ($deleteid != "") {
                        foreach ($newp as $z) {

                            $_POST1['eventid'] = $deleteid;
                            $_POST1['ticketprice'] = $z;
                            $_POST1['itemeventday'] = $day[$i];
                            $id = $ticketeventdayModel->save(array_merge($_POST1));
                            $i++;

                        }
                    }
                }   
            } else {
                $event = $_POST['itemtevents'] ?? '';
                $newp = $_POST['ticketprice'] ?? '';
                $avat = $data['ticketavatar'] ?? '';
                $_POST['ticketavatar'] = $avat;
                $eventprice = $event."/". $avat;
                $day = $_POST['itemeventday'] ?? [];
                $new =  implode("/", is_array($day) ? $day : []);
                $_POST['itemeventday'] = $new;
                //$_POST['ticketprice'] = $eventprice;

                $id = $ticketeventnameModel->update(array_merge($data, $_POST));
                $deleteid = $_POST['id'] ?? '';
                $retval = $this->deletechlid($deleteid);
                if ($retval == true) {
                    $i = 0;
                    if ($deleteid != "") {
                        foreach ($newp as $z) {

                            $_POST1['eventid'] = $deleteid;
                            $_POST1['ticketprice'] = $z;
                            $_POST1['itemeventday'] = $day[$i];
                            $id = $ticketeventdayModel->save(array_merge($_POST1));
                            $i++;

                        }
                    }
                }
            }
                     

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin() && !$this->isEvents()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "Eventadmin/eventindex");
            }
        }
        $id = $_GET['id'] ?? '';
        $ticketeventarr = $ticketeventnameModel->get($id);

        $this->tpl['ticketeventarr'] = $ticketeventarr;

        $ticketdayarr = $ticketeventdayModel->ticketall($id);

        $this->tpl['ticketdayarr'] = $ticketdayarr;
    }
    
    function  index() {
        GzObject::loadFiles('Model', array('Event', 'ticket'));
        $EventModel = new EventModel();
        $ticketModel = new ticketModel();

        $opts = array();
        $Eventarr = $EventModel->EventAll($opts);
        $this->tpl['Eventarr'] = $Eventarr;
   
        $opts = array();
        $ticketarr = $ticketModel->ticketAlldata($opts);
        $this->tpl['ticketarr'] = $ticketarr;
    } 

    function eventindex() {

        GzObject::loadFiles('Model', array('Eventname', 'ticketeventname' , 'vendorpaymentaccount' , 'ThresholdAmount'));
        $EventnameModel = new EventnameModel();
        $ticketeventnameModel = new ticketeventnameModel();
        
        // 28 july
         $vendorpaymentaccountModel = new vendorpaymentaccountModel();
         $ThresholdAmount = new ThresholdAmountModel();

        $opts = array();
        $Eventdonationarr = $EventnameModel->getAll($opts);
        $this->tpl['Eventdonationarr'] = $Eventdonationarr;

        $opts = array();
        $Eventticketarr = $ticketeventnameModel->getAll($opts);
        $this->tpl['Eventticketarr'] = $Eventticketarr;
        
        
        // 28 july
        
        //Get selected payment account
        $vendorpayAccountarr = $vendorpaymentaccountModel->EventPaymentAccount();
        $this->tpl['EventAccount'] = $vendorpayAccountarr;
        
        $totalAmount =  $ThresholdAmount->getThresholdAmount();
        $this->tpl['amount'] =  $totalAmount[0] ?? null;
        
        
        
        
        
       }
      

    function export() {

        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Event'));
        $EventModel = new EventModel();
        
        //$BookingSlotModel = new BookingSlotModel();

        $output = "";

        $query = $EventModel->from($EventModel->getTable());

        $Event = $query->fetchAll();

        foreach ($Event[0] ?? [] as $k => $v) {
            $output .= '"' . $k . '",';
        }
        $output .= "\n";

        foreach ($Event as $key => $value) {

            $opts = array();
            $opts['member_id'] = $value['id'];
            $slots = $EventModel->getAll($opts);

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

        $filename = "Eventrecords_" . time() . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        echo $output;
        exit;
    }
    function ticketexport() {

        $this->isAjax = true;

        GzObject::loadFiles('Model', array('ticket'));
        $ticketModel = new ticketModel();

        $output = "";

        $query = $ticketModel->from($ticketModel->getTable());

        $ticket = $query->fetchAll();

        foreach ($ticket[0] ?? [] as $k => $v) {
            $output .= '"' . $k . '",';
        }
        $output .= "\n";

        foreach ($ticket as $key => $value) {

            $opts = array();
            $opts['member_id'] = $value['id'];
            $slots = $ticketModel->getAll($opts);

            foreach ($value as $k => $v) {
                if ($k == 'date') {
                    $output .= '"' . date("Y-m-d H:i", $v) . '",';
                } else {
                    $output .= '"' . $v . '",';
                }
            }
            $output .= "\n";
        }

        $filename = "ticketrecords_" . time() . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        echo $output;
        exit;
    }


    function delete() {
        $this->isAjax = true;

        $id = $_REQUEST['id'];

        GzObject::loadFiles('Model', array('Eventname', 'ticketeventname','ticketeventday'));
        $EventnameModel = new EventnameModel();
        $ticketeventnameModel = new ticketeventnameModel();
        $ticketeventdayModel = new ticketeventdayModel();

        $EventnameModel->deleteFrom($EventnameModel->getTable())
                ->where('id', $id)->execute();

          $ticketeventnameModel->deleteFrom($ticketeventnameModel->getTable())
            ->where('id', $id)->execute();
        $ticketeventdayModel->deleteFrom($ticketeventdayModel->getTable())
                ->where('eventid', $id)->execute();
        $opts = array();
        Util::redirect(INSTALL_URL . "Eventadmin/eventindex");
      
    }
    
    function deleteImage() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Eventname'));
        $EventnameModel = new EventnameModel();

        if (!empty($_POST['id'])) {

            $id = $_POST['id'] ?? '';

            $Eventname = $EventnameModel->get($id);

            $dest = INSTALL_PATH . UPLOAD_PATH . "avatar/thumb/" . $Eventname['avatar'];
            if (is_file($dest)) {
                unlink($dest);
            }

            $data = array();
            $data['avatar'] = '';

            $EventnameModel->update(array_merge($_POST, $data));
        }

        $opts = array();

        $this->tpl['Eventarr'] = $EventnameModel->getAll($opts, 'id desc');
    }


    function deleteEditedImage() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Eventname'));
        $EventnameModel = new EventnameModel();

        if (!empty($_POST['id'])) {

            $id = $_POST['id'] ?? '';

            $Eventname = $EventnameModel->get($id);

            $dest = INSTALL_PATH . UPLOAD_PATH . "avatar/thumb/" . $Eventname['avatar'];
            if (is_file($dest)) {
                unlink($dest);
            }

            $data = array();
            $data['avatar'] = '';

            $EventnameModel->update(array_merge($_POST, $data));
        }
    }

 function deleteEditedticketImage() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('ticketeventname', 'Eventname'));
        $ticketeventnameModel = new ticketeventnameModel();
        $EventnameModel = new EventnameModel();

        if (!empty($_POST['id'])) {

            $id = $_POST['id'] ?? '';

            $Eventticketname = $ticketeventnameModel->get($id);

            $dest = INSTALL_PATH . UPLOAD_PATH . "avatar/thumb/" . $Eventticketname['avatar'];
            if (is_file($dest)) {
                unlink($dest);
            }

            $data = array();
            $data['avatar'] = '';

            $ticketeventnameModel->update(array_merge($_POST, $data));

            $Eventname = $EventnameModel->get($id);

            $dest = INSTALL_PATH . UPLOAD_PATH . "avatar/thumb/" . $Eventname['avatar'];
            if (is_file($dest)) {
                unlink($dest);
            }

            $data = array();
            $data['avatar'] = '';

            $EventnameModel->update(array_merge($_POST, $data));
        }
    }
    
    
    // 28 july
     function eventPaymentEdit()
    {
        GzObject::loadFiles('Model', array('vendorpaymentaccount', 'User'));
        $vendorpaymentaccountModel = new vendorpaymentaccountModel();
        $UserModel = new UserModel();

        $id = $_GET['id'] ?? '';
        $PayArr = $vendorpaymentaccountModel->get($id);
        $this->tpl['payarr'] = $PayArr;
        
     //echo "<script type='text/javascript'>alert('" . "hello" . "');</script>";

        if (!empty($_POST['paymentaccount'])) {

            if ($this->isAdmin() || $this->isEditor()) {
                $id = $this->getUserId();
                $admin = $UserModel->get($id);
                $rolename = $admin['first'] . ' ' . $admin['last'];
                $_POST['admin_id'] = $admin['id'];
                $_POST['admin_name'] = $rolename;
            }

             $id = $vendorpaymentaccountModel->update($_POST);

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "Eventadmin/eventindex");
            }
        }
    }
    
    
    function thresholdamount()
    {
        $this->layout = 'login';

        GzObject::loadFiles('Model', array('ThresholdAmount', 'User'));
        $ThresholdAmount = new ThresholdAmountModel();
        $UserModel = new UserModel();


        if (!empty($_POST['amount'])) {

            if ($this->isAdmin() || $this->isEditor()) {
                $id = $this->getUserId();
                $admin = $UserModel->get($id);
                $rolename = $admin['first'] . ' ' . $admin['last'];
                $_POST['admin_id'] = $admin['id'];
                $_POST['admin_name'] = $rolename;
            }



             $id =   $ThresholdAmount->update($_POST);



            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "Eventadmin/eventindex");
            }
        }

        else{
            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "Eventadmin/eventindex");
            }
        }
    }


    function import() {
        if (!empty($_POST['import'])) {
            if (!empty($_FILES['csv_file'])) {
                $filename = time() . '_' . $_FILES['csv_file']['name'];
    
                $path = INSTALL_PATH . UPLOAD_PATH . 'csv/' . $filename;
    
                $this->tpl['eventarr'] = array();
    
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
                                    $this->tpl['eventarr'][$row] = array();
    
                                    for ($c = 0; $c < $num; $c++) {
                                        $this->tpl['eventarr'][$row][] = $data[$c];
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
                GzObject::loadFiles('Model', array('Eventname'));
                $EventnameModel = new EventnameModel();
                // $BookingSlotModel = new BookingSlotModel();
    
                foreach (($_POST['id'] ?? []) as $k => $v) {
                    $data = array();
    
                    $data['id']=$data[' ']=$_POST['id'][$k];
                    $data['events']=$_POST['events'][$k];
                    $data['price']=$_POST['price'][$k];
                    $data['Startdate']=$_POST['Startdate'][$k];
                    $data['Enddate']=$_POST['Enddate'][$k];
                    $data['Starttime']=$_POST['Starttime'][$k];
                    $data['Endtime']=$_POST['Endtime'][$k];
                    
                    $id = $EventnameModel->save($data);
    
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
    
                Util::redirect(INSTALL_URL . "Eventadmin/eventindex");
            }
        }
    }
    
    

}

?>


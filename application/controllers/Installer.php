<?php

require_once FRAMEWORK_PATH . 'Controller.class.php';

class Installer extends Controller {

    var $layout = 'install';

    function Installer() {
        
    }

    function beforeFilter() {
        $this->js[] = array('file' => 'jquery/jquery-1.9.1.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/bootstrap.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/jquery.dataTables.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/dataTables.bootstrap.js', 'path' => JS_PATH);
        //$this->js[] = array('file' => 'gzadmin/gzadmin/app.js', 'path' => JS_PATH);

        $this->css[] = array('file' => 'admin/gzstyling/bootstrap.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/font-awesome.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/ionicons.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/gzstyle.css', 'path' => CSS_PATH);

        $this->css[] = array('file' => 'admin/admin.css', 'path' => CSS_PATH);
    }

    function importSQL($file, $admin_username, $admin_password, $prefix, $link) {
        $string = file_get_contents($file);
        $string = preg_replace(
                array('/INSERT\s+INTO\s+`/', '/DROP\s+TABLE\s+IF\s+EXISTS\s+`/', '/CREATE\s+TABLE\s+IF\s+NOT\s+EXISTS\s+`/', '/DROP\s+TABLE\s+`/', '/CREATE\s+TABLE\s+`/'), array('INSERT INTO `' . $prefix, 'DROP TABLE IF EXISTS `' . $prefix, 'CREATE TABLE IF NOT EXISTS `' . $prefix, 'DROP TABLE `' . $prefix, 'CREATE TABLE `' . $prefix), $string);

        $arr = preg_split('/;(\s+)?\n/', $string);
        foreach ($arr as $v) {
            $v = trim($v);
            if (!empty($v)) {
                mysqli_query($link, $v) or die(mysqli_error($link));
            }
        }
        require('application/config/constants.php');

        if (!defined('DEFAULT_DB')) {
            define("DEFAULT_DB", $_POST['database']);
        }
        if (!defined('DEFAULT_HOST')) {
            define("DEFAULT_HOST", $_POST['hostname']);
        }
        if (!defined('DEFAULT_USER')) {
            define("DEFAULT_USER", $_POST['username']);
        }
        if (!defined('DEFAULT_PASS')) {
            define("DEFAULT_PASS", $_POST['password']);
        }
        if (!defined('DEFAULT_PREFIX')) {
            define("DEFAULT_PREFIX", $_POST['prefix']);
        }

        GzObject::loadFiles('Model', 'User');
        $UserModel = new UserModel();

        $UserModel->prefix = DEFAULT_PREFIX;

        $data['email'] = $admin_username;
        $data['password'] = md5($admin_password);
        $data['status'] = 'T';
        $data['type'] = '1';

        $query = $UserModel->insertInto($UserModel->getTable(), $data);
        $lastInsert = $query->execute();
    }

    function index() {
        Util::redirect(INSTALL_URL . "Installer&action=step1&install=1");
    }

    function step0() {
        
    }

    function step1() {

        $filename = 'application/config/constants.php';
        $this->tpl['warning'] = array();
        $this->tpl['status'] = 1;

        if (!is_writable($filename)) {
            $this->tpl['warning'][] = 'You need to Changing File Permissions (chmod 777) to file located at: ' . $filename;
            $this->tpl['status'] = 0;
        }
        $this->js[] = array('file' => 'jquery/jquery-1.9.1.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery/jquery-validation-1.13.0/dist/jquery.validate.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'installer.js', 'path' => JS_PATH);
    }

    function step2() {

        if (isset($_POST['step1'])) {
            $this->tpl['status'] = 1;
            $_SESSION[$this->default_product]['Installer'] = $_POST;

            $link = gz_mysqli_connect(
                $_POST['hostname'] ?? '',
                $_POST['username'] ?? '',
                $_POST['password'] ?? '',
                ''
            );
            if (!$link || $link->connect_error) {
                $this->tpl['warning'][] = "It is not possible to open a TCP/IP connection with database.";
                $this->tpl['status'] = 0;
            } else {
                $db_selected = mysqli_select_db($link, $_POST['database'] ?? '');
                if (!$db_selected) {
                    $this->tpl['warning'][] = "Database not exist!";
                    $this->tpl['status'] = 0;
                } else {
                    if (!$this->checkTablesExist($link)) {
                        $this->tpl['warning'][] = "All tables in databes exist! All the data will be deleted?";
                    }
                }
            }

            $this->js[] = array('file' => 'jquery/jquery-validation-1.13.0/dist/jquery.validate.min.js', 'path' => LIBS_PATH);
            $this->js[] = array('file' => 'installer.js', 'path' => JS_PATH);
        }
    }

    function step3() {

        if (isset($_POST['step2'])) {

            @set_time_limit(240); //seconds

            $this->tpl['status'] = true;
            $filename = 'application/config/constants.php';

            $string = file_get_contents('application/config/constants.original.php');

            if ($string === FALSE) {
                exit;
            }

            $string = str_replace('[hostname]', $_POST['hostname'], $string);
            $string = str_replace('[username]', $_POST['username'], $string);
            $string = str_replace('[password]', $_POST['password'], $string);
            $string = str_replace('[database]', $_POST['database'], $string);
            $string = str_replace('[prefix]', $_POST['prefix'], $string);

            $pathinfo = pathinfo($_SERVER["PHP_SELF"]);

            $string = str_replace('[INSTALL_PATH]', str_replace("\\", "/", ROOT_PATH), $string);
            $string = str_replace('[INSTALL_URL]', 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}" . $pathinfo['dirname'] . '/', $string);
            $string = str_replace('[INSTALL_FOLDER]', $pathinfo['dirname'], $string);

            if (is_writable($filename)) {
                if (!$handle = fopen($filename, 'wb')) {
                    exit;
                }

                if (fwrite($handle, $string) === FALSE) {
                    exit;
                }

                fclose($handle);
            } else {
                exit;
            }

            $link = gz_mysqli_connect(
                $_POST['hostname'] ?? '',
                $_POST['username'] ?? '',
                $_POST['password'] ?? '',
                ''
            );

            if (!$link || $link->connect_error) {
                exit;
            }
            $db_selected = mysqli_select_db($link, $_POST['database'] ?? '');
            if (!$db_selected) {
                exit;
            }

            $this->importSQL('application/config/database.sql', $_POST['admin_email'], $_POST['admin_password'], $_POST['prefix'], $link);

            Util::redirect(INSTALL_URL . "Admin/login");
        }
    }

    function checkTablesExist($link) {
        $string = file_get_contents('application/config/database.sql');
        preg_match_all('/DROP\s+TABLE(\s+IF\s+EXISTS)?\s+`(\w+)`/i', $string, $match);
        if (count($match[0]) > 0) {
            $arr = array();
            foreach ($match[2] as $k => $table) {
                $r = mysqli_query($link, sprintf("SHOW TABLES FROM `%s` LIKE '%s'", $_SESSION[$this->default_product]['Installer']['database'], $_SESSION[$this->default_product]['Installer']['prefix'] . $table
                ));
                if (mysqli_num_rows($r) > 0) {
                    $row = mysqli_fetch_assoc($r);
                    $row = array_values($row);
                    $arr[] = $row[0];
                }
            }
            return count($arr) === 0;
        }
        return true;
    }

}

?>


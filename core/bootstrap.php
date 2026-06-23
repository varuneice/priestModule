<?php

class Bootstrap {

    protected $_url;
    public $controller = NULL;
    public $_controller = NULL;
    public $_action = NULL;
    private $_defaultController = 'Admin';
    private $_defaultAction = "index";

    public function __construct() {
        //start the session class
        //sets the protected url
        //$this->_getUrl();
    }

    public function setController($name) {
        $file = ROOT_PATH . '/application/controllers/' . $name . '.php';
        if (file_exists($file)) {
            $this->_controller = $name;
        } else {
            $this->_controller = $this->_defaultController;
        }
    }

    public function setAction($action) {
        if (!empty($action)) {
            $this->_action = $action;
        } else {
            $this->_action = $this->_defaultAction;
        }
    }

    public function init() {
        $this->_loadExistingController();

        $tpl = &$this->controller->tpl;

        $content_tpl = VIEWS_PATH . $this->_controller . '/' . $this->_action . '.php';

        $this->controller->csrfInit();
        $this->controller->csrfValidate();
        $this->controller->beforeFilter();

        $this->_callControllerMethod();
       
        if ($this->controller->isAjax()) {

            if (is_file($content_tpl)) {
                require $content_tpl;
            }
        } elseif ($this->controller->getLayout() == 'empty') {
            $this->controller->beforeRender();
            require $content_tpl;
        } else {
            $this->controller->beforeRender();
            require VIEWS_PATH . 'Layouts/' . $this->controller->getLayout() . '.php';
        }
       
    }

    /*
      protected function _getUrl() {
      $url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : NULL;
      $url = filter_var($url, FILTER_SANITIZE_URL);
      $this->_url = explode('/', $url);
      }
     */

    protected function _loadDefaultController() {
        require ROOT_PATH . '/application/controllers/' . $this->_defaultController . '.php';
        $this->controller = new $this->_defaultController();
        $this->controller->index();
    }

    protected function _loadExistingController() {

        //set url for controllers
        $file = ROOT_PATH . '/application/controllers/' . $this->_controller . '.php';

        if (file_exists($file)) {
            require_once $file;

            $this->controller = new $this->_controller();
        } else {

            $this->_loadDefaultController();
        }
    }

    /**
     * If a method is passed in the GET url paremter
     * 
     *  http://localhost/controller/method/(param)/(param)/(param)
     *  url[0] = Controller
     *  url[1] = Method
     *  url[2] = Param
     *  url[3] = Param
     *  url[4] = Param
     */
    protected function _callControllerMethod() {

        // Make sure the method we are calling exists
        if (empty($this->_action) || !method_exists($this->controller, $this->_action)) {
            $this->controller->{$this->_defaultAction}();
        } else {
            $this->controller->{$this->_action}();
        }
    }

}

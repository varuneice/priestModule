<?php

require_once CONTROLLERS_PATH . 'App.php';

class Preview extends App {

    var $layout = 'empty';

    function beforeFilter() {
        
    }

    function index() {
        GzObject::loadFiles('Model', array('Calendar'));
        $CalendarModel = new CalendarModel();
        
        $this->tpl['arr'] = $CalendarModel->getI18nAll();
    }

}

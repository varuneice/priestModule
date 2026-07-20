<?php
require_once FRAMEWORK_PATH . 'Controller.class.php';

class I18n extends Controller {

    var $local = array();
    var $field = array();
    var $language;

    public function setLang($language) {
        $this->language = $language;
    }

    public function __construct() {
        GzObject::loadFiles('Model', array('Languages', 'Local'));
        $LanguagesModel = new LanguagesModel();
        $LocalModel = new LocalModel();
        $lang = $this->getLanguage();
        
        if (empty($lang['id'])) {
            $default_language = $LanguagesModel->getAll(array('isdefault' => 1), 'order');
            $lang = is_array($default_language) ? ($default_language[0] ?? []) : [];
        }
        $this->setLang($lang['id'] ?? null);

        $local = $LocalModel->getAll(array('language_id' => $this->language));

        if (is_array($local)) {

            foreach ($local as $key => $value) {

                if ($value['type'] == 'text') {
                    $this->local[$value['key']] = $value;
                } elseif ($value['type'] == 'array') {
                    // Guard: if a 'text' row was processed first for the same key, ['value'] is
                    // already a string. Re-initialise it as an array before treating it as one.
                    if (!isset($this->local[$value['key']]['value']) || !is_array($this->local[$value['key']]['value'])) {
                        $this->local[$value['key']]['value'] = [];
                    }
                    $this->local[$value['key']]['value'][$value['arr_key']] = $value['value'];
                }
            }
        }
    }

    public function __($key) {
        if (is_array($this->local) && array_key_exists($key, $this->local)) {
            return $this->local[$key]['value'];
        } else {
            // return $key . 'not set!';
            return $key;
        }
    }

}
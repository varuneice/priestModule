<?php

require_once MODELS_PATH . 'App.model.php';

class subjectfeeModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'studentssubject';
    
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'subject', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'type', 'type' => 'varchar', 'default' => ':NULL')
     );

     public function subjectsstudent()
    {
        $registration=$_POST['regtype'] ?? '';

       $res = 'SELECT * FROM '.$this->getTable().' WHERE  type="'."$registration".'" ORDER BY subject';
        $result = array();
        $arr = $this->execute($res);
        foreach ($arr as $key => $value) {
            $result[$value['subject']] = $value['subject'];
        }
        return $arr; 
    }
} 

?>
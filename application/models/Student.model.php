<?php

require_once MODELS_PATH . 'App.model.php';

class StudentModel extends AppModel {

    var $primaryKey = 'uid';
    var $table = 'students';
    var $schema = array(
        array('name' => 'uid', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'reg_uid', 'type' => 'int', 'default' => ''),
        array('name' => 'oid', 'type' => 'int', 'default' => ''),
        array('name' => 'Registration_type', 'type' => 'varchar', 'default' => ''),
        array('name' => 'St_Name1', 'type' => 'varchar', 'default' => ''),
        array('name' => 'St_Name2', 'type' => 'varchar', 'default' => ''),
        array('name' => 'school', 'type' => 'enum', 'default' => ':NULL'),
        array('name' => 'subject', 'type' => 'varchar', 'default' => ''),
        array('name' => 'type', 'type' => 'varchar', 'default' => ''),
        array('name' => 'fee', 'type' => 'decimal', 'default' => ''),
        array('name' => 'session', 'type' => 'varchar', 'default' => ''),
        array('name' => 'pay_date', 'type' => 'date', 'default' => ''),
        array('name' => 'remarks', 'type' => 'text', 'default' => ''),
        array('name' => 'State', 'type' => 'varchar', 'default' => ':TX'),
        array('name' => 'payment_method', 'type' => 'text', 'default' => ''),
        array('name' => 'payment_status', 'type' => 'text', 'default' => ''),
        array('name' => 'payment_timestamp', 'type' => 'text', 'default' => ''),
        array('name' => 'stripe_return', 'type' => 'text', 'default' => ''),
        array('name' => 'transaction_id', 'type' => 'text', 'default' => ''),
        array('name' => 'paid_amount', 'type' => 'text', 'default' => ''),
        array('name' => 'stripe_product', 'type' => 'text', 'default' => ''),
        array('name' => 'phone_number', 'type' => 'varchar', 'default' => ''),
        array('name' => 'email', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Country', 'type' => 'varchar', 'default' => ''),
        array('name' => 'CreatedOn', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'update_on', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP'),
        array('name' => 'membername', 'type' => 'varchar', 'default' => ''),
         array('name' => 'totalamount', 'type' => 'float', 'default' => ''),
         array('name' => 'regmember', 'type' => 'varchar', 'default' => ''),
         array('name' => 'pay_type', 'type' => 'varchar', 'default' => ''),
         array('name' => 'pay_for', 'type' => 'varchar', 'default' => '')
    );
    
    public function get($id = null) {

        if (!empty($id)) {

            return $this->from($this->getTable())->where('uid', $id)->fetch();
        }
    }
    
    public function update($data = array()) {
        $save = array();
        foreach ($this->schema as $field) {

            if (isset($data[$field['name']])) {

                if (!is_array($data[$field['name']])) {
                    $save["`" . $field['name'] . "`"] = $data[$field['name']];
                } else {
                    if (isset($data[$field['name']][0])) {
                        $save["`" . $field['name'] . "`"] = $data[$field['name']][0];
                    }
                }
            }
        }

        $query = new UpdateQuery($this, $this->getTable());
        $query->set($save);
       
        if (!empty($data['uid'])) {
            $query = $query->where('uid', $data['uid']);
        }

        return $query->execute();
    }


    function getMaxid(){
        $sql = 'SELECT MAX(reg_uid) AS reg_uid FROM '.$this->getTable().'; ';
        
        $res = $this->execute($sql);
        
        if(!empty($res[0]['reg_uid'])){
            return $res[0]['reg_uid'];
        }else{
            return 0;
        }
    }

     function getidMax(){
        $sql = 'SELECT MAX(uid) AS uid FROM '.$this->getTable().'; ';
        
        $res = $this->execute($sql);
        
        if(!empty($res[0]['uid'])){
            return $res[0]['uid'];
        }else{
            return 0;
        }
    }

 public function studentAll($opts)
    {
        $sql = 'SELECT * FROM '.$this->getTable().'  ORDER BY uid DESC';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }

}

?>

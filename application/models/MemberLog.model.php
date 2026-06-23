<?php

require_once MODELS_PATH . 'App.model.php';

class MemberLogModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'members_log';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'member_id', 'type' => 'int', 'default' => ''),
        array('name' => 'Category', 'type' => 'varchar', 'default' => ''),
        array('name' => 'rate', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Createdon', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Status', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Updatedby', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Updatedon', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP')
    );

     function getAllWithMember($opts = null) {
        
        GzObject::loadFiles('Model', array('Member'));
        $MemberModel = new MemberModel();

        $query = $this->from($this->getTable() . ' as t1');
        $query->select(null);
        $query->select('t1.*, t2.F_Name, t2.L_Name, t2.Member_id as MemberID');
        $query->where($opts);
        $query->leftJoin($MemberModel->getTable() . ' as t2 ON t2.Member_id = t1.member_id');
        $query->orderBy("t1.id DESC");
        $arr = $query->fetchAll();
        
        //echo $query->getQuery();

        return $arr;
    }
}

?>
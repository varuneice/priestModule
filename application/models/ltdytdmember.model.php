<?php

require_once MODELS_PATH . 'App.model.php';

class ltdytdmemberModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'memberltdytd';
    var $schema = array(
        array('name' => 'ID', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'information', 'type' => 'varchar', 'default' => ''),
        array('name' => 'GovtissueID', 'type' => 'varchar', 'default' => ''),
        array('name' => 'membership_type', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Member_id', 'type' => 'int', 'default' => ''),
        array('name' => 'Category', 'type' => 'enum', 'default' => ''),
        array('name' => 'fav_language', 'type' => 'varchar', 'default' => ''),
        array('name' => 'fav', 'type' => 'varchar', 'default' => ''),
        array('name' => 'F_Name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'M_Name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'L_Name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Mob_No', 'type' => 'bigint', 'default' => ''),
        array('name' => 'Sp_FName', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Sp_LName', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Address1', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Address2', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Address3', 'type' => 'varchar', 'default' => ''),
        array('name' => 'City', 'type' => 'varchar', 'default' => ''),
        array('name' => 'State', 'type' => 'varchar', 'default' => ':TX'),
        array('name' => 'Country', 'type' => 'varchar', 'default' => ':USA'),
        array('name' => 'Zip', 'type' => 'varchar', 'default' => ''),
        array('name' => 'email', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Email2', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Tele1', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Tele2', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Child1', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Age1', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Child2', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Age2', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Child3', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Age3', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Child4', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Age4', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Parent1', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Parent2', 'type' => 'varchar', 'default' => ''),
        array('name' => 'remarks', 'type' => 'text', 'default' => ''),
        array('name' => 'swap', 'type' => 'enum', 'default' => ''),
        array('name' => 'FirstSal', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Payment_method', 'type' => 'varchar', 'default' => ''),
        array('name' => 'avatar', 'type' => 'varchar', 'default' => ''),
        array('name' => 'SpouseSal', 'type' => 'varchar', 'default' => ''),
        array('name' => 'CreatedOn', 'type' => 'datetime', 'default' => ':NULL'),
        array('name' => 'password', 'type' => 'varchar', 'default' => ''),
        array('name' => 'type', 'type' => 'int', 'default' => '1'),
        array('name' => 'status', 'type' => 'enum', 'default' => 'T'),
        
        
        array('name' => 'rate', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'payment_status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'payment_timestamp', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'stripe_return', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'transaction_id', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'paid_amount', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'stripe_product', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'amount', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'donation', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'total', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'UpdateBy', 'type' => 'varchar', 'default' => ''),
        array('name' => 'UpdateOn', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP'),
        array('name' => 'Renew_date', 'type' => 'date','default' => ':NULL' ),
        array('name' => 'Ref_Phone', 'type' => 'varchar','default' => ':NULL' ), 
        array('name' => 'ytdMID', 'type' => 'varchar', 'default' => ''),
        array('name' => 'YTD', 'type' => 'varchar', 'default' => ''),
        array('name' => 'ltdMID', 'type' => 'varchar', 'default' => ''),
        array('name' => 'LTC', 'type' => 'varchar', 'default' => ''),
        array('name' => 'pay_date', 'type' => 'Date', 'default' => ':NULL'),
        array('name' => 'pay_type', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'pay_for', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'AMC', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'ARC', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Gotra', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Senior', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Active', 'type' => 'varchar', 'default' => ':NULL'),
        
    );

    private function fetchMembers($opts = array(), $baseWhere = '')
    {
        $query = $this->from($this->getTable());

        if (!empty($baseWhere)) {
            $query = $query->where($baseWhere);
        }

        if (is_array($opts) && !empty($opts)) {
            $query = $query->where($opts);
        }

        return $query->fetchAll();
    }

    public function ctmember($opts)
    {
        //$sql = 'SELECT * FROM '.$this->getTable().' WHERE Category  NOT IN("GM", "GD", "LM", "BF","GC") AND FirstSal !="'."Late".'"';
        return $this->fetchMembers($opts, 'Category NOT IN("GM", "GD", "LM", "BF","GC") AND FirstSal != "Late" AND (Active IS NULL OR Active = "")');
        
    }
     public function AllMember()
    {
        $Memberid = $_POST['memberid'] ?? '';
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE Member_id="'."$Memberid".'"';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }
    
    public function memberGM($opts)
    {
       //$sql = 'SELECT * FROM '.$this->getTable().' WHERE  Category="'."GM".'" AND (status !="'."E".'" OR status ="")';
       return $this->fetchMembers($opts, 'Category = "GM" AND FirstSal != "Late" AND (Active IS NULL OR Active = "")');
        
    }
    
   public function memberExpired($opts = array())
    {
        //$sql = 'SELECT * FROM ' . $this->getTable() . ' WHERE  FirstSal = "Late" OR SpouseSal  = "Late"';
        return $this->fetchMembers($opts, '(FirstSal = "Late" OR SpouseSal = "Late") AND (Active IS NULL OR Active = "")');
        
    }

    public function memberBF($opts)
    {
        //$sql = 'SELECT * FROM '.$this->getTable().' WHERE  Category="'."BF".'" AND FirstSal !="'."Late".'"';
        return $this->fetchMembers($opts, 'Category = "BF" AND FirstSal != "Late" AND (Active IS NULL OR Active = "")');
        
    }
   public function memberLM($opts)
    {
        //$sql = 'SELECT * FROM '.$this->getTable().' WHERE status!="'."F".'" AND Category ="'."LM".'" AND FirstSal !="'."Late".'"';
        return $this->fetchMembers($opts, 'status != "F" AND Category = "LM" AND FirstSal != "Late" AND (Active IS NULL OR Active = "")');
        
    }
    

    public function memberGD($opts)
    {
        //$sql = 'SELECT * FROM '.$this->getTable().' WHERE  Category="'."GD".'" AND status !="'."P".'" AND FirstSal !="'."Late".'"';
        return $this->fetchMembers($opts, 'Category = "GD" AND status != "P" AND FirstSal != "Late" AND (Active IS NULL OR Active = "")');
        
    }
    public function GCmember($opts)
    {
        //$sql = 'SELECT * FROM '.$this->getTable().' WHERE  Category="'."GC".'" AND status !="'."P".'" AND FirstSal !="'."Late".'"';
        return $this->fetchMembers($opts, 'Category = "GC" AND status != "P" AND FirstSal != "Late" AND (Active IS NULL OR Active = "")');
        
    }
     public function All($opts = array())
    {
        //$sql = 'SELECT * FROM '.$this->getTable();
        return $this->fetchMembers($opts, '(Active IS NULL OR Active = "")');
        
    }
    
    public function pendingmember($opts)
    {
        //$sql = 'SELECT * FROM '.$this->getTable().' WHERE  status="'."F".'"';
        return $this->fetchMembers($opts, 'status = "F" AND (Active IS NULL OR Active = "")');
        
    }
    
    public function getInactiveMembers($opts)
    {
        return $this->fetchMembers($opts, 'Active = "D"');
    }
}

?>

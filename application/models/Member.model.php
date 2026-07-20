<?php

require_once MODELS_PATH . 'App.model.php';

class MemberModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'members';
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
        array('name' => 'Age1', 'type' => 'int', 'default' => ''),
        array('name' => 'Child2', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Age2', 'type' => 'int', 'default' => ''),
        array('name' => 'Child3', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Age3', 'type' => 'int', 'default' => ''),
        array('name' => 'Child4', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Age4', 'type' => 'int', 'default' => ''),
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
        array('name' => 'pay_date', 'type' => 'Date', 'default' => ':NULL'),
        array('name' => 'pay_type', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'pay_for', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Active', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Gotra', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Senior', 'type' => 'varchar', 'default' => ':NULL')
        
    );
    
     public function update($data = array()) {
        $save = array();
        $numericTypes = ['int','integer','smallint','tinyint','mediumint','bigint','float','double','decimal','real'];
        $dateTypes    = ['date','datetime','timestamp','time','year'];

        foreach ($this->schema as $field) {

            if (isset($data[$field['name']])) {

                $val = !is_array($data[$field['name']])
                    ? $data[$field['name']]
                    : (isset($data[$field['name']][0]) ? $data[$field['name']][0] : null);

                if ($val === null) {
                    continue;
                }

                $type = strtolower($field['type'] ?? '');
                if (in_array($type, $numericTypes)) {
                    if ($val === '' || (is_string($val) && !is_numeric($val))) {
                        continue;
                    }
                } elseif (in_array($type, $dateTypes)) {
                    if ($val === '') {
                        continue;
                    }
                }

                $save["`" . $field['name'] . "`"] = $val;
            }
        }

        $query = new UpdateQuery($this, $this->getTable());
        $query->set($save);

        if (!empty($data['ID'])) {
            $query = $query->where('ID', $data['ID']);
        }

        return $query->execute();
    }
     public function AllMember()
    {
        $Memberid = $_POST['memberid'] ?? '';
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE Member_id="'."$Memberid".'"';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }

    public function getMemberF_name($ID)
      {

     $res = 'SELECT FirstSal, SpouseSal, CONCAT(`F_Name`, " / ",`Sp_FName`) AS Name FROM ' . $this->getTable() . ' WHERE  Member_id="' . "$ID" . '"';
        $result = array();
        $arr = $this->execute($res);
        if (empty($arr)) { return; }
        $name =$arr[0]['Name'];
        $firstSal =$arr[0]['FirstSal'];
        $spousesal =$arr[0]['SpouseSal'];

        if(!empty($arr[0]['Name'])){
            echo  "<input  id='latemem' value='$name' /> ";
            echo  "<input  id='spousesalfield' value='$spousesal' /> ";
            echo  "<input  id='firstSalfield' value='$firstSal' /> ";
        }
        
    }

    function getMax(){
        $sql = 'SELECT MAX(Member_id) AS Member_id FROM '.$this->getTable().'; ';
        
        $res = $this->execute($sql);
        
        if(!empty($res[0]['Member_id'])){
            return $res[0]['Member_id'];
        }else{
            return 0;
        }
    }

    function getMaxid(){
        $sql = 'SELECT MAX(ID) AS ID FROM '.$this->getTable().'; ';
        
        $res = $this->execute($sql);
        
        if(!empty($res[0]['ID'])){
            return $res[0]['ID'];
        }else{
            return 0;
        }
    }
    
     public function checkduplicatemember()
    {
        $email = $_POST['email'] ?? '';
		$Tele = $_POST['Tele1'] ?? '';
        //$res = 'SELECT * FROM '.$this->getTable().' WHERE  Tele1="'."$Tele".'" OR email="'."$email".'"';
        $res = 'SELECT * FROM ' . $this->getTable() . ' WHERE (REPLACE(Tele1, "-", "") = "' . "$Tele" . '" OR email="' . "$email" . '") AND (Active IS NULL OR ACTIVE="")';
        $result = array();
        $arr = $this->execute($res);
        return $arr[0]['Member_id'] ?? null;
    }

    public function deactivateDuplicateGcContact($currentId, $email, $phone)
    {
        $currentId = (int) $currentId;
        $email = trim((string) $email);
        $phone = preg_replace('/\D+/', '', (string) $phone);

        if ($currentId <= 0 || ($email === '' && $phone === '')) {
            return false;
        }

        $conditions = array();
        if ($email !== '') {
            $conditions[] = 'email = "' . addslashes($email) . '"';
        }
        if ($phone !== '') {
            $conditions[] = 'REPLACE(REPLACE(REPLACE(REPLACE(Tele1, "-", ""), "(", ""), ")", ""), " ", "") = "' . addslashes($phone) . '"';
        }

        if (empty($conditions)) {
            return false;
        }

        $sql = 'UPDATE ' . $this->getTable() . '
            SET email = "", Email2 = "", Tele1 = "", Tele2 = "", Mob_No = NULL, Active = "D"
            WHERE ID <> ' . $currentId . '
                AND Category = "GC"
                AND Member_id >= 10000
                AND (Active IS NULL OR Active = "")
                AND (' . implode(' OR ', $conditions) . ')';

        return $this->execute($sql);
    }

    public function getActiveGcMemberDuplicates()
    {
        $phoneExprGc = 'REPLACE(REPLACE(REPLACE(REPLACE(gc.Tele1, "-", ""), "(", ""), ")", ""), " ", "")';
        $phoneExprMember = 'REPLACE(REPLACE(REPLACE(REPLACE(m.Tele1, "-", ""), "(", ""), ")", ""), " ", "")';

        $sql = 'SELECT
                gc.ID AS gc_id,
                gc.Member_id AS gc_member_id,
                gc.F_Name AS gc_first_name,
                gc.M_Name AS gc_middle_name,
                gc.L_Name AS gc_last_name,
                gc.email AS gc_email,
                gc.Tele1 AS gc_phone,
                m.ID AS member_id,
                m.Member_id AS real_member_id,
                m.F_Name AS member_first_name,
                m.M_Name AS member_middle_name,
                m.L_Name AS member_last_name,
                m.Category AS member_category,
                m.email AS member_email,
                m.Tele1 AS member_phone,
                CASE
                    WHEN gc.email <> "" AND m.email <> "" AND LOWER(gc.email) = LOWER(m.email)
                        AND ' . $phoneExprGc . ' <> "" AND ' . $phoneExprGc . ' = ' . $phoneExprMember . ' THEN "Both"
                    WHEN gc.email <> "" AND m.email <> "" AND LOWER(gc.email) = LOWER(m.email) THEN "Email"
                    ELSE "Phone"
                END AS match_type
            FROM ' . $this->getTable() . ' gc
            INNER JOIN ' . $this->getTable() . ' m
                ON m.ID <> gc.ID
                AND m.Category <> "GC"
                AND m.Member_id < 10000
                AND (m.Active IS NULL OR m.Active = "")
                AND (
                    (gc.email <> "" AND m.email <> "" AND LOWER(gc.email) = LOWER(m.email))
                    OR (' . $phoneExprGc . ' <> "" AND ' . $phoneExprGc . ' = ' . $phoneExprMember . ')
                )
            WHERE gc.Category = "GC"
                AND gc.Member_id >= 10000
                AND (gc.Active IS NULL OR gc.Active = "")
            ORDER BY gc.Member_id DESC';

        return $this->execute($sql);
    }

    public function deactivateGcDuplicateById($gcId)
    {
        $gcId = (int) $gcId;
        if ($gcId <= 0) {
            return false;
        }

        $sql = 'UPDATE ' . $this->getTable() . '
            SET email = "", Email2 = "", Tele1 = "", Tele2 = "", Mob_No = NULL, Active = "D"
            WHERE ID = ' . $gcId . '
                AND Category = "GC"
                AND Member_id >= 10000
                AND (Active IS NULL OR Active = "")';

        $stmt = $this->getPdo()->prepare($sql);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function updateSeniorStatusById($id, $senior, $gotra = null)
    {
        $id = (int) $id;
        if ($id <= 0) {
            return false;
        }

        $senior = ($senior === 'YES') ? 'YES' : '';
        $saveGotra = ($gotra !== null);
        $sql = 'UPDATE ' . $this->getTable() . ' SET Senior = :senior';
        $params = array(':senior' => $senior, ':id' => $id);

        if ($saveGotra) {
            $sql .= ', Gotra = :gotra';
            $params[':gotra'] = trim((string) $gotra);
        }

        $sql .= ' WHERE ID = :id';
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->execute($params);

        if ($stmt->rowCount() > 0) {
            return true;
        }

        $checkSql = 'SELECT ID FROM ' . $this->getTable() . ' WHERE ID = :id AND COALESCE(Senior, "") = :senior';
        $checkParams = array(':senior' => $senior, ':id' => $id);

        if ($saveGotra) {
            $checkSql .= ' AND COALESCE(Gotra, "") = :gotra';
            $checkParams[':gotra'] = trim((string) $gotra);
        }

        $stmt = $this->getPdo()->prepare($checkSql);
        $stmt->execute($checkParams);

        return (bool) $stmt->fetch(PDO::FETCH_ASSOC);
    }

       public function rentalmemberduplicate()
    {
        $email = $_POST['email'] ?? '';
		$Tele = $_POST['phone'] ?? '';
       // $res = 'SELECT * FROM '.$this->getTable().' WHERE  Tele1="'."$Tele".'" OR email="'."$email".'"';
        $res = 'SELECT * FROM ' . $this->getTable() . ' WHERE (REPLACE(Tele1, "-", "") = "' . $Tele . '" OR email = "' . $email . '") AND (Active IS NULL OR ACTIVE="")' ;
        $result = array();
        $arr = $this->execute($res);
        return $arr[0]['Member_id'] ?? null;
    }

     public function ticketduplicatemember()
    {
        $email = $_POST['email'] ?? '';
		$Tele = $_POST['tele'] ?? '';
        //$res = 'SELECT * FROM '.$this->getTable().' WHERE  Tele1="'."$Tele".'" OR email="'."$email".'"';
        $res = 'SELECT * FROM ' . $this->getTable() . ' WHERE (REPLACE(Tele1, "-", "") = "' . "$Tele" . '" OR email="' . "$email" . '") AND (Active IS NULL OR ACTIVE="")';
        $result = array();
        $arr = $this->execute($res);
        return $arr[0]['Member_id'] ?? null;
    }
     public function studentcheckduplicatemember()
    {
        $email = $_POST['email'] ?? '';
		$Tele = $_POST['phone_number'] ?? '';
        //$res = 'SELECT * FROM '.$this->getTable().' WHERE  Tele1="'."$Tele".'" OR email="'."$email".'"';
        $res = 'SELECT * FROM ' . $this->getTable() . ' WHERE (REPLACE(Tele1, "-", "") = "' . "$Tele" . '" OR email="' . "$email" . '") AND (Active IS NULL OR ACTIVE="")';
        $result = array();
        $arr = $this->execute($res);
        return $arr[0]['Member_id'] ?? null;
    }

    public function memberphone()
    {
        $Tele = $_POST['Tele'] ?? '';
        //$res = 'SELECT * FROM '.$this->getTable().' WHERE  Tele1="'."$Tele".'"';
        $res = 'SELECT * FROM ' . $this->getTable() . ' WHERE REPLACE(Tele1, "-", "") = "' . $Tele . '"';
        $result = array();
        $arr = $this->execute($res);
        if(!empty($arr[0]['ID'])){
            echo "<input  id='phone_mobile' value='true'/> ";
            
        }else{
            echo "<input  id='phone_mobile' value='false'/> ";
        }  
    }


     public function Membercheck()
    {
        $email = $_POST['email'] ?? '';

        $res = 'SELECT * FROM '.$this->getTable().' WHERE  email="'."$email".'"';
        $result = array();
        $arr = $this->execute($res);
        if(!empty($arr[0]['ID'])){
                echo "<input  id='email' value='true'/> ";
        }else{
            echo "<input  id='email' value='false'/> ";
        }  
    }

      public function getid($mid)
    {
         
        $sql = 'SELECT ID FROM '.$this->getTable().' WHERE Member_id='.$mid.'';
        $res = $this->execute($sql);
        
        if(!empty($res[0]['ID'])){
            return $res[0]['ID'];
        }else{
            return 0;
        }
        
    }
    public function ctmember($opts)
    {
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE Category  NOT IN("GM", "GD", "LM", "BF")';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }
    // create general donor as  member 
        public function SaveDataInmember($value)
            {
            $memberunique = $this->getMaxid();
            $ID = $memberunique +1;	

            $Member_id =  $value['Member_id'] ?? null;
            $Member_id_sql = ($Member_id === null || $Member_id === '') ? 'NULL' : (int)$Member_id;
            //$Category = 'GD';
            $Category = 'GC';
            $membername = $value['MemberName'] ?? '';
            $name=explode(" ",$membername);
            $First_Name = $name[0] ?? '';
            $Last_Name= $name[1] ?? '';
            $F_Name =  $First_Name;
            $L_Name =  $Last_Name;
            $spousename =  $value['spousename'] ?? '';
            $sname=explode(" ",$spousename);
            $Sp_newFName = $sname[0] ?? '';
            $Sp_newLName= $sname[1] ?? '';

            $Sp_FName = $Sp_newFName;
            $Sp_LName = $Sp_newLName;
            $Address1 =  $value['Street'] ?? '';
            $Address2 = $value['Address'] ?? '';
            $Address3 = $value['Address3'] ?? '';
            $City = $value['City'] ?? '';
            $State =  $value['State'] ?? '';
            $Country =  $value['Country'] ?? '';
            $Zip = $value['Zip_Code'] ?? '';
            $email = $value['email'] ?? '';
            $Tele1 = $value['Tele1'] ?? '';
            $Tele2 =  $value['Tele2'] ?? '';
            $Child1 = $value['Child1'] ?? '';
            $Age1 = ($value['Age1'] ?? '') !== '' ? (int)$value['Age1'] : null;
            $Age1_sql = ($Age1 === null) ? 'NULL' : $Age1;
            $Child2 = $value['Child2'] ?? '';
            $Age2 = ($value['Age2'] ?? '') !== '' ? (int)$value['Age2'] : null;
            $Age2_sql = ($Age2 === null) ? 'NULL' : $Age2;
            $Child3 = $value['Child3'] ?? '';
            $Age3 = ($value['Age3'] ?? '') !== '' ? (int)$value['Age3'] : null;
            $Age3_sql = ($Age3 === null) ? 'NULL' : $Age3;
            $Parent1 = $value['Parent1'] ?? '';
            $Parent2 =  $value['Parent2'] ?? '';
            $remarks = $value['remarks'] ?? '';
            $swap = $value['swap'] ?? '0';
            $FirstSal = $value['FirstSal'] ?? '';
            $SpouseSal =  $value['SpouseSal'] ?? '';
            $membership_type = $value['MType'] ?? '';
            $CreatedOn         = $value['CreatedOn']         ?? date('Y-m-d H:i:s');
            $UpdateBy          = $value['UpdateBy']          ?? '';
            $UpdateOn          = $value['UpdateOn']          ?? ($value['update_on'] ?? date('Y-m-d H:i:s'));
            $rate              = null;
            $payment_status    = $value['payment_status'];
            $payment_timestamp = $value['payment_timestamp'] ?? '';
            $stripe_return     = 'succeeded';
            $transaction_id    = $value['transaction_id']    ?? '';
            $paid_amount       = $value['paid_amount']       ?? null;
            $stripe_product    = $value['stripe_product']    ?? null;
            $donation          = null;
            $amount            = $value['Amount'];
            $fav_language      = null;
            $fav               = null;
            $total             = $value['Amount'];
            $Child4            = null;
            $Age4              = ($value['Age4'] ?? '') !== '' ? (int)$value['Age4'] : null;
            $Age4_sql          = ($Age4 === null) ? 'NULL' : $Age4;
            $information       = null;
            $GovtissueID       = null;
            $M_Name            = null;
            $Mob_No            = preg_replace('/\D+/', '', (string)($value['Tele1'] ?? ''));
            $Mob_No_sql        = ($Mob_No === '') ? 'NULL' : (int)$Mob_No;
            $Email2            = null;
            $password          = null;
            $type              = is_numeric($value['type'] ?? null) ? (int)$value['type'] : 1;
            $avatar            = null;
            $Renew_date        = null;
            $status            = $value['status'] ?? 'T';
            $status            = in_array($status, ['T', 'F'], true) ? $status : 'T';
            $Payment_method    = $value['PaymentOption']     ?? '';
            $Ref_Phone         = null;
            $pay_date          = $value['pay_date']          ?? '';
            $pay_type          = $value['pay_type']          ?? '';
            $pay_for           = $value['pay_for']           ?? '';
            $Active            = $value['ACTIVE']            ?? '';
            $gotra             = $value['Gotra']             ?? '';
            $senior            = $value['Senior']            ?? '';

            // DATE/DATETIME columns must be NULL rather than '' in strict mode
            $CreatedOn_sql        = !empty($CreatedOn)         ? "'$CreatedOn'"         : "'" . date('Y-m-d H:i:s') . "'";
            $UpdateOn_sql         = !empty($UpdateOn)          ? "'$UpdateOn'"          : "'" . date('Y-m-d H:i:s') . "'";
            $payment_ts_sql       = !empty($payment_timestamp) ? "'$payment_timestamp'" : 'NULL';
            $paid_amount_sql      = ($paid_amount  !== null && $paid_amount  !== '') ? "'$paid_amount'"  : 'NULL';
            $stripe_product_sql   = ($stripe_product !== null && $stripe_product !== '') ? "'$stripe_product'" : 'NULL';
            $donation_sql         = ($donation !== null && $donation !== '')             ? (float)$donation      : 'NULL';

            $sql = "INSERT INTO members  VALUES ('$ID',$Member_id_sql,'$Category','$F_Name','$L_Name','$Sp_FName','$Sp_LName','$Address1','$Address2','$Address3','$City','$State','$Country','$Zip','$email','$Tele1','$Tele2','$Child1',$Age1_sql,'$Child2',$Age2_sql,'$Child3',$Age3_sql,'$Parent1','$Parent2','$remarks','$swap','$FirstSal','$SpouseSal','$membership_type',$CreatedOn_sql,'$UpdateBy',$UpdateOn_sql,'$rate','$payment_status',$payment_ts_sql,'$stripe_return','$transaction_id',$paid_amount_sql,$stripe_product_sql,$donation_sql,'$amount','$fav_language','$fav','$total','$Child4',$Age4_sql,'$information','$GovtissueID','$M_Name',$Mob_No_sql,'$Email2','$password',$type,'$avatar',NULL,'$status','$Payment_method','$Ref_Phone','$pay_date','$pay_type','$pay_for','$Active','$gotra','$senior')";
             $result = array();
             $arr = $this->execute($sql);
             return $arr;
           
            }


      // end
    
    public function getMemberDetails($id) {
        GzObject::loadFiles('Model', array('Member'));
        // $CalendarModel = new CalendarModel();
        // $BookingSlotModel = new BookingSlotModel();
        // $TimePriceModel = new TimePriceModel();
        // $CustomDateModel = new CustomDateModel();
        $MemberModel = new MemberModel();

        $arr = $this->get($id);
        $opts = array();

        $opts['Member_id'] = $arr['Member_id'];
        $slots = $MemberModel->getAll($opts);

        // $arr = $this->get($id);
        // $booked_calendar = $CalendarModel->getI18n($arr['calendar_id']);

        // $arr['booked_calendar'] = $booked_calendar;

        // $language_arr = $_SESSION['lang'];
        // $language_id = $language_arr['id'];

        // $arr['calendar'] = $booked_calendar['i18n'][$language_id]['title'];

        // $opts = array();

        // $opts['booking_id'] = $arr['id'];
        // $slots = $BookingSlotModel->getAll($opts);
        // $opts = array();
        // $opts['calendar_id'] = $arr['calendar_id'];
        // $working_time = $TimePriceModel->getAll($opts, 'id');
        
        // $opts = array();
        // $opts['calendar_id'] = $arr['calendar_id'];
        // $custom_dates = $CustomDateModel->getAll($opts);

        // if (!empty($custom_dates)) {
        //     foreach ($custom_dates as $k => $v) {
        //         for($i = $v['timestamp']; $i <= $v['timestamp_end']; $i+=86400){
        //             $custom_dates[mktime(0, 0, 0, date('n', $i), date('d', $i), date('Y', $i))] = $v;
        //         }
        //     }
        // }

        // $slot = array();
        
        // foreach ($slots as $k => $v) {
        //     $i = $v['timestamp'];
        //     $count = $v['count'];
            
        //     if(!empty($custom_dates[mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))])){
        //         $slot_lenght = $custom_dates[mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))]['slot_lenght'];
        //         $price = $custom_dates[mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))]['price'];
        //     }else{

        //         switch (date('N', $i)) {
        //             case '1':
        //                 $slot_lenght = $working_time[0]['monday_slot_lenght'];
        //                 $price = $working_time[0]['monday_price'];
        //                 break;
        //             case '2':
        //                 $slot_lenght = $working_time[0]['tuesday_slot_lenght'];
        //                 $price = $working_time[0]['tuesday_price'];
        //                 break;
        //             case '3':
        //                 $slot_lenght = $working_time[0]['wednesday_slot_lenght'];
        //                 $price = $working_time[0]['wednesday_price'];
        //                 break;
        //             case '4':
        //                 $slot_lenght = $working_time[0]['thursday_slot_lenght'];
        //                 $price = $working_time[0]['thursday_price'];
        //                 break;
        //             case '5':
        //                 $slot_lenght = $working_time[0]['friday_slot_lenght'];
        //                 $price = $working_time[0]['friday_price'];
        //                 break;
        //             case '6':
        //                 $slot_lenght = $working_time[0]['saturday_slot_lenght'];
        //                 $price = $working_time[0]['saturday_price'];
        //                 break;
        //             case '7':
        //                 $slot_lenght = $working_time[0]['sunday_slot_lenght'];
        //                 $price = $working_time[0]['sunday_price'];
        //                 break;
        //         }
        //     }

        //     $slot[] = date('F d, Y H:i', $i) . "-" . date('H:i', ($i + $slot_lenght * 60));
        // }
        //$arr['slots'] = $slot;
        return $arr;
    }
       function getNewMemberWithPayment($opts = null) {
        
        GzObject::loadFiles('Model', array('Donation'));
        $DonationModel = new DonationModel();

        $query = $this->from($this->getTable() . ' as t1');
        $query->select(null);
        $query->select('SUM(t2.Amount) as newMemberCount');
        $query->where('(Category="GM" or Category="LM") AND DATE_FORMAT(CreatedOn,"%y-%m-%d") >= DATE_FORMAT(CONCAT(Year(CURRENT_DATE), "-01-01"),"%y-%m-%d")');
        $query->leftJoin($DonationModel->getTable() . ' as t2 ON t2.Member_id = t1.Member_id');
        $query->orderBy("t1.ID DESC");
        $arr = $query->fetchAll();
        
        //echo $query->getQuery();

        return $arr;
    }
    
    function GD_MemberReport()
    {

        $sql = "SELECT Member_id,Category,F_Name, M_Name, L_Name,email,Tele1,Address1,Address2,Address3,City,State,Zip FROM " . $this->getTable() . " 
        WHERE Member_id > 0 AND LENGTH(Member_id) <= 4
        AND Category IN ('GD') 
        AND YEAR(pay_date) != YEAR(CURDATE()) 
        AND (Active IS NULL OR Active = '')";
        $arr = $this->execute($sql);
        return $arr;
    }

    function othersCategoryReport()
    {

        $sql = "SELECT Member_id,Category,F_Name, M_Name, L_Name,email,Tele1,Address1,Address2,Address3,City,State,Zip FROM " . $this->getTable() . " 
        WHERE Member_id > 0 AND LENGTH(Member_id) <= 4 
        AND Category NOT IN ('GD', 'GM') 
        AND YEAR(pay_date) != YEAR(CURDATE()) 
        AND (Active IS NULL OR Active = '')";
        $arr = $this->execute($sql);
        return $arr;
    }
}

?>




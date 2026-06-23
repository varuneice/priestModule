<?php

require_once MODELS_PATH . 'App.model.php';

class BadgesdataModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'badgesdata';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'MID', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'OID', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'Category', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'F_Name', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'L_Name', 'type' => 'varchar', 'default' => ':NULL'),
	    array('name' => 'Sp_FName', 'type' => 'varchar', 'default' => ':NULL'),
       
		array('name' => 'City', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'State', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Country', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Zip', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Email', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Phone', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Parent2', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Parent1', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Child3', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Child2', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Child1', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Total', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Child', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Adult', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'YTD', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Magazines', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Sponsorship_Amount', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Sponsor', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Student', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'SeqNo', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'StudentVerified', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'PendingIssues', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'Signature', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Date', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'Status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Name_Authorized', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'total_badges', 'type' => 'varchar', 'default' => ':NULL'),
       array('name' => 'Veggies', 'type' => 'varchar', 'default' => ':NULL')
    );
    
    public function UpdateAssignBadges($POST)
    {
        $id=$id=$POST['id'] ?? '';
        $Category=$POST['Category'] ?? '';
        $City=$POST['City'] ?? '';
        $State=$POST['State'] ?? '';
        $Country=$POST['Country '] ?? '';
        $Zip=$POST['Zip'] ?? '';
        $Email=$POST['Email'] ?? '';
        $Phone=$POST['Phone'] ?? '';
        $Parent1=$POST['Parent1'] ?? '';
        $Parent2=$POST['Parent2'] ?? '';
        $Child3=$POST['Child3'] ?? '';
        $Child2=$POST['Child2'] ?? '';
        $Child1=$POST['Child2'] ?? '';
        $Total=$POST['Total'] ?? '';
        $Child=$POST['Child'] ?? '';
        $Adult=$POST['Adult'] ?? '';
        $YTD=$POST['YTD'] ?? '';
        $Magazines=$POST['Magazines'] ?? '';
        $Sponsorship_Amount=$POST['Sponsorship_Amount'] ?? '';
        $Sponsor=$POST['Sponsor'] ?? '';
        $Student=$POST['Student'] ?? '';
        $SeqNo=$POST['SeqNo'] ?? '';
        $StudentVerified=$POST['StudentVerified'] ?? '';
        $PendingIssues=$POST['PendingIssues'] ?? '';
        $Signature=$POST['Signature'] ?? '';
        $Date=$POST['Date'] ?? '';
        $Status=$POST['Status'] ?? '';
        $Veggies=$POST['Veggies'] ?? '';

        $Name_AuthorizedName_Authorized=$POST['Name_Authorized'] ?? '';
   
         $sql = 'UPDATE '.$this->getTable().' SET Category="'."$Category".'",City="'."$City".'" ,State="'."$State".'",Country="'."$Country".'",Zip="'."$Zip".'",Email="'."$Email".'",Phone="'."$Phone".'"
         ,Parent2="'."$Parent2".'",Parent1="'."$Parent1".'",Child3="'."$Child3".'",Child2="'."$Child2".'",Child1="'."$Child1".'",Total="'."$Total".'",Child="'."$Child".'",Adult="'."$Adult".'",YTD="'."$YTD".'",Magazines="'."$Magazines".'",Sponsorship_Amount="'."$Sponsorship_Amount".'",Sponsor="'."$Sponsor".'",Student="'."$Student".'",SeqNo="'."$SeqNo".'",StudentVerified="'."$StudentVerified".'",PendingIssues="'."$PendingIssues".'",Signature="'."$Signature".'"
         ,Date="'."$Date".'",Status="'."$Status".'",Name_AuthorizedName_Authorized="'."$Name_AuthorizedName_Authorized".'",Veggies="'."$Veggies".'" WHERE id="'."$id".'"';
        // $sql = 'SELECT CONCAT(date," / ",DonarName," / ", Amount," / " ,Confirmation," / " ,Description) AS Amount FROM '.$this->getTable().'; ';
        $result = array();
        $arr = $this->execute($sql);
        
        return $id;
        
    }
    
   

}            

?>
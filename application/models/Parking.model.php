<?php

require_once MODELS_PATH . 'App.model.php';

class ParkingModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'parking';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'MID', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Category', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'F_Name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'L_Name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Sp_FName', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'YTD', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Adjustment', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Sponsorship_Amount', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Sponsor_Level', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Parking _Basis', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Team', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Registration_Status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Pending_Issues', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Parking_LotAssigned', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Decal', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Name_Authorizedcolleect', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Signature', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Date', 'type' => 'Date', 'default' => ':NULL')
    );
    
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
       
        if (!empty($data['ID'])) {
            $query = $query->where('ID', $data['ID']);
        }

        return $query->execute();
    }
  
    // public function generateparkingInvoice($id) {
    //     GzObject::loadFiles('Model', array('Member', 'Parking'));

    //     $MemberModel = new MemberModel();
    //     $ParkingModel = new ParkingModel();
    //     //$OptionModel = new OptionModel();
        
    //     $parkinginvoice = $ParkingModel->get($id);
    //     $member_details = $MemberModel->getMemberDetails($parkinginvoice['id']);
        
    //     // $opts = array();
    //     // $opts['Member_id'] = $member_details['Member_id'];
    //     // $option_arr = $OptionModel->getAllPairValues($opts);

    //     $replacement = array();

    //    // $replacement['calendar'] = $member_details['calendar'];
    //     $replacement['MID'] = $member_details['MID'];
    //     $replacement['Category'] = $parkinginvoice['Category'];
    //     $replacement['F_Name'] = $parkinginvoice['F_Name'];
    //     $replacement['L_Name'] = $parkinginvoice['L_Name'];
    //     $replacement['Sp_FName'] = $parkinginvoice['Sp_FName'];
    //     $replacement['YTD'] = $parkinginvoice['YTD'];
    //     $replacement['Adjustment'] = $parkinginvoice['Adjustment'];
    //     $replacement['Sponsorship Amount'] = $parkinginvoice['Sponsorship Amount'];
    //     $replacement['Sposnor Level'] = $parkinginvoice['Sposnor Level'];
    //     $replacement['Parking Basis'] = $parkinginvoice['Parking Basis'];
    //     $replacement['Team'] = $parkinginvoice['Team(if volunteer)'];
    //     $replacement['Registration Status'] = $parkinginvoice['Registration Status'];
    //     $replacement['Pending Issues'] = $parkinginvoice['Pending Issues'];
    //     $replacement['Parking Lot Assigned'] = $parkinginvoice['Parking Lot Assigned'];
    //     $replacement['Decal'] = $parkinginvoice['Decal #Assigned'];
    //     $replacement['Name'] = $parkinginvoice['Name if Authorized to collect '];
    //     $replacement['Date'] = $parkinginvoice['Date'];
       
    //     return $result = Util::replaceParkingInvoiceToken($parkinginvoice, $replacement);
    // }
   
}            

?>
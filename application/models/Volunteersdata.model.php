<?php

require_once MODELS_PATH . 'App.model.php';

class VolunteersdataModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'volunteersdata';

    var $schema = array(
        array('name' => 'ID', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'MID', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'Volunteer_Name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'L_Name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Core_Team', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Core_TeamRole', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Other_Teams', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Spouse_Name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Spouse_Team', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'Registered', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Sponsor_Parking', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Spouse_volunteerparking', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Priority', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'Day_FullParking', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Day_assigned', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Parking_AreaAssigned', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Date', 'type' => 'Date', 'default' => ':NULL'),
        array('name' => 'Signature', 'type' => 'Date', 'default' => ':NULL'),
        array('name' => 'Status', 'type' => 'Date', 'default' => ':NULL'),
        array('name' => 'Decal', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Name_Authorized', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'paid_parking', 'type' => 'varchar', 'default' => ':NULL'),
         array('name' => 'Tele1', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'email', 'type' => 'varchar', 'default' => ':NULL')
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
    
    function saveParkingInvoice($ID){
        
        if (!empty($ID)) {

            GzObject::loadFiles('Model', array('Volunteersdata'));
            $VolunteersdataModel = new VolunteersdataModel();
         
            
            $Parking = $this->getparking($ID);
            $Path = INSTALL_URL . 'esign/';
            $signName = $Parking['Signature'];
            $Mid = $Parking['MID'];
            $FinalSignImage =$Path.$signName;
            $opts = array();
            //$opts['calendar_id'] = $booking['calendar_id'];
            //$option_arr = $OptionModel->getAllPairValues($opts);

            $data = array();
            $variable = "<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
            <div class='email-token-class' style='text-align: justify;'>
            <div class='email-token-class' style='text-align: center;'>
            <div class='email-token-class' style='text-align: center;'>
            <table style='height: 77px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;' width='606'>
            <tbody>
            <tr>
            <td style='text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;'><img src='" . INSTALL_URL . "application/web/upload/image/create.png' alt='' width='396' height='66' /></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class='email-token-class' style='text-align: center;'>
            <table style='height: 22px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;' width='604'>
            <tbody>
            <tr>
            <td style='text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;'><strong>Parking Details</strong></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class='email-token-class' style='text-align: center;'>
            <table style='height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;' width='604'>
            <tbody>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>MID&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Parking[MID]</td>
            </tr>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>First Name&nbsp;&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Parking[Volunteer_Name]</td>
            </tr>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Last Name Name&nbsp;&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Parking[L_Name]</td>
            </tr>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Core Team Role&nbsp;&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Parking[Core_TeamRole]</td>
            </tr>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Spouse Name&nbsp;&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Parking[Spouse_Name]</td>
            </tr>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Team &nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Parking[Core_TeamRole]</td>
            </tr>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Parking Lot Assigned&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Parking[Parking_AreaAssigned]</td>
            </tr>
			<tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Decal Assigned&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Parking[Decal]</td>
            </tr>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Name Authorized To Collect &nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Parking[Name_Authorized]</td>
            </tr>
            <tr>
            <td colspan=2 style='text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;'><img src='$FinalSignImage' alt='' width='396' height='80' /></td>
            </tr>
            </tbody>
            </table>
            </div>
            </div>
            </div>";

            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($variable);
            $name = 'Parking_' . $ID . '_invoice_' .  $Mid . '.pdf';
            $folderPath = "parkinginvoice/";
            $mpdf->Output($folderPath . $name, 'F');

            $save = array();

            return $id;
        }
        
        return false;
    }

}            

?>
<?php

require_once MODELS_PATH . 'App.model.php';

class ParkingdataviewModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'parkingdataview';

    var $schema = array(
        array('name' => 'ID', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'Member_id', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Category', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'F_Name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'L_Name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Sp_FName', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Sp_LName', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Address', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'City', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'State', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Zip', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Tele1', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Tele2', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'email', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'donation', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'donation_pay_date', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Adjustment', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Parking_basis', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Team', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Registration_Status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Pending_Issues', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Decal_Assigned', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Name_Authorized', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Signature', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'SponsorshipCategory', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'parking_assigned', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Date', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'status', 'type' => 'varchar', 'default' => ':NULL'),
         array('name' => 'sponsor_amount', 'type' => 'varchar', 'default' => ':NULL')


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
     public function getAllData()
    {
        $sql = 'SELECT * FROM '.$this->getTable().'; ';
        $result = array();
        $arr = $this->execute($sql);
        print $sql;
        echo  $sql;
        return $arr;
        
    }
    
    function saveParkingInvoice($ID){
        
        if (!empty($ID)) {

            GzObject::loadFiles('Model', array('Parkingdataview'));
            $ParkingdataviewModel = new ParkingdataviewModel();
            // $InvoiceModel = new InvoiceModel();
            
            $Parking = $this->getparking($ID);
            //server url
            $Path = INSTALL_URL . "esign/";
            
            $signName = $Parking['Signature'];
            $Mid = $Parking['Member_id'];
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
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Member ID&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Parking[Member_id]</td>
            </tr>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Category&nbsp;&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Parking[Category]</td>
            </tr>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>First Name&nbsp;&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Parking[F_Name]</td>
            </tr>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Last Name&nbsp;&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Parking[L_Name]</td>
            </tr>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Spouse Name&nbsp;&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Parking[Sp_FName]</td>
            </tr>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Parking Lot Assigned&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Parking[parking_assigned]</td>
            </tr>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Decal Assigned&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Parking[Decal]</td>
            </tr>
			<tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Date&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Parking[Date]</td>
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
<?php

require_once MODELS_PATH . 'App.model.php';

class PaidparkingviewModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'Paidparkingview';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'oid', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'txn_id', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'city', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'zip', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'item_name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'item_number', 'type' => 'smallint', 'default' => ':NULL'),
        array('name' => 'PaymentOption', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'amount', 'type' => 'decimal', 'default' => ':NULL'),
        array('name' => 'created_on', 'type' => 'datetime', 'default' => ':NULL'),
        array('name' => 'Parking_Basis', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Pending_Issues', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Decal', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Name_Authorized', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Signature', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'parking_assigned', 'type' => 'enum', 'default' => ':NULL'),
        array('name' => 'Date', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'parkingid', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'senior', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'ct_members', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'tele', 'type' => 'varchar', 'default' => ':NULL')

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

            GzObject::loadFiles('Model', array('Paidparkingview'));
            $PaidparkingviewModel = new PaidparkingviewModel();
       
            
            $Parking = $this->getparking($ID);
            $Path = INSTALL_URL . 'esign/';
            $signName = $Parking['Signature'];
            $oid = $Parking['oid'];
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
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>OID&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Parking[oid]</td>
            </tr>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Name&nbsp;&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Parking[name]</td>
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
            $name = 'Parking_' . $ID . '_invoice_' .  $oid . '.pdf';
            $folderPath = "parkinginvoice/";
            $mpdf->Output($folderPath . $name, 'F');

            $save = array();

            return $id;
        }
        
        return false;
    }
}            

?>
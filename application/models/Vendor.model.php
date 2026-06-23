<?php

require_once MODELS_PATH . 'App.model.php';

class VendorModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'vendors';
    
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'businessname', 'type' => 'varchar', 'default' => ''),
        array('name' => 'ownername', 'type' => 'varchar', 'default' => ''),
        array('name' => 'email', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'phone', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'address', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'city', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'state', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'zip', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'country', 'type' => 'varchar', 'default' => ''),
        array('name' => 'taxid', 'type' => 'varchar', 'default' => ''), 
        array('name' => 'custid', 'type' => 'varchar', 'default' => ''),
        array('name' => 'vax', 'type' => 'varchar', 'default' => ''),
        array('name' => 'CreatedOn', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP'),
        array('name' => 'UpdateOn', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP'),
        array('name' => 'UpdateBy', 'type' => 'varchar', 'default' => ''),
        
    );
    
    
      function getallvendordatawithinvoice($opts = null) { 
        GzObject::loadFiles('Model', array('vendorinvoice'));
        $vendorinvoiceModel = new vendorinvoiceModel();
        $query = $this->from($this->getTable() . ' as t1');
        $query->select(null);
         $query->select('t1.*, t2.item_number, t2.item_cost,  t2.amount, t2.status, t2.item_desc, t2.oid, t2.update_on, t2.paytype,t2.id');
        $query->where($opts);
        $query->innerJoin($vendorinvoiceModel->getTable() . ' as t2 ON t2.custid = t1.id');
        $query->orderBy("t1.id DESC");
        $arr = $query->fetchAll();
      // echo $query->getQuery();
        return $arr;
    }

    function getallvendordatawithinvoice22($opts = null) { 
        GzObject::loadFiles('Model', array('vendorinvoice'));
        $vendorinvoiceModel = new vendorinvoiceModel();
        $query = $this->from($this->getTable() . ' as t1');
        $query->select(null);
        $query->select('t1.*, t2.item_number, t2.item_cost, t2.amount, t2.status, t2.item_desc, t2.oid, t2.update_on');
        $query->where($opts);
        $query->innerJoin($vendorinvoiceModel->getTable() . ' as t2 ON t2.custid = t1.id');
        //$query->orderBy("t1.id DESC");
        $arr = $query->fetchAll();
      // echo $query->getQuery();
        return $arr;
    }

    function getallvendordataexport($opts = null) { 
        GzObject::loadFiles('Model', array('vendorinvoice'));
        $vendorinvoiceModel = new vendorinvoiceModel();
        $query = $this->from($this->getTable() . ' as t1');
        $query->select(null);
        $query->select('t1.*, t2.oid, t2.paytype, t2.invoice_id, t2.invoice_num, t2.item_desc, t2.item_number,t2.item_cost,t2.amount,t2.status,t2.pay_mode,t2.pay_date,t2.payment_status,t2.payment_timestamp,t2.stripe_return,t2.transaction_id,t2.paid_amount,t2.stripe_product,t2.chkno,t2.bank,t2.chkdate,t2.receiveby,t2.remarks,t2.update_on');
        $query->where($opts);
        $query->innerJoin($vendorinvoiceModel->getTable() . ' as t2 ON t2.custid = t1.id');
        $query->orderBy("t2.id DESC");
        $arr = $query->fetchAll();
      // echo $query->getQuery();
        return $arr;
    }


   public function checkduplicatemember()
    {
        $email=$_POST['email'] ?? '';
        $phone=$_POST['phone'] ?? '';
        $taxid =$_POST['taxid'] ?? '';
    
        $res = 'SELECT * FROM '.$this->getTable().' WHERE  phone="'."$phone".'" OR email="'."$email".'" OR taxid="'."$taxid".'"';
        $result = array();
        $arr = $this->execute($res);
        return $arr[0]['id'] ?? null;
    }

    function savevendorInvoice($id){
        
        if (!empty($id)) {

            GzObject::loadFiles('Model', array('Vendor','vendorinvoice'));
            $VendorModel = new VendorModel();
            $vendorinvoiceModel = new vendorinvoiceModel();


            $businessname =$_POST['businessname'] ?? '';
            $ownername =$_POST['ownername'] ?? '';
            $taxid = $_POST['taxid'] ?? '';
             $mainpaytype=$_POST['paytype'] ?? '';
            if($mainpaytype == "OTHADV"){
                $paymentfor = 'Other Advertisements' ;
                }
                elseif($mainpaytype == "BOOTH"){
                 $paymentfor =  'Booth Rentals';
                }
                elseif($mainpaytype == "MAGADV"){
                  $paymentfor = 'Magazine Advertisements';
                    }           
             $type = $_POST['item_desc'] ?? '';
             $quantity =$_POST['item_number'] ?? '';
             $totalamount =$_POST['amount'] ?? '';
             $Amount =$_POST['item_cost'] ?? '';

            $oid =$_POST['oid'] ?? '';
            $invoice_number = Util::incrementalHash(10);
            $_POST['invoice_num'] = $invoice_number; 

            $opts = array();

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
            <td style='text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;'><strong>Vendor  Payment Details</strong></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class='email-token-class' style='text-align: center;'>
            <table style='height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;' width='604'>
            <tbody>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Order Id&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$oid</td>
            </tr>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Owner Name &nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$ownername</td>
            </tr>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Business Name&nbsp;&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$businessname</td>
            </tr>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Tax Id&nbsp;&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$taxid</td>
            </tr>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Payment For&nbsp;&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$paymentfor</td>
            </tr>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Type&nbsp;&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$type</td>
            </tr>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Quantity&nbsp;&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$quantity</td>
            </tr>

            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Amount&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'><span style='color:red;'>$</span>$Amount</td>
            </tr>
            <tr>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Total Amount&nbsp;</td>
            <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'><span style='color:red;'>$</span>$totalamount</td>
            </tr>
            </tbody>
            </table>
            </div>
            </div>
            </div>";
            

            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($variable);
            $name = 'Vendordata_' . $id . '_invoice_' . $invoice_number . '.pdf';
            $mpdf->Output(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . $name, 'F');
            //$folderPath = "parkinginvoice/";
            //$mpdf->Output($folderPath . $name, 'F');

            $save = array();

            return $id;
        }
        
        return false;
    }


    
}

?>
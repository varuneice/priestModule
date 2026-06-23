<?php
ini_set("display_errors", "Off");
header('Access-Control-Allow-Origin: *');
header('data-Type:application/json; charset=UTF-8');
header('Content-Type: application/json; charset=UTF-8');
include "config.php";
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//$query3 = "DELETE  FROM members WHERE date_format(CreatedOn,'%Y.%m.%d')  = CURDATE() ";
//$query3 = "DELETE  FROM members WHERE 1=1 ";
//mysqli_query($con, $query3);
$reponce = json_decode(file_get_contents('php://input'), true);
if (isset($_POST)) {
    foreach ($reponce as $value) {
// foreach ($_POST['mydata'] as $index=>$value) {
            $ID = $value['ID'];
            $Member_id = $value['Member_id'];
            $Category = $value['Category'];
            $F_Name =  $value['F_Name'];
            $L_Name = $value['L_Name'];
            $Sp_FName = $value['Sp_FName'];
            $Sp_LName = $value['Sp_LName'];
            $Address1 =  $value['Address1'];
            $Address2 = $value['Address2'];
            $Address3 = $value['Address3'];
            $City = $value['City'];
            $State =  $value['State'];
            $Country =  $value['Country'];
            $Zip = $value['Zip'];
            $email = $value['Email'];
            $Tele1 = $value['Tele1'];
            $Tele2 =  $value['Tele2'];
            $Child1 = $value['Child1'];
            $Age1 = $value['Age1'];
            $Child2 = $value['Child2'];
            $Age2 = $value['Age2'];
            $Child3 = $value['Child3'];
            $Age3 = $value['Age3'];
            $Parent1 = $value['Parent1'];
            $Parent2 =  $value['Parent2'];
            $remarks = $value['remarks'];
            $swap = $value['swap'];
            $FirstSal = $value['FirstSal'];
            $SpouseSal =  $value['SpouseSal'];
            $membership_type = $value['MType'];
            $CreatedOn = $value['CreatedOn'];
            $UpdateBy = $value['UpdateBy'];
            $UpdateOn = $value['UpdateOn'];
            $rate = null;//$_POST['rate'];
            $payment_status = 'confirmed';//$_POST['status'];
            $payment_times = $value['UpdateOn'];
            $payment_timestamp = mktime($payment_times);
            $stripe_return =  'succeeded';
            $transaction_id = $value['cc_ref_no'];
            $payamount = $value['amount'];
            $paid_amount = $payamount."00";
            $stripe_product = $value['cc_name'];
            $donation = null;//$_POST['donation'];
            $amount = $value['amount'];
            $fav_language = null;//$_POST['fav_language'];
            $fav =  null;//$_POST['fav'];
            $total = $value['amount'];
            $Child4 = null;//$_POST['Child4'];
            $Age4 = null;//$_POST['Age4'];
            $information = null;//$_POST['information'];
            $GovtissueID = null;//$_POST['GovtissueID'];
            $M_Name = null;//$_POST['M_Name'];
            $Mob_No =  $value['Tele1'];
            $Email2 = null;//$_POST['Email2'];
            $password = null;//$_POST['password'];
            $type = null;//$_POST['type'];
            $avatar = null;//$_POST['avatar'];
            $Renew_date = null;//$_POST['Renew_date'];
            $status = null;//$_POST['status'];
            $Payment_method = $value['pay_mode'];
            $Ref_Phone = null;//$_POST['Ref_Phone'];
             // new field
            $pay_date = '';
            $pay_type = '';
            $pay_for = '';
            
     $get = "SELECT * FROM members WHERE ID='$ID'";
    $result = mysqli_query($con, $get);
if (mysqli_num_rows($result) > 0) {
    
    $res =mysqli_fetch_assoc($result);
    $update =  "UPDATE members SET Category='$Category',F_Name='$F_Name',L_Name='$L_Name',Sp_FName='$Sp_FName',Sp_LName='$Sp_LName',Address1='$Address1',Address2='$Address2',Address3='$Address3',City='$City',State='$State',Country='$Country',Zip='$Zip',email='$email',Tele1='$Tele1',Tele2='$Tele2',Child1='$Child1',Age2='$Age2',Child3='$Child3',Age3='$Age3',Parent1='$Parent1',Parent2='$Parent2',remarks='$remarks',swap='$swap',FirstSal='$FirstSal',SpouseSal='$SpouseSal',membership_type='$membership_type',CreatedOn='$CreatedOn',UpdateBy='$UpdateBy',UpdateOn='$UpdateOn',rate='$rate',payment_status='$payment_status',payment_timestamp='$payment_timestamp',stripe_return='$stripe_return',transaction_id='$transaction_id',paid_amount='$paid_amount',stripe_product='$stripe_product',donation='$donation',amount='$amount',fav_language='$fav_language',fav='$fav',total='$total',Child4='$Child4',Age4='$Age4',information='$information',GovtissueID='$GovtissueID',M_Name='$M_Name',Mob_No='$Mob_No',Email2='$Email2',password='$password',type='$type',avatar='$avatar',Renew_date='$Renew_date',status='$status',Payment_method='$Payment_method',Ref_Phone='$Ref_Phone',pay_date='$pay_date',pay_type='$pay_type',pay_for='$pay_for' WHERE ID='$ID'";
    $tres =mysqli_query($con, $update);
    $tickets=$tres;
}
else{
    $sql = "INSERT INTO members  VALUES ('$ID','$Member_id','$Category','$F_Name','$L_Name','$Sp_FName','$Sp_LName','$Address1','$Address2','$Address3','$City','$State','$Country','$Zip','$email','$Tele1','$Tele2','$Child1','$Age1','$Child2','$Age2','$Child3','$Age3','$Parent1','$Parent2','$remarks','$swap','$FirstSal','$SpouseSal','$membership_type','$CreatedOn','$UpdateBy','$UpdateOn','$rate','$payment_status','$payment_timestamp','$stripe_return','$transaction_id','$paid_amount','$stripe_product','$donation','$amount','$fav_language','$fav','$total','$Child4','$Age4','$information','$GovtissueID','$M_Name','$Mob_No','$Email2','$password','$type','$avatar','$Renew_date','$status','$Payment_method','$Ref_Phone','$pay_date','$pay_type','$pay_for')";
    //$sql = "INSERT INTO confirm_code  VALUES ('','$str','$GetData[2]','$GetData[1]','$GetData[3]')";
    $retval = mysqli_query($con, $sql);
    if($Category == 'GM'){
    $sql2 ="UPDATE nxtmid SET nxtmid = '$Member_id' WHERE id=1";
     }
    mysqli_query($con, $sql2);
    $members =  $retval;
}
  //$sql2 ='UPDATE members SET nxtmid= $Member_id WHERE id=1';
            // mysqli_query($con, $sql2);
            //$sql2 ='UPDATE members SET nxtmid='$Member_id' WHERE id=1';
            // mysqli_query($con, $sql2);
            //return $retval;
}
//return $members;
}



?>
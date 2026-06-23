<?php
header('Access-Control-Allow-Origin: *');
header('data-Type:application/json; charset=UTF-8');
header('Content-Type: application/json; charset=UTF-8');
include "config.php";
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$reponce = json_decode(file_get_contents('php://input'), true);

if (isset($_POST)) {
    
    
    //$updatetimestamp =  "UPDATE lastsync SET SyncDateTime='$reponce' WHERE id='1'";
   // $tres =mysqli_query($con, $updatetimestamp);
    //$lasttime = $tres;
}

        
        

	
//}

?>
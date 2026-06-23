<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
include "config.php";
// Check connection
if ($con->connect_error) {
    echo json_encode(['error' => 'DB connection failed: ' . $con->connect_error]);
    exit;
}

if (isset($_GET['term'])) {
    $term = $_GET['term'] . '%';

    $stmt = $con->prepare(
        "SELECT CHAR_LENGTH(Member_id) as digit, Zip, FirstSal, SpouseSal, Member_id,
                CONCAT(`F_Name`, ' ', `L_Name`) AS Name,
                CONCAT(`Sp_FName`, ' ', `Sp_LName`) AS Spouse,
                CONCAT(`Address1`, ' ', `Address2`, ' ', `Address3`) AS Address
         FROM members
         WHERE (F_Name LIKE ? OR L_Name LIKE ? OR Zip LIKE ? OR Sp_FName LIKE ? OR Sp_LName LIKE ? OR Member_id LIKE ?)
           AND Member_id <> 0
           AND (FirstSal != 'Late' OR SpouseSal != 'Late')
           AND (Active IS NULL OR Active = '')
         HAVING digit <= 4
         LIMIT 20"
    );

    if (!$stmt) {
        echo json_encode(['error' => 'Prepare failed: ' . $con->error]);
        exit;
    }

    $stmt->bind_param('ssssss', $term, $term, $term, $term, $term, $term);
    $stmt->execute();
    $result = $stmt->get_result();

    $memberData = array();
    if ($result->num_rows > 0) {
        while ($user = $result->fetch_array()) {
            $data['id'] = $user['Member_id'];
            $sp = $user['Spouse'];
            if ($user['FirstSal'] == 'Late' || $user['SpouseSal'] == 'Late') {
                $data['value'] = $user['Name'];
            } else {
                if ($sp == "" || $sp == " " || $sp == null) {
                    $data['value'] = $user['Name'] . ' , ' . $user['Zip'];
                } else {
                    $data['value'] = $user['Name'] . ' , ' . $user['Spouse'] . ' , ' . $user['Zip'];
                }
            }
            array_push($memberData, $data);
        }
    }
    echo json_encode($memberData);
    $stmt->close();
}
?>

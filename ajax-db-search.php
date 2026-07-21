<?php
header('Access-Control-Allow-Origin: *');
header('data-Type:application/json; charset=UTF-8');
header('Content-Type: application/json; charset=UTF-8');

if (session_status() === PHP_SESSION_NONE) {
    session_name('TimeSlotBookingCalendarPHP');
    session_start();
}
require_once __DIR__ . '/application/config/otp_session.php';
if (empty($_SESSION['otp_verified_member']) && empty($_SESSION['admin_user'])) {
    echo json_encode([]);
    exit;
}

include "config.php";
// Check connection
if (!$con || $con->connect_error) {
    echo json_encode(['error' => 'Connection failed: ' . ($con->connect_error ?? 'unknown')]);
    exit;
}

if (isset($_GET['term'])) {
    $term = $_GET['term'] . '%';

    $stmt = $con->prepare(
        "SELECT Zip, FirstSal, SpouseSal, Member_id,
                CONCAT(`F_Name`, ' ', `L_Name`) AS Name,
                CONCAT(`Sp_FName`, ' ', `Sp_LName`) AS Spouse,
                CONCAT(`Address1`, ' ', `Address2`, ' ', `Address3`) AS Address
         FROM memberltdytd
         WHERE (F_name LIKE ? OR L_Name LIKE ? OR Zip LIKE ? OR Sp_FName LIKE ? OR Sp_LName LIKE ? OR Member_id LIKE ?)
           AND (FirstSal != 'Late' OR SpouseSal != 'Late')
           AND (Active IS NULL OR Active='')
         LIMIT 8"
    );
    $stmt->bind_param('ssssss', $term, $term, $term, $term, $term, $term);
    $stmt->execute();
    $result = $stmt->get_result();

    $memberData = array();
    if ($result && $result->num_rows > 0) {
        while ($user = $result->fetch_array()) {
            $data['id'] = $user['Member_id'];
            $sp = $user['Spouse'];
            if ($user['FirstSal'] == 'Late' or $user['SpouseSal'] == 'Late') {
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


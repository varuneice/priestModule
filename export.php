<?php

$ENV_DB_HOST = 'durgabari-server.mysql.database.azure.com';
$ENV_DB_NAME = 'hdbs_payment_2';
$ENV_DB_USER = 'aowdjkkwgi';
$ENV_DB_PASS = 'Eice@2025#';

$conn = mysqli_init();

mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

mysqli_real_connect(
    $conn,
    $ENV_DB_HOST,
    $ENV_DB_USER,
    $ENV_DB_PASS,
    $ENV_DB_NAME,
    3306,
    NULL,
    MYSQLI_CLIENT_SSL
);

if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM confirm_code WHERE paymentfrom='pujaregistration'";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}

$filename = "confirm_code_rows.txt";

$file = fopen($filename, "w");

while ($row = mysqli_fetch_assoc($result)) {

    $line =
        "ID: " . $row['id'] .
        " | Date: " . $row['date'] .
        " | Confirmation: " . $row['Confirmation'] .
        " | Amount: " . $row['Amount'] .
        " | Description: " . $row['Description'] .
        " | Donar Name: " . $row['DonarName'] .
        " | Updated On: " . $row['UpdatedOn'] .
        " | Payment From: " . $row['paymentfrom'] .
        PHP_EOL;

    fwrite($file, $line);
}

fclose($file);

echo "File created successfully: " . $filename;

mysqli_close($conn);

?>
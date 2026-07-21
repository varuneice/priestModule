<?php
$serverDateTime = date('Y-m-d');
$currentYear = date('Y');

echo json_encode(array(
    'serverDateTime' => $serverDateTime,
    'currentYear' => $currentYear
));

<?php

switch ($_POST['cat'] ?? '') {
    case '1':
        require 'component/tab_1_table.php';
        break;
    case '2':
        require 'component/tab_2_table.php';
        break;
    case '3':
        require 'component/tab_3_table.php';
        break;
    case '4':
        require 'component/tab_4_table.php';
        break;
    case '5':
        require 'component/tab_5_table.php';
        break;
    case '6':
        require 'component/tab_6_table.php';
        break;
}
?>
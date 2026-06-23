<?php
require 'component/vendor_table.php';
?>
<?php

switch ($_POST['cat'] ?? '') {
    case '1':
        require 'component/vendor_table.php';
        break;
    case '2':
        require 'component/vendor_price_table.php';
        break;
}
?>
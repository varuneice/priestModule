<?php
if (empty($_POST['calendars_id'])) {
   $_POST['calendars_id'][] = '1';
}
?>
<script type="text/javascript" src="<?php echo INSTALL_URL; ?>index.php?controller=GzFront&action=load&cid[]=<?php echo implode('&cid[]=', ($_POST['calendars_id'] ?? '') ); ?>&view_month=1"></script>
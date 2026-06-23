<div class="overlay"></div>
<div class="loading-img"></div>
<?php require 'component/lang.php'; ?>
<?php
foreach ($_GET['cid'] ?? [] as $cid) {
    ?>
    <div id="gz-abc-main-container-<?php echo $cid; ?>">
        <div id="gz-abc-calendar-container-<?php echo $cid; ?>">
            <?php require 'component/calendars.php'; ?>
        </div>
    </div>
    <?php
}
?>
<?php if (empty($_SESSION['err'])) { ?>
    <div class="GZBookingContainer">
        <?php
        require_once 'component/booking_details.php';
        ?>
    </div>
<?php
} else {
    require_once 'booking_form.php';
}
?>
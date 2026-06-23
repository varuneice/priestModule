<div id="install-container">
    <div class="grid">
        <header class="header bordered" role="banner">
            <h1>PHP GZ Hotel Booking</h1>
        </header>
        <div class="breadcrumb">
            <div class="sub-breadcrumb">
                <span class="time">It is currently <?php echo date('l jS \of F Y h:i:s'); ?></span>
            </div>
        </div>
        <div id="page-body">
            <main role="main">
                <div class="well">
                    <?php
                    if (!empty($_SESSION['message'])) {
                        ?>
                        <div class="alert alert-danger alert-dismissable">
                            <i class="fa fa-ban"></i>
                            <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                            <b>Alert!</b>
                            <?php echo $_SESSION['message']; ?>
                        </div>
                        <?php
                        unset($_SESSION['message']);
                    }
                    ?>
                    <form name="UpdateDbFrm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=Admin&action=update_db">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                        <p class="form_install">
                            Welcome to GZ Scripts Update Wizard. To continue click Update DB button.
                            <br />
                            <br />
                            <input type="hidden" name="update_db" value="1" />
                            <?php
                            if (!empty($_SESSION['status'])) {
                                ?>
                            <div class="alert alert-success alert-dismissable">
                                <i class="fa fa-check"></i>
                                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                                <b>Alert!</b>
                                <?php 
                                echo $_SESSION['status'];
                                unset($_SESSION['status']);
                                ?>
                            </div>
                            <?php
                        } else {
                            ?>
                            <button class="btn btn-primary">Update DB</button>
                        <?php } ?>
                        </p>
                        <input type="hidden" name="controller" value="Admin" />
                        <input type="hidden" name="action" value="update_db" />
                    </form>
                </div>
            </main>
        </div>
    </div>
</div>
<footer id="footer">
    <section class="container clearfix">
        <div class="bottom">
            <section style="text-align: center;">
                Copyright ©
                <span class="the-year">2014</span>
                <a style="font-size: 16px; font-weight: bold;" href="http://www.gzscripts.com/">GZ Scripts</a>
            </section>
        </div>
</footer>
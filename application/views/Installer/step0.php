
<div id="install-container">
    <div class="grid">
        <header class="header bordered" role="banner">
            <h1>Time Slot Booking Calendar</h1>
        </header>
        <div class="breadcrumb">
            <div class="sub-breadcrumb">
                <span class="time">It is currently <?php echo date('l jS \of F Y h:i:s'); ?></span>
            </div>
        </div>
        <div id="page-body">
            <main role="main">
                <div class="well">
                    <p class="form_install">
                        Welcome to GZ Scripts Install Wizard. To continue click Install button.
                        <br />
                        <br />
                        <a class="btn btn-default" href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=Installer&amp;action=step1&amp;install=1">Install</a>
                    </p>
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
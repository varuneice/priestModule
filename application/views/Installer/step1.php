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
                <h1 class="bordered title"><span class="green">STEP 1</span>: MySQL Server Data</h1>
                <?php
                if (!empty($tpl['warning'])) {
                    foreach (($tpl['warning'] ?? []) as $key => $v) {
                        Util::printNotice($v, 'alert-warning');
                        echo '<br />';
                    }
                }
                if (isset($tpl['status']) && $tpl['status'] == 1) {
                    $STORAGE = &$_SESSION[$this->controller->default_product]['Installer'];
                    ?>

                    <form action="index.php?controller=Installer&amp;action=step2&amp;install=1" method="post" id="step1-installer-id" class="frm-class">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                        <input type="hidden" name="step1" value="1" />
                        <div class="well">
                            <fieldset>
                                <div class = "form-group">
                                    <label class = "control-label" for = "title">Hostname <span class="red">*</span></label>
                                    <input class = "form-control input-sm" type = "text" name = "hostname" size = "25" value = "<?php echo isset($STORAGE['hostname']) ? $STORAGE['hostname'] : 'localhost'; ?>" title = "hostname" placeholder = "hostname" /> 
                                </div>

                                <div class = "form-group">
                                    <label class = "control-label" for = "title">Username <span class="red">*</span></label>
                                    <input class = "form-control input-sm" type = "text" name = "username" size = "25" value = "<?php echo isset($STORAGE['username']) ? $STORAGE['username'] : NULL; ?>" title = "Username" placeholder = "Username" />
                                </div>

                                <div class = "form-group">
                                    <label class = "control-label" for = "title">Password</label>
                                    <input class = "form-control input-sm" type = "password" name = "password" size = "25" value = "<?php echo isset($STORAGE['username']) ? $STORAGE['username'] : NULL; ?>" title = "Password" placeholder = "Password" />
                                </div>

                                <div class = "form-group">
                                    <label class = "control-label" for = "title">Database <span class="red">*</span></label>
                                    <input class = "form-control input-sm" type = "text" name = "database" size = "25" value = "<?php echo isset($STORAGE['database']) ? $STORAGE['database'] : NULL; ?>" title = "Database" placeholder = "Database" />
                                </div>

                                <div class = "form-group">
                                    <label class = "control-label" for = "title">Table prefix</label>
                                    <input class = "form-control input-sm" type = "text" name = "prefix" size = "25" value = "<?php echo isset($STORAGE['prefix']) ? $STORAGE['prefix'] : NULL; ?>" title = "Table prefix" placeholder = "Table prefix" />

                                </div>
                            </fieldset>
                            <fieldset>
                                <button id = "get-ifno-id" class = "btn btn-default" autocomplete = "off" value = "Next &gt;&gt;" name = "submit" tabindex = "9" type = "submit">Next &gt;&gt;</button>
                            </fieldset>
                        </div>
                    </form>
                <?php } ?>
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
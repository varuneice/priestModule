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
                <h1 class="bordered title"><span class="green">STEP 2</span>: User Admin Data</h1>
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
                    <br />
                    <form action="index.php?controller=Installer&amp;action=step3&amp;install=1" method="post" id="frmStep2" class="frm-class">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                        <input type="hidden" name="step2" value="1" />
                        <input type="hidden" name="hostname" value="<?php echo isset($STORAGE['hostname']) ? $STORAGE['hostname'] : NULL; ?>" />
                        <input type="hidden" name="username" value="<?php echo isset($STORAGE['username']) ? $STORAGE['username'] : NULL; ?>" />
                        <input type="hidden" name="password" value="<?php echo isset($STORAGE['password']) ? $STORAGE['password'] : NULL; ?>" />
                        <input type="hidden" name="database" value="<?php echo isset($STORAGE['database']) ? $STORAGE['database'] : NULL; ?>" />
                        <input type="hidden" name="prefix" value="<?php echo isset($STORAGE['prefix']) ? $STORAGE['prefix'] : NULL; ?>" />
                        <div class="well">
                            <fieldset>
                                <div class = "form-group">
                                    <label class = "control-label" for = "title">Email <span class="red">*</span></label>
                                    <input class = "form-control input-sm" type = "text" name = "admin_email" size = "25" title = "Email" placeholder = "Email" />
                                
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class = "form-group">
                                    <label class = "control-label" for = "title">Password <span class="red">*</span></label>
                                    <input class = "form-control input-sm" type = "password" name = "admin_password" size = "25" title = "Password" placeholder = "Password" />
                        
                                </div>
                            </fieldset>

                            <fieldset class = "form-actions">
                                <button class = "btn btn-default" autocomplete = "off" value = "Finish" name = "Finish" tabindex = "9" type = "submit">Finish</button>
                                <input class = "btn btn-default"  type="button" value = "Back" name = "Back" tabindex = "9"  onclick=" window.location = 'index.php?controller=Installer&action=step1'"/>
                            </fieldset>
                        </div>
                    </form>
                    <?php
                } else {
                    ?>
                    <form action="" method="post" id="frmStep2" class="frm-class">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                        <fieldset>
                            <input class = "btn btn-default"  type="button" value = "Back" name = "Back" tabindex = "9"  onclick=" window.location = 'index.php?controller=Installer&action=step1'"/>
                        </fieldset>
                    </form>
                    <?php
                }
                ?>
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
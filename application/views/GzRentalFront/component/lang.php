<div id="server-id" style="display: none"><?php echo INSTALL_URL; ?></div>
<?php if (count($tpl['languages']) > 1) { ?>
    <form id="lang-frm-id" name="lang-frm-name">
        <input type="hidden" name="view_month" value="<?php echo $_GET['view_month'] ?? 1; ?>" >
        <?php
        foreach ($_GET['cid'] ?? [] as $cid) {
            ?>
            <input type="hidden" name="cid[]" value="<?php echo $cid; ?>" >
            <?php
        }
        ?>
    </form>
    <div class="gz-nav">
        <div class="gz-container">
            <div class="gz-row">
                <nav>
                    <div id="languages-block-top" class="gz-languages-block">
                        <div class="gz-current">
                            <span><?php echo @$tpl['select_language']['language']; ?></span>
                        </div>
                        <ul id="first-languages" class="gz-languages-block_ul gz-toogle_content" style="display: none;">
                            <?php
                            foreach (($tpl['languages'] ?? []) as $key => $value) {
                                ?>
                                <li>
                                    <a rel="<?php echo $value['id']; ?>" title="<?php echo $value['language']; ?>" href="#">
                                        <span><?php echo $value['language']; ?></span>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <br />
<?php } ?>
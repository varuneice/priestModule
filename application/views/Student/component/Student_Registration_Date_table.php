<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
        <section class="content left width_100">
             <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Student/registrationDate" method="post" name="registrationDate" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                <table class="table">
                     <tr class="tr">
                      <td class="td"><label>Registration Date</label></td>
                      <td class="td"><input  required="true" id="regDate" class="form-control input-sm" type="date" name="registrationDate" size="25" value="<?php echo $tpl['RegistrationLastDatearr'][0]['registrationDate']; ?>" title="<?php echo __('Registration Date'); ?>"></td>
                     
                    </tr>
                </table>
                <br>
                    <input type="hidden" name="id" value="<?php echo $tpl['RegistrationLastDatearr'][0]['id']; ?>" />
                    <?php if ($this->controller->isAdmin()) { ?>
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
                    <?php } ?> 
                </form>
        </section>
<script>
    var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        $('#regDate').attr('min',today);
</script>
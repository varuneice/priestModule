<form id="edit_user" class=" user-frm-class" action="<?php echo INSTALL_URL; ?>Eventadmin/thresholdamount/"
    method="post" name="eventThreasholdAmount" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
    <table id="thresholdAmountTable"
        class="gzblog-table table-striped table-hover" cellpadding="0" cellspacing="0">
        <tbody>
            
       
            <tr class="tr">
                <td class="td"><label> Threshold Amount</label></td>
                <td class="td">

                    <input style="width:  50%;" value="<?php echo $tpl['amount']['amount'] ?? ''; ?>"  type="number" name="amount" id="thresholdAmount" min="1" oninput="validity.valid||(value='');">
                </td>
            </tr>
        </tbody>
    </table>
    <br>
     <input  type="hidden" name="id" value="<?php echo $tpl['amount']['id'] ?? ''; ?>">
  
    

   

    <?php if ($this->controller->isAdmin()) { ?>
        <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit"
            tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
    <?php } ?>
</form>


<script>
   
</script>
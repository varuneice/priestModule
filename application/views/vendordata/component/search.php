<form style="display: none;" id="search-booking-frm-id" class="booking-frm-class" action="<?php echo INSTALL_URL; ?>Student/index" method="post" name="booking-frm-search">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
    <br />
    <fieldset class="scheduler-border bg-light-green">
        <row class="row">
            <div class="col-sm-6">
                <div class="form-group" id="calendars-container-id">
                    <label class="control-label" for="calendar_id"><?php echo __('Reg_UId'); ?>:</label>
                    <input id="Member_id" class="form-control input-sm" type="number" name="reg_uid" size="25" value="<?php echo @$_POST['reg_uid']; ?>" title="<?php echo __('reg_uid'); ?>" placeholder="">
                    <!-- <select data-rule-required="true" name="calendar_id" id="calendar_id" class="form-control input-sm" >
                        <option value="">---</option>
                        <?php
                        foreach (($tpl['calendars'] ?? []) as $k => $v) {
                            ?>
                            <option <?php echo (@$_POST['calendar_id'] == $v['uid']) ? "selected='selected'" : ""; ?> value="<?php echo $v['uid']; ?>" ><?php echo $v['i18n'][$this->controller->tpl['default_language']['uid']]['title']; ?></option>
                            <?php
                        }
                        ?>
                    </select> -->
                </div>
            </div>
           
            <div class="col-sm-6">
                <div class="form-group">
                    <!-- <label class="control-label" for="status">
                        //<?php echo __('booking_status'); ?>:
                    </label>
                    <select data-rule-required="true" name="status" id="status" class="form-control input-sm" >
                        <option value="">---</option>
                       // <?php
                      //  $status_arr = __('status_arr');
                       // foreach ($status_arr as $k => $v) {
                         //   ?>
                            <option <?php echo (@$_POST['status'] == ($k ?? '')) ? "selected='selected'" : ""; ?> value="<?php echo $k ?? ''; ?>" ><?php echo $v ?? ''; ?></option>
                     //       <?php
                      //  }
                     //   ?>
                    </select> -->
                </div>
            </div>
        </row>
        <row class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="control-label" for="St_Name"><?php echo __('Student Name'); ?>:</label>
                    <input id="first_name" class="form-control input-sm" type="text" name="St_Name" size="25" value="<?php echo @$_POST['St_Name']; ?>" title="<?php echo __('St_Name'); ?>" placeholder="">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="control-label" for="subject"><?php echo __('Subject'); ?>:</label>
                    <input id="second_name" class="form-control input-sm" type="text" name="subject" size="25" value="<?php echo @$_POST['subject']; ?>" title="<?php echo __('subject'); ?>" placeholder="">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="control-label" for="school"><?php echo __('School'); ?>:</label>
                    <input id="second_name" class="form-control input-sm" type="text" name="school" size="25" value="<?php echo @$_POST['school']; ?>" title="<?php echo __('school'); ?>" placeholder="">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="control-label" for="session"><?php echo __('Session'); ?>:</label>
                    <input id="email" class="form-control input-sm" type="text" name="session" size="25" value="" title="<?php echo __('session'); ?>" placeholder="">
                </div>
            </div>
        </row>
        <row>
            <div class="col-sm-6">
                <br />
                <button id="search-project-id" class="btn btn-success" autocomplete="off" value="<?php echo __('search'); ?>" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-search"></i>&nbsp;<?php echo __('search'); ?></button>
            </div>
        </row>
    </fieldset>
</form>



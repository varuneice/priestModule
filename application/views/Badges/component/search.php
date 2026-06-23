<form style="display: none;" id="search-booking-frm-id" class="booking-frm-class" action="<?php echo INSTALL_URL; ?>Badges/index" method="post" name="booking-frm-search">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
    <br />
    <fieldset class="scheduler-border bg-light-green">
        <row class="row">
            <div class="col-sm-6">
                <!-- <div class="form-group" id="calendars-container-id">
                    <label class="control-label" for="calendar_id"><?php echo __('Members'); ?>:</label>
                    <input id="Member_id" class="form-control input-sm" type="number" name="Member_id" size="25" value="<?php echo @$_POST['Member_id']; ?>" title="<?php echo __('member_id'); ?>" placeholder="">
                    <select data-rule-required="true" name="calendar_id" id="calendar_id" class="form-control input-sm" >
                        <option value="">---</option>
                        <?php
                        foreach (($tpl['calendars'] ?? []) as $k => $v) {
                            ?>
                            <option <?php echo (@$_POST['calendar_id'] == $v['id']) ? "selected='selected'" : ""; ?> value="<?php echo $v['id']; ?>" ><?php echo $v['i18n'][$this->controller->tpl['default_language']['id']]['title']; ?></option>
                            <?php
                        }
                        ?>
                    </select> 
                </div>  -->
            </div>
           
            <div class="col-sm-6">
                <!-- <div class="form-group">
                    <label class="control-label" for="status">
                        <?php echo __('booking_status'); ?>:
                    </label>
                    <select data-rule-required="true" name="status" id="status" class="form-control input-sm" >
                        <option value="">---</option>
                        <?php
                        $status_arr = __('status_arr');
                        foreach ($status_arr as $k => $v) {
                            ?>
                            <option <?php echo (@$_POST['status'] == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div> -->
            </div>
        </row>
        <row class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="control-label" for="first_name"><?php echo __('first_name'); ?>:</label>
                    <input id="first_name" class="form-control input-sm" type="text" name="F_Name" size="25" value="<?php echo @$_POST['F_Name']; ?>" title="<?php echo __('first_name'); ?>" placeholder="">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="control-label" for="second_name"><?php echo __('Spouse'); ?>:</label>
                    <input id="second_name" class="form-control input-sm" type="text" name="Sp_FName" size="25" value="<?php echo @$_POST['Sp_FName']; ?>" title="<?php echo __('second_name'); ?>" placeholder="">
                </div>
            </div>
            <!-- <div class="col-sm-4">
                <div class="form-group">
                    <label class="control-label" for="second_name"><?php echo __('Member_id'); ?>:</label>
                    <input id="Member_id" class="form-control input-sm" type="number" name="Member_id" size="25" value="<?php echo @$_POST['Member_id']; ?>" title="<?php echo __('member Id'); ?>" placeholder="">
                </div>
            </div> -->
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="control-label" for="second_name"><?php echo __('category'); ?>:</label>
                    <input id="second_name" class="form-control input-sm" type="text" name="Category" size="25" value="<?php echo @$_POST['Sp_FName']; ?>" title="<?php echo __('category'); ?>" placeholder="">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="control-label" for="email"><?php echo __('email'); ?>:</label>
                    <input id="email" class="form-control input-sm" type="text" name="Email" size="25" value="" title="<?php echo __('Email'); ?>" placeholder="">
                </div>
            </div>
        </row>
        <row>
        <div class="col-sm-6"><br/>
        <button id="search-project-id" class="btn btn-success" autocomplete="off" value="<?php echo __('search'); ?>" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-search"></i>&nbsp;<?php echo __('search'); ?></button>
            </div>
        </row>
    </fieldset>
</form>



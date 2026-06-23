<section class="content-header">
    <h1>
        <?php echo __('import'); ?>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> 
                <?php
                echo __('home');
                ?>
            </a>
        </li>
        <li><a href="<?php echo INSTALL_URL; ?>Badges/index"><?php echo __('Parking'); ?></a></li>
        <li class="active"><?php echo __('import'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<section class="content">
    <div class="row">
        <div class="col-md-12 ui-sortable">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title"><?php echo __('import'); ?></h4>
                </div>
                <div class="panel-body">
                    <form id="import-frm-id" class="frm-class import-frm-class" action="<?php echo INSTALL_URL; ?>Badges/import" method="post" name="import-frm" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                        <div class="callout callout-info" >
                            <h4><?php echo __('import_data') . ' ' . __('Volunteers'); ?></h4>
                            <p><?php echo __('import_info'); ?></p>
                        </div>
                        <div class="padding-19 nav-tabs-custom left width_100">
                            <div class="overlay"></div>
                            <div class="loading-img"></div>
                            <div id="import_table">
                                <div style="overflow-x: auto; overflow-y: hidden;">
                                    <table class="table table-striped table-bordered dataTable no-footer" cellpadding="0" cellspacing="0" >
                                        <thead>
                                            <tr>
                                                <th><?php echo __('ID'); ?></th>
                                                <th><?php echo __('MID'); ?></th>
                                                <th><?php echo __('Volunteer Name'); ?></th>
                                                <th><?php echo __('Last Name'); ?></th>
                                                <th><?php echo __('Core Team'); ?></th>
                                                <th><?php echo __('Core TeamRole'); ?></th>
                                                <th><?php echo __('Other Teams'); ?></th>
                                                <th><?php echo __('Spouse Name'); ?></th>
                                                <th><?php echo __('Spouse Team'); ?></th>
                                                <th><?php echo __('Registered'); ?></th>
                                                <th><?php echo __('Sponsor Parking'); ?></th>
                                                <th><?php echo __('Spouse volunteerparking'); ?></th>
                                                <th><?php echo __('Priority'); ?></th>
                                                <th><?php echo __('Day FullParking'); ?></th>
                                                <th><?php echo __('Day Assigned'); ?></th>
                                                <th><?php echo __('Parking AreaAssigned'); ?></th>
                                                <th><?php echo __('Date'); ?></th>
                                                <th><?php echo __('Signature'); ?></th>
                                                <th><?php echo __('Status'); ?></th>
                                                <th><?php echo __('Decal'); ?></th>
                                                <th><?php echo __('Name Authorized'); ?></th>   
                                                <th><?php echo __('paid parking'); ?></th>
                                                <th><?php echo __('Phone No'); ?></th>   
                                                <th><?php echo __('Email'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($_POST['import'])) {
                                                if (!empty($tpl['volarr'])) {
                                                    foreach (($tpl['volarr'] ?? []) as $key => $value) {
                                                        ?>
                                                        <tr>
                                                            <td><input type="hidden" name="id[]" value="<?php echo $value[0]; ?>"></td>
                                                            <td><input class="mini" type="text" name="MID[]" value="<?php echo $value[1]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Volunteer_Name[]" value="<?php echo $value[2]; ?>"></td>
                                                            <td><input class="mini" type="text" name="L_Name[]" value="<?php echo $value[3]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Core_Team[]" value="<?php echo $value[4]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Core_TeamRole[]" value="<?php echo $value[5]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Other_Teams[]" value="<?php echo $value[6]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Spouse_Name[]" value="<?php echo $value[7]; ?>"></td>
                                                            <td><input type="text" name="Spouse_Team[]" value="<?php echo $value[8]; ?>"></td>
                                                            <td><input type="text" name="Registered[]" value="<?php echo $value[9]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Sponsor_Parking[]" value="<?php echo $value[10]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Spouse_volunteerparking[]" value="<?php echo $value[11]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Priority[]" value="<?php echo $value[12]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Day_FullParking[]" value="<?php echo $value[13]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Day_assigned[]" value="<?php echo $value[14]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Parking_AreaAssigned[]" value="<?php echo $value[15]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Date[]" value="<?php echo $value[16]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Signature[]" value="<?php echo $value[17]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Status[]" value="<?php echo $value[18]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Decal[]" value="<?php echo $value[19]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Name_Authorized[]" value="<?php echo $value[20]; ?>"></td>
                                                            <td><input class="mini" type="text" name="paid_parking[]" value="<?php echo $value[21]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Tele1[]" value="<?php echo $value[22]; ?>"></td>
                                                            <td><input class="mini" type="text" name="email[]" value="<?php echo $value[23]; ?>"></td>
                                                            <?php 
                                                            for($i=24; $i<count($value); $i++){
                                                                if(!empty($value[$i])){
                                                                    ?>
                                                                    <td><input class="mini" type="text" name="timestamp[<?php echo $value[0]; ?>][]" value="<?php echo $value[$i]; ?>"></td>
                                                                    <?php $i++; ?>
                                                                    <td><input class="mini" type="text" name="count[<?php echo $value[0]; ?>][]" value="<?php echo $value[$i]; ?>"></td>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td><strong style="float: right"><?php echo __('total_row'); ?>:</strong></td>
                                                        <td colspan="24"><?php echo $tpl['row_count'] ?></td>
                                                    </tr>
                                                </tfoot>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td>1451</td>
                                                <td>Volunteer Name</td>
                                                <td>Last Name</td>
                                                <td>Core Team</td>
                                                <td>Core Team Role</td>
                                                <td>Other Team</td>
                                                <td>Spouse Name</td>
                                                <td>Spouse Team</td>
                                                <td>Registered</td>
                                                <td>Sponsor Parking</td>
                                                <td>Spouse Volunteer Parking</td>
                                                <td>Priority</td>
                                                <td>Day Full Parking</td>
                                                <td>Day Assigned</td>
                                                <td>Parking Area Assigned </td>
                                                <td>Date</td>
                                                <td>Signature</td>
                                                <td>Status</td>
                                                <td>Decal</td>
                                                <td>Name Authorized</td>
                                                <td>paid Parking</td>
                                                <td>Phone</td>
                                                <td>Email</td>
                                               
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>445</td>
                                                <td>Volunteer Name</td>
                                                <td>Last Name</td>
                                                <td>Core Team</td>
                                                <td>Core Team Role</td>
                                                <td>Other Team</td>
                                                <td>Spouse Name</td>
                                                <td>Spouse Team</td>
                                                <td>Registered</td>
                                                <td>Sponsor Parking</td>
                                                <td>Spouse Volunteer Parking</td>
                                                <td>Priority</td>
                                                <td>Day Full Parking</td>
                                                <td>Day Assigned</td>
                                                <td>Parking Area Assigned </td>
                                                <td>Date</td>
                                                <td>Signature</td>
                                                <td>Status</td>
                                                <td>Decal</td>
                                                <td>Name Authorized</td>
                                                <td>paid Parking</td> 
                                                <td>Phone</td>
                                                <td>Email</td>                                            
                                            </tr>
                                            <tr>
                                                <td colspan="24">
                                                    <?php echo __('etc'); ?>
                                                </td>
                                            </tr>
                                            </tbody>
                                        <?php } ?>

                                    </table>
                                </div>
                            </div>
                            <br /><br />
                            <?php
                            if (!empty($tpl['volarr'])) {
                                ?>
                                <fieldset class="form-actions">
                                    <input type="hidden" name="save" value="1" /> 
                                    <button id="save-submit-id" class="btn btn-default" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9" type="submit"><?php echo __('save'); ?></button>
                                </fieldset>
                                <?php
                            } else {
                                ?>
                                <fieldset class="scheduler-border bg-light-orange">
                                    <legend class="scheduler-border"><?php echo __('import'); ?></legend>
                                    <br />
                                    <div class="form-group">
                                        <label class="control-label" for="csv_file">
                                            <?php echo __('label_csv_file'); ?>:
                                        </label>
                                        <input class="form-control" type="file" name="csv_file">
                                    </div>
                                </fieldset>
                                <fieldset class="form-actions">
                                    <input type="hidden" name="import" value="1" /> 
                                    <button id="import-submit-id" class="btn btn-default" autocomplete="off" value="<?php echo __('import'); ?>" name="submit" tabindex="9" type="submit"><?php echo __('import'); ?></button>
                                </fieldset>
                            <?php }
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
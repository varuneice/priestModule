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
        <li><a href="<?php echo INSTALL_URL; ?>Foodcoupon/index"><?php echo __('Food Coupon'); ?></a></li>
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
                    <form id="import-frm-id" class="frm-class import-frm-class" action="<?php echo INSTALL_URL; ?>Foodcoupon/import" method="post" name="import-frm" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                        <div class="callout callout-info" >
                            <h4><?php echo __('import_data') . ' ' . __('Food Coupons'); ?></h4>
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
                                                <th><?php echo __('OID'); ?></th>
                                                <th><?php echo __('Category'); ?></th>
                                                <th><?php echo __('F_Name'); ?></th>
                                                <th><?php echo __('L_Name'); ?></th>
                                                <th><?php echo __('Sp_FName'); ?></th>
                                                <th><?php echo __('City'); ?></th>
                                                <th><?php echo __('State'); ?></th>
                                                <th><?php echo __('Country'); ?></th>
                                                <th><?php echo __('Zip'); ?></th>
                                                <th><?php echo __('Email'); ?></th>
                                                <th><?php echo __('Phone'); ?></th>
                                                <th><?php echo __('Parent2'); ?></th>
                                                <th><?php echo __('Parent1'); ?></th>
                                                <th><?php echo __('Child3'); ?></th>
                                                <th><?php echo __('Child2'); ?></th>
                                                <th><?php echo __('Child1'); ?></th>
                                                <th><?php echo __('Total'); ?></th>
                                                <th><?php echo __('Child'); ?></th>
                                                <th><?php echo __('Adult'); ?></th>   
                                                <th><?php echo __('YTD'); ?></th>
                                                <th><?php echo __('Magazines'); ?></th>   
                                                <th><?php echo __('Sponsorship_Amount'); ?></th>
												<th><?php echo __('Sponsor'); ?></th>
												<th><?php echo __('Student'); ?></th>
												<th><?php echo __('SeqNo'); ?></th>
												<th><?php echo __('StudentVerified'); ?></th>
												<th><?php echo __('PendingIssues'); ?></th>
												<th><?php echo __('Signature'); ?></th>
												<th><?php echo __('Date'); ?></th>
												<th><?php echo __('Status'); ?></th>
												<th><?php echo __('Name_Authorized'); ?></th>
										 <th><?php echo __('Total Food Coupons Issued'); ?></th>
										 <th><?php echo __('Veggies'); ?></th>
										  <th><?php echo __('Amount'); ?></th>
										
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($_POST['import'])) {
                                                if (!empty($tpl['foodarr'])) {
                                                    foreach (($tpl['foodarr'] ?? []) as $key => $value) {
                                                        ?>
                                                        <tr>
                                                            <td><input class="mini" type="hidden" name="id[]" value="<?php echo $value[0]; ?>"></td>
                                                            <td><input class="mini" type="text" name="MID[]" value="<?php echo $value[1]; ?>"></td>
                                                            <td><input class="mini" type="text" name="OID[]" value="<?php echo $value[2]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Category[]" value="<?php echo $value[3]; ?>"></td>
                                                            <td><input class="mini" type="text" name="F_Name[]" value="<?php echo $value[4]; ?>"></td>
                                                            <td><input class="mini" type="text" name="L_Name[]" value="<?php echo $value[5]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Sp_FName[]" value="<?php echo $value[6]; ?>"></td>
                                                            <td><input class="mini" type="text" name="City[]" value="<?php echo $value[7]; ?>"></td>
                                                            <td><input class="mini" type="text" name="State[]" value="<?php echo $value[8]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Country[]" value="<?php echo $value[9]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Zip[]" value="<?php echo $value[10]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Email[]" value="<?php echo $value[11]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Phone[]" value="<?php echo $value[12]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Parent2[]" value="<?php echo $value[13]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Parent1[]" value="<?php echo $value[14]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Child3[]" value="<?php echo $value[15]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Child2[]" value="<?php echo $value[16]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Child1[]" value="<?php echo $value[17]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Total[]" value="<?php echo $value[18]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Child[]" value="<?php echo $value[19]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Adult[]" value="<?php echo $value[20]; ?>"></td>
                                                            <td><input class="mini" type="text" name="YTD[]" value="<?php echo $value[21]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Magazines[]" value="<?php echo $value[22]; ?>"></td>
                                                            <td><input class="mini" type="text" name="Sponsorship_Amount[]" value="<?php echo $value[23]; ?>"></td>
															<td><input class="mini" type="text" name="Sponsor[]" value="<?php echo $value[24]; ?>"></td>
															<td><input class="mini" type="text" name="Student[]" value="<?php echo $value[25]; ?>"></td>
															<td><input class="mini" type="text" name="SeqNo[]" value="<?php echo $value[26]; ?>"></td>
															<td><input class="mini" type="text" name="StudentVerified[]" value="<?php echo $value[27]; ?>"></td>
															<td><input class="mini" type="text" name="PendingIssues[]" value="<?php echo $value[28]; ?>"></td>
															<td><input class="mini" type="text" name="Signature[]" value="<?php echo $value[29]; ?>"></td>
															<td><input class="mini" type="text" name="Date[]" value="<?php echo $value[30]; ?>"></td>
															<td><input class="mini" type="text" name="Status[]" value="<?php echo $value[31]; ?>"></td>
															<td><input class="mini" type="text" name="Name_Authorized[]" value="<?php echo $value[32]; ?>"></td>
										                    <td><input class="mini" type="text" name="total_badges[]" value="<?php echo $value[33]; ?>"></td>
										                    <td><input class="mini" type="text" name="Veggies[]" value="<?php echo $value[34]; ?>"></td>
										    <td><input class="mini" type="text" name="Amount[]" value="<?php echo $value[35]; ?>"></td>                 
										                    
                                                            <?php 
                                                            for($i=36; $i<count($value); $i++){
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
                                                        <td colspan="36"><?php echo $tpl['row_count'] ?></td>
                                                    </tr>
                                                </tfoot>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                
                                                <td></td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>gm</td>
                                                <td>Test</td>
                                                <td>Test</td>
                                                <td>Test</td>
                                                <td>NOIDA</td>
                                                <td>UP</td>
                                                <td>INDIA</td>
                                                <td>201301</td>
                                                <td>Test@GMAIL.COM</td>
                                                <td>8693586423</td>
                                                <td>YES</td>
                                                <td>YES </td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>YES</td>
                                                <td>3000</td>
                                                <td>YES</td>
												 <td>3000</td>
                                                <td>GOLD</td>
                                                <td>YES</td>
                                                <td>001</td>
                                                <td>YES</td>
                                                <td>NO</td>
                                                <td>Signature</td>
                                                <td>2022-09-09</td>
                                                <td>Badges Assignrd</td>
                                                <td>Test</td>
                                               <td>10</td>
                                               <td>10</td>
                                               <td>10</td>
                                              
                                            </tr>
                                            <tr>
                                               
                                                <td></td>
                                                <td>2</td>
                                                <td>2</td>
                                                <td>gm</td>
                                                <td>Test</td>
                                                <td>Test</td>
                                                <td>Test</td>
                                                <td>NOIDA</td>
                                                <td>UP</td>
                                                <td>INDIA</td>
                                                <td>201301</td>
                                                <td>Test@GMAIL.COM</td>
                                                <td>8693586423</td>
                                                <td>YES</td>
                                                <td>YES </td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>YES</td>
                                                <td>3000</td>
                                                <td>YES</td>
												 <td>3000</td>
                                                <td>GOLD</td>
                                                <td>YES</td>
                                                <td>001</td>
                                                <td>YES</td>
                                                <td>NO</td>
                                                <td>Signature</td>
                                                <td>2022-09-09</td>
                                                <td>Badges Assignrd</td>
                                                <td>Test</td>
                                                <td>10</td> 
                                                <td>10</td>
                                                <td>10</td>
                                                
                                            </tr>
                                            <tr>
                                                <td colspan="36">
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
                            if (!empty($tpl['foodarr'])) {
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
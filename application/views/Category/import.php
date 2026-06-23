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
        <li><a href="<?php echo INSTALL_URL; ?>Catrgory/index"><?php echo __('Category'); ?></a></li>
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
                    <form id="import-frm-id" class="frm-class import-frm-class" action="<?php echo INSTALL_URL; ?>Category/import" method="post" name="import-frm" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                        <div class="callout callout-info" >
                            <h4><?php echo __('import_data') . ' ' . __('Category'); ?></h4>
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
                                                <th><?php echo __('id'); ?></th>
                                                <th><?php echo __('Category'); ?></th>
                                               
                                                 </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($_POST['import'])) {
                                                if (!empty($tpl['categoryarr'])) {
                                                    foreach (($tpl['categoryarr'] ?? []) as $key => $value) {
                                                        ?>
                                                        <tr>
                                                            <td><input class="mini" type="hidden" name="id[]" value="<?php echo $value[0]; ?>"></td>
                                                            <td><input class="mini" type="text" name="category[]" value="<?php echo $value[1]; ?>"></td>
                                                            
                                                    </tr>
                                                            <?php 
                                                            for($i=3; $i<count($value); $i++){
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
                                                        <td colspan="3"><?php echo $tpl['row_count'] ?></td>
                                                    </tr>
                                                </tfoot>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                            <td></td>
                                                 <td>Test</td>
                                                 </tr>
                                            <tr>
                                                 <td></td>
                                                 <td>Test</td>
                                                 </tr>  
                                            <tr>
                                                <td colspan="3">
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
                            if (!empty($tpl['categoryarr'])) {
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
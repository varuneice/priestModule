<style>
    th {
        border: 1px solid black;
        text-align: left;
        background-color: #f6f6f6;
        border-collapse: collapse;
    }
</style>

<section class="content-header">
    <h1>
        <?php echo __('Vendor Price'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i>
                <?php echo __('home'); ?>
            </a></li>
        <li><a href="<?php echo INSTALL_URL; ?>vendordata/index"><?php echo __('Vendor Price'); ?></a></li>
        <li class="active">
            <?php echo __('Vendor Price'); ?>
        </li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';

?>
<section class="content left width_100">
    <form id="createvendorprice" class="frm-class user-frm-class"
        action="<?php echo INSTALL_URL; ?>vendordata/vendorpricecreate" method="post" name="vendorprice"
        enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <!-- <h1 style="margin:0; font-size:24px; color:#2679b5;"> Add Amount</h1><br> -->
                <table class="table">
                    <tr class="tr">
                        <th class="th">Payment For</th>
                        <th class="th">Type</th>
                        <th class="th">Price</th>
                    </tr>
                    <tr class="tr">
                        <td class="td">
                            <!--<select data-rule-required='true' required name="paymentfor" id="paymentfor"-->
                            <!--    class="form-control input-sm">-->
                            <!--    <option value="">Select Payment For:</option>-->
                            <!--    <option value="BOOTH">Booth Rentals</option>-->
                            <!--    <option value="MAGADV">Magazine Advertisements</option>-->
                            <!--    <option value="OTHADV">Other Advertisements</option>-->
                            <!--</select>-->
                            <select data-rule-required='true' required="" name="paymentfor" id="paymentfor"
                                class="form-control input-sm">
                                <option value="">Select Payment For:</option>
                               <?php
                                foreach (($tpl['dataarr'] ?? []) as $key => $value) {
                                    ?>
                                    <option value="<?php echo $value['payforalice']; ?>"><?php echo $value['payfor']; ?></option> 
                                    <?php
                                }
                                ?>
                                    </select> 
                        </td>
                        <td class="td"><input required="true" id="paytype" class="form-control input-sm" type="text"
                                name="type" size="25" value="" title="<?php echo __('Type'); ?>" placeholder="Type">
                        </td>
                        <td class="td"><input required="true" id="Price" class="form-control input-sm" type="number"
                                name="price" size="25" value="" title="<?php echo __('Price'); ?>" placeholder="Price"
                                onchange="pricecheck(this.id)"></td>
                    </tr>
                </table>


                <fieldset>
                    <input type="hidden" name="vendorpricecreate" value="1" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>"
                        name="submit" tabindex="" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;
                        <?php echo __('save') ?>
                    </button>
                </fieldset>


            </fieldset>
        </div>
    </form>

</section>
<script>

    $(function () {
        $('input[type="text"]').change(function () {
            this.value = $.trim(this.value);
        });
    });

    function pricecheck() {
        debugger;
        const price = $("#Price").val();
        if (price > 0) {
            $("#Price").prop('required', true);
            $("#submit").removeClass('disabled');
        }
        else {
            alert("Amount will be greater than 0");
            $("#submit").addClass('disabled');
            
        }
    }
</script>
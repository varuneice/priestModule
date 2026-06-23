<section class="content-header">
    <h1>
        <?php echo __('Vendor Price'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i>
                <?php echo __('home'); ?>
            </a></li>
        <li><a href="<?php echo INSTALL_URL; ?>vendordata/vendorpriceedit"><?php echo __('Vendor Price'); ?></a></li>
        <li class="active">
            <?php echo __('Vendor Price'); ?>
        </li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$paytype = $tpl['vendorpicearr']['paymentfor'] ?? '';

?>
<section class="content left width_100">
    <form id="vendorpriceedit" class="frm-class user-frm-class"
        action="<?php echo INSTALL_URL; ?>vendordata/vendorpriceedit" method="post" name="vendorpriceedit"
        enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <table class="table">
                    <tr class="tr">
                        <th>Payment For</th>
                        <th>Type</th>
                        <th>price</th>
                    </tr>
                    <tr class="tr">
                        <td class="td">
                            <!--<select data-rule-required='true' name="paymentfor" id="paymentfor"-->
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
                                      <option <?php echo ($tpl['vendorpicearr']['paymentfor'] == $value['payforalice']) ? "selected='selected'" : ""; ?> value="<?php echo $value['payforalice']; ?>"><?php echo $value['payfor']; ?></option> 
                                    <?php
                                }
                                ?>
                                    </select> 
                        </td>
                        <td class="td"><input required="true" id="paytype" class="form-control input-sm" type="text"
                                name="type" size="25" value="<?php echo $tpl['vendorpicearr']['type'] ?? ''; ?>"
                                title="<?php echo __('Type'); ?>" placeholder="Type">
                        </td>
                        <td class="td"><input required="true" id="Price" class="form-control input-sm" type="number"
                                name="price" size="25" value="<?php echo $tpl['vendorpicearr']['price'] ?? ''; ?>"
                                title="<?php echo __('Price'); ?>" placeholder="Price" onchange="pricecheck(this.id)">
                        </td>

                    </tr>

                </table>
                <fieldset>
                    <input type="hidden" name="priceedit" value="1" />
                    <input type="hidden" name="id" value="<?php echo $tpl['vendorpicearr']['id'] ?? ''; ?>" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>"
                        name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;
                        <?php echo __('save') ?>
                    </button>
                </fieldset>
            </fieldset>
        </div>

    </form>

    <div id="dialogDeleteImage" title="<?php echo htmlspecialchars(__('gallery_del_title')); ?>" style="display:none">
        <p>
            <?php echo __('gallery_del_body'); ?>
        </p>
    </div>
</section>

<script>
    $(document).ready(function () {
        //debugger;
        payfor();

    });


    var productname = <?php echo (json_encode($paytype)); ?>;
    function payfor() {
        if (productname != null || productname == "" || productname == " ") {
            $("#paymentfor").val(productname);
        }
    }

    $(function () {
        $('input[type="text"]').change(function () {
            this.value = $.trim(this.value);
        });
    });

    function pricecheck() {
        
        const vendorprice = $("#Price").val();
        if (vendorprice > 0) {
            $("#Price").prop('required', true);
            $("#submit").removeClass('disabled');

        }
        else {
            alert("Amount will be greater than 0");
            $("#submit").addClass('disabled');
        }
    }


</script>
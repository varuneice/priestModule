<section class="content-header">
    <h1>
        <?php echo __('pay'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Member/index"><?php echo __('title_members'); ?></a></li>
        <li class="active"><?php echo __('pay'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$idmember = $tpl['arr']['ID'] ?? '';
?>
<section class="content left width_100">
    <div class="padding-19 nav-tabs-custom left width_100">
        <?php
        if (!empty($_SESSION['status'])) {
            ?>
            <div class="alert alert-danger in">
                <strong><?php echo $_SESSION['status']; ?></strong>
            </div>
            <?php
        } else {

            if (($_POST['Payment_method'] ?? '') == 'stripe') {
                ?>
                <!--  <div class="payment_information"> -->
                <table border="4" width='585px' style= "margin-left: 32em;" >
                                 <tr>
                                <td colspan='2'> <img src='../create.png' alt='' height='102px' ></td> </tr>
                                <tr>
                                <td>Member ID</td> <td><?php echo $tpl['arr']['Member_id'] ?? ''; ?></td> </tr>
                                 <tr><td>Member Name</td> <td><?php echo ($tpl['arr']['F_Name'] ?? '').' ' .($tpl['arr']['M_Name'] ?? '').' ' .($tpl['arr']['L_Name'] ?? ''); ?></td> </tr>
                                <tr><td>Member Email Address</td> <td><?php echo $tpl['arr']['email'] ?? ''; ?></td> </tr>
                                <tr><td>Member Phone Number</td> <td><?php echo $tpl['arr']['Tele1'] ?? ''; ?></td>  </tr>
                                <tr><td>Membership Type</td> <td><?php echo $tpl['arr']['membership_type'] ?? ''; ?></td>  </tr>
                                <tr><td>Amount</td> <td><?php echo $tpl['arr']['total'] ?? ''; ?></td>  </tr>
                                <tr><td>Transaction ID</td> <td><?php echo $tpl['arr']['transaction_id'] ?? ''; ?></td>  </tr>
                                </tr> 
                        </table>
                         <?php echo "<a href='" . INSTALL_URL . "Member/edit/$idmember'>Go to home</a>";?> 
                  <!-- </div> -->
                <?php
            } else {
                ?>
                <div class="alert alert-success  in">
                    <i class="fa-fw fa fa-check"></i>
                    <strong><?php echo __('success'); ?></strong>
                </div>
                <?php
            }
        }
        ?>
    </div>
</section>
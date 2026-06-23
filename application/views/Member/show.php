<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<section class="content left width_100">
    <div class="padding-19 nav-tabs-custom left width_100">
        <?php
        if (!empty($tpl['arr'])) {
            $membershiptype = $tpl['arr']['membership_type'] ?? '';
            if($membershiptype == 'IND'){
             $membertype = 'Individual Membership';
            }
            else{
                $membertype =  'Family Membership';
            }
            ?>
            <div class="payment_information">
            <table border="4" width='585px' style= "margin: 0 auto;" >
                                 <tr>
                                 <td colspan='2'> <img src='<?= INSTALL_URL ?>thankyouscreen.jpg' alt='' height='167px' style="margin-left:1em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                </tr>
                                <tr>
                                <td colspan='2'><b>Your membership request have been submitted.
                                    Membership details will be shared with you after approval.
                                    For more details please contact to<a href='mailto:treasurer@durgabari.org'> treasurer@durgabari.org</a></b></td></tr>
                                  <tr>
                               <!-- <td>Member ID</td> <td><?php echo $tpl['arr']['Member_id'] ?? ''; ?></td> </tr>-->
                                    <tr><td>Order Id</td> <td><?php echo htmlspecialchars($_SESSION['myValue'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td> </tr>
                                    <tr><td>Member Name</td> <td><?php echo $tpl['arr']['F_Name'].' ' .$tpl['arr']['M_Name'].' ' .$tpl['arr']['L_Name'];?></td> </tr>
                                <tr><td>Member Email Address</td> <td><?php echo $tpl['arr']['email'] ?? ''; ?></td> </tr>
                                <tr><td>Member Phone Number</td> <td><?php echo $tpl['arr']['Tele1'] ?? ''; ?></td>  </tr>
                                <tr><td>Membership Type</td> <td><?php echo $membertype; ?></td>  </tr>
                                 <tr><td>Payment Method</td> <td><?php echo "Credit Card"; ?></td>  </tr>
                                </tr> 
                        </table>
                        <a href="<?= INSTALL_URL ?>Member/create" style="display: flex;">Go to home</a> 
                <!-- <p><strong>Member Name:</strong> <?php echo $tpl['arr']['F_Name'] . ' ' . $tpl['arr']['Sp_FName']; ?></p>
                <p><strong>Phone No:</strong> <?php echo $tpl['arr']['Mob_No'] ?? ''; ?></p>
                <p><strong>Email:</strong> <?php echo $tpl['arr']['email'] ?? ''; ?></p>
                <p> -->
                    <!-- <strong>Category:</strong> 
                    <?php
                    switch ($tpl['arr']['rate']) {
                        case 'gmi_1':
                            echo 'General Member-Individual(Due jan1/Apr 1 every year)';
                            break;
                        case 'gmi_4':
                            echo 'General Member-Individual(Due jan1/Apr 1 every year)';
                            break;
                        case 'gmf_1':
                            echo 'General Member-Family(Due jan1/Apr 1 every year)';
                            break;
                        case 'gmf_4':
                            echo 'General Member-Family(Due jan1/Apr 1 every year)';
                            break;
                        case 'lm':
                            echo 'Life Member(LM)';
                            break;
                        case 'bf':
                            echo 'Benefactor(BF)';
                            break;
                        case 'pm':
                            echo 'Patron Member(pm)';
                            break;
                        case 'lm_h':
                            echo 'Maintenance (LM and higher)-per calendar Year';
                            break;
                    }
                    ?> -->
                <!-- </p> -->
            </div>
            <?php
        }
        ?>
    </div>
</section>

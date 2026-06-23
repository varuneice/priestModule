<style>
    .logo .profile {
        margin-left: 50%;
        border-radius: 25%;
        transform: translate(-50%);
        filter: brightness(123%);

    } 
    .logo .logo-caption {
        font-family: 'Poiret One', cursive;
        color:00000;
        text-align: center;
        margin-bottom: 25px;
    }
    .logo-caption  .h1 {
        font-size:2.5rem;
    }
    h3{
        font-size: 30px;
        color: 00000;
        margin-left:1%;
        font-family: initial;
    }
    .logo .tweak {
        color: #ff5252;
        font-weight: bold;
    }
    .abd{
        font-weight: bold;
        font-family: 'Poiret One', cursive;
        font-size:20px;
        color:00000;
    }
    .btn-custom {
        background: #ff5252;
        border-color: rgba(48, 46, 45, 1);
        color: #ffffff;
        font-weight: bold;
        font-size:20px;
    }
    .btn-custom:hover{
        -webkit-transition: all 500ms ease;
        -moz-transition: all 500ms ease;
        -ms-transition: all 500ms ease;
        -o-transition: all 500ms ease;
        transition: all 500ms ease;
        background: rgba(48, 46, 45, 1);
        border-color: #ff5252;
    }
    .footer {
        padding-top: 10px;
        margin-left: 15%;
        width: 85%;
        background: #111111;
        position: relative;
        bottom: 0;
        z-index: 1;
    }
    .text-center{
        width:80%;
        float:right;

    }
    .nev-right{
        width:20%;
        float:left;
    }

    .info{
        font-size: 28px;
        margin-left: 50px;
        font-weight: 900;
    }

    @media (min-width:320px)  {    width:500% !important;}
</style>
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
<div id="menu-container" style="width: 40%; margin: 90px auto; background-color:rgba(211,211,211) !important; ">
    <div id="page-body">
        <main role="main">
            <?php
            require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
            ?>
            <div class="logo">
                <img src="../logo.jpg" class="profile"/>
                <h3><b>Houston Durgabari Society</b></h3>
                <h1 class="logo-caption"><span class="tweak">L</span>ogin</h1>
            </div> 
            <form id="login" class="form-horizontal" method="post" action="" role="form">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                <input type="hidden" name="login_user" value="1" />
                <fieldset>
                    <div class="form-group">
                        <label for="email" class="abd">Email:</label>
                        <input id="email" class="form-control input-sm" type="text" placeholder="Email" value="" name="email" tabindex="1"-->
                    </div>
                    <div class="form-group">
                        <label for="password" class="abd">Password:</label>
                        <input id="password" class="form-control input-sm" type="password" placeholder="Password" name="password" tabindex="2">
                    </div>
                    <div class="form-group">
                        <button id="load" class="btn  btn-block btn-custom" data-loading-text="Logging-in... <i class='fa-spin fa fa-spinner fa-lg'></i>" value="Login" tabindex="6" name="login" type="submit"><i class="fa fa-fw fa-key"></i>&nbsp;Login</button>
                    </div>
                </fieldset>
                <div class="card-footer">
                    <div class="text-center">
                        <a class="text-light"  onclick="displayForgotPasswordForm();" style="cursor: pointer; color:00000; font-size: 25px; margin-right: 112px; " href="<?php echo INSTALL_URL ?>Admin/forgot">Forgot password?</a>
                    </div>
                </div> 
            </form>
        </main>
    </div>
    <!-- </div> -->
</div>
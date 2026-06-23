<style>
    .logo .profile {
        margin-left: 50%;
        border-radius: 25%;
        transform: translate(-50%);
        filter: brightness(123%);
        padding: 10px;

    } 
    .logo .logo-caption {
        font-family: 'Poiret One', cursive;
        color:00000;
        text-align: center;

    }
    .logo-caption .h1 {
        font-size:2.5rem;;
    }
    h3{

        font-size:30px;
        color: 00000;
        margin-left:1px;
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
        color: 00000;
    }
    .btn-custom {
        background: #ff5252;
        border-color: rgba(48, 46, 45, 1);
        color: #ffffff;
        font-weight: bold;
        font-size:20px;
        width: -webkit-fill-available;
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
    .form-group label {
        display: inline-block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-control {
        background-color: #f9fcfa;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 1px 1px rgb(0 0 0 / 8%) inset;
        color: #555;
        display: block;
        font-size: 14px;
        height: 34px;
        line-height: 1.42857;
        padding: 6px 12px;
        transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
        width: 100%;
    }
    .form-horizontal .form-group {
        margin: 10px;
    }
    .asb {
        border-width: 0;
        border: 0 none;
        margin: 0;
        padding: 0;
    }
    .text-center{
        text-align:center;
    }

</style>
<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon"/>
<div id="menu-container" style="width: 40%; margin: 90px auto;  background-color:rgba(211,211,211) !important;">
    <div id="page-body">
        <main role="main">
            <?php
            require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
            ?>
            <div class="logo">
                <img src="../logo.jpg" class="profile"/>
                <h3><b>Houston Durgabari Society</b></h3>
                <h1 class="logo-caption"><span class="tweak">F</span>orgot <span class="tweak">P</span>assword</h1>
            </div> 
            <form id="login" class="form-horizontal" method="post" action="" role="form">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                <input type="hidden" name="forgo_password" value="1" />
                <fieldset class="asb">
                    <div class="form-group">
                        <label for="email" class="abd">Email:</label>
                        <input id="email" class="form-control input-sm" type="text" placeholder="Email" value="" name="email" tabindex="1">
                    </div>
                    <div class="form-group">
                        <button id="load" type="submit" name="submit" class="btn  btn-block btn-custom"></i>&nbsp;Submit</button>
                    </div>
                </fieldset>
                <div class="card-footer">
                    <div class="text-center">
                    </div>
                </div> 
            </form>
        </main>
    </div>
    <!-- </div> -->
</div>
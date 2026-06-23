
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
    margin-left:24%;
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
  <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
<div id="menu-container" style="width: 40%; margin: 90px auto;  background-color:rgba(211,211,211) !important;">
    <!--div class="grid">
        <header class="header bordered" role="banner">
           <img src="./full_logo.png" > <h1><b>Houston Durgabari Society</b></h1>
        </header>
        <div class="breadcrumb">
            <div class="sub-breadcrumb">
                <span class="time">It is currently <?php echo date('l jS \of F Y h:i:s'); ?></span>
            </div>
        </div-->
        <div id="page-body">
            <main role="main">
                
                <!--h1 class="bordered title"><span class="green">L</span>OG IN</h1-->
                <div class="logo">
                    <img src="../logo.jpg" class="profile"/>
                    <h3><b>Houston Durgabari Society</b></h3>
        			<h1 class="logo-caption"><span class="tweak">F</span>orget <span class="tweak">P</span>assword</h1>
        		</div> 
                <!-- logo class -->
                <form id="login" class="form-horizontal" method="post" action="" role="form">
                    <input type="hidden" name="login_user" value="1" />
                    <fieldset class="asb">
                        
                        <div class="form-group">
                            
                            <label for="email" class="abd">Email:</label>
                   <input id="email" class="form-control input-sm" type="text" placeholder="Email" value="" name="email" tabindex="1"-->
                        </div>
                        <div class="form-group">
                            <button id="load" type="submit" name="submit"  class="btn  btn-block btn-custom"></i>&nbsp;Submit</button>
                        </div>
                    </fieldset>
                    <div class="card-footer">
                      <div class="text-center">
                       <!-- <a class="text-light" onclick="displayForgotPasswordForm();" style="cursor: pointer; color:00000; font-size: 20px;">Login here</a> -->
                       </div>
                     </div> 
                </form>
            </main>
        </div>
    <!-- </div> -->
</div>


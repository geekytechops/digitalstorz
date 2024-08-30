<?php
	include("./Admin/dbconnect.php");
	extract($_REQUEST);
	$mess='';
		if(isset($_REQUEST['q'])){
			$m=$_REQUEST['q'];	
			if($m==1){
				$mess="No User Found with Given Details..";
			}else if($m==2){
				$mess="Seems Password Entered was Wrong";
			}else if($m==3){
				$mess="User Not Active";
			}
		}
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="./js/script.js"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
	
	<script type="text/javascript">
            // Form validation code for SIGN UP
            function validate()
            {

				if (document.retail_login.username_retail.value == "")
                {
                    document.retail_login.username_retail.focus();
					alert("Please Enter Username.");
                    return false;
                }
				if (document.retail_login.password_retail.value == "")
                {
                    document.retail_login.password_retail.focus();
					alert("Please Enter Password.");
                    return false;
                }
			}
	</script> 
</head>
<body>
	<div class="header">
		<a href="../index.html">&nbsp;&nbsp;&nbsp;&nbsp;Kolors Mobile Services</a>
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">
		<div class="left_container">
			<div class="menu_heading">&#8803;&nbsp;&nbsp;MENU</div>
			<div id='cssmenu'>
				<ul>
				   <li class='active'><a href='http://www.kolorsmobileservices.com'><span><img src="../images/home.png">&nbsp;&nbsp;Home</span></a></li>
				   <li><a href='http://www.kolorsmobileservices.com/about.html'><span><img src="../images/shopping-cart.png">&nbsp;&nbsp;About</span></a></li>
				   <li><a href='http://www.kolorsmobileservices.com/training-institute.html'><span><img src="../images/history.png">&nbsp;&nbsp;Training Institute</span></a></li>
				   <li><a href='http://www.kolorsmobileservices.com/contact.html'><span><img src="../images/list-icon.png">&nbsp;&nbsp;&nbsp;Contact</span></a></li>
				   <li><a href='http://www.kolorsmobileservices.com/Unlocks/retail-login.php'><span><img src="../images/account.png">&nbsp;&nbsp;Retail Login</span></a></li>
				</ul>
			</div>
		</div>
		<div class="right_container">
			<div class="page_title_div"><h1>Digitalstorz Retail Login</h1></div>
			<div class="content_holder_small">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Login&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $mess; ?></div>
				
				<div class="content_holder_body">
				<form name="retail_login" method="post" action="./login_check.php" onsubmit="return validate()">
					<div class="txt_lable">USERNAME :</div>
					<div><input type="text" id="username_retail" name="username_retail" value="<?php echo $_COOKIE['remember_me_usr']; ?>"/></div>
				
					<div class="txt_lable">PASSWORD :</div>
					<div><input class="text_box" type="password" name="password_retail" value="<?php echo $_COOKIE['remember_me_pwd']; ?>"/></div>
					
					<div class="submit_button_div"><input type="submit" name="submit" value="&nbsp;&nbsp;Submit&nbsp;&nbsp;"> <input type="checkbox" name="remember" 
					<?php 
						if(isset($_COOKIE['remember_me_usr'])) {
							echo 'checked="checked"';
						}else {
							echo ''; 
						} 
					?> >Remember Me</div>
					<div class="forgot_pass_div"><a href="./forgot-password.php">Forgot Password</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="./retail-registration.php">Register</a></div>
				</form>
				</div>
			</div>
		</div>
	</div>
	<div class="footer">
		Copyright © 2015, <a href="#">KolorsMobileServices.com</a>
	</div>
	
</body>
</html>
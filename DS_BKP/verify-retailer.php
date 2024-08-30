<?php
	include("./Admin/dbconnect.php");
	extract($_REQUEST);
	$mess='';
	if(isset($_REQUEST['user']) && $_REQUEST['KolorsVrfPassCode']){
		
		$user_name=$_REQUEST['user'];
		$passcode=$_REQUEST['KolorsVrfPassCode'];
		
		$sql_pass="SELECT `passkey` FROM `cust_kolors_retail_users` WHERE `username`='".$user_name."'";
		$query_pass=mysql_query($sql_pass);
		$result_pass=mysql_fetch_array($query_pass);
		
		$original_passcode=$result_pass['passkey'];
		if($original_passcode==$passcode){
			$sql_verify="UPDATE `cust_kolors_retail_users` SET `email_verified`='Verified', `passkey`=''  WHERE `username`='".$user_name."'";
			$query_verify=mysql_query($sql_verify);
			
			if($query_verify){
				$mess="<font color=green>Congratulations... Your Account Verified Succesfully..</font>";
			}else{
				$mess="<font color=green>Link Expired / Invalid. Contact Admin</font>";
			}  
		}
	}
?>
<html>
<head>
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="../js/script.js"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
</head>
<body>
	<div class="header">
		&nbsp;&nbsp;&nbsp;&nbsp;Kolors Mobile Services
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
			<div class="page_title_div"><h1>Retail User Verification</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Email Verification</div>
				
				<div class="content_holder_body">
				<br><br><br><h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $mess;?></h2>
				</div>
			</div>
		</div>
	</div>
	<div class="footer">
		Copyright © 2015, <a href="#">KolorsMobileServices.com</a>
	</div>
	
</body>
</html>
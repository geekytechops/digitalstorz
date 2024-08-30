<?php
session_start();
if(isset($_SESSION['session_retail_username']) && isset($_SESSION['session_retail_password'])){
$page_no=4;
include("./Admin/dbconnect.php");
 $mess='';
if(isset($_REQUEST['submit'])){
	$cur_password=$_REQUEST['cur_password'];
	$new_password1=$_REQUEST['new_password1'];
	$new_password2=$_REQUEST['new_password2'];
	
	if($new_password1==$new_password2){
		$sql_pwd="SELECT `password` FROM `cust_kolors_retail_users` WHERE `username`='".$_SESSION['session_retail_username_login']."'";
		$query_pwd=mysql_query($sql_pwd);
		$result_pwd=mysql_fetch_array($query_pwd);
		$original_pwd=$result_pwd['password'];
		
		//echo $original_pwd;
		if($original_pwd==$cur_password){
			$sql1="UPDATE `cust_kolors_retail_users` SET
									`password`='".$new_password1."' WHERE `username`='".$_SESSION['session_retail_username_login']."'";
				$query1=mysql_query($sql1);
				if($query1){
					$mess="Password Updated Succesfully..";
				}else{
					$mess="Failed To Update..";
				}
		}else{
			$mess="Current Password is wrong..";	
		}
	}else{
		$mess="Passwords Do Not Match..";
	}
	
	//echo $mess;exit;
	
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
	
	<script type="text/javascript">
            // Form validation code for SIGN UP
            function validate()
            {

				if (document.ret_ac_det.cur_password.value == "")
                {
                    document.ret_ac_det.cur_password.focus();
					alert("Enter Current Password.");
                    return false;
                }
				if (document.ret_ac_det.new_password1.value == "")
                {
                    document.ret_ac_det.new_password1.focus();
					alert("Please Enter New Password.");
                    return false;
                }
				if (document.ret_ac_det.new_password2.value == "")
                {
                    document.ret_ac_det.new_password2.focus();
					alert("Please Re Enter New Password.");
                    return false;
                }
				
				if(document.ret_ac_det.new_password1.value != document.ret_ac_det.new_password2.value){
					document.ret_ac_det.new_password2.focus();
					alert("Password Do Not Matched.");
                    return false;
				}
			}
	</script>
</head>
<body>
	<div class="header">
		<a href="./retailer-home.php">&nbsp;&nbsp;&nbsp;&nbsp;Kolors Mobile Services</a>
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container"> 
		<div class="left_container">
			<?php include("./retailer-menu.php");?>
		</div>
		<div class="right_container">
			<div class="page_title_div"><h1>Change Password</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Change Password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $mess;?></div>
				
				<div class="content_holder_body">
										 
											<form name="ret_ac_det" action="./profile-settings.php" method="post" onsubmit="return validate()">
											<table>
												<tr>
													<td width="120px" style="text-align:right">Current&nbsp;Password&nbsp;&nbsp;:&nbsp;&nbsp;</td>
													<td ><input style="width:250px;" class="text_box" type="password" name="cur_password" value="" /></td>
												
													</tr>
												<tr><td>&nbsp;</td></tr>
												<tr>
													<td width="120px" style="text-align:right">New&nbsp;Password&nbsp;&nbsp;:&nbsp;&nbsp;</td> 
													<td><input style="width:250px;" class="text_box" type="password" name="new_password1"  value="" /></td>
												
												</tr>
												<tr><td>&nbsp;</td></tr>
												<tr>
													<td width="120px" style="text-align:right">Re&nbsp;Enter&nbsp;&nbsp;:&nbsp;&nbsp;</td> 
													<td><input style="width:250px;" type="password" class="text_box" name="new_password2" value="" /></td>
												
												</tr>
												
												<tr><td>&nbsp;</td></tr>
												<tr><td>&nbsp;</td><td><input type="submit" name="submit" value="&nbsp;&nbsp;Change&nbsp;&nbsp;"></td></tr>
											</table>
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
<?php
mysql_close($connection);
}else{
header('Location: ./retail-login.php');
}
?>
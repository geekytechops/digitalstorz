<?php
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$session_store_name=$_SESSION['session_store_name'];
if(isset($_REQUEST['submit'])){ //When form Submits
		$user_name=$_SESSION['session_username'];
		$old_passwd=$_REQUEST['current_passwd'];

		$new_password=$_REQUEST['new_passwd'];
		$hashed_password_new = password_hash($new_password,PASSWORD_DEFAULT);
		
		//echo $hashed_password_new;
		$sql1="SELECT * FROM `cust_kolors_users_list` WHERE username='".$user_name."'";
        //echo $sql1; exit;
		$query1=mysql_query($sql1);
		$result1=mysql_fetch_array($query1);

			$og_password=$result1['password'];
			$verify = password_verify($old_passwd, $og_password);
			if($verify){ // when old password Supplied and old password in DB are same
			//echo "passwords matched"; exit;
               $sql_upd="update cust_kolors_users_list set
                                `password`='".$hashed_password_new."'
                                 WHERE username='".$user_name."'";
               $query_upd=mysql_query($sql_upd);
               if($query_upd){ 
                   $mess="Password Updated Successfully..";
               }else{
                   $mess="Password Update Failed..";
               }
				
			}else{
			    $mess="Old Password is Not Correct..";	
			}
} 

?>
<html>
<head>
            <link rel="icon" type="image/x-icon" href="./css/favicon1.jpeg">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>

<script type="text/javascript">
            // Form validation code for SIGN UP
            function validate()
            {
				if (document.change_pass.current_passwd.value == "")
                {
                    document.change_pass.current_passwd.focus();
                    alert("Enter Current Password..");
					return false;
                }
                if (document.change_pass.new_passwd.value == "")
                {
                    document.change_pass.new_passwd.focus();
                    alert("Enter New Password..");
					return false;
                }
                
                if (document.change_pass.new_passwd.value != ''){
                    if(document.change_pass.new_passwd.value.length < 8){
                        document.change_pass.new_passwd.focus();
                        alert("New Password Should Be minimum 8 Charecters..");
                        return false;
                    }
                }
                if (document.change_pass.new_passwd1.value == "")
                {
                    document.change_pass.new_passwd1.focus();
                    alert("Re-Enter New Password..");
					return false;
                }
                if (document.change_pass.new_passwd1.value != ''){
                    if(document.change_pass.new_passwd1.value.length < 8){
                        document.change_pass.new_passwd1.focus();
                        alert("Re Enter Password Should Be minimum 8 Charecters..");
                        return false;
                    }
                }
                if (document.change_pass.new_passwd.value != document.change_pass.new_passwd1.value){
                        document.change_pass.new_passwd1.focus();
                        alert("Passwords Do Not Match..");
                        return false;
                }
                
            }
</script>
<!-- Script for preventing reload submit entry-->
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</head>
<body>
	<div class="header">
		<span class="title_grad">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $session_store_name;?></span> <span style="font-size:14px; color:yellow;">Powered By DigitalStorz.com</span>
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">
		<?php include("kol-mob-entry-menu.php");?>
		<div class="right_container">
			<div class="page_title_div"><h1>Welcome <?php echo $_SESSION['session_staff_name'];?></h1></div>
			<div class="content_holder">


				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Self Password Change &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $mess;?></div>
				
				<div class="content_holder_body">
				    <form name="change_pass" method="post" action="./change-password.php" onsubmit="return validate()">
					<table style="margin-left:30px">
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Enter Current Password&nbsp;&nbsp;</td> <td><input type="password" name="current_passwd" value=""></td></tr>
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Enter New Password&nbsp;&nbsp;</td> <td><input type="password" name="new_passwd" value=""></td></tr>
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Re-Enter New Password&nbsp;&nbsp;</td> <td><input type="password" name="new_passwd1" value=""></td></tr>
					    <tr><td>&nbsp;</td></td></tr>
					    <tr><td>&nbsp;</td></td><td><input type="submit" name="submit" value="Change Password"></td></tr>
					</table>
					</form>
				</div>

			</div>
		</div>
	</div>
</body>
</html>
<?php
mysql_close($connection);
}else{
header('Location: ./index.php');
}
?>
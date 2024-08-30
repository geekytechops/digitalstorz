<?php
session_start();
//print_r($_SESSION);
if(isset($_SESSION['username_verify_otp']) && $_SESSION['otp_validate_status']=='validated' ){
    if (time() - $_SESSION['sess_start_time'] < 120) { 
include("./dbconnect.php");

if(isset($_REQUEST['submit'])){ //When form Submits
        $new_password=$_REQUEST['new_passwd'];
		$hashed_password_new = password_hash($new_password,PASSWORD_DEFAULT);
		
		$username_verify_otp=$_SESSION['username_verify_otp'];
		
		$sql_upd="update cust_kolors_users_list set
                                `password`='".$hashed_password_new."',
                                `last_update_date`=NOW()
                                 WHERE username='".$username_verify_otp."'";
                                 //echo $sql_upd;exit;
               $query_upd=mysql_query($sql_upd);
                session_destroy();
                $_SESSION['username_verify_otp'] = '';
                $_SESSION['otp_validate_status'] = '';
               if($query_upd){ 

                    header("Location:index.php?q=3");
               }else{

                     header("Location:index.php?q=4");
                     
                     
               }
		
		
}
?>

<html>
    <head>
        <link rel="icon" type="image/x-icon" href="./css/favicon1.jpeg">
        	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
        	<script type="text/javascript">
            // Form validation code for SIGN UP
            function validate()
            {

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
            
function ShowPassword1() {
  var x = document.getElementById("new_passwd");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

function ShowPassword2() {
  var y = document.getElementById("new_passwd1");
  if (y.type === "password") {
    y.type = "text";
  } else {
    y.type = "password";
  }
}
</script>
    </head>
    
    <body>
	<div class="header">
		<span>&nbsp;&nbsp;&nbsp;&nbsp;DigitalStorz.com</span>
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>        
     	<div class="right_container">
			<div class="page_title_div"><h1>OTP Validated</h1></div>
			<div class="content_holder">


				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Change Password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $mess;?></div>
				
				<div class="content_holder_body">
				    <form name="change_pass" method="post" action="./self-password-change.php" onsubmit="return validate()">
					<table style="margin-left:30px">
					 
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Enter New Password&nbsp;&nbsp;</td> <td><input type="password" name="new_passwd" id="new_passwd" value=""></td><td><input type="checkbox" onclick="ShowPassword1()">Show Password</td></tr>
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Re-Enter New Password&nbsp;&nbsp;</td> <td><input type="password" name="new_passwd1" id="new_passwd1" value=""></td><td><input type="checkbox" onclick="ShowPassword2()">Show Password</td></tr>
					    <tr><td>&nbsp;</td></td></tr>
					    <tr><td>&nbsp;</td></td><td><input type="submit" name="submit" value="Change Password"></td></tr>
					</table>
					</form>
				</div>

			</div>
		</div>   
    </body>
    
</html>


<?php
}else{
session_destroy();
header('Location: ./index.php?q=6');
}

}else{
session_destroy();
header('Location: ./index.php');
}
?>

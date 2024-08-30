<?php
session_start();
//print_r($_SESSION);

if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){

$session_store_name=$_SESSION['session_store_name'];
$session_store_id=$_SESSION['session_store_id'];

//print_r($_SESSION);

//echo (time() - $_SESSION['sess_start_time']);
//exit;
include("./dbconnect.php");
if (time() - $_SESSION['sess_start_time'] < 120) { 
if(isset($_REQUEST['submit'])){
    $otp_received=$_REQUEST['otp_received'];
    if($_SESSION['otp_sent_for_verification'] == $otp_received){
        $sql_update_mob="UPDATE `cust_kolors_users_list` SET mobile_no_verified='yes' WHERE username=".$_SESSION['session_username'];
        $query_update_mob=mysql_query($sql_update_mob);
        
        //exit;
        if($query_update_mob){
            	header('Location: ./admin-home.php?status=mobile_verified');
        }else{
            $mess="Error in verifying Mobile Number. Contact Admin Digital Storz.";
        }
    }else{
        $mess="INVALID OTP";
    }
    
}


?>
<html>
<head>
    <link rel="icon" type="image/x-icon" href="./css/favicon1.jpeg">
	<link href="https://digitalstorz.com/css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
<style>
#grad {
  text-transform: uppercase;
	background: linear-gradient(to right, #EDD106 0%, #06DFED 100%);
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;
}

</style>
    <script type="text/javascript">
	window.history.forward();
	function noBack() { window.history.forward(); }
    </script>

</head>
<body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
	<div class="header">
	    
		<span class="title_grad">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $session_store_name;?></span> <span style="font-size:14px; color:yellow;">Powered By DigitalStorz.com</span>
		
		<div style="float:right; font-family: 'Trebuchet MS', sans-serif; font-weight:bold;  font-size:17px; color:#ECFA12; padding-right:15px; padding-top:10px;" ><?php echo $_SESSION['session_staff_name'];?> (<?php echo $_SESSION['session_user_role']?>)</div>
		
	</div>
	<div class="main_container">
		<div class="right_container">
			<div class="content_holder">

				<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;VERIFY MOBILE WITH OTP - Complete Transaction in 120 Seconds.</div>
				
				<div class="content_holder_body">
				    <form name="verify_mobile_otp" method="post" action="verify-mobile-num.php">
				        <table>
				            <tr>
				                <td>ENTER OTP RECEIVED : &nbsp;&nbsp;</td>
				                <td><input type="text" maxlength=6 required name="otp_received" value=""></td>
				                <td>&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="VERIFY OTP">&nbsp;</td>
				                <td><span style="color:red; font-weight: bold; font-size:18px; ">&nbsp;&nbsp;<?php echo $mess;?></span></td>
				            </tr>
				        </table>
				         
				        
				    </form>
				    
				</div>
				
				<div class="clear"></div>			
				</div>
			</div>
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
mysql_close($connection);
}else{
header('Location: ./index.php');
}

?>
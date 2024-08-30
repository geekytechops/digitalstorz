<?php
session_start();
//print_r($_SESSION);
if(isset($_SESSION['session_username_activation']) && isset($_SESSION['session_password_activation'])){
include("./dbconnect.php");
$mess='';
//print_R($_SESSION);exit;
if(isset($_REQUEST['submit'])){ //When form Submits
    $subscription_plan=$_REQUEST['subscription_plan'];
        $sql_upd="	UPDATE `cust_kolors_users_list` SET 
							`subscription_plan`='".$subscription_plan."',
							`status`=1,
					 	    `subscription_date`=NOW()
					WHERE `username`=".$_SESSION['session_username_activation'];
		//echo $sql_upd;exit;
		$query_upd=mysql_query($sql_upd);
		if($query_upd){
			$mess="<font>Your Trail Pack Activated Please Logout and Login to get Benifit of Trail pack..</font>";
		}else{
			$mess="Failed to Update Subscription..";
		}


}
?>
<html>
<head>
	<link href="https://www.kolorsmobileservices.com/css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
<style>
    .p_style{
        text-align:center; 
        color:red; 
        font-size:18px;
        font-family: 'Trebuchet MS', sans-serif;
    }
    .p_style_1{
        text-align:center;
        font-family: 'Trebuchet MS', sans-serif;
    }
    body{
        font-family: 'Trebuchet MS', sans-serif;
    }

</style>
<script type="text/javascript">
function validate()
            {
		
		if (document.subscribe.subscription_plan.value == "")
                {
                    document.subscribe.subscription_plan.focus();
                    alert("Please Select a Subscription..");
		    return false;
                }
            }
</script>

</head>
<body>
	<div class="header">
		<span>&nbsp;&nbsp;&nbsp;&nbsp;DigitalStorz.com</span>
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">

		<div class="right_container">
			<div class="page_title_div"><h1>Welcome <?php echo $_SESSION['session_user_profile_name'];?></h1></div>

				<div class="content_holder">
				<div style="float:right;font-weight:bold;font-size:20px;"><a href="./logout.php" >LOGOUT</a></div>
                <div class="clear"></div>
                <div style="font-size:15px; color:green;">Your Account is inactive, please select any of the below package and continue for premium services.</div></br>
                		
				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Dashboard &nbsp;&nbsp;</div>
				
				<div class="content_holder_body">
				<div class="widget2">
												<div class="widget2_heading">&#10064;&nbsp;&nbsp;Trail Package</div>
											<div class="widget2_body">
													<p class="p_style_1">Free Access for 30 Days</p>	
													<p class="p_style"><s>2000 &#x20B9;</s></p>	
													<p class="p_style">0 &#x20B9;</p>	
												</div>
											</div>
											
											<div class="widget4">
												<div class="widget4_heading">&#x2668;&nbsp;&nbsp;Monthly Subscription</div>
												<div class="widget4_body">
												    <p class="p_style_1">Access for Month</p>
												    <p class="p_style"><s>2000 &#x20B9;</s></p>	
												    <p class="p_style">1499 &#x20B9;</p>	
												</div>
											</div>

											
											<div class="widget5">
												<div class="widget5_heading">&#9734;&nbsp;&nbsp;Quarterly Subscription</div>
												<div class="widget5_body">
												    <p class="p_style_1">Access for 3 Months</p>
												    <p class="p_style"><s>5000 &#x20B9;</s></p>	
						                            <p class="p_style">2999 &#x20B9;</p>
												</div>
											</div>
											<div class="widget5">
												<div class="widget5_heading">&#9734;&nbsp;&nbsp;Half-Yearly Subscription</div>
												<div class="widget5_body">
												    <p class="p_style_1">Access for 6 Months</p>
												    <p class="p_style"><s>9000 &#x20B9;</s></p>
						                            <p class="p_style">5999 &#x20B9;</p>
												</div>
											</div>
											<div class="widget5">
												<div class="widget5_heading">&#9734;&nbsp;&nbsp;Annual Subscription</div>
												<div class="widget5_body">
												    <p class="p_style_1">Access for 1 Year</p>	
												    <p class="p_style"><s>15000 &#x20B9;</s></p>
						                            <p class="p_style">11999 &#x20B9;</p>
												</div>
											</div>
								<div class="clear"></div>	
								<div>&nbsp;</div><div>&nbsp;</div>
								
								<form action="./user-activation.php" method="POST" name="subscribe" onsubmit="return validate()">
								 <label >Select a Subscription:</label>
                                 <select name="subscription_plan" id="subscription_plan" >
                                    <option value="">-- SELECT --</option>
                                    <option value="trail">Trail 30 Days </option>
                                    <!--<option value="quarterly">Quarterly Subscription</option>
                                    <option value="halfyearly">Half-Yearly Subscription</option>
                                    <option value="annual">Annual Subscription</option>-->
                                 </select>
                                 <input type="submit" name="submit" value="Proceed">
                                </form>
                                <br>
                                <div style="font-size:15px; color:green;"> <?php echo $mess;?></div>
                                <div>&nbsp;</div>
				</div>
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
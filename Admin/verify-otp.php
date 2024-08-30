<?php
session_start();
if(isset($_SESSION['username_verify_otp']) && isset($_SESSION['OTP_verify_otp'])){
    if (time() - $_SESSION['sess_start_time'] < 120) { 


    //print_r($_SESSION);exit;
    if(isset($_REQUEST['submit'])){ //When form Submits
        $otp_generated_in_session=$_SESSION['OTP_verify_otp'];
        $otp_entered_by_user=$_REQUEST['otp_entered_by_user'];
        //echo $otp_generated_in_session;        echo "--";        echo $otp_entered_by_user;        exit;
        
        if($otp_generated_in_session == $otp_entered_by_user){
           $_SESSION["otp_validate_status"]='validated';
             header("Location:self-password-change.php");
        }else{
            $mess="<b>INVALID OTP..</b>";
        }
    }
?>
<html>
<head>
            <link rel="icon" type="image/x-icon" href="./css/favicon1.jpeg">
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<script type="text/javascript">
            // Form validation code for SIGN UP
            function validete()
            {
				if (document.login_form.otp_entered_by_user.value == "")
                {
                    document.login_form.otp_entered_by_user.focus();
                    return false;
                }

            }
    </script>
    	<script>
    function onlyNumberKey(evt) {
          
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
</script>
    <script type="text/javascript">
	window.history.forward();
	function noBack() { window.history.forward(); }
    </script>
</head>
<body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
    	<div class="header">
		&nbsp;&nbsp;&nbsp;&nbsp;DigitalStorz.com
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
<div class="right_container">
    <?php
    $staff_email_for_otp=$_SESSION['staff_email_for_otp'];
    $first5char_email=substr($staff_email_for_otp,0,5);
    $middle_char_email="xxxxx";
    $last5char_email=substr($staff_email_for_otp,8);
    
    ?>
			<div class="page_title_div"><h1>OTP Sent to you email Successfully.. (<?php echo $first5char_email.$middle_char_email.$last5char_email; ?>)</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;PLEASE ENTER OTP RECEIVED OVER EMAIL..&nbsp;&nbsp;&nbsp;&nbsp; complete it on 120 Sec</div>
				
				<div class="content_holder_body">
				<form name="login_form" onpaste="return false;" ondrop="return false;" autocomplete="off" method="post" action="./verify-otp.php" onsubmit="return validete()">
					
					<div class="txt_lable">Please enter your OTP :</div>
					<div><input type="text" name="otp_entered_by_user" maxlength=6 placeholder="6 Digit OTP" value="" onkeypress="return onlyNumberKey(event)" autofocus > </div><div><?php echo $mess;?></div>

					<div class="submit_button_div" ><input class="submit_button" type="submit" name="submit" value="&nbsp;&nbsp;Validate&nbsp;&nbsp;" /></div>
					
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
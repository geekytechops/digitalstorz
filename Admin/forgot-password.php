<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
	include('./dbconnect.php');
	if($_REQUEST['submit']){
    $username=$_REQUEST['user_name_fgp'];
    //print_r($_REQUEST);exit;
        $sql1="SELECT * FROM `cust_kolors_users_list` WHERE username='".$username."'";
        //echo $sql1; exit;
		$query1=mysql_query($sql1);
		$num_rows_1=mysql_num_rows($query1);
		
		//echo $num_rows_1;exit;
		if($num_rows_1==1){
            $result1=mysql_fetch_array($query1);
                    // Generating otp with php rand variable
                    $otp_kol=rand(100000,999999);
                    $otp_kol_send=strval($otp_kol);
		           // echo $otp_kol_send; exit;
		           // This is for sending otp to email
				//require './PHPMailer/PHPMailerAutoload.php';
				require './mailtest/PHPMailer/src/Exception.php';
                require './mailtest/PHPMailer/src/PHPMailer.php';
                require './mailtest/PHPMailer/src/SMTP.php';
				
				$staff_name=$result1['staff_name'];
				$staff_email=$result1['staff_email'];
                $send_from_email='transactions@digitalstorz.com';
                $send_from_name='OTP From Digital Storz';
				
				$mail = new PHPMailer;
				
				/*$mail->isSMTP();                                      // Set mailer to use SMTP
				//$mail->Host = 'mail.digitalstorz.com';  // Specify main and backup server
				$mail->Host = 'mail.digitalstorz.com';  // Specify main and backup server
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = 'transactions@digitalstorz.com';                            // SMTP username
				$mail->Password = '!nfo@d!g!+@l';                           // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
			    $mail->Port = 465;  
				$mail->From = 'transactions@digitalstorz.com'; 
				$mail->FromName = 'OTP From Digital Storz';
				//$mail->setFrom($send_from_email,$send_from_name); 
				$mail->addAddress($staff_email);  // Add a recipient
				//$mail->addAddress($result1['staff_email']);
				//$mail->addReplyTo('');
				//$mail->addCC('');
				//$mail->addBCC('');
			
				$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
				//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
				//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
				$mail->isHTML(true);  */
				
				// Set email format to HTML
	//New Code			
	$mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.digitalstorz.com';                  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'transactions@digitalstorz.com';            // SMTP username
    $mail->Password = '!nfo@d!g!+@l';                              // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable SSL encryption, TLS also accepted with port 465
    $mail->Port = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('transactions@digitalstorz.com', 'OTP From Digital Storz');          //This is the email your form sends From
    $mail->addAddress($staff_email); // Add a recipient address
	$mail->isHTML(true);			
				$mail->Subject = 'OTP for Password Reset';
				$mail->Body    = 'Hi '.$staff_name.', <br><br>Welcome To DigitalStorz.com, 
								<br><br>OTP for changing password of your user account :  '.$retailer_username.' is <b> '.$otp_kol_send.'</b> <br>
								<br>
								OTP is valid for 2 minutes only..<br>
								Please donot share it to others.<br>
								
								<br><br>Thank You.. <br>
								Team Digital Storz.
								
								<br><br><br><br><br><br>
								<b>Please do not reply to this email. This is an auto generated email from DigitalStorz, and this mailbox will not be monitored.<br>
								In case of any queries, please write to info@digitalstorz.com.</b>
								
								';
				//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
				//echo 'Mailer Error: ' . $mail->ErrorInfo;
				//$mail->send();
			    //echo ("<pre>"); print_r($mail);	exit;
				if($mail->send()) {
				    session_start();
				    $_SESSION['sess_start_time'] = time();
				    $_SESSION["username_verify_otp"]=$username;
                    $_SESSION["OTP_verify_otp"]=$otp_kol_send;
                    $_SESSION["staff_email_for_otp"]=$staff_email;
				    
				    header("Location:verify-otp.php");
					
				}else{
				    session_destroy();
					header('Location: ./index.php?q=5');

				}

			}
		}


$mess='';
	if(isset($_REQUEST['q'])){
		$m=$_REQUEST['q'];	
		if($m==1){
			$mess="No User Found..";
		}else if($m==2){
			$mess="Password Given Was Wrong";
		}
	}
?>
<html>
<head>
        <link rel="icon" type="image/x-icon" href="./css/favicon1.jpeg">
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
		<script type="text/javascript">
            // Form validation code for SIGN UP
            function validete()
            {
				if (document.login_form.user_name_fgp.value == "")
                {
                    alert("Please enter Username");
                    document.login_form.user_name_fgp.focus();
                    return false;
                }

            }
            
            function numbersonly(e){
			    //alert("hi");
				var unicode=e.charCode? e.charCode : e.keyCode
				if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
				if (unicode<48||unicode>57) //if not a number
				if (document.login_form.user_name_fgp.value < 10)
				return false //disable key press
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
</head>
<body>
	<div class="header">
		&nbsp;&nbsp;&nbsp;&nbsp;DigitalStorz.com
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">
        <!--<div class="left_container">
			<div class="menu_heading">&#8803;&nbsp;&nbsp;MENU</div>
			<div id='cssmenu'>
				<ul>
				    <li class='active'><a href='https://www.digitalstorz.com'><span><img src="../images/home.png">&nbsp;&nbsp;Home</span></a></li>
                    <li><a href='https://www.digitalstorz.com/Admin/index.php'><span><img src="../images/account.png">&nbsp;&nbsp;Login</span></a></li>
				    <li><a href='https://www.digitalstorz.com/user-registration.php'><span><img src="../images/account.png">&nbsp;&nbsp;Register</span></a></li>
				</ul>
			</div>
		</div>-->
		<div class="right_container_index">
			<div class="page_title_div"><h1>Forgot Password</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Forgot Password &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $mess;?></div>
				
				<div class="content_holder_body">
				<form name="login_form" onpaste="return false;" ondrop="return false;" autocomplete="off" method="post" action="./forgot-password.php" onsubmit="return validete()">
					
					<div class="txt_lable">Tell us your Mobile Number :</div>
					<div><input type="text" placeholder="Only Numbers Allowed" name="user_name_fgp" value="" onkeypress="return onlyNumberKey(event)" maxlength=10 autofocus ></div>

					<div class="submit_button_div" ><input class="submit_button" type="submit" name="submit" value="&nbsp;&nbsp;Check&nbsp;&nbsp;" /></div>
					
				</form>
				<div style="font-weight:bold;padding-top:40px;padding-bottom:20px;"><a href="./index.php">Go Back</a></div>
				</div>
				
		</div>
	</div>
</body>
</html>
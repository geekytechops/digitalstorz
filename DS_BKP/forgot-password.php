<?php
	include("./Admin/dbconnect.php");
	extract($_REQUEST);
	$mess='';
	if(isset($_REQUEST['submit'])){
		
		$email_id=$_REQUEST['username_retail'];
		$sql="SELECT `password` from `cust_kolors_retail_users` WHERE `email_id`='".$email_id."'";
		//echo $sql;
		$query=mysql_query($sql);
		$result=mysql_fetch_array($query);
		
		$password=$result['password'];
		
		//SENDING USER AN Email
			require './PHPMailer/PHPMailerAutoload.php';
			
			$email=$_REQUEST['username_retail'];

			
			$mail = new PHPMailer;
			
			$mail->isSMTP();                                      // Set mailer to use SMTP
			//$mail->Host = 'mail.kolorsmobileservices.com';  // Specify main and backup server
			$mail->Host = 'fiesta.websitewelcome.com';  // Specify main and backup server
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'admin@kolorsmobileservices.com';                            // SMTP username
			$mail->Password = 'Nandu@9c';                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
		
			$mail->From = 'admin@kolorsmobileservices.com'; 
			$mail->FromName = 'ADMIN Kolors Mobile Services';
			$mail->addAddress($email);  // Add a recipient
			$mail->addReplyTo('');
			$mail->addCC('');
			$mail->addBCC('');
			
			$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
			//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
			$mail->isHTML(true);                                  // Set email format to HTML
			
			$mail->Subject = 'Password Recovery..';
			$mail->Body    = 'Hi,<br><br>As Requested By you.. Your Password for Kolors Mobile Services Retail Login is below.. 
							<br><br> Your Password is: '.$password.'
							<br><br>Kolors Mobile Services Team.
							<br><br>Note: Information contained in this email is strictly confidential. Do not share email with anyone.
							';
			//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
			
			if(!$mail->send()) {
				$mess="<font color='#fff'><b>Please contact Admin</b></font>";
			}else{
				$mess="<font color='#fff'><b>Password Sent your Email Id..</b></font>";
			}
		
	}
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
		<script type="text/javascript">
            // Form validation code for SIGN UP
            function validate()
            {
				if (document.forgot_password.username_retail.value == "")
                {
                    document.forgot_password.username_retail.focus();
					alert("Enter email id..");
                    return false;
                }else{
					var email = document.getElementById('username_retail');
					var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

					if (!filter.test(email.value)) {
						alert('Invalid Email');
						email.focus();
						return false;
					}
				}
			}
	</script>
	
		<script type="text/javascript">
			function CheckUserName(){
			var UserName = document.getElementById('username_retail');
			
			//alert(UserName.value);
			if(UserName.value != "")
			{
				//alert('username not null');
				if (window.XMLHttpRequest)
				{// code for IE7+, Firefox, Chrome, Opera, Safari
				  //alert('in if');
				  xmlhttp=new XMLHttpRequest();
				}
				else
				{// code for IE6, IE5
				  //alert('in else');
				  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=function()
				{
					//alert(xmlhttp.readyState.value);
				  if (xmlhttp.readyState==4 && xmlhttp.status==200)
					{
						var value = xmlhttp.responseText;
						//alert(value.length);
						if(value.length > 1)
						{
							document.getElementById('ErrorSpan').innerHTML="Email Exists..";
							
						}
						else
						{
							document.getElementById('ErrorSpan').innerHTML="Email does not Exists..";
							UserName.focus();
						}
					}
				  }
				xmlhttp.open("GET","retail_usernname_check_ajax.php?q="+UserName.value,true);
				xmlhttp.send();
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
			<div class="menu_heading">&#8803;&nbsp;&nbsp;MENU</div>
			<div id='cssmenu'>
				<ul>
				   <li class='active'><a href='http://www.kolorsmobileservices.com'><span><img src="../images/home.png">&nbsp;&nbsp;Home</span></a></li>
				   <li><a href='http://www.kolorsmobileservices.com/about.html'><span><img src="../images/shopping-cart.png">&nbsp;&nbsp;About</span></a></li>
				   <li><a href='http://www.kolorsmobileservices.com/training-institute.html'><span><img src="../images/history.png">&nbsp;&nbsp;Training Institute</span></a></li>
				   <li><a href='http://www.kolorsmobileservices.com/contact.html'><span><img src="../images/list-icon.png">&nbsp;&nbsp;&nbsp;Contact</span></a></li>
				   <li><a href='http://www.kolorsmobileservices.com/Unlocks/retail-login.php'><span><img src="../images/account.png">&nbsp;&nbsp;Login</span></a></li>
				</ul>
			</div>
		</div>
		<div class="right_container">
			<div class="page_title_div"><h1>Forgot Password</h1></div>
			<div class="content_holder_small">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Forgot Password..?? Give Your Email.. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $mess; ?></div>
				
				<div class="content_holder_body">
				<form name="forgot_password" method="post" action="./forgot-password.php" onsubmit="return validate()">
					<div class="txt_lable">Username:&nbsp;</div>
					<div><input class="search_form"  type="text" id="username_retail" name="username_retail" value="" onblur="CheckUserName();"/>&nbsp;<span id="ErrorSpan" style=" color:blue; font-size:11px;"></span></div>
				
					<div class="submit_button_div"><input type="submit" name="submit" value="Retrieve"/> </div>
					<div class="forgot_pass_div"><a href="./retail-login.php">Back to Login</a></div>
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
?>
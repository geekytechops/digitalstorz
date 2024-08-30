<?php
	include("./Admin/dbconnect.php");
	extract($_REQUEST);
	$mess='';
	if(isset($_REQUEST['submit'])){
		
		$retailer_name==$_REQUEST['retailer_name'];
		$retailer_mobile=$_REQUEST['retailer_mobile'];
		$retailer_role='admin';
		$temp_email=$_REQUEST['retailer_email'];
		$retailer_email=strtolower($temp_email ); //changing user email to lowercase
		
		$retailer_username=strtolower($_REQUEST['retailer_username'] ); //changing user name to lowercase
		
		//Checking User exists
		$sql_user_exists="select * from cust_kolors_retail_users where username='".$retailer_username."'";
		$query_user_exists = mysql_query($sql_user_exists);
		$num_rows_username = mysql_num_rows($query_user_exists);
		
		//Checking Email Exists
		$sql_email_exists="select * from cust_kolors_retail_users where username='".$retailer_email."'";
		$query_email_exists = mysql_query($sql_email_exists);
		$num_rows_email = mysql_num_rows($query_user_exists);
		
		$retail_password=$_REQUEST['retail_password'];
		$retail_outlet_name=$_REQUEST['retail_outlet_name'];
		$retail_outlet_address=$_REQUEST['retail_outlet_address'];
		
		$passkey=md5(uniqid(rand()));
		
		if($num_rows_username<1 && $num_rows_email <1){
			$sql_ins="INSERT INTO `cust_kolors_retail_users`(`retailer_name`, `retailer_role`, `contact_no`, `email_id`,`username`,`password`, `outlet_name`, `outlet_address`, `status`, `add_date`, `passkey`) VALUES 
			('".$retailer_name."','".$retailer_role."','".$retailer_mobile."','".$retailer_email."','".$retailer_username."','".$retail_password."','".$retail_outlet_name."','".$retail_outlet_address."','0',NOW(),'".$passkey."')";
			$sql_query=mysql_query($sql_ins);
			if($sql_query){
			$mess="<font color='green'><b>Registration Succesful.. <br>Please Check Your Mail for remaining details..</b></font>";
			
				//SENDING USER AN Email
				require './PHPMailer/PHPMailerAutoload.php';
				
				$name=$_REQUEST['retailer_name'];
				$email=$_REQUEST['retailer_email'];

				
				$mail = new PHPMailer;
				
				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'mail.kolorsmobileservices.com';  // Specify main and backup server
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
				
				$mail->Subject = 'Retail Registration';
				$mail->Body    = 'Hi '.$name.', <br><br>Welcome To Kolors Mobile Services Retail User Portal. 
								<br><br> Login with your username ('.$retailer_username.') and password given.. <br>
								<a href="http://www.kolorsmobileservices.com/Unlocks/verify-retailer.php?user='.$retailer_username.'&KolorsVrfPassCode='.$passkey.'">Click Here to Verify the email</a> to complete registration process.
								<br><br>
								After Email verification, our Representative will get in touch with you on phone and will come to your location for verification.
								<br><br>Thank You.. <br>
								Kolors Mobile Services Team.
								';
				//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
				
				if(!$mail->send()) {
					$mess="<font color='green'><b>Please contact Admin</b></font>";
				}else{
					$mess="<font color='green'><b>Registration Succesful.. <br>Please Check Your Mail for remaining details..</b></font>";
				}
			}else{
				$mess="<font color='red'><b>Registration Incomplete.. </br>Please Contact site admin..</b></font>";
			}
		}else if($num_rows_username==1){
			$mess="<font color='red'><b>Username Alresdy exists..</font>";
		}else if($num_rows_email==1){
			$mess="<font color='red'><b>Email Alresdy exists..</font>";
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
				if (document.retail_registration.retailer_username.value == "")
                {
                    document.retail_registration.retailer_username.focus();
					alert("Provide Username..");
                    return false;
                }else if(document.retail_registration.retailer_username.value.length <5 ){
					document.retail_registration.retailer_username.focus();
					alert("Username Min 5 characters..");
                    return false;
				}
				
				if (document.retail_registration.retail_password.value == "")
                {
                    document.retail_registration.retail_password.focus();
					alert("Provide Password..");
                    return false;
                }
				
				if (document.retail_registration.retailer_name.value == "")
                {
                    document.retail_registration.retailer_name.focus();
                    alert("Enter Your Name");
					return false;
                }
				
				if (document.retail_registration.retailer_mobile.value == "")
                {
                    document.retail_registration.retailer_mobile.focus();
					alert("Enter Working Phone No..");
                    return false;
                }else if(document.retail_registration.retailer_mobile.value.length <10 ){
					document.retail_registration.retailer_mobile.focus();
					alert("Mobile Number Should be 10 Digits..");
                    return false;
				}
				
				if (document.retail_registration.retailer_email.value == "")
                {
                    document.retail_registration.retailer_email.focus();
					alert("Enter email id..");
                    return false;
                }else{
					var email = document.getElementById('retailer_email');
					var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

					if (!filter.test(email.value)) {
						alert('Invalid Email');
						email.focus();
						return false;
					}
				}
				
				if (document.retail_registration.retail_outlet_name.value == "")
                {
                    document.retail_registration.retail_outlet_name.focus();
					alert("Provide Your Outlet Full Name");
                    return false;
                }
				if (document.retail_registration.retail_outlet_address.value == "")
                {
                    document.retail_registration.retail_outlet_address.focus();
					alert("Provide Outlet full address");
                    return false;
                }
			}
			
			function numbersonly(e){
				var unicode=e.charCode? e.charCode : e.keyCode
				if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
				if (unicode<48||unicode>57) //if not a number
				return false //disable key press
				}
			}
			
			function AvoidSpace() { 
                        if (event.keyCode == 32) { 
                                event.returnValue = false; 
                                return false; 
                        } 
                } 	

	</script>
	
	<script type="text/javascript">
			function CheckUserName(){
			var UserName = document.getElementById('retailer_username');

			//alert(UserName.value);
			if(UserName.value != "" && UserName.value.length >4)
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
							document.getElementById('ErrorSpan').innerHTML="Not Available.";
							UserName.focus();
						}
						else
						{
							document.getElementById('ErrorSpan').innerHTML="Available";
						}
					}
				  }
				xmlhttp.open("GET","retail_usernname_check_ajax.php?q="+UserName.value,true);
				xmlhttp.send();
			}else{
				document.getElementById('ErrorSpan').innerHTML="Min 5 Characters";
				UserName.focus();
			}
		}
		
		//Check Email
					function CheckEmail(){
			var ret_email = document.getElementById('retailer_email');

			//alert(UserName.value);
			if(ret_email.value != "")
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
							document.getElementById('ErrorSpan2').innerHTML="Email Id Already Exists.";
							ret_email.focus();
						}
						else
						{
							document.getElementById('ErrorSpan2').innerHTML="Email Not Registered.. Proceed";
						}
					}
				  }
				xmlhttp.open("GET","retail_usernname_check_ajax.php?email="+ret_email.value,true);
				xmlhttp.send();
			}
		}

</script>
</head>
<body>
	<div class="header">
		<a href="./retailer-home.php">&nbsp;&nbsp;&nbsp;&nbsp;DIGITALSTORZ.COM</a>
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">
		<div class="left_container">
			<div class="menu_heading">&#8803;&nbsp;&nbsp;MENU</div>
			<div id='cssmenu'>
				<ul>
				    <li class='active'><a href='https://www.digitalstorz.com'><span><img src="../images/home.png">&nbsp;&nbsp;Home</span></a></li>
                    <li><a href='https://www.digitalstorz.com/Admin/index.php'><span><img src="../images/account.png">&nbsp;&nbsp;Login</span></a></li>
				    <li><a href='https://www.digitalstorz.com/retail-registration.php'><span><img src="../images/account.png">&nbsp;&nbsp;Register</span></a></li>
				</ul>
			</div>
		</div>
		<div class="right_container">
			<div class="page_title_div"><h1>Join With Us</h1></div>
			<div class="content_holder_small">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Retailer Registration &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $mess; ?></div>
				
				<div class="content_holder_body">
				<form name="retail_registration" method="post" action="./retail-registration.php" onsubmit="return validate()">
					<div>Login Details:</div>
					
					<div class="txt_lable">Username : (Max 15 Characters)</div>
					<div><input type="text" id="retailer_username" maxlength="15" name="retailer_username" id="retailer_username" value=""  onkeypress="return AvoidSpace()" onblur="CheckUserName();"/>&nbsp;<span id="ErrorSpan" style=" color:blue; font-weight:bold; font-size:12px;"></span></div>

					<div class="txt_lable">Password :</div>
					<div><input class="text_box" type="password" maxlength="20" name="retail_password" value=""/></div>
					
					<div>Personal Details:</div>
					<div class="txt_lable">Your Name: :</div>
					<div><input type="text" name="retailer_name" value=""/></div>
					
					<div class="txt_lable">Mobile No :</div>
					<div><input onkeypress="return numbersonly(event)" maxlength=10 type="text" name="retailer_mobile" value=""/>&nbsp;&nbsp;10 Digits only</div>
					
					<div class="txt_lable">Email Id: :</div>
					<div><input type="text" id="retailer_email" onblur="CheckEmail();" name="retailer_email" id="retailer_email" value="" /></div>&nbsp;<span id="ErrorSpan2" style=" color:blue; font-weight:bold; font-size:12px;"></span>
					
					<div>Shop/Outlet Details::</div>
					<div class="txt_lable">Outlet Name:</div>
					<div><input type="text" name="retail_outlet_name" value=""/></div>
					
					<div class="txt_lable">Address:</div>
					<div><textarea name="retail_outlet_address" ></textarea></div>
					
					<div class="submit_button_div"><input type="submit" name="submit" value="&nbsp;&nbsp;Register&nbsp;&nbsp;"/></div>
					
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
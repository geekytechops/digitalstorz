<?php
session_start();
//print_r($_SESSION);

if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
$username_store=$_SESSION['session_username'];
$session_store_name=$_SESSION['session_store_name'];
$session_store_id=$_SESSION['session_store_id'];

//print_r($_SESSION);

//echo (time() - $_SESSION['sess_start_time']);
//exit;
include("./dbconnect.php");
//if (time() - $_SESSION['sess_start_time'] < 120) {
if(isset($_REQUEST['submit'])){
    //extract($_REQUEST);
    $upload_dir = './kyc/';
    
    $ext1 = pathinfo($_FILES['store_reg_certificate']['name'], PATHINFO_EXTENSION);
    $filename_store_reg_cert=$session_store_id.'_'.$username_store.'_store_reg_cert.'.$ext1;
    //$ext2 = pathinfo($_FILES['store_owner_id_proof']['name'], PATHINFO_EXTENSION);
    //$filename_store_owner_id_proof=$session_store_id.'_'.$username_store.'_store_owner_id_proof.'.$ext2;
    
    //echo $_FILES['store_reg_certificate']['size'];
    //print_r($_FILES);
if( ($_FILES["store_reg_certificate"]["size"]) > 0  ){
    if(move_uploaded_file($_FILES['store_reg_certificate']['tmp_name'], $upload_dir.$filename_store_reg_cert) ) 
      {
            $sql_file_upd="UPDATE `stores` SET 
                                            `kyc_status`='Submitted',
                                            `store_reg_certificate`='".$filename_store_reg_cert."'
                                            WHERE `store_id`=".$session_store_id;
            //echo $sql_file_upd;exit;
            $query_file_upd=mysql_query($sql_file_upd);
            if($query_file_upd){
                // This is for sending otp to email
				require './PHPMailer/PHPMailerAutoload.php';
				
				require './mailtest/PHPMailer/src/Exception.php';
                require './mailtest/PHPMailer/src/PHPMailer.php';
                require './mailtest/PHPMailer/src/SMTP.php';
				
			    $mail = new PHPMailer;
				
				/*
				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'mail.digitalstorz.com';  // Specify main and backup server
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = 'transactions@digitalstorz.com';                            // SMTP username
				$mail->Password = '!nfo@d!g!+@l';                           // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
			
				$mail->From = 'transactions@digitalstorz.com'; 
				$mail->FromName = 'KYC Approval Required.';
				$mail->addAddress('digitalstorz@gmail.com');  // Add a recipient
				$mail->addReplyTo('');
				$mail->addCC('');
				$mail->addBCC('');
			
				$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
				$mail->addAttachment('');         // Add attachments
				//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
				$mail->isHTML(true); // Set email format to HTML
				
				*/
				//New Code			
	//$mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.digitalstorz.com';                  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'transactions@digitalstorz.com';            // SMTP username
    $mail->Password = '!nfo@d!g!+@l';                              // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable SSL encryption, TLS also accepted with port 465
    $mail->Port = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('transactions@digitalstorz.com', 'Customer KYC Approval Request');          //This is the email your form sends From
    $mail->addAddress('digitalstorz@gmail.com');  // Add a recipient
	$mail->isHTML(true);			
				
				$mail->Subject = 'KYC Approval Required';
				$mail->Body    = 'Hi Admin, <br><br> You have received KYC Details of store ID - '.$session_store_id.' - '.$session_store_name.', 
								<br> <br>
								Kindly Review the details and take action.
								<br> <br> <br> 
							
								<b>Please do not reply to this email. This is an auto generated email from DigitalStorz, and this mailbox will not be monitored.<br>
								
								';
				//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
				
				//print_r($mail);	exit;
				$mail->send();
				
               $mess='Your Files are uploaded.'; 
            }else{
                require './PHPMailer/PHPMailerAutoload.php'; //old
                
                //new
				require './mailtest/PHPMailer/src/Exception.php';
                require './mailtest/PHPMailer/src/PHPMailer.php';
                require './mailtest/PHPMailer/src/SMTP.php';
				
				$mail = new PHPMailer;
				
				/* old code
				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'mail.digitalstorz.com';  // Specify main and backup server
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = 'transactions@digitalstorz.com';                            // SMTP username
				$mail->Password = '!nfo@d!g!+@l';                           // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
			
				$mail->From = 'transactions@digitalstorz.com'; 
				$mail->FromName = 'Error In Uploading Docs.';
				$mail->addAddress('digitalstorz@gmail.com');  // Add a recipient
				$mail->addReplyTo('');
				$mail->addCC('');
				$mail->addBCC('');
			
				$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
				$mail->addAttachment('');         // Add attachments
				//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
				$mail->isHTML(true);                                  // Set email format to HTML
				*/
				
				//New Code			
	//$mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.digitalstorz.com';                  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'transactions@digitalstorz.com';            // SMTP username
    $mail->Password = '!nfo@d!g!+@l';                              // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable SSL encryption, TLS also accepted with port 465
    $mail->Port = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('transactions@digitalstorz.com', 'Customer KYC Approval Request Error');          //This is the email your form sends From
    $mail->addAddress('digitalstorz@gmail.com');  // Add a recipient
	$mail->isHTML(true);		
				
				$mail->Subject = 'Error In Uploading Docs';
				$mail->Body    = 'Hi Admin, <br><br> User with store ID - '.$session_store_id.' - '.$session_store_name.', faces issues while file upload.
								<br> <br>
								Please contact user and assist further.
								<br> <br> <br> 
							
								<b>Please do not reply to this email. This is an auto generated email from DigitalStorz, and this mailbox will not be monitored.<br>
								
								';
				//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
				
				//print_r($mail);	exit;
				$mail->send();
                $mess='Error in updating filenames in Database. Please contact DigitalStorz Admin.';
            }
      }
      else
      {
        $mess='Error In file Uploading, Please contact DigitalStorz Admin.';
        //echo $_FILES['store_owner_id_proof']['error'];
        require './PHPMailer/PHPMailerAutoload.php';
        
        //new
				require './mailtest/PHPMailer/src/Exception.php';
                require './mailtest/PHPMailer/src/PHPMailer.php';
                require './mailtest/PHPMailer/src/SMTP.php';
				
				$mail = new PHPMailer;
				
				/*
				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'mail.digitalstorz.com';  // Specify main and backup server
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = 'transactions@digitalstorz.com';                            // SMTP username
				$mail->Password = '!nfo@d!g!+@l';                           // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
			
				$mail->From = 'transactions@digitalstorz.com'; 
				$mail->FromName = 'Error In Uploading Docs.';
				$mail->addAddress('digitalstorz@gmail.com');  // Add a recipient
				$mail->addReplyTo('');
				$mail->addCC('');
				$mail->addBCC('');
			
				$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
				$mail->addAttachment('');         // Add attachments
				//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
				$mail->isHTML(true);                                  // Set email format to HTML
				*/
				
				//New Code			
	//$mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.digitalstorz.com';                  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'transactions@digitalstorz.com';            // SMTP username
    $mail->Password = '!nfo@d!g!+@l';                              // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable SSL encryption, TLS also accepted with port 465
    $mail->Port = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('transactions@digitalstorz.com', 'Customer KYC Approval Request Error');          //This is the email your form sends From
    $mail->addAddress('digitalstorz@gmail.com');  // Add a recipient
	$mail->isHTML(true);		
				
				$mail->Subject = 'Error In Uploading Docs';
				$mail->Body    = 'Hi Admin, <br><br> User with store ID - '.$session_store_id.' - '.$session_store_name.', faces issues while file upload.
								<br> <br>
								Please contact user and assist further.
								<br> <br> <br> 
							
								<b>Please do not reply to this email. This is an auto generated email from DigitalStorz, and this mailbox will not be monitored.<br>
								
								';
				//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
				
				//print_r($mail);	exit;
				$mail->send();
      }
}else{
     $mess='Upload File Size is more than 2 MB, Please compress the size and upload again.';
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
    <!-- Script for preventing reload submit entry-->
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<script type="text/javascript">
    function Upload() {
        var fileUpload = document.getElementById("fileUpload");
        if (typeof (fileUpload.files) != "undefined") {
            //var size = parseFloat(fileUpload.files[0].size / 1024).toFixed(2);
            var size = parseFloat(fileUpload.files[0].size / (1024 * 1024)).toFixed(2); 
            if(size > 2) {
                alert('Please select image size less than 2 MB');
            }else{
                //alert('success');
            }
        } else {
            alert("Contact Admin.");
        }
    }
    
    function Upload2() {
        var fileUpload = document.getElementById("fileUpload2");
        if (typeof (fileUpload.files) != "undefined") {
            //var size = parseFloat(fileUpload.files[0].size / 1024).toFixed(2);
            var size = parseFloat(fileUpload.files[0].size / (1024 * 1024)).toFixed(2); 
            if(size > 2) {
                alert('Please select image size less than 2 MB');
            }else{
                //alert('success');
            }
        } else {
            alert("Contact Admin.");
        }
    }
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
				    <h1 style="text-align:right;padding-right:100px;"><a href="./logout.php">LOGOUT</a></h1>
				    <h1 style="color:green;text-align:center;"><?php echo $mess;?></h1><br>
				    
				    <?php
				    $sql_get_kyc_stat="SELECT `kyc_status` FROM `stores` WHERE `store_id`=".$session_store_id;
				    $query_get_kyc_stat=mysql_query($sql_get_kyc_stat);
				    $result_get_kyc_stat=mysql_fetch_array($query_get_kyc_stat);
				    if($result_get_kyc_stat['kyc_status'] == 'Submitted'){
				        echo '<h1 style="color:green;text-align:center;">Your KYC Details are Submitted and are under review and will be actioned with in 1-2 hours.</h1>';
				    }else{
				    ?>
				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Complete KYC By uploading documents.</div>
				<div class="content_holder_body">
				    <form name="verify_mobile_otp" method="post" action="kyc-complete.php" enctype="multipart/form-data">
				        <table>
				            <tr><td colspan="2"><span style="color:red; font-weight:bold;">Please upload below details of your store to verify your store name and address.</span></td></tr>
				            <tr><td>&nbsp;</td>
				            <tr>
				                <td style="text-align:right">Store Registration Certificate : &nbsp;&nbsp;</td>
				                <td><input required type="file"   onchange="Upload()"  id="fileUpload" name="store_reg_certificate" accept="image/png, image/jpeg,image/jpg, application/pdf">Max File Size: 2MB (Labour License/Trade License/Private Ltd Doc/Propritership Doc)</td>
				            </tr>
				            <tr><td>&nbsp;</td></tr>
				            <!--<tr>
				                <td style="text-align:right">Owner/Admin ID Proof : &nbsp;&nbsp;</td>
				                <td><input required type="file"  onchange="Upload()"  id="fileUpload2" name="store_owner_id_proof" accept="image/png, image/jpeg, application/pdf">Max File Size: 2MB (Adhaar/PAN/Passport/Driving License/Any Govt Id Proof)</td>
				            </tr>-->
				            <tr>
				                <td style="text-align:right"><input type="checkbox" class="custom-control-input" id="cb1" name="" required></td>
				                <td><label class="custom-control-label" for="cb1">&nbsp;&nbsp;Accept <a href="https://www.digitalstorz.com/terms-conditions.html" target="_blank">Terms and Conditions</a></label> [ I am Uploading this document with my consent.]</td>
			                </tr>
                      
                      
                    </div>
				            </tr>
				            <tr><td>&nbsp;</td></tr>
				            <tr>
				            <td>&nbsp;</td>
				            <td>&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="UPLOAD DOCUMENTS">&nbsp;</td>
				            </tr>
				        </table>
				    </form>
				</div>
				<div class="clear"></div>			
				</div>
				<?php
				    }
				?>
			</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php
//}else{
    //session_destroy();
//header('Location: ./index.php?q=6');    
//}
mysql_close($connection);
}else{
header('Location: ./index.php');
}

?>
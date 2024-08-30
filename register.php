<?php
	include("./Admin/dbconnect.php");
	extract($_REQUEST);
	$mess='';
		if(isset($_REQUEST['q'])){
			$m=$_REQUEST['q'];	
			if($m==1){
				$mess="Registration Successful..";
			}else if($m==2){
				$mess="Please Contact Admin..";
			}else if($m==3){
			    $mess="USER ALREADY EXISTS..";
			}
		}
$username_retail='';
$field_disable='';
$btn_name="submit";
$btn_val="GET OTP";
if(isset($_REQUEST['submit'])){
   // print_r($_REQUEST);
    $username_retail=$_REQUEST['username_retail'];
        $sql_check_user="select * from cust_kolors_retail_users where username='".$username_retail."'";
		$query_check_user = mysql_query($sql_check_user);
		$row_count = mysql_num_rows($query_check_user);
		
		if($row_count < 1){ //if user doesnot exists
		    $field_disable="disabled = 'yes' ";
            $btn_name="submit_otp";
            $btn_val="VERIFY OTP";
    
            $otp_kol=rand(100000,999999);
            $otp_kol_send=strval($otp_kol);
            $message='Dear Customer, OTP for Mobile number verification is '.$otp_kol_send.'. Thank you. - DigitalStorz';
    
            //SMS SENDING CODE for OTP
		
		$curl = curl_init();
        $data = array(
        "SenderId" => "DigStz",
        "Is_Unicode" => false,
        "Is_Flash" => false,
        "Message" => $message,
        "MobileNumbers" => "91".$username_retail,
        "ApiKey" => "7BuFBODK3Xs/WqDhRgUCaWpUVndUszaBT5HZEbP0K40=",
        "ClientId" => "344a995d-c0f6-4ded-96b3-992e4b5dbeb6"
        );
        $payload = json_encode($data);
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.smslane.com/api/v2/SendSMS",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>$payload,
        CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json"
        ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($curl);
        curl_close($curl);
		}else{
		    echo $mess="user already exists";
		}
    
}

if(isset($_REQUEST['submit_otp'])){
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/x-icon" href="./Admin/css/favicon1.jpeg">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Admin/css/ds-login-style.css">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>DigitalStorz.com</title>
    
<script>
    
    		function CheckUserName(){

			var UserName = document.getElementById('username_retail');
            //alert(UserName);
			//alert(UserName.value);
			if(UserName.value != "" && UserName.value.length >9)
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
							document.getElementById('ErrorSpan').innerHTML="<font style='color:red'>&#10006;</font>";
							UserName.focus();
						}
						else
						{
							document.getElementById('ErrorSpan').innerHTML="<font style='color:green;font-size:16px'>&#10003;</font>"; //Available
						}
					}
				  }
				xmlhttp.open("GET","retail_username_check_ajax_new.php?q="+UserName.value,true);
				xmlhttp.send();
			}else{
				document.getElementById('ErrorSpan').innerHTML="Min 10 Characters";
				UserName.focus();
			}
		}
		
		
		function validate(){
		    if (document.retail_login.password_retail.value != document.retail_login.reenter_password_retail.value){
                document.retail_login.reenter_password_retail.focus();
                alert("Passwords Do Not Match..");
                return false;
            }
		}
</script>
</head>
<body>

    <div class="registerForm">
        <div class="container">
          <div class="row px-3">
            <div class="col-lg-10 col-xl-9 card flex-row mx-auto px-0">
              <!-- <div class="img-left d-none d-md-flex"></div> -->

              <div class="card-body">
                <h4 class="title text-center mt-2">
                 REGISTER YOUR ACCOUNT
                </h4>
                <form onsubmit="return validate()" class="form-box px-3" name="retail_login" onpaste="return false;" ondrop="return false;" autocomplete="off" method="post" action="./register.php" >
                  <div class="form-input">
                    <span><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                    <input type="number"  id="username_retail" name="username_retail" placeholder="Mobile Number (Username)" maxlength="10" value="<?php echo $username_retail;?>" <?php echo $field_disable;?> required pattern="[0-9]{10}" onkeypress="if(this.value.length==10) return false;"  onkeydown="javascript: return (event.keyCode == 69 || event.keyCode == 190 || event.keyCode == 189 || event.keyCode == 187) ? false : true" onblur="CheckUserName();">
                  <span id="ErrorSpan" style=" color:blue; font-weight:bold; font-size:12px;"></span>
                  </div>
                  
                  <?php
                    if($username_retail != ''){
                  ?>
                  <div class="form-input">
                    <span><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                    <input type="number"  id="mobile_otp" name="mobile_otp" placeholder="Enter OTP" maxlength="6" value="" required pattern="[0-9]{10}" onkeypress="if(this.value.length==6) return false;"  onkeydown="javascript: return (event.keyCode == 69 || event.keyCode == 190 || event.keyCode == 189 || event.keyCode == 187) ? false : true" ">
                  </div>
                  <?php
                    }
                  ?>
        
                  <div class="mb-3">
                    <input type="submit" name="<?php echo $btn_name?>" value="<?php echo $btn_val?>" class="btn btn-block text-uppercase">
                     
                  </div>
                <div style="font-size:12px;text-align:center;color:red">By Registering you are accepting the terms and conditions. We request you to read the terms and conditions thoroughly before you register.</div>
                  <!-- <div class="text-right">
                    <a href="./Admin/forgot-password.php" class="forget-link">
                      Forget Password?
                    </a>
                  </div> -->
        
                  <hr class="my-4">
        
                  <div class="text-center mb-2 Already-account">
                   Already have an account?
                    <a href="./Admin/index.php" class="register-link">
                      Login
                    </a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
</body>
</html>

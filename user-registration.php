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
		
if(isset($_REQUEST['submit'])){
   // print_r($_REQUEST);

    $username_retail=$_REQUEST['username_retail'];
    $password_retail=$_REQUEST['password_retail'];
    $hashed_password = password_hash($password_retail,PASSWORD_DEFAULT); //encrypting password
    $staff_name=$_REQUEST['staff_name'];
    $staff_email=$_REQUEST['staff_email'];
    $referal_code=$_REQUEST['referal_code'];
    $use_default_defects="yes";
    
    $sql_usercheck="SELECT * FROM cust_kolors_users_list WHERE username=".$username_retail;
    $query_usercheck=mysql_query($sql_usercheck);
    $num_rows_usercheck=mysql_num_rows($query_usercheck);
    
    if($num_rows_usercheck==0){
    $user_role='admin';
    
    $sql_user_ins="INSERT INTO `cust_kolors_users_list`(`user_role`, `username`, `password`,`staff_name`,`staff_mobile`,`staff_email`, `status`, `add_date`,`refered_by`) 
    VALUES 
    ('".$user_role."','".$username_retail."','".$hashed_password."','".$staff_name."','".$username_retail."','".$staff_email."','0',NOW(),'".$referal_code."' )";
    
   //echo $sql_user_ins;exit;
   $query_user_ins=mysql_query($sql_user_ins);
   
   if($query_user_ins){
       	header('Location: ./Admin/index.php?reg=success');
   }else{
        header('Location: ./user-registration.php?q=2');
   }
    }else{
        header('Location: ./user-registration.php?q=3');
    }
   
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
							document.getElementById('ErrorSpan').innerHTML="<font style='color:red'>&#10006; User Already Registered.</font>";
							UserName.focus();
						}
						else
						{
							document.getElementById('ErrorSpan').innerHTML="<font style='color:green'>&#10003; Available.</font>";
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
                <form onsubmit="return validate()" class="form-box px-3" name="retail_login" onpaste="return false;" ondrop="return false;" autocomplete="off" method="post" action="./user-registration.php" >
                  <div class="form-input">
                    <span><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                    <input type="number"  id="username_retail" name="username_retail" placeholder="Mobile Number (Username)" maxlength="10" required pattern="[0-9]{10}" onkeypress="if(this.value.length==10) return false;"  onkeydown="javascript: return (event.keyCode == 69 || event.keyCode == 190 || event.keyCode == 189 || event.keyCode == 187) ? false : true" onblur="CheckUserName();">
                  </div>
                  <div><span id="ErrorSpan" style=" color:blue; font-weight:bold; font-size:12px;"></span></div>
                  <div class="form-input">
                    <span><i class="fa fa-key"></i></span>
                    <input type="password" placeholder="Password (Min 8 Characters)" minlength=8 name="password_retail" id="password_retail" value="" required>
                  </div>
                  <div class="form-input">
                    <span><i class="fa fa-key"></i></span>
                    <input type="password" placeholder="Re-Enter Password" minlength=8 name="reenter_password_retail" id="reenter_password_retail" value="" required>
                  </div>
                  <div class="form-input">
                    <span><i class="fa fa-key"></i></span>
                    <input type="text" placeholder="Your Name" name="staff_name" id="staff_name" value="" required>
                  </div>
                  <div class="form-input">
                    <span><i class="fa fa-key"></i></span>
                    <input type="email" placeholder="Email Address" name="staff_email" id="staff_email" value="" required>
                  </div>
                  <div class="form-input">
                    <span><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                    <input type="number"  id="referal_code" name="referal_code" placeholder="Referal Mobile No (Optional)" maxlength="10" pattern="[0-9]{10}" onkeypress="if(this.value.length==10) return false;"  onkeydown="javascript: return (event.keyCode == 69 || event.keyCode == 190 || event.keyCode == 189 || event.keyCode == 187) ? false : true"">
                  </div>
                  <div class="mb-3">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="cb1" name="" required>
                      <label class="custom-control-label" for="cb1"> Accept <a href="https://www.digitalstorz.com/terms-conditions.html" target="_blank">Terms and Conditions</a></label>
                    </div>
                  </div>
        
                  <div class="mb-3">
                    <input type="submit" name='submit' value="REGISTER" class="btn btn-block text-uppercase">
                     
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

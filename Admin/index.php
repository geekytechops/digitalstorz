<?php
$mess='';
	if(isset($_REQUEST['q'])){
		$m=$_REQUEST['q'];	
		if($m==1){
			$mess="No User Found..";
		}else if($m==2){
			$mess="Password Given Was Wrong";
		}else if($m==3){
			$mess="Password Reset Completed Successfully.";
		}else if($m==4){
			$mess="Password Update Failed.. Please contact Admin.";
		}else if($m==5){
			$mess="Mail Error.. Please contact Admin.";
		}else if($m==6){
			$mess="Session Timed Out.. Please try again.";
		}
		else if($m==7){
			$mess="User is Inactive.. Please contact Admin.";
		}
		else if($m==8){
			$mess="Subscription Plan Expired, Contact your Admin.";
		}
	}
	
	if(isset($_REQUEST['reg'])){
	  
			$mess2="<br><h5 style='color:green'>Your Registration is Successful.. Please Login..</h5>";
	
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/x-icon" href="./css/favicon1.jpeg">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/ds-login-style.css">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>DigitalStorz.com</title>
    
    <script type="text/javascript">
            // Form validation code for SIGN UP
            function validete()
            {
				if (document.login_form.user.value == "")
                {
                    document.login_form.user.focus();
                    return false;
                }

                if (document.login_form.pass.value == "")
                {
                    document.login_form.pass.focus();
                    return false;
                }
            }
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
    <!--<header>
      <div class="container">
   
      <a href="https://www.digitalstorz.com/"><img style="width:181px;padding-left:13px;height:23px" src="./css/ds_logo.PNG"></a>
      <h4><a href="https://www.digitalstorz.com/" >DigitalStorz.com</a></h4>

      </div>
   </header>-->
   <header>
      <div class="container">
   
      <h4><a href="https://www.uat.digitalstorz.com/">UAT DigitalStorz.com</a></h4>

      </div>
   </header>
    <div class="loginform">

        <div class="container">
          <div class="row px-3">
            <div class="col-lg-10 col-xl-9 card flex-row mx-auto px-0">
              <!-- <div class="img-left d-none d-md-flex"></div> -->
        
              <div class="card-body">
                <h4 class="title text-center mt-4">
                  Login to your Dashboard
                </h4>
                <form class="form-box px-3" name="login_form" onpaste="return false;" ondrop="return false;" autocomplete="off" method="post" action="./login_check.php" onsubmit="return validete()">
                  <div class="form-input">
                    <span><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                    <!--<input type="text" name="user" maxlength="10" placeholder="Enter Mobile Number"  required onkeypress="return onlyNumberKey(event)">-->
                    <input type="number" name="user"  placeholder="Enter Mobile Number"  required pattern="[0-9]{10}" onkeypress="if(this.value.length==10) return false;"  onkeydown="javascript: return (event.keyCode == 69 || event.keyCode == 190 || event.keyCode == 189 || event.keyCode == 187) ? false : true"  >
                  </div>
                  <div class="form-input">
                    <span><i class="fa fa-key"></i></span>
                    <input type="password" id='pass' name="pass" value="" placeholder="Password" required>
                  </div>
        
                    <div class="mb-3">
                    <div class="custom-control custom-checkbox">
                      <!--<input type="checkbox" class="custom-control-input" id="cb1" name="">
                      <label class="custom-control-label" for="cb1">Remember me</label>-->
                      <h5 style="text-align:center; color:red;"> <?php echo $mess.' '.$mess2;?></h5>
                    </div>
                  </div>
        
                  <div class="mb-3">
                    <input type="submit" name="submit" value="LOGIN" class="btn btn-block text-uppercase" >
                      
                    
                  </div>
        
                  <div class="text-right">
                    <a href="./forgot-password.php" class="forget-link">
                      Forgot Password?
                    </a>
                  </div>
        
                  <!-- <div class="text-center mb-3">
                    or login with
                  </div> -->
        
                  <!-- <div class="row mb-3 text-center">
                    <div class="col-4">
                      <a href="#" class="btn btn-block btn-social btn-facebook">
                        facebook
                      </a>
                    </div>
        
                    <div class="col-4">
                      <a href="#" class="btn btn-block btn-social btn-google">
                        google
                      </a>
                    </div>
        
                    <div class="col-4">
                      <a href="#" class="btn btn-block btn-social btn-twitter">
                        twitter
                      </a>
                    </div>
                  </div> -->
        
                  <hr class="my-4">
        
                  <div class="text-center mb-2">
                    Don't have an account?
                    <a href="https://www.uat.digitalstorz.com/user-registration.php" class="register-link">
                      Register here
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

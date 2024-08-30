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
	}
	
	if(isset($_REQUEST['reg'])){
	  
			$mess2="<br><h1 style='color:green'>Your Registration is Successful.. Please Login..</h1>";
	
	}
?>
<html>
<head>
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
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
            
            function numbersonly(e){
			    //alert("hi");
				var unicode=e.charCode? e.charCode : e.keyCode
				if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
				if (unicode<48||unicode>57) //if not a number
				if (document.login_form.user.value < 10)
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
    
    function ShowPassword2() {
  var y = document.getElementById("pass");
  if (y.type === "password") {
    y.type = "text";
  } else {
    y.type = "password";
  }
}
</script>
</head>
<body>
	<div class="header">
		&nbsp;&nbsp;&nbsp;&nbsp;DigitalStorz.com
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">
<div class="left_container">
			<div class="menu_heading">&#8803;&nbsp;&nbsp;MENU</div>
			<div id='cssmenu'>
				<ul>
				    <li class='active'><a href='https://www.digitalstorz.com'><span><img src="../images/home.png">&nbsp;&nbsp;Home</span></a></li>
                    <li><a href='https://www.digitalstorz.com/Admin/index.php'><span><img src="../images/account.png">&nbsp;&nbsp;Login</span></a></li>
				    <li><a href='https://www.digitalstorz.com/user-registration.php'><span><img src="../images/account.png">&nbsp;&nbsp;Register</span></a></li>
				</ul>
			</div>
		</div>
		<div class="right_container_index">
			<div class="page_title_div"><h1>Store Admin/Staff Login</h1> <?php echo $mess2;?></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Login &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $mess;?></div>
				
				<div class="content_holder_body">
				<form name="login_form" onpaste="return false;" ondrop="return false;" autocomplete="off" method="post" action="./login_check.php" onsubmit="return validete()">
					
					<div class="txt_lable">Mobile Number :</div>
					<!--<div><input type="text"  name="user" value="" autofocus  maxlength="10" onkeypress="return numbersonly(event)"></div>-->
					<div><input type="text" placeholder="Only Numbers Allowed"  name="user" value="" autofocus  maxlength="10" onkeypress="return onlyNumberKey(event)"></div>
					
					<div class="txt_lable">Password :</div>
					<div><input class="text_box" type="password" id='pass' name="pass" value=""><input type="checkbox" onclick="ShowPassword2()">Show Password</div>
				
					<div class="submit_button_div" ><input class="submit_button" type="submit" name="submit" value="&nbsp;&nbsp;Submit&nbsp;&nbsp;" /></div>
					
				</form>
				<div style="font-weight:bold;padding-top:40px;padding-bottom:20px;"><a href="./forgot-password.php">Forgot Password</a></div>
				</div>
				
		</div>
	</div>
</body>
</html>
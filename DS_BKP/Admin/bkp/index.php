<?php
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
    </script>
</head>
<body>
	<div class="header">
		<!--<a href="http://www.kolorsmobileservices.com/">&nbsp;&nbsp;&nbsp;&nbsp;Kolors Mobile Services</a>-->
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">

		<div class="right_container">
			<div class="page_title_div"><h1>Admin Login</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Login &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $mess;?></div>
				
				<div class="content_holder_body">
				<form name="login_form" method="post" action="./login_check.php" onsubmit="return validete()">
					
					<div class="txt_lable">UserName :</div>
					<div><input type="text" name="user" value="" autofocus></div>
					
					<div class="txt_lable">Password :</div>
					<div><input class="text_box" type="password" name="pass" value=""></div>
				
					<div class="submit_button_div"><input class="submit_button" type="submit" name="submit" value="&nbsp;&nbsp;Submit&nbsp;&nbsp;" /></div>
				</form>
				</div>
		</div>
	</div>
</body>
</html>
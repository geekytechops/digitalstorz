<?php
session_start();
if(isset($_SESSION['session_retail_username']) && isset($_SESSION['session_retail_password'])){
include("./Admin/dbconnect.php");
$page_no=5;
?>
<html>
<head>
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="../js/script.js"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
	<script type="text/javascript">
            // Form validation code for SIGN UP
            function validate()
            {

				if (document.ret_sup.name.value == "")
                {
                    document.ret_sup.name.focus();
					alert("Enter Name.");
                    return false;
                }
				if (document.ret_sup.ph_no.value == "")
                {
                    document.ret_sup.ph_no.focus();
					alert("Enter Contact No.");
                    return false;
                }
				if (document.ret_sup.query.value == "")
                {
                    document.ret_sup.query.focus();
					alert("Enter query.");
                    return false;
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
			<?php include("./retailer-menu.php")?>
		</div>
		<div class="right_container">
			<div class="page_title_div"><h1>Retailer Help Desk</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Write Your Query</div>
				
				<div class="content_holder_body">
				<form name="ret_sup" action="./retailer-support.php" method="post" onsubmit="return validate()">
					<div class="txt_lable">Name :</div>
					<div><input type="text" name="name" value=""></div>
					
					<div class="txt_lable">Phone No :</div>
					<div><input type="text" name="ph_no" value=""></div>
				
					<div class="txt_lable">Your Query :</div> 
					<div><textarea name="query"></textarea></div>
					<div class="submit_button_div"><input type="submit" name="submit" value="&nbsp;&nbsp;Submit Query&nbsp;&nbsp;"></div>
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
}else{
header('Location: ./retail-login.php');
}
?>
	<?php 
date_default_timezone_set("Asia/Kolkata");
session_start();
//print_r($_SESSION);
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
$session_store_name=$_SESSION['session_store_name'];    

$mess='';
	if(isset($_REQUEST['q'])){
		$m=$_REQUEST['q'];	
		if($m=='Success'){
			$mess="<span style='color:green'>&nbsp;&nbsp;Email Sent Successfully..</span>";
		}else if($m="Error"){
			$mess="<span style='color:red'>&nbsp;&nbsp;Error In Sending Email.. Contact Admin Digital Storz.</span>";
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
	
	<style>
table, td, th {  
  border: 1px solid #ddd;
  text-align: left;
}

table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  padding: 15px;
}
</style>

</head>
<body>
    <div id="loader"></div>  
	<div class="header">
		<span class="title_grad">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $session_store_name;?></span> <span style="font-size:14px; color:yellow;">Powered By DigitalStorz.com</span>
		<div style="float:right; font-family: 'Trebuchet MS', sans-serif; font-weight:bold; font-size:17px; color:#ECFA12; padding-right:15px; padding-top:10px;" ><?php echo $_SESSION['session_staff_name'];?> (<?php echo $_SESSION['session_user_role']?>)</div>
	</div>
	
	<div class="main_container">
			<?php include("kol-mob-entry-menu.php");?>
		<div class="right_container">
			<div class="page_title_div"><h1>GENERATE INVOICE USING</h1></div>
			<br>
			<h1> <?php echo $mess?></h1>
			<div class="content_holder">
				<!--<a href="./send-invoice.php"><div style="color:#E4E5E8; background:#0202C2;text-align:center; border:1px solid #154FF5; border-radius:3px; width:200px; margin:20px;padding:20px; font-size:25px; float:left;">JOB ID</div></a>-->
			    <a href="./send-invoice-by-phone.php"><div style="color:#E4E5E8; background:#0202C2;text-align:center; border:1px solid #154FF5; border-radius:3px; width:220px; margin:20px;padding:20px; font-size:25px; float:left;">PRINT</div></a>
			    <a href="./send-email-invoice.php"><div style="color:#E4E5E8; background:#0202C2;text-align:center; border:1px solid #154FF5; border-radius:3px; width:200px; margin:20px;padding:20px; font-size:25px; float:left;">SEND EMAIL</div></a>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php
mysql_close($connection);
}else{
header('Location: ./index.php');
}
?>
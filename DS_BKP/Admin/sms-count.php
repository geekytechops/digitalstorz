<?php
session_start();
//print_r($_SESSION);
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$session_store_name=$_SESSION['session_store_name'];
$session_store_id=$_SESSION['session_store_id'];
?>
<html>
<head>
	<link href="https://digitalstorz.com/css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
<style>


</style>

</head>
<body>
	<div class="header">
		<span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $session_store_name;?> <span style="font-size:14px; color:yellow;">Powered By DigitalStorz.com</span></span>
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">
		<?php include("kol-mob-entry-menu.php");?>
		<div class="right_container">
			<div class="page_title_div"><h1>Welcome <?php echo $_SESSION['session_staff_name'];?></h1></div>

			<div class="content_holder">
			    <table class="order_hisory_table">
			        <tr style="background:#C0BEBE;"><td>Store ID</td><td>Store Name</td><td>Store Address</td><td>Used SMS Count</td></tr>
            <?php 
                    if($_SESSION['session_user_role']=='superadmin'){
                        $sql_msg_count="SELECT * FROM `stores`";
                    }else{
                        $sql_msg_count="SELECT * FROM `stores` WHERE store_id=".$session_store_id;
                    }
                    
                    
                    //echo $sql_msg_count;
			        $query_msg_count=mysql_query($sql_msg_count);
			        while($result_msg_count=mysql_fetch_array($query_msg_count)){
			            //print_r($result_msg_count);
                                                echo '<tr>
															<td>'.$result_msg_count['store_id'].'</td>
															<td>'.$result_msg_count['store_name'].'</td>
															<td>'.$result_msg_count['store_address'].'</td>
															<td>'.$result_msg_count['message_sent_count'].'</td>
													</tr>';

					}
			        
            ?>
            </table>
			</div>
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
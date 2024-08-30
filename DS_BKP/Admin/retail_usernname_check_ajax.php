<?php
include("../Admin/dbconnect.php");
	
	//Checking Username
	if(isset($_GET["empid"])){
	session_start();
	$session_store_id=$_SESSION['session_store_id'];
		$q=$_GET["empid"];
		$sql="select customer_name from adm_cust_mob_add where cust_contact='".$q."' AND `store_id`='".$session_store_id."' ORDER BY `entry_id` DESC LIMIT 1";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		  {
			echo $row['customer_name'];
		  }
		  //$row = mysql_fetch_array($result)
		  //echo $row['customer_name'];
		mysql_close($connection);
	}
	
	//Checking EmailId
	if(isset($_GET["email"])){
		$x=$_GET["email"];
		$sql1="select * from cust_kolors_retail_users where email_id='".$x."'";
		$result1 = mysql_query($sql1);
		while($row1 = mysql_fetch_array($result1))
		  {
			echo $row1['email_id'];
		  }
		mysql_close($connection);
	}


?>
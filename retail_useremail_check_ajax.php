<?php
include("./Admin/dbconnect.php");
	//Checking EmailId
	if(isset($_GET["email"])){
		$x=$_GET["email"];
		$sql1="SELECT * FROM `cust_kolors_users_list` WHERE `staff_email`='".$x."'";
		$result1 = mysql_query($sql1);
		while($row1 = mysql_fetch_array($result1))
		  {
			echo $row1['staff_email'];
		  }
		mysql_close($connection);
	}


?>
<?php
include("./Admin/dbconnect.php");
	
	//Checking Username
	if(isset($_GET["q"])){
		$q=$_GET["q"];
		$sql="select * from cust_kolors_users_list where username='".$q."'";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		  {
			echo $row['username'];
		  }
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
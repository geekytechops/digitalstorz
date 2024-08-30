

<?php
	extract($_REQUEST);
	include('./dbconnect.php');
	if($submit){
		$username=$_REQUEST['user'];
		$password=$_REQUEST['pass'];
		
		$sql1="SELECT * FROM `cust_kolors_users_list` WHERE username='".$username."'";
//echo $sql1; exit;
		$query1=mysql_query($sql1);
		
		$num_rows_1=mysql_num_rows($query1);
		if($num_rows_1==1){
			$result1=mysql_fetch_array($query1);
			
			$og_username=$result1['username'];
			$og_password=$result1['password'];
			
			if($og_username==$username && $og_password==$password){
				session_start();
				$_SESSION['session_username']=$og_username;
				$_SESSION['session_password']=$og_password;
				header('Location: ./admin-home.php');
			}else{
				header('Location: ./index.php?q=2');
			}			
		}else{
			header('Location: ./index.php?q=1');
		}	
	}else{
		header('Location: ./index.php');
	}
?>
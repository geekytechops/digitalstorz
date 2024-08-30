<?php
	extract($_REQUEST);
	include('./Admin/dbconnect.php');

	if($submit){
		if($_POST['remember']) {
			setcookie('remember_me_usr', $_POST['username_retail'], $year);
			setcookie('remember_me_pwd', $_POST['password_retail'], $year);
		}elseif(!$_POST['remember']) {
			if(isset($_COOKIE['remember_me_usr'])) {
				$past = time() - 100;
				setcookie(remember_me_usr, gone, $past);
				setcookie(remember_me_pwd, gone, $past);
			} 
		}
		//exit;
		$username=$_REQUEST['username_retail'];
		$password=$_REQUEST['password_retail'];
		
		$sql1="SELECT * FROM `cust_kolors_retail_users` WHERE username='".$username."' AND status=1";
		//echo $sql1;		exit;
		$query1=mysql_query($sql1);
			
		$num_rows_1=mysql_num_rows($query1);

		if($num_rows_1==1){
			$result1=mysql_fetch_array($query1);
			
			$og_username=$result1['email_id'];
			$og_username_login=$result1['username'];
			$og_password=$result1['password'];
			$retailer_name=$result1['retailer_name'];
			$contact_no=$result1['contact_no'];
			$retailer_id=$result1['retailer_id'];
		
			if($og_username_login==$username && $og_password==$password){
				session_start();
				$_SESSION['session_retail_username']=$og_username;
				$_SESSION['session_retail_username_login']=$og_username_login;
				$_SESSION['session_retail_password']=$og_password;
				$_SESSION['session_retailer_name']=$retailer_name;
				$_SESSION['session_retailer_contact']=$contact_no;
				$_SESSION['session_retailer_account_id']=$retailer_id;
				header('Location: ./retailer-home.php');
			}else{ 
				header('Location: ./retail-login.php?q=2');
			}			
		}else{
			//Blocked users
			$sql2="SELECT * FROM `cust_kolors_retail_users` WHERE username='".$username."' AND status=0";
			$query2=mysql_query($sql2);
			$num_rows_2=mysql_num_rows($query2);
			if($num_rows_2==1){
				header('Location: ./retail-login.php?q=3');
			}else{
				header('Location: ./retail-login.php?q=1');
			} 
		}	
	}else{
		header('Location: ./retail-login.php');
	}
?>
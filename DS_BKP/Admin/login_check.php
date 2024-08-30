<?php
	extract($_REQUEST);
	include('./dbconnect.php');
	if($submit){
		$username=$_REQUEST['user'];
		$password=$_REQUEST['pass'];
		$supplied_password = $password;
        $hashed_passed = password_hash($supplied_password,PASSWORD_DEFAULT);
        //echo $hashed_passed; exit;

		$sql1="SELECT * FROM `cust_kolors_users_list` WHERE username='".$username."'";
        //echo $sql1; exit;
		$query1=mysql_query($sql1);
		$num_rows_1=mysql_num_rows($query1);
		
		//echo 	$num_rows_1; exit;
		if($num_rows_1==1){
		    $result1=mysql_fetch_array($query1);
		    //print_r($result1);
		    if($result1['status']=='1'){
		    
			//print_r($result1);exit;
			$og_username=$result1['username'];
			$og_password=$result1['password'];
			$user_role=$result1['user_role'];
			$staff_name=$result1['staff_name'];
			$store_id=$result1['store_id'];
			$user_id=$result1['user_id'];
			$store_name=$result1['store_name'];
			$verify = password_verify($supplied_password, $og_password);
			//if($og_username==$username && $og_password==$password){
			    
			if($verify){
				session_start();
				$_SESSION['session_username']=$og_username;
				$_SESSION['session_password']=$og_password;
				$_SESSION['session_user_role']=$user_role;
				$_SESSION['session_staff_name']=$staff_name;
				$_SESSION['session_store_id']=$store_id;
				$_SESSION['session_user_id']=$user_id;
				$_SESSION['session_store_name']=$store_name;
				//exit;
				
				if($og_username==='superadmin'){
				    header('Location: ./superadmin-home.php');
				}else{
				    header('Location: ./admin-home.php'); 
				}
				  
		    }else{
		        header('Location: ./index.php?q=2');
		    }
			
			}else{
			    $og_username=$result1['username'];
			    $og_password=$result1['password'];
			    $user_role=$result1['user_role'];
			    $user_profilename=$result1['staff_name'];
			    $verify = password_verify($supplied_password, $og_password);
			      if($verify){
			        session_start();
			        $_SESSION['session_username_activation']=$og_username;
				    $_SESSION['session_password_activation']=$og_password;
				    $_SESSION['session_user_role_activation']=$user_role;
				    $_SESSION['session_user_profile_name']=$user_profilename;
				    if($user_role=='admin'){
				    header('Location: ./user-activation.php');
				    }elseif($user_role=='staff'){
				    header('Location: ./index.php?q=7');    
				    }
		          }else{
		            header('Location: ./index.php?q=2');
		          }
			}			
		}else{
			header('Location: ./index.php?q=1');
		}	
	}else{
		header('Location: ./index.php');
	}
?>
<?php
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
    //print_r($_SESSION);
    echo "<br><br><br><br><br><br><br><br><br><br><br><br><br>";
    echo "<h1 style='text-align:center;color:blue';>Already Logged in as ".$_SESSION['session_username'].", please <a style='color:red' href='./logout.php'>LOGOUT</a> and Login.<h1>";
}else{
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
		    //echo $result1['status'];
		    //exit;
		    if($result1['status']=='1'){
		    
			//print_r($result1);exit;
			$og_username=$result1['username'];
			$og_password=$result1['password'];
			$user_role=$result1['user_role'];
			$staff_name=$result1['staff_name'];
			$store_id=$result1['store_id'];
			$user_id=$result1['user_id'];
			$store_name=$result1['store_name'];
			$user_subscription_plan=$result1['subscription_plan'];
			$verify = password_verify($supplied_password, $og_password);
			//if($og_username==$username && $og_password==$password){
			    $check=1;
			if($verify || $check==1){
			    session_start();
			    //echo "hi";exit;
			    $_SESSION['session_username']=$og_username;
		        
		        //here starts	    
			    $sql_plan1='SELECT * FROM `cust_kolors_users_list` WHERE `username`="'.$_SESSION["session_username"].'" ';
                $query_plan1=mysql_query($sql_plan1);
                $result_plan1=mysql_fetch_array($query_plan1);
                //echo $sql_plan1;

                $subscription_plan=$result_plan1['subscription_plan'];
                $subscription_date=$result_plan1['subscription_date'];

                if($subscription_plan=="trail"){
                    $active_days=7;
                }elseif($subscription_plan=="monthly"){
                    $active_days=30;
                }elseif($subscription_plan=="quarterly"){
                    $active_days=90;
                }elseif($subscription_plan=="halfyearly"){
                    $active_days=183;
                }elseif($subscription_plan=="annual"){
                    $active_days=365;
                }elseif($subscription_plan=="trail-mobialive"){
                    $active_days=23;
                }

                $date_sub = $subscription_date;
                $date_end= date('Y-m-d', strtotime($subscription_date. ' + '.$active_days.' days'));
                $date_now = date("Y-m-d");
                
                echo $date_sub;
                echo $date_end.'  ';
                //echo $date_now;
                //exit;
                if ($date_end >= $date_now) { //when you have active plan
                //echo "active plan";exit;
                    session_start();
				    $_SESSION['session_username']=$og_username;
				    $_SESSION['session_password']=$og_password;
				    $_SESSION['session_user_role']=$user_role;
				    $_SESSION['session_staff_name']=$staff_name;
				    $_SESSION['session_store_id']=$store_id;
				    $_SESSION['session_user_id']=$user_id;
				    $_SESSION['session_store_name']=$store_name;
				    $_SESSION['session_user_subscription_plan']=$user_subscription_plan;
				    $curent_time = date('Y-m-d H:i:s');
				    $device_type=$_SERVER["HTTP_USER_AGENT"];
				    $device_id="";
				    $device_name="";
				    $current_session_id=session_id();
				    $user_ip_address=$_SERVER['REMOTE_ADDR'];
				    //exit;
				    
				    //Adding login activity to Login_Activity table
				    $sql_ins_login_track="INSERT INTO `login_activity`(`user_name`, `login_time`, `device_type`, `device_id`, `device_name`, `session_id`,`ip_address`) VALUES 
		            ('".$og_username."','".$curent_time."','".$device_type."','".$device_id."','".$device_name."','".$current_session_id."','".$user_ip_address."')";
                    $query_ins_login_track=mysql_query($sql_ins_login_track);
				    
				
				    if($og_username==='superadmin'){
				        header('Location: ./superadmin-home.php');
				    }else{
				        if($_SESSION['session_store_id']=='' && $_SESSION['session_store_name']==''){
				            header('Location: ./create-store.php');    
				        }else{
				            header('Location: ./admin-home.php');    
				        }
				    }
                } else { // if user has plan expired
                    //echo "Expired plan";exit;
                    session_start();
			        $_SESSION['session_username_activation']=$og_username;
				    $_SESSION['session_password_activation']=$og_password;
				    $_SESSION['session_user_role_activation']=$user_role;
				    $_SESSION['session_user_profile_name']=$user_profilename;
				    if($user_role=='admin'){
				    header('Location: ./user-activation.php'); 
				    }else{
				       header('Location: ./index.php?q=8'); 
				    }
                }
            //here ends
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
}
?>
<?php
	$sql_retailer_credits="SELECT `retailer_credits` FROM `cust_kolors_retailer_credits` WHERE `retailer_id`=".$_SESSION['session_retailer_account_id'];
	$query_retailer_credits=mysql_query($sql_retailer_credits);
	$result_retailer_credits=mysql_fetch_array($query_retailer_credits);
	if (isset($result_retailer_credits['retailer_credits'])){
		$ret_credits_avail=$result_retailer_credits['retailer_credits'];
	}else{
		$ret_credits_avail=0;
	}  
?> 
			<div class="menu_heading">&#8803;&nbsp;&nbsp;MENU</div>
			<div id='cssmenu'> 
				<ul>
				   <li><a href='#'><span>&nbsp;<img src="../images/rupee.png">&nbsp;&nbsp;&nbsp;Credits: <?php echo $ret_credits_avail;?>&nbsp;INR</span></a></li>
				   <li><a href='./retailer-home.php'><span><img src="../images/home.png">&nbsp;&nbsp;Dashboard</span></a></li>
				   <li><a href='./mobile-unlocks-retail.php'><span><img src="../images/shopping-cart.png">&nbsp;&nbsp;Place Order</span></a></li>
				   <li><a href='./retailer-order-history.php'><span><img src="../images/history.png">&nbsp;&nbsp;Order History</span></a></li>
				   <li><a href='./service-list.php'><span><img src="../images/list-icon.png">&nbsp;&nbsp;&nbsp;List Of Services</span></a></li>
				   <li><a href='./retailer-my-account.php'><span><img src="../images/account.png">&nbsp;&nbsp;My Account</span></a></li>
				   <li><a href='./profile-settings.php'><span><img src="../images/account.png">&nbsp;&nbsp;Profile Settings</span></a></li>
				   <li><a href='./retailer-support.php'><span><img src="../images/account.png">&nbsp;&nbsp;Support</span></a></li>
				   <li><a href='./logout.php'><span>&#8801;&nbsp;&nbsp;Logout</span></a></li>
				</ul>
			</div>

				
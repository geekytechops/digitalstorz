<style>
.dropbtn {
  background-color: #3e8e41;
  color: white;
  padding: 10px;

  font-size: 16px;
  border:none;
  cursor: pointer;
  font-family: 'Trebuchet MS', sans-serif;
}

.dropdown {
  position: relative;
  display: inline-block;
  float:right;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #160584;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: #fff;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  font-family: 'Trebuchet MS', sans-serif;
}

.dropdown-content a:hover {background-color: #D3D6E3; color: #160584;}

.dropdown:hover .dropdown-content {
  display: block;
}

.dropdown:hover .dropbtn {
  background-color: #3e8e41;
}
</style>
<div class="admin_menu_holder">
    
    <?php
	if($_SESSION['session_user_role']=='admin' || $_SESSION['session_user_role']=='staff'){
	?>
	<div class="admin_menu_link"><a href="admin-home.php">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-home'></i></i>Home&nbsp;&nbsp;|</a></div>
	<div class="admin_menu_link <?php echo $active?> "><a href="add-cust-mobile.php">Add Job&nbsp;&nbsp;|</a></div>
	<div class="admin_menu_link"><a href="view-cust-mobile-entry.php?result_key=pend">View Jobs &nbsp;&nbsp;|</a></div>
	<!--<div class="admin_menu_link"><a href="mobile-delivery.php">Delivery &nbsp;&nbsp;|</a></div>-->
	<?php
	if($_SESSION['session_user_role']=='admin'){
	?>
	<div class="admin_menu_link"><a href="./transactions.php">View Transactions&nbsp;&nbsp;|</a></div>
	<div class="admin_menu_link"><a href="./add-defect.php">Defects&nbsp;&nbsp;|</a></div>
	<?php
	}
	?>
	<div class="admin_menu_link"><a href="./generate-invoice.php">Print Invoice&nbsp;&nbsp;|</a></div>
	<div class="admin_menu_link"><a href="./logout.php">Logout</a></div>
	<?php
	}if($_SESSION['session_user_role']=='superadmin'){
	?>
	<div class="admin_menu_link"><a href="admin-home.php">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-home'></i></i>Home&nbsp;&nbsp;|</a></div>
	<div class="admin_menu_link"><a href="./add-defect.php">Manage Defects&nbsp;&nbsp;|</a></div>
	<div class="admin_menu_link"><a href="./subscription-details.php">User Plan Details&nbsp;&nbsp;|</a></div>
	<?php
	}
	?>
	<div style="float:right; padding-right:25px;"><img src="./img/admin.png" width="40" height="38"></div>
    <!--<div style="float:right; font-family: 'Trebuchet MS', sans-serif; font-weight:bold; font-size:17px; color:#ECFA12; padding-right:15px; padding-top:10px;" ><?php echo $_SESSION['session_staff_name'];?> (<?php echo $_SESSION['session_user_role']?>)</div>-->
</div>
  <div class="dropdown">
  <button class="dropbtn">Manage Account</button>
  <div class="dropdown-content">
  <a href="change-password.php">Change Password</a>
  <?php
	if($_SESSION['session_user_role']=='admin' || $_SESSION['session_user_role']=='superadmin'){
	?>
  <a href="manage-users.php">Manage Users</a>
  <a href="manage-store.php">Manage Store</a>
  <a href="sms-count.php">SMS Count</a>
  <?php
	}
	?>
  <a href="logout.php">Logout</a>
  </div>
</div>

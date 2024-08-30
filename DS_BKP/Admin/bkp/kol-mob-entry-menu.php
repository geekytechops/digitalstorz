<div class="admin_menu_holder">
	<div class="admin_menu_link"><a href="admin-home.php">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Home&nbsp;&nbsp;|</a></div>
	<div class="admin_menu_link"><a href="add-cust-mobile.php">Add Mobile&nbsp;&nbsp;|</a></div>
	<div class="admin_menu_link"><a href="view-cust-mobile-entry.php?result_key=pend">View Entries &nbsp;&nbsp;|</a></div>
	<div class="admin_menu_link"><a href="mobile-delivery.php">Delivery &nbsp;&nbsp;|</a></div>
	<?php
	if($_SESSION['session_username']=='admin'){
	?>
	<div class="admin_menu_link"><a href="./transactions.php">View Transactions&nbsp;&nbsp;|</a></div>
	<div class="admin_menu_link"><a href="./add-defect.php">Add Defects&nbsp;&nbsp;|</a></div>
	<?php
	}
	?>
	<div class="admin_menu_link"><a href="./prod-sale.php">SALE&nbsp;&nbsp;|</a></div>
	<div class="admin_menu_link"><a href="./view-sale.php">Sale History&nbsp;&nbsp;|</a></div>
	<div class="admin_menu_link"><a href="logout.php">Logout &nbsp;&nbsp;|</a></div>
	<div class="admin_menu_link">&nbsp;&nbsp; >>>>>>>>>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="f3f3f3">Welcome <?php echo $_SESSION['session_username']; ?>,</font></div>
</div>
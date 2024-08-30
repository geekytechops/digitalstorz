<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php
$q = intval($_GET['q']);

$con = mysqli_connect('localhost','kol14747_admin','kolors@9c','kol14747_kolors');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"ajax_demo");
$sql="SELECT `service_name`, `retail_price`, `duration` FROM `cust_kolors_services_list` WHERE `service_id` = '".$q."'";
$result = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($result)) {
	echo"
		<div class='content_holder_order_details'>
			<div style='color:blue; font-size:14px; float:right;'>Order Will Take : ". $row['duration'] ." To Complete</div><br>
			<div style='color:red; font-weight:bold;'>Please Note:</div>
			<div style='color:green'>Service You have Selected : ". $row['service_name'] ."</div>
			
			<div style='color:green'>You Will be charged : INR ". $row['retail_price'] ." from your Credits.</div>
			<br>
			<div> 
				<p><b>NO REFUND IN CASE OF</b> Wrong Operator, Imei, Country, already Unlocked or any other user errors or phone is Relocked by operator or FMI ON.</p>
				<p>In the above cases we are not responsible to user.</p>
				<p>Processing your order may delay some times, No cancellation once order is raised from user end.</p>
				 
				<p>No Cancellation in case Order is delayed, in such cases user will be intimated order status.</p>
				<br>
				<p>By Placing order you are accepting all the above terms and conditions.</p>
			</div>
		</div> 
	";
}
echo "</table>";
mysqli_close($con);
?>
</body>
</html>
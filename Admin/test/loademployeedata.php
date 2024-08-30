<?php
include("./dbconnect.php");
$empid = $_GET['empid'];

if (isset($empid)) {
    $query = " SELECT * FROM cust_kolors_users_list WHERE user_id = '$empid'";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);
    echo $row['password'];
  
}
mysql_close($connection); // Connection Closed
?>     
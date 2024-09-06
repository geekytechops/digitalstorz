<?php
error_reporting(0);
session_start();
 date_default_timezone_set("Asia/Kolkata");
$username = "root";  //chanege if needed
$password = "";  //chanege if needed
$host_name = "localhost"; //chanege if needed

//$connection = mysqli_connect($host_name, $username, $password);
$connection = mysql_connect($host_name, $username, $password);

//echo $connection;
//echo "test";exit;
if ($connection) {
    //echo 'Connected To Database..';
    $database = mysql_query("Use kol14747_UAT_digitalstorz");
    if ($database) {
        //echo "Database Selected..";
    } else {
        echo "Failed To Select Database..";
       // echo mysql_error($connection);

    }
} else {
    echo 'Could Not Connect To Database..'.mysql_error();
	exit;
}
?>
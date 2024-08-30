<?php

 date_default_timezone_set("Asia/Kolkata");
$username = "kol14747_digitalstorz";  //chanege if needed
$password = "D!G!+@l$+0rEz9";  //chanege if needed
$host_name = "localhost"; //chanege if needed

//$connection = mysqli_connect($host_name, $username, $password);
$connection = mysql_connect($host_name, $username, $password);

if ($connection) {
    //echo 'Connected To Database..';
    $database = mysql_query("Use kol14747_digitalstorz");
    if ($database) {
        //echo "Database Selected..";
    } else {
        echo "Failed To Select Database..";
       // echo mysql_error($connection);

    }
} else {
    echo 'Could Not Connect To Database..';
	exit;
}
?>
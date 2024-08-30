<?php
 date_default_timezone_set("Asia/Kolkata");
$username = "root";  //chanege if needed
$password = "";  //chanege if needed
$host_name = "localhost"; //chanege if needed

$connection = mysql_connect($host_name, $username, $password);

if ($connection) {
    //echo 'Connected To Database..';
    $database = mysql_query("Use live3180_9cinemas");
    if ($database) {
        //echo "Database Selected..";
    } else {
        echo "Failed To Select Database..";
    }
} else {
    echo 'Could Not Connect To Database..';
	exit;
}

/*
$link = mysql_connect("localhost", "mysql_user", "mysql_password");
if (mysql_errno() == 1203) {
  // 1203 == ER_TOO_MANY_USER_CONNECTIONS (mysqld_error.h)
  header("Location: http://your.site.com/alternate_page.php");
  exit;
}
*/
?>
<?php
include("./dbconnect.php");
$select = "SELECT * FROM `cust_kolors_users_list`";
$result = mysql_query($select);

//$row = mysql_fetch_array($result);
//echo "test";
//print_r($row);
//exit;
$option = '';
while($row = mysql_fetch_array($result)){ 
    $option .= '<option value="'.$row['user_id'].'">'.$row['username'].'</option>';
}
?>
<html>
    <head>
        <title>Retrieve data from database using Ajax</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script type="text/javascript">
            function getData(empid, divid){
                $.ajax({
                    url: 'loademployeedata.php?empid='+empid, //call storeemdata.php to store form data
                    success: function(html) {
                        var ajaxDisplay = document.getElementById(divid);
                        //ajaxDisplay.innerHTML = html;
                        document.getElementById(divid).value= html;
                    }
                });
            }
        </script>
    </head>
    <body>
        <form method="post">
            <select name="empid" id="empid" onchange="getData(this.value, 'displaydata')">
              <?php
                echo $option;
              ?>
            </select>
            <input type="text" id="displaydata" value="">
            </div>
        </form>
    </body>
</html>    
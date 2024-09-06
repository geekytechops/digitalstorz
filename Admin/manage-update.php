<?php

include("./dbconnect.php");
if($_POST['formName']=='updateStaff'){
    $staffRole = $_POST['staffRole'];
    $userId = $_POST['userId'];
    $query = "UPDATE `cust_kolors_users_list` SET staff_role=$staffRole where user_id=$userId";
    // echo $query;
    $result = mysql_query($query);
    if($result){
       echo json_encode(array('status'=>'success','message'=>'User Role Changed Successfully'));
    }else{
        $error = mysql_error();
        echo json_encode(array('status'=>'success','message'=>$error));
    }
}
if($_POST['formName']=='addOtherStaff'){

$name= $_POST['name'];
$mobile= $_POST['mobile'];

$query = "INSERT INTO `other_staff` ( staff_name , staff_contact ) VALUES('$name' , '$mobile')" ; 
$result = mysql_query($query);
if($result){
   echo json_encode(array('status'=>'success','message'=>'New Staff Created Successfully'));
}else{
    $error = mysql_error();
    echo json_encode(array('status'=>'success','message'=>$error));
}

}

if($_POST['formName']=='mark_attendance'){
 $staffId = $_POST['staffId'];
 $attId = $_POST['attId'];
 $staffType = $_POST['staffType'];
 $startTime = $_POST['startTime'];
 $endTime = $_POST['endTime'];
 $dateTime = $_POST['dateTime'];
    
     $query = "UPDATE attendance
SET
  att_in_time = '$startTime',
  att_out_time = '$endTime'
WHERE att_id = $attId";
    $result = mysql_query($query);
    if($result){
       echo json_encode(array('status'=>'success','message'=>'Updated Successfully'));
    }else{
        $error = mysql_error();
        echo json_encode(array('status'=>'success','message'=>$error));
    }
}

if($_POST['formName']=='attendance'){
 $staffId = $_POST['staffId'];
 $staffType = $_POST['staffType'];
 $attendance = $_POST['attendance'];
 $dateTime = $_POST['dateTime'];
 if($dateTime==0){
    $nowDate = date('Y-m-d');    
 }else{
    $nowDate = $dateTime;
 }
$nowTime = date('H:i');

    $query = "INSERT INTO attendance(att_staff_id , att_in_time  ,att_date, staff_type , attendance ) VALUES ( $staffId, '$nowTime' , '$nowDate',  $staffType , $attendance  )";
    $result = mysql_query($query);
    if($result){
       echo json_encode(array('status'=>'success','message'=>'Updated Successfully'));
    }else{
        $error = mysql_error();
        echo json_encode(array('status'=>'success','message'=>$error));
    }
}
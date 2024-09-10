<?php

include("./dbconnect.php");
header('Content-Type: application/json');
$store_id=$_SESSION['session_store_id'];
$session_store_name=$_SESSION['session_store_name'];
$session_store_id=$_SESSION['session_store_id'];

$tableType = isset($_GET['tableType']) ? $_GET['tableType'] : '';

if($tableType=='all'){

    $sql_cust="SELECT * FROM `adm_cust_mob_add` WHERE delete_status !=1  AND store_id=".$store_id." ORDER BY entry_id DESC";

}else if($tableType=='pending'){
    $sql_cust="SELECT * FROM `adm_cust_mob_add` WHERE ( `status`='Pending' OR `status`='in-process' OR `status`='customer-approval' OR `status`='customer-approved' OR `status`='spare-part' ) AND delete_status !=1  AND store_id=".$store_id." ORDER BY entry_id DESC";
}else if($tableType=='completed'){
    $sql_cust="SELECT * FROM `adm_cust_mob_add` WHERE `status`='Completed' AND delete_status !=1  AND store_id=".$store_id." ORDER BY entry_id DESC";
}else if($tableType=='delivered'){
    $sql_cust="SELECT * FROM `adm_cust_mob_add` WHERE `status`='Delivered' AND delete_status !=1 AND rejected=0  AND store_id=".$store_id." ORDER BY entry_id DESC";
}else if($tableType=='rejected'){
    $sql_cust="SELECT * FROM `adm_cust_mob_add` WHERE `status`!='Delivered' AND `rejected`='1' AND delete_status !=1  AND store_id=".$store_id." ORDER BY entry_id DESC";
}else if($tableType=='delivery_rejected'){
    $sql_cust="SELECT * FROM `adm_cust_mob_add` WHERE `status`='Delivered' AND `rejected`='1' AND delete_status !=1  AND store_id=".$store_id." ORDER BY entry_id DESC";
}


$data = ["data" => []];

$query_cust=mysql_query($sql_cust);

while($result_cust=mysql_fetch_array($query_cust)){

    $mobile_def_sql='SELECT `defect_name` FROM `adm_mobile_defects` WHERE `defect_id`='.$result_cust['mobile_defect'];
    $mob_def_query=mysql_query($mobile_def_sql);
    $mob_def_result=mysql_fetch_array($mob_def_query);	
    
    if ($result_cust['mobile_defect_2']!=''){
    $mobile_def_sql2='SELECT `defect_name` FROM `adm_mobile_defects` WHERE `defect_id`='.$result_cust['mobile_defect_2'];
    $mob_def_query2=mysql_query($mobile_def_sql2);
    $mob_def_result2=mysql_fetch_array($mob_def_query2);	
    
    $defect_2=', '.$mob_def_result2['defect_name'];
    }else{
    $defect_2='';
    }	
    
    if ($result_cust['mobile_defect_3']!=''){
    $mobile_def_sql3='SELECT `defect_name` FROM `adm_mobile_defects` WHERE `defect_id`='.$result_cust['mobile_defect_3'];
    $mob_def_query3=mysql_query($mobile_def_sql3);
    $mob_def_result3=mysql_fetch_array($mob_def_query3);	
    
    $defect_3=', '.$mob_def_result3['defect_name'];
    }else{
    $defect_3='';
    }	
        if($result_cust['rejected']==0 && $result_cust['status']=='Delivered'){
            $del_msg_stat="Successful ";
        }elseif($result_cust['rejected']==1 && $result_cust['status']=='Delivered'){
            $del_msg_stat="Rejected ";
        }else{
            
        $del_msg_stat="";
        }
        //echo $result_key;
    $sql_get_name1="SELECT `staff_name` FROM `cust_kolors_users_list` WHERE `username`=".$result_cust['added_by'];
    $query_get_name1=mysql_query($sql_get_name1);
    $result_getname_addedby=mysql_fetch_array($query_get_name1);
    
    $sql_get_name2="SELECT `staff_name` FROM `cust_kolors_users_list` WHERE `username`=".$result_cust['repair_by'];
    //echo $sql_get_name2;
    $query_get_name2=mysql_query($sql_get_name2);
    $result_getname_repairby=mysql_fetch_array($query_get_name2);
    //echo $result_getname_repairby['staff_name'];
    $sql_get_name3="SELECT `staff_name` FROM `cust_kolors_users_list` WHERE `username`=".$result_cust['deliver_by'];
    $query_get_name3=mysql_query($sql_get_name3);
    $result_getname_delby=mysql_fetch_array($query_get_name3);

    if($result_cust['status']=='in-process'){
        $status = '<span class="badge bg-warning fs-6">In Process</span>';
    }else if($result_cust['status']=='customer-approval'){
        $status = '<span class="badge bg-secondary fs-6">Waiting for <br>Customer Approval</span>';
    }else if($result_cust['status']=='customer-approved'){
        $status = '<span class="badge bg-success fs-6">Customer Approved</span>';
    }else if($result_cust['status']=='spare-part'){
        $status = '<span class="badge bg-secondary fs-6">Waiting for <br>Spare Part</span>';
    }else{
        $status = $result_cust['status'];
    }

    $row = [
        "entry_id" => $result_cust['entry_id'],
        "received_date" => $result_cust['added_date'],
        "customer_name"=>$result_cust['customer_name'],
        "brand_model"=>$result_cust['mobile_name'],
        "status"=>$del_msg_stat.$status,
        "defects"=>$mob_def_result['defect_name'].$defect_2.$defect_3,
        "contact"=>$result_cust['cust_contact'].' / '.$result_cust['cust_alt_contact'],
        "action"=>'<a class="btn btn-outline-dark btn-sm" href="print-job.php?job_id='.$result_cust['entry_id'].'">Print</a>
        <a class="btn btn-outline-success btn-sm" href="add-cust-mobile-ui.php?entry_id='.$result_cust['entry_id'].'">View</a>
        <a class="btn btn-outline-info btn-sm" href="mobile-delivery-invoice-ui.php?delivery-id='.$result_cust['entry_id'].'">Instant Delivery</a>
        <a class="btn btn-outline-danger btn-sm" href="mobile-delivery-instant-reject-ui.php?delivery-id='.$result_cust['entry_id'].'&action=inst_rej_del">Instant Reject</a>',
    ];

    $data["data"][] = $row;

}

echo json_encode($data);
?>

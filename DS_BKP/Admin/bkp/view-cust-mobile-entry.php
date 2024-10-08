<?php 
date_default_timezone_set("Asia/Kolkata");
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$mess='';
if(isset($_REQUEST['result_key'])){
$result_key=$_REQUEST['result_key'];
}else{
$result_key='';
}
if(isset($_REQUEST['mode'])){
	$pr_id_ed=$_REQUEST['pr_id'];
	
	if($_REQUEST['mode']=='edit'){ // Action Edit Fetch Data
	exit;
		$sql_upd_pr="SELECT * FROM `adm_product_category` WHERE `p_cat_id`=".$pr_id_ed;
		$query_upd_pr=mysql_query($sql_upd_pr);
		$result_upd_pr=mysql_fetch_array($query_upd_pr);
		
		$upd_pr_id=$result_upd_pr['p_cat_id'];
		$upd_pr_name=$result_upd_pr['category_name'];

		$btn_value=" UPDATE ";
		$btn_name="update";
		
		
	}else if($_REQUEST['mode']=='del'){ // Action Delete
		$sql_disable_pr_id="UPDATE `adm_cust_mob_add` SET `delete_status`='1' WHERE entry_id=".$pr_id_ed;
		$query_disable_pr_id=mysql_query($sql_disable_pr_id);
		if($query_disable_pr_id){
			$mess="Record Deleted..";
		}else{
			$mess="Failed to Delete..";
		}
	}
}

if(isset($_REQUEST['submit'])){
$mobile_no_search=$_REQUEST['mobile_search'];
$cust_name_search=$_REQUEST['name_search'];

//echo $mobile_no_search;

if($mobile_no_search !=''){
    $sql_cust="SELECT * FROM `adm_cust_mob_add` WHERE `cust_contact`='".$mobile_no_search."' AND delete_status != '1'";
}elseif($cust_name_search!=''){
    $sql_cust="SELECT * FROM `adm_cust_mob_add` WHERE `customer_name`LIKE '%".$cust_name_search."%' AND delete_status != '1'";
}

$result_key="mobile_search";

}
?>
<html>
<head>
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
	<style>
.pagination{
    background-color: #fff;
    color: blue;
    padding: 10px;
} 
.pagination a{
	color: red;
	padding:7px;
	font-weight:bold;
}

</style>
	
	

</head>
<body>
	<div class="header">
		&nbsp;&nbsp;&nbsp;&nbsp;Kolors Mobile Services
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">
		<?php include("kol-mob-entry-menu.php");?>
		<div class="right_container_full">
			<div class="page_title_div"><h1>VIEW CUSTOMER ENTRIES</h1></div>
			
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;View / Update Customer entries &nbsp;&nbsp;&nbsp;<?php echo $mess;?></div>
				
				<div class="content_holder_body">
				
				<div> 
					<form name="mobile_search" method="post" action="./view-cust-mobile-entry.php" onsubmit="return validate()">
					Mobile: <input type="text" maxlength="10" name="mobile_search" value="">&nbsp;&nbsp;&nbsp;
					Name: <input type="text" name="name_search" value="">&nbsp;&nbsp;&nbsp;
					<input type="submit" name="submit" value="Search"> 
					</form>
				</div><br>
				
				<div class="content_holder_body">
				<a style="padding:8px; color:blue; font-weight:bold;" href="./view-cust-mobile-entry.php?result_key=all">All</a></font>
				<a style="padding:8px; color:blue; font-weight:bold;" href="./view-cust-mobile-entry.php?result_key=pend">Pending </a> 
				<a style="padding:8px; color:blue; font-weight:bold;" href="./view-cust-mobile-entry.php?result_key=comp">Completed </a> 
				<a style="padding:8px; color:blue; font-weight:bold;" href="./view-cust-mobile-entry.php?result_key=delv">Delivered </a>
				<a style="padding:8px; color:blue; font-weight:bold;" href="./view-cust-mobile-entry.php?result_key=rej">Rejected</a>
				
				</div>
			
				<table class="order_hisory_table">
				
											<tr class="table_heading">
														
														<td><b>Entry ID</b></td>
														<td><b>Recd Date</b></td>
														<td><b>Recd By</b></td>
														<td><b>Repair By</b></td>
														<td><b>Del By</b></td>
														<td><b>Customer Name</b></td>
														<td><b>Mobile Name & Model</b></td>
														<td><b>Defect</b></td>
														<td><b>Exp Delivery Date</b></td>
														<td><b>Contact No</b></td>
														<td><b>Est Amt</b></td>
														<td><b>Adv Amt</b></td>
														<td><b>Final Amt</b></td>
														<td><b>Remarks/Rejected Reson</b></td>
													    <td><b>Repair Completed Date</b></td>
														<td><b>Delivered Date</b></td>
														<td><b>Status</b></td>
														<td><b>Edit</b></td>
														<?php
														if($_SESSION['session_username']=='admin'){
														?>
														<td><b>Del</b></td>
														<?php
														}
														
														?>
														
														<td><b>INST&nbsp;DEL</b></td>
														<td><b>INST&nbsp;REJ</b></td>
											</tr>
										<?php
										
										if($result_key=='all' || $result_key==''){
											
											//PAGINATION CODE
											$sql_pagin = "SELECT COUNT(entry_id) FROM `adm_cust_mob_add` WHERE delete_status !=1 ORDER BY entry_id DESC";
											$rs_sql_pagin = mysql_query($sql_pagin);
											$row_pagin = mysql_fetch_row($rs_sql_pagin);
											$total_records_pagin = $row_pagin[0];
											//echo $total_records_pagin;
											$limit=40;
											$limit1=2;
											$offset=40;
											$total_pages = ceil($total_records_pagin / $limit); 
											//echo $total_pages; 
											$pagLink = "<div class='pagination'>";  
											 
											if (isset($_GET["page"])) { $page=$_REQUEST["page"]; } else { $page=1; };
											$start_from = ($page-1) * $limit;
											for ($i=1; $i<=$total_pages; $i++) {  
											
											if($page==$i){
											$pagLink .= "<a style='color: #ffffff; background: #ff0000;' href='view-cust-mobile-entry.php?result_key=delv&page=".$i."'>".$i."</a>";  
											
											}else{
												$pagLink .= "<a href='view-cust-mobile-entry.php?result_key=all&page=".$i."'>".$i."</a>";  
											}
             											
											};  
											echo $pagLink . "</div>";
											
											
											
											
											//PAGINATION ENDS
											
											
											$sql_cust="SELECT * FROM `adm_cust_mob_add` WHERE delete_status !=1 ORDER BY entry_id DESC LIMIT ".$start_from.", ".$offset."";							
											
										}elseif($result_key=='pend'){
											$sql_cust="SELECT * FROM `adm_cust_mob_add` WHERE `status`='Pending' AND delete_status !=1 ORDER BY entry_id DESC";
										}elseif($result_key=='comp'){
											$sql_cust="SELECT * FROM `adm_cust_mob_add` WHERE `status`='Completed' AND delete_status !=1 ORDER BY repair_date DESC";
										}elseif($result_key=='delv'){
											
											//PAGINATION CODE
											$sql_pagin = "SELECT COUNT(entry_id) FROM `adm_cust_mob_add` WHERE `status`='Delivered' AND delete_status !=1  AND rejected=0";
											$rs_sql_pagin = mysql_query($sql_pagin);
											$row_pagin = mysql_fetch_row($rs_sql_pagin);
											$total_records_pagin = $row_pagin[0];
											//echo $total_records_pagin;
											$limit=40;
											$limit1=2;
											$offset=40;
											$total_pages = ceil($total_records_pagin / $limit); 
											//echo $total_pages; 
											$pagLink = "<div class='pagination'>";  
											
											if (isset($_GET["page"])) { $page=$_REQUEST["page"]; } else { $page=1; };
											//echo $page;exit;
											
											for ($i=1; $i<=$total_pages; $i++) {
											
												if($page==$i){
													$pagLink .= "<a style='color: #ffffff; background: #ff0000;' href='view-cust-mobile-entry.php?result_key=delv&page=".$i."'>".$i."</a>";  
												}else{
													$pagLink .= "<a href='view-cust-mobile-entry.php?result_key=delv&page=".$i."'>".$i."</a>";  
												}
             											
											};  
											echo $pagLink . "</div>";
											  
											
											$start_from = ($page-1) * $limit; 

											
											//PAGINATION ENDS
											
											$sql_cust="SELECT * FROM `adm_cust_mob_add` WHERE `status`='Delivered' AND delete_status !=1  AND rejected=0 ORDER BY delivered_date DESC LIMIT ".$start_from.", ".$offset."";
											
											
										}elseif($result_key=='rej'){
										
										//PAGINATION CODE
											$sql_pagin = "SELECT COUNT(entry_id) FROM `adm_cust_mob_add` WHERE `rejected`='1' AND delete_status !=1 ORDER BY `status` DESC ";
											//$sql_pagin = "SELECT COUNT(entry_id) FROM `adm_cust_mob_add` WHERE `rejected`='1' AND delete_status !=1 ORDER BY `status` DESC";
											$rs_sql_pagin = mysql_query($sql_pagin);
											$row_pagin = mysql_fetch_row($rs_sql_pagin);
											$total_records_pagin = $row_pagin[0];
											//echo $total_records_pagin;
											$limit=40;
											$limit1=2;
											$offset=40;
											$total_pages = ceil($total_records_pagin / $limit); 
											//echo $total_pages; 
											$pagLink = "<div class='pagination'>";  
											if (isset($_GET["page"])) { $page=$_REQUEST["page"]; } else { $page=1; };
											
											
											for ($i=1; $i<=$total_pages; $i++) {  
											if($page==$i){
												$pagLink .= "<a  style='color: #ffffff; background: #ff0000;' href='view-cust-mobile-entry.php?result_key=rej&page=".$i."'>".$i."</a>";  
											}else{
												$pagLink .= "<a href='view-cust-mobile-entry.php?result_key=rej&page=".$i."'>".$i."</a>";  
											}
             											
											};  
											echo $pagLink . "</div>";
											
											
											$start_from = ($page-1) * $limit; 

											
											//PAGINATION ENDS
											
											$sql_cust="SELECT * FROM `adm_cust_mob_add` WHERE `rejected`='1' AND delete_status !=1 ORDER BY `status` DESC LIMIT ".$start_from.", ".$offset."";
										}
										//echo $sql_cust;
												//$sql_cust="SELECT * FROM `adm_cust_mob_add` WHERE delete_status !=1 ORDER BY entry_id DESC";
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
													echo '<tr>
															<td>'.$result_cust['entry_id'].'</td>
															<td>'.$result_cust['added_date'].'</td>
															<td>'.$result_cust['added_by'].'</td>
															<td>'.$result_cust['repair_by'].'</td>
															<td>'.$result_cust['deliver_by'].'</td>
															<td>'.$result_cust['customer_name'].'</td>
															<td>'.$result_cust['mobile_name'].'</td>
															<td>'.$mob_def_result['defect_name'].$defect_2.$defect_3.'</td>
															<td>'.$result_cust['exp_delivery'].'</td>
															<td>'.$result_cust['cust_contact'].'</td>
															<td>'.$result_cust['est_amount'].'</td>
															<td>'.$result_cust['adv_amount'].'</td>
															<td>'.$result_cust['actual_amount'].'</td>
															<td>'.$result_cust['remarks'].' / '.$result_cust['rejected_reason'].'</td>
															<td>'.$result_cust['repair_date'].'</td>
															<td>'.$result_cust['delivered_date'].'</td>
															<td>'.$del_msg_stat.$result_cust['status'].'</td>'; //echo ends
										if($result_cust['status']!='Delivered'){
										?>
										<td><a href="./add-cust-mobile.php?entry_id=<?php echo $result_cust['entry_id']; ?>" ><img style="border:none; width:15px; height:15px;" src="./img/edit-icon.jpg"/></a></td>
										<?php
										if($_SESSION['session_username']=='admin'){
										?>
									
										<td><a href="./view-cust-mobile-entry.php?mode=del&pr_id=<?php echo $result_cust['entry_id']; ?>" onclick="javascript:return confirm('Are you sure you want to delete?')"><img style="border:none; width:15px; height:15px;"src="./img/delete-icon.jpg"/></a></td>
										<?php
										}
										?>
										
										<td><a href="./mobile-delivery-invoice.php?delivery-id=<?php echo $result_cust['entry_id']; ?>"><img style="border:none; width:65px; height:40px;" src="./img/inst_del.png"/></a></td>
										<td><a href="#"><img style="border:none; width:65px; height:40px;" src="./img/inst_rej.jpg"/></a></td>
										<?php
										}//if ends

												} //while ends
										?>
										</tr>
																					
				</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php
mysql_close($connection);
}else{
header('Location: ./index.php');
}
?>
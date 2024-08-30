<?php
session_start();
//print_r($_SESSION);
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){

if($_SESSION['session_username']=='superadmin'){
    
include("./dbconnect.php");
$session_store_name=$_SESSION['session_store_name'];
$session_store_id=$_SESSION['session_store_id'];
$mess='';
if(isset($_REQUEST['submit'])){
    //echo "here";exit;
    $user_id_for_update=$_REQUEST['user_id_for_update'];
    $store_name=$_REQUEST['store_name'];
    $store_contact=$_REQUEST['store_contact'];
    $store_address1=$_REQUEST['store_address1'];
    $store_address2=$_REQUEST['store_address2'];
    
    $sql_update_store_data="UPDATE `stores` SET 
        `store_name`='".$store_name."',
        `store_contact`='".$store_contact."',
        `store_address1`='".$store_address1."',
        `store_address2`='".$store_address2."',
        `last_update_date`=now() WHERE store_id=".$user_id_for_update;
    //echo $sql_update_store_data;exit;
    $query_update_store_data=mysql_query($sql_update_store_data);
		if($query_update_store_data){ 
		    $sql_upd_store_in_cust_kol_users="UPDATE `cust_kolors_users_list` SET `store_name` ='".$store_name."'  WHERE `store_id`=".$user_id_for_update;
		    $query_upd_store_in_cust_kol_users=mysql_query($sql_upd_store_in_cust_kol_users);
			$mess="<h1 style='color:red'>Message: </h1><h1 style='color:green'>Store Details Updated Succesfully..<h1>";
		}else{
			$mess="<h1 style='color:red'>Message: </h1><h1 style='color:red'>Failed to Update Store Details..<h1>";
		}
		
}
if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='edit'){
    $store_id_upd=$_REQUEST['store_id'];
    $action="edit";
    $sql_get_details="SELECT * FROM stores WHERE store_id=".$store_id_upd;
    //echo $sql_get_details;    exit;
    $query_get_details=mysql_query($sql_get_details);
    $rowcount = mysql_num_rows( $query_get_details );
    if($rowcount==0){
        $transaction='illegal';
    }
    $result_get_details=mysql_fetch_array($query_get_details);
    $note="Please Be very careful While modifying Customer data.";
}

?>
<html>
<head>
	<link href="https://digitalstorz.com/css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
<style>


</style>
<!-- Script for preventing reload submit entry-->
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</head>
<body>
	<div class="header">
	    
		<span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $session_store_name;?> <span style="font-size:14px; color:yellow;">Powered By DigitalStorz.com</span></span>
		
		<div style="float:right; font-family: 'Trebuchet MS', sans-serif; font-weight:bold;  font-size:17px; color:#ECFA12; padding-right:15px; padding-top:10px;" ><?php echo $_SESSION['session_staff_name'];?> (<?php echo $_SESSION['session_user_role']?>)</div>
		
	</div>
	
	<div class="main_container">
		<?php include("kol-mob-entry-menu.php");?>
		<div class="right_container">
		    <div class="page_title_div"><h1>MANAGE STORE DETAILS</h1></div>
		    <div class="page_title_div"><?php echo $mess.' '.$mess1?></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Update Store Details&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div>
				
				<div class="content_holder_body">
				    <?php
				    if($action=='edit'){
			
				    ?>
				    <form name="create_user" onpaste="return false;" ondrop="return false;" autocomplete="off" method="post" action="./manage-store-by-superadmin.php" onsubmit="return validate()">
				        <h1><?php echo $note; ?></h1><br>
					<table style="margin-left:30px">
					    <input type="hidden" name="user_id_for_update" value="<?php echo $store_id_upd;?>">
					 
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Store Name&nbsp;&nbsp;</td> <td><input type="text" name="store_name" value="<?php echo $result_get_details['store_name'];?>" onkeyup=" var start = this.selectionStart;  var end = this.selectionEnd;   this.value = this.value.toUpperCase();   this.setSelectionRange(start, end);"></td><td style="color:red; font-size:12px;padding-left:15px;"></td></tr>
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Store Contact Number&nbsp;&nbsp;</td> <td><input type="number" onkeyup=" var start = this.selectionStart;  var end = this.selectionEnd;   this.value = this.value.toUpperCase();   this.setSelectionRange(start, end);" required name="store_contact" value="<?php echo $result_get_details['store_contact'];?>" maxlength=10 ondrop="return false;" autocomplete="off" required required pattern="[0-9]{10}" onkeypress="if(this.value.length==10) return false;"  onkeydown="javascript: return (event.keyCode == 69 || event.keyCode == 190 || event.keyCode == 189 || event.keyCode == 187) ? false : true"></td><td style="color:red; font-size:15px;padding-left:15px;">&#x2731;</td></tr>
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Store Address Line 1&nbsp;&nbsp;</td> <td><input type="text" onkeyup=" var start = this.selectionStart;  var end = this.selectionEnd;   this.value = this.value.toUpperCase();   this.setSelectionRange(start, end);" required name="store_address1" value="<?php echo $result_get_details['store_address1'];?>"></td><td style="color:red; font-size:15px;padding-left:15px;">&#x2731;</td></tr>
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Store Address Line 2&nbsp;&nbsp;</td> <td><input type="text" onkeyup=" var start = this.selectionStart;  var end = this.selectionEnd;   this.value = this.value.toUpperCase();   this.setSelectionRange(start, end);" required name="store_address2" value="<?php echo $result_get_details['store_address2'];?>"></td><td style="color:red; font-size:15px;padding-left:15px;">&#x2731;</td></tr>
					    <tr><td>&nbsp;</td></td></tr>
					    <tr><td>&nbsp;</td></td><td><input type="submit" name="submit" value="Update"></td></tr>
					</table>
					</form>
                    <?php
				        

				    }
                    ?>
					<br><br>
				<table class="order_hisory_table">
													<tr class="table_heading">
														<td><b>Store Id </b></td>
														<td><b>Store Name</b></td>
														<td><b>Store Contact</b></td>
														<td><b>Address Line1</b></td>
														<td><b>Address Line2</b></td>
                                                        <td><b>Referred By</b></td>
                                                        <td><b>Store Added Date</b></td>
                                                        <td><b>Last Updated Date</b></td>
                                                        <td><b>Edit</b></td>
													</tr>
											<?php
											    $sql_com="SELECT * FROM `stores` ORDER BY `store_id` DESC"; 
												$query_com=mysql_query($sql_com);
												while($result_com=mysql_fetch_array($query_com)){
												//print('<pre>');print_r($result_com);
												    
											?>
													<tr>
															<td><?php echo $result_com['store_id'];?></td>
															<td><?php echo $result_com['store_name'];?></td>
															<td><?php echo $result_com['store_contact'];?></td>
															<td><?php echo $result_com['store_address1']?></td>
															<td><?php echo $result_com['store_address2']?></td>
															<td><?php echo $result_com['referal_code']?></td>
															<td><?php echo $result_com['added_date'];?></td>
															<td><?php echo $result_com['last_update_date'];?></td>
															<td><a href="./manage-store-by-superadmin.php?mode=edit&store_id=<?php echo $result_com['store_id']?>"> EDIT </a></td>
															
													</tr>
											<?php
												}
											?>
												</table>
				</div>

			</div>
			
		</div>
		</div>
	</div>
</body>
</html>
<?php
mysql_close($connection);
}
}else{
header('Location: ./index.php');
}
?>
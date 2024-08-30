<?php 
date_default_timezone_set("Asia/Kolkata");
session_start();
//print_r($_SESSION);
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$session_store_name=$_SESSION['session_store_name'];
$mess='';
$upd_ser_id='';
$upd_ser_name='';
$cust_entry_id='';
$btn_value="Get Data";
$btn_name="submit";
$num_rows_result='-1';


if(isset($_REQUEST['submit'])){ //When form Submits
//print_r($_REQUEST);
	  $cust_phone_no=$_REQUEST['cust_phone_no']; 
	  $sql_job_details="SELECT * FROM adm_cust_mob_add WHERE `cust_contact`=".$cust_phone_no." AND status='Delivered' AND `store_id`=".$_SESSION['session_store_id']; 
	  $query_disp=mysql_query($sql_job_details);
	  $num_rows_result=mysql_num_rows($query_disp);
} 
if(isset($_REQUEST['submit_selected'])){ 
    //print_r($_REQUEST);
    
    $prefix = $order_id = '';
    foreach ($_REQUEST['check_list_print'] as $entryid)
    {
        $order_id .= $prefix . '' . $entryid . '';
        $prefix = ',';
    }
    //echo $order_id;exit;
    	//header.location('Location: ./print-invoice.php?job_id='.$order_id);
    	echo "<script type=\"text/javascript\">
                window.open('./print-invoice.php?job_id=".$order_id."', '_blank')
              </script>";
    	
    }
?>
<html>
<head>
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
	
	<script type="text/javascript">
            // Form validation code for SIGN UP
            function validate()
            {
				if (document.send_invoice.cust_phone_no.value == "")
                {
                    document.send_invoice.cust_phone_no.focus();
                    alert("Enter Phone Number");
					return false;
                }

			}
			function numbersonly(e){
			    //alert("hi");
				var unicode=e.charCode? e.charCode : e.keyCode
				if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
				if (unicode<48||unicode>57) //if not a number
				if (document.send_invoice.cust_phone_no.value < 10)
				return false //disable key press
				}
			}

	</script>
	<style>
table, td, th {  
  border: 1px solid #8D8D8E;
  text-align: left;
}

table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  padding: 15px;
}
</style>

<script>
    
     function onlyNumberKey(evt) {
          
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
    
</script>
</head>
<body>
    <div id="loader"></div>  
	<div class="header">
		<span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $session_store_name;?> <span style="font-size:14px; color:yellow;">Powered By DigitalStorz.com</span></span>
		<div style="float:right; font-family: 'Trebuchet MS', sans-serif; font-weight:bold; font-size:17px; color:#ECFA12; padding-right:15px; padding-top:10px;" ><?php echo $_SESSION['session_staff_name'];?> (<?php echo $_SESSION['session_user_role']?>)</div>
	</div>
	
	<div class="main_container">
			<?php include("kol-mob-entry-menu.php");?>
		<div class="right_container">
			<div class="page_title_div"><h1>GENERATE INVOICE BY CUSTOMER PHONE NO</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Generate Invoice &nbsp;&nbsp;&nbsp;<?php echo $mess;?></div>
				
				<div class="content_holder_body">
				    <form name="send_invoice" method="post" action="./send-invoice-by-phone.php" onsubmit="return validate()">
					<div class="txt_lable">Phone Number:</div>
					<div><input type="text" name="cust_phone_no" value="<?php echo $cust_phone_no;?>" onkeypress="return onlyNumberKey(event)" maxlength=10></div>
					<div class="submit_button_div"><input  type="submit" name="<?php echo $btn_name;?>" value="<?php echo $btn_value?>" /></div>
				    </form>


                <br><br>
				
				  	    
                <form name="submit_print" action="./send-invoice-by-phone.php" method="post">
                    <table>
                    <tr style="background:#8D8D8E"><th>Job ID</th><th>Customer Name</th><th>Device Name</th><th>Defect</th><th>Amount</th><th>Select</th>
                    
                        </tr>
                <?php
                    if($num_rows_result > 0){
                            while($result_disp=mysql_fetch_array($query_disp)){
	                        $defect_sql1="SELECT * FROM `adm_mobile_defects` WHERE `defect_id`=".$result_disp['mobile_defect'];
	                        $query_defect_query1=mysql_query($defect_sql1);
	                        $result_disp_result1=mysql_fetch_array($query_defect_query1);
                            $defect1=$result_disp_result1['defect_name'];
                            $entry_id_print=$result_disp['entry_id'];
                            echo '<tr>
								    <td>'.$result_disp['entry_id'].'</td> 
								    <td>'.$result_disp['customer_name'].'</td>
								    <td>'.$result_disp['mobile_name'].'</td>
								    <td>'.$defect1.'</td>
								    <td>'.$result_disp['actual_amount'].'</td>
								    <td><input type="checkbox" name="check_list_print[]" value="'.$entry_id_print.'"></td>
								    </tr>
								';
                        }
                ?>
                <tr><td colspan=6 style="text-align:right"><input type="submit" name="submit_selected" value="Submit Selected" ></td></tr>
				  	</table>
				  	</form>
                <?php
                    }elseif($num_rows_result == 0){
                        echo "No Records Found for Job ID..";
                    }
                ?>
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
<?php 
date_default_timezone_set("Asia/Kolkata");
session_start();
//print_r($_SESSION);
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$cust_entry_id=$_REQUEST['job_id'];

    $sql_job_details1="SELECT * FROM adm_cust_mob_add WHERE entry_id=".$cust_entry_id." AND `store_id`=".$_SESSION['session_store_id'];
	$query_disp1=mysql_query($sql_job_details1);
	$result_disp1=mysql_fetch_array($query_disp1);
    $num_rows_result=mysql_num_rows($query_disp1);
	//echo $num_rows_result;
	$sql_store_det="SELECT * FROM `stores` WHERE `store_id`=".$result_disp1['store_id'];
	$query_store_det=mysql_query($sql_store_det);
	$result_store_det=mysql_fetch_array($query_store_det);

    
    //$invoice_date=date("d/m/Y");
    //$invoice_date_temp=$result_disp1['delivered_date'];
    $receipt_date_temp=$result_disp1['added_date'];
    $timestamp = strtotime($receipt_date_temp);
    $receipt_date = date("d-m-Y", $timestamp);
    
    //code for converting numbers into words.
    class numbertowordconvertsconver {
    function convert_number($number) 
    {
        if (($number < 0) || ($number > 999999999)) 
        {
            throw new Exception("Number is out of range");
        }
        $giga = floor($number / 1000000);
        // Millions (giga)
        $number -= $giga * 1000000;
        $kilo = floor($number / 1000);
        // Thousands (kilo)
        $number -= $kilo * 1000;
        $hecto = floor($number / 100);
        // Hundreds (hecto)
        $number -= $hecto * 100;
        $deca = floor($number / 10);
        // Tens (deca)
        $n = $number % 10;
        // Ones
        $result = "";
        if ($giga) 
        {
            $result .= $this->convert_number($giga) .  "Million";
        }
        if ($kilo) 
        {
            $result .= (empty($result) ? "" : " ") .$this->convert_number($kilo) . " Thousand";
        }
        if ($hecto) 
        {
            $result .= (empty($result) ? "" : " ") .$this->convert_number($hecto) . " Hundred";
        }
        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
        if ($deca || $n) {
            if (!empty($result)) 
            {
                $result .= " and ";
            }
            if ($deca < 2) 
            {
                $result .= $ones[$deca * 10 + $n];
            } else {
                $result .= $tens[$deca];
                if ($n) 
                {
                    $result .= "-" . $ones[$n];
                }
            }
        }
        if (empty($result)) 
        {
            $result = "zero";
        }
        return $result;
    }
}
//Code ends

?>
<html>
    <head>
        <style>
            .print_inv_tablw{
                font-family: Calibri;
                width:100%;
                padding:20px;
                margin-left: auto;
                margin-right: auto;
            }
            .print_inv_table2{
               /*font-family: 'Trebuchet MS', sans-serif;*/
               font-family: Calibri;
                width:95%;
                padding:20px;
                margin-left: auto;
                margin-right: auto;
                
            }
            .print_inv_tablw.th, .print_inv_tablw.td {
                text-align: left;
                padding: 8px;
                line-height: 8px;
            }
           
            .print_inv_table2, .print_inv_table2.th, .print_inv_table2.td {
                border: 1px solid black;
                border-collapse: collapse;
                line-height: auto;
                
            }

        </style>
        <style media="print">
            @page {
                size: auto;
                margin: 0;
  
            }
        </style>
    </head>
    <body onload="window.print();">
    <!--<body>-->
    <?php
    if($num_rows_result >0){
    ?>
        <table class="print_inv_tablw">
            <tr>
                <td style="font-weight:bold; font-size:20px;"><?php echo $_SESSION['session_store_name']?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right"><b>Order #<?php echo $_REQUEST['job_id']; ?></b></td>
            </tr>
            <tr>
                <td><?php echo $result_store_det['store_address1']?>, </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right">Date: <?php echo $receipt_date; ?></td>
            </tr>
            <tr>
             <td><?php echo $result_store_det['store_address2']; ?>,</td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
            </tr>
            <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
            </tr>

            <tr>
             <td>Store Contact : <?php echo $result_store_det['store_contact']; ?>.</td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             
            </tr>
            <tr>
             <!--<td>website</td>-->
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             
            </tr>

        </table>
        <hr><br>
        
        <div style="text-align:center; font-weight:bold; font-family: Calibri;">Acknowledgement of Service Request for Order #<?php echo $_REQUEST['job_id']; ?></div>
        <table class="print_inv_tablw">
            <tr>
                <td>Customer Name:  <?php echo $result_disp1['customer_name']; ?>,</td>
            </tr>
            <tr>
                <td>Phone:  <?php echo $result_disp1['cust_contact']; ?>.</td>
            </tr>
        </table>
        <div style="font-family: Calibri;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Below are the details of Device received.</div><br>
        <table class="print_inv_table2">
            
            <?php
                            
                            $sql_job_details="SELECT * FROM adm_cust_mob_add WHERE entry_id=".$cust_entry_id."";
	                        $query_disp=mysql_query($sql_job_details);
	                        $result_disp=mysql_fetch_array($query_disp);

	                        $defect_sql1="SELECT * FROM `adm_mobile_defects` WHERE `defect_id`=".$result_disp['mobile_defect'];
	                        $query_defect_query1=mysql_query($defect_sql1);
	                        $result_disp_result1=mysql_fetch_array($query_defect_query1);
                            $defect1=$result_disp_result1['defect_name'];
            ?>
            
            <tr>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">Device Name: <?php echo $result_disp['mobile_name']; ?></td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">Defect Description: <?php echo $defect1;?></td>
       
            </tr>
            <tr>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">Estimated Charges : <?php echo $result_disp['est_amount']; ?></td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">Device Inspection Report:</td>
            </tr>
            <?php
            $class_obj = new numbertowordconvertsconver();
            $convert_number = $result_disp['adv_amount'];
            $total_inwords=$class_obj->convert_number($convert_number);
            
            if($result_disp['adv_amount']==0 || $result_disp['adv_amount']==''){
                $adv_amt='Nill';
            }else{
                $adv_amt='Rs.'.$result_disp['adv_amount'].' (Rupees '.$total_inwords.' Only).';
            }
            ?>
            <tr>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">Advance received:  <?php echo $adv_amt; ?> </td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">Job Created Date & Time: <?php echo $result_disp['added_date']; ?></td>
            </tr>
        </table>
        <br><br>
        <table class="print_inv_tablw">
            <tr>
                <td><b>Customer Signature</b></td>
                <td><b>Store Authority Signature</b></td>
            </tr>
        </table>
        <br><br>
         <div style="font-family: Calibri;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Risk Details:</b></div><br>
        <div style="font-family: 'Trebuchet MS', sans-serif; padding-left:20px;" >*In case of any Water Damage, customer has to accept the complete risk of the device.</div>
        <div style="font-family: 'Trebuchet MS', sans-serif; padding-left:20px;" >*In case of Software Issues, customer has to accept the complete risk to the data (Data will be wiped off).</div>
        <br><br>
        <?php
    }
        ?>
    </body>
</html>

    
<?php
mysql_close($connection);
}else{
header('Location: ./index.php');
}
?>
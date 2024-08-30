<?php 
date_default_timezone_set("Asia/Kolkata");
session_start();
//print_r($_SESSION);
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$cust_entry_id1=$_REQUEST['job_id'];
$cust_entry_id=explode(",",$cust_entry_id1);
//print_r($cust_entry_id);

    $sql_job_details1="SELECT * FROM adm_cust_mob_add WHERE entry_id=".$cust_entry_id['0'];
	$query_disp1=mysql_query($sql_job_details1);
	$result_disp1=mysql_fetch_array($query_disp1);

	
	$sql_store_det="SELECT * FROM `stores` WHERE `store_id`=".$result_disp1['store_id'];
	$query_store_det=mysql_query($sql_store_det);
	$result_store_det=mysql_fetch_array($query_store_det);

    
    //$invoice_date=date("d/m/Y");
    $invoice_date_temp=$result_disp1['delivered_date'];
    $timestamp = strtotime($invoice_date_temp);
    $invoice_date = date("d-m-Y", $timestamp);
    
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
        <table class="print_inv_tablw">
            <tr>
                <td style="font-weight:bold; font-size:20px;"><?php echo $_SESSION['session_store_name']?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right"><b>INVOICE For Order #<?php echo $_REQUEST['job_id']; ?></b></td>
            </tr>
            <tr>
             <td></br></td>
            </tr>
            <tr>
                <td><?php echo $result_store_det['store_address1']?>, </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right">Date: <?php echo $invoice_date; ?></td>
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
             <td>Ph : <?php echo $result_store_det['store_contact']; ?></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td style="text-align: right"><b>Customer Name: Mr.&nbsp;<?php echo $result_disp1['customer_name']; ?></b></td>
            </tr>
            <tr>
             <!--<td>website</td>-->
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td style="text-align: right"><b>Phone: <?php echo $result_disp1['cust_contact']; ?></b></td>
            </tr>

        </table>
        <hr><br>
        <table class="print_inv_table2">
            <tr style="background:#C0BEBE; -webkit-print-color-adjust: exact; ">
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">S.No.</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">Order&nbsp;ID</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">Item&nbsp;Description</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">Quantity</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">Unit&nbsp;Price</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">Total</td>
            </tr>
            
            <!--<tr >
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">1</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse"><?php echo $result_disp['mobile_name'].' '.$defect1; ?></td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">1</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse"><?php echo $result_disp['actual_amount']; ?></td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse"><?php echo $result_disp['actual_amount']; ?></td>
            </tr>-->
            
            <?php
            $grand_total=0;
            $i=0;
                        foreach ($cust_entry_id as $value) {
                            
                            $sql_job_details="SELECT * FROM adm_cust_mob_add WHERE entry_id=".$value." AND status='Delivered' ";
	                        $query_disp=mysql_query($sql_job_details);
	                        $result_disp=mysql_fetch_array($query_disp);

	                        $defect_sql1="SELECT * FROM `adm_mobile_defects` WHERE `defect_id`=".$result_disp['mobile_defect'];
	                        $query_defect_query1=mysql_query($defect_sql1);
	                        $result_disp_result1=mysql_fetch_array($query_defect_query1);
                            $defect1=$result_disp_result1['defect_name'];
                            
                            $grand_total=$grand_total+$result_disp['actual_amount'];
                            $i++;
                            echo '<tr>
                                    <td style="border:1px solid #C0BEBE; border-collapse: collapse">'.$i.'</td>
								    <td style="border:1px solid #C0BEBE; border-collapse: collapse">'.$result_disp['entry_id'].'</td> 
								    <td style="border:1px solid #C0BEBE; border-collapse: collapse">'.$result_disp['mobile_name'].', '.$defect1.'</td>
								    <td style="border:1px solid #C0BEBE; border-collapse: collapse">1</td>
								    <td style="border:1px solid #C0BEBE; border-collapse: collapse">'.$result_disp['actual_amount'].'</td>
								    <td style="border:1px solid #C0BEBE; border-collapse: collapse">'.$result_disp['actual_amount'].'</td>
								    </tr>
								';
							
                        }
                        
                        
            ?>

            <tr>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
            </tr>
            <tr>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
            </tr>
            <tr>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
            </tr>
            <tr>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse">&nbsp;</td>
            </tr>
            <tr>
             <td colspan=5 style="border:1px solid #C0BEBE; border-collapse: collapse; text-align:right;"><b>Grand Total Rs.</b></td>
             <td style="border:1px solid #C0BEBE; border-collapse: collapse; text-align:left;"><b><?php echo $grand_total; ?>.00</b></td>
            </tr>
            <?php
            $class_obj = new numbertowordconvertsconver();
            $convert_number = $grand_total;
            $total_inwords=$class_obj->convert_number($convert_number);
            ?>

            <tr>
             <td colspan=6 style="border:1px solid #C0BEBE; border-collapse: collapse; text-align:right;">Payment received Rs.<?php echo $grand_total;?>.00, (Rupees <?php echo $total_inwords; ?> Only).</td>
            </tr>

        </table>
        <br><br>
        <div style="font-family: 'Trebuchet MS', sans-serif; padding-left:20px;" >*This is a Computer generated invoice no signature is required.</div>
    </body>
</html>

    
<?php
mysql_close($connection);
}else{
header('Location: ./index.php');
}
?>
<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
date_default_timezone_set("Asia/Kolkata");
session_start();
//print_r($_SESSION);exit;
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$cust_entry_id1=$_REQUEST['job_id'];
$cust_entry_id=explode(",",$cust_entry_id1);

$email_id=$_REQUEST['email_id'];
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

<?Php

require('./pdf/fpdf.php');
$pdf = new FPDF(); 
$pdf->AddPage();

$pdf->SetFont('Arial','B',12);
$pdf->Cell(80,10,$_SESSION['session_store_name'],0,0,'L');
$pdf->Cell(110,10,'Invoice For Order # '.$_REQUEST['job_id'],0,0,'R');
$pdf->SetFont('Arial');
$pdf->Ln(6);

 if($result_disp1['gst_amount'] !=''){
$pdf->SetFont('Arial','B',12);
$pdf->Cell(80,10,' ',0,0,'L');
$pdf->Cell(110,10,'Store GST No.  '.$result_store_det['store_gst_no'],0,0,'R');
$pdf->SetFont('Arial');
$pdf->Ln(6);
}
$pdf->Cell(80,10,$result_store_det['store_address1']);
$pdf->Cell(110,10,'Date : '.$invoice_date,0,0,'R');
$pdf->Ln(6);

$pdf->Cell(80,10,$result_store_det['store_address2']);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(110,10,'Customer Name: '.$result_disp1['customer_name'],0,0,'R');
$pdf->Ln(6);

$pdf->Cell(80,10,'Store Contact: . '.$result_store_det['store_contact']);
$pdf->Cell(110,10,'Phone: '.$result_disp1['cust_contact'],0,0,'R');
$pdf->Ln(6);

if($result_disp1['customer_gst_no'] !=''){
$pdf->Cell(80,10,'');
$pdf->Cell(110,10,'Customer GST No. : '.$result_disp1['customer_gst_no'],0,0,'R');
$pdf->Ln(6);

$pdf->Line(10, 50, 250-50, 50);
$pdf->Ln(6);
$pdf->Ln(6);
$pdf->Ln(6);
}else{
    $pdf->Line(10, 45, 250-50, 45);
    $pdf->Ln(6);
    $pdf->Ln(6);
    $pdf->Ln(6);
}

//$pdf->Line(10, 45, 250-50, 45);
$pdf->SetFont('Arial','B',12);
 
$pdf->Cell(13,6,'Sl.No', 1,0);
$pdf->Cell(20,6,'Order Id', 1,0);
$pdf->Cell(105,6,'Item Description', 1,0);
$pdf->Cell(10,6,'Qty', 1,0);
$pdf->Cell(22,6,'Unit Price', 1,0);
$pdf->Cell(20,6,'Total', 1,0);


$base_service_charges=0;
$gst_amount=0;
$i=0;
$pdf->SetFont('Arial');
$pdf->Ln(6);
                        foreach ($cust_entry_id as $value) {
                            
                            $sql_job_details="SELECT * FROM adm_cust_mob_add WHERE entry_id=".$value." AND status='Delivered' ";
	                        $query_disp=mysql_query($sql_job_details);
	                        $result_disp=mysql_fetch_array($query_disp);

	                        $defect_sql1="SELECT * FROM `adm_mobile_defects` WHERE `defect_id`=".$result_disp['mobile_defect'];
	                        $query_defect_query1=mysql_query($defect_sql1);
	                        $result_disp_result1=mysql_fetch_array($query_defect_query1);
                            $defect1=$result_disp_result1['defect_name'];
                            
                            $base_service_charges=$base_service_charges+$result_disp['actual_amount'];
                            $gst_amount=$gst_amount+$result_disp['gst_amount'];
                            $i++;
                            
                            $pdf->Cell(13,6,$i, 1,0);
                            $pdf->Cell(20,6,$result_disp['entry_id'], 1,0);
                            $pdf->Cell(105,6,$result_disp['mobile_name'].', '.$defect1, 1,0);
                            $pdf->Cell(10,6,'1', 1,0);
                            $pdf->Cell(22,6,$result_disp['actual_amount'], 1,0);
                            $pdf->Cell(20,6,$result_disp['actual_amount'], 1,0);
                            $pdf->Ln(6);
							
                        }            
                        $grand_total=$base_service_charges+$gst_amount;

$pdf->Cell(13,6,'', 1,0);
$pdf->Cell(20,6,'', 1,0);
$pdf->Cell(105,6,'', 1,0);
$pdf->Cell(10,6,'', 1,0);
$pdf->Cell(22,6,'', 1,0);
$pdf->Cell(20,6,'', 1,0);

$pdf->Ln(6);
$pdf->Cell(13,6,'', 1,0);
$pdf->Cell(20,6,'', 1,0);
$pdf->Cell(105,6,'', 1,0);
$pdf->Cell(10,6,'', 1,0);
$pdf->Cell(22,6,'', 1,0);
$pdf->Cell(20,6,'', 1,0);

$pdf->Ln(6);
$pdf->Cell(13,6,'', 1,0);
$pdf->Cell(20,6,'', 1,0);
$pdf->Cell(105,6,'', 1,0);
$pdf->Cell(10,6,'', 1,0);
$pdf->Cell(22,6,'', 1,0);
$pdf->Cell(20,6,'', 1,0);

$pdf->Ln(6);
$pdf->Cell(13,6,'', 1,0);
$pdf->Cell(20,6,'', 1,0);
$pdf->Cell(105,6,'', 1,0);
$pdf->Cell(10,6,'', 1,0);
$pdf->Cell(22,6,'', 1,0);
$pdf->Cell(20,6,'', 1,0);

if($gst_amount >0){
$pdf->Ln(6);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(170,6,'Service Charges Rs. ', 1,0,R);
$pdf->Cell(20,6,$base_service_charges.'.00', 1,0,L);
$pdf->Ln(6);
$pdf->Cell(170,6,'GST (18%) Rs. ', 1,0,R);
$pdf->Cell(20,6,$gst_amount.'.00', 1,0,L);
$pdf->Ln(6);
$pdf->Cell(170,6,'Grand Total', 1,0,R);
$pdf->Cell(20,6,$grand_total.'.00', 1,0,L);    
}else{
$pdf->Ln(6);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(170,6,'Grand Total', 1,0,R);
$pdf->Cell(20,6,$grand_total.'.00', 1,0,L);    
}


$class_obj = new numbertowordconvertsconver();
$convert_number = $grand_total;
$total_inwords=$class_obj->convert_number($convert_number);
            
$pdf->SetFont('Arial','B',12);
$pdf->Ln(6);
$pdf->Cell(190,6,'Payment Received INR '.$grand_total.'/- Only. ( '.$total_inwords.' Only)', 1,0,R);
$pdf->Ln(15);
$pdf->SetFont('Arial');
$pdf->Cell(190,10,'*This is a Computer generated invoice no signature is required.,',0,0,'L');


//$pdf->Output('Invoices/my_file.pdf','I'); //  Saved in local computer with the file name given
$pdf->Output('Invoices/'.$cust_entry_id1.'.pdf','F'); //  Saved in local computer with the file name given


$sql_store_det="SELECT * FROM stores where store_id=".$_SESSION['session_store_id'];
//echo $sql_store_det;exit;
$query_store_details=mysql_query($sql_store_det);
$result_store_details=mysql_fetch_array($query_store_details);

//echo 'File saved..';
                

                
                // This is for sending otp to email
				//require './PHPMailer/PHPMailerAutoload.php';
				/*$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'mail.digitalstorz.com';  // Specify main and backup server
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = 'transactions@digitalstorz.com';                            // SMTP username
				$mail->Password = '!nfo@d!g!+@l';                           // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
			
				$mail->From = 'transactions@digitalstorz.com'; 
				$mail->FromName = 'Invoice From Digital Storz';
				$mail->addAddress($email_id);  // Add a recipient
				$mail->addReplyTo('');
				$mail->addCC('');
				$mail->addBCC('');*/
	//New Code
    require './mailtest/PHPMailer/src/Exception.php';
    require './mailtest/PHPMailer/src/PHPMailer.php';
    require './mailtest/PHPMailer/src/SMTP.php';
	$mail = new PHPMailer;
	//$mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.digitalstorz.com';                  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'transactions@digitalstorz.com';            // SMTP username
    $mail->Password = '!nfo@d!g!+@l';                              // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable SSL encryption, TLS also accepted with port 465
    $mail->Port = 465;                                    // TCP port to connect to
	//Recipients
    $mail->setFrom('transactions@digitalstorz.com', 'Invoice From Digital Storz');          //This is the email your form sends From
    $mail->addAddress($email_id); // Add a recipient address
    
				$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
				$mail->addAttachment('./Invoices/'.$cust_entry_id1.'.pdf');         // Add attachments
				//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
				$mail->isHTML(true);                                  // Set email format to HTML
				
				$mail->Subject = 'Invoice for Order #'.$cust_entry_id1.'';
				$mail->Body    = 'Hi '.$result_disp1['customer_name'].', <br><br>Thanks For your Order #'.$cust_entry_id1.' at store '.$_SESSION['session_store_name'].' powered by DigitalStorz.com, 
								<br> <br>
								<br> 
								Please find attached Invoice for your order #'.$cust_entry_id1.'
								
								<br><br>Thank You.. <br>
								'.$_SESSION['session_store_name'].', Powered by DigitalStorz.com <br><br><br><br><br><br>
								<b>Please do not reply to this email. This is an auto generated email from DigitalStorz, and this mailbox will not be monitored.<br>
								In case of any queries, please Contact Store : '.$result_store_details["store_name"].', Contact No : '.$result_store_details["store_contact"].' .</b>
								';
				
				if($mail->send()) {
				    //exit;
				    header("location: ./generate-invoice.php?q=Success");
					
				}else{
				    header("location: ./generate-invoice.php?q=Error");
				}
	

mysql_close($connection);
}else{
header('Location: ./index.php');
}
?>
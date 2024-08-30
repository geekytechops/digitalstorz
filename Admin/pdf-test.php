<?Php

require('./pdf/fpdf.php');
$pdf = new FPDF(); 
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(80,10,'Kolors Mobile Services,',0,0,'L');
$pdf->Cell(110,10,'Invoice For Order #8924,',0,0,'R');
$pdf->SetFont('Arial');
$pdf->Ln(6);
$pdf->Cell(80,10,'Shop No.9 & 10, Nagarjuna Homes,');
$pdf->Cell(110,10,'Date:19/08/2022',0,0,'R');
$pdf->Ln(6);
$pdf->Cell(80,10,'Nizampet Road Kukatpally,Hyderabad-500085.');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(110,10,'Customer Name: Mr. Sivananda Tirumala',0,0,'R');
$pdf->Ln(6);
$pdf->Cell(80,10,'');
$pdf->Cell(110,10,'Phone: 9703777755',0,0,'R');
$pdf->Ln(6);   
$pdf->Line(10, 45, 250-50, 45);
$pdf->Ln(6);
$pdf->Ln(6);
$pdf->Ln(6);
$pdf->SetFont('Arial','B',12);
 
$pdf->Cell(20,6,'Sl.No', 1,0);
$pdf->Cell(30,6,'Order Id', 1,0);
$pdf->Cell(75,6,'Item Description', 1,0);
$pdf->Cell(20,6,'Quantity', 1,0);
$pdf->Cell(25,6,'Unit Price', 1,0);
$pdf->Cell(20,6,'Total', 1,0);

$pdf->SetFont('Arial');
$pdf->Ln(6);
$pdf->Cell(20,6,'1', 1,0);
$pdf->Cell(30,6,'12345', 1,0);
$pdf->Cell(75,6,'Samsung Galaxy S9 Plus', 1,0);
$pdf->Cell(20,6,'1', 1,0);
$pdf->Cell(25,6,'2000', 1,0);
$pdf->Cell(20,6,'2000', 1,0);

$pdf->Ln(6);
$pdf->Cell(20,6,'2', 1,0);
$pdf->Cell(30,6,'12345', 1,0);
$pdf->Cell(75,6,'Samsung Galaxy S9 Plus', 1,0);
$pdf->Cell(20,6,'1', 1,0);
$pdf->Cell(25,6,'2000', 1,0);
$pdf->Cell(20,6,'2000', 1,0);

$pdf->Ln(6);
$pdf->Cell(20,6,'', 1,0);
$pdf->Cell(30,6,'', 1,0);
$pdf->Cell(75,6,'', 1,0);
$pdf->Cell(20,6,'', 1,0);
$pdf->Cell(25,6,'', 1,0);
$pdf->Cell(20,6,'', 1,0);

$pdf->Ln(6);
$pdf->Cell(20,6,'', 1,0);
$pdf->Cell(30,6,'', 1,0);
$pdf->Cell(75,6,'', 1,0);
$pdf->Cell(20,6,'', 1,0);
$pdf->Cell(25,6,'', 1,0);
$pdf->Cell(20,6,'', 1,0);

$pdf->SetFont('Arial','B',12);
$pdf->Ln(6);
$pdf->Cell(20,6,'', 1,0);
$pdf->Cell(30,6,'', 1,0);
$pdf->Cell(75,6,'', 1,0);
$pdf->Cell(20,6,'', 1,0);
$pdf->Cell(25,6,'', 1,0);
$pdf->Cell(20,6,'', 1,0);
$pdf->Ln(6);
$pdf->Cell(170,6,'Grand Total', 1,0,R);
$pdf->Cell(20,6,'2000', 1,0,L);

$pdf->SetFont('Arial');
$pdf->Ln(6);
$pdf->Cell(190,6,'Payment Received Rupees 2000/- Only. (Two Thousand Rupees Only)', 1,0,R);
$pdf->Ln(15);
$pdf->Cell(190,10,'*This is a Computer generated invoice no signature is required.,',0,0,'L');


//$pdf->Output('Invoices/my_file.pdf','I'); //  Saved in local computer with the file name given

//$pdf->Output('Invoices/my_file.pdf','F'); //  Saved in local computer with the file name given
print ("<pre>");
print_r($_SERVER);
?>
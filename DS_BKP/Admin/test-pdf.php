<?Php
require('fpdf.php');
$pdf = new FPDF(); 
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

$pdf->SetX(50); // abscissa of Horizontal position 
$pdf->MultiCell(100,20,'Alignment = L',1,'L',false);

$pdf->Ln(20); // Line gap
$pdf->SetX(50); // abscissa of Horizontal position 
$pdf->MultiCell(100,10,'Alignment = R',1,'R',false);

$pdf->Ln(20); 
$pdf->SetX(50); 
$pdf->MultiCell(100,10,'Alignment = C',1,'C',false);

$pdf->Ln(20); 
$pdf->SetX(50); 
$pdf->MultiCell(100,10,'Demo About MultiCell Alignment = J',1,'J',false);

$pdf->Output('my_file.pdf','I'); // send to browser and display
?>
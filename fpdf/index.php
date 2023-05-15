<?php
require('fpdf.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class PDF extends FPDF
{
// Page header
function Header()
{
 
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    if($this->page > 1) {
       $this->Image('../imgs/logo.jpg', 20,18,25);
       $this->Image('../imgs/proec.png',100,18,40);
    } else {
       $this->Image('../imgs/logo.jpg', 90,18,30);
       //$this->Cell(30,10,'Title',1,0,'C'); 
    }
    // Line break
    $this->Ln(45);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
for($i=1;$i<=40;$i++)
    $pdf->Cell(0,10,'Printing line number '.$i,0,1);
$pdf->Output();
?>
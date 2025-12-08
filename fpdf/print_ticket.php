<?php
require('fpdf.php');

class GenerateTicket extends FPDF {
    public function Header(){

        $this->Image('../public/assets/repPH.png', 20, 8, 30);
        $this->Image('../public/assets/croc.jpg', 160, 8, 30);

        $this->SetFont('Arial', 'B', 16);  
        $this->Cell(0, 10, 'REPUBLIC OF THE PHILIPPINES', 0, 1, 'C');

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Mobile Data Terminal Office', 0, 1, 'C');

        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, '1648 Taft Avenue corner Pedro Gil St., Malate, Manila', 0, 1, 'C');

        $this->Ln(3);
        $this->Cell(0, 10, str_repeat("_", 75), 0, 1, 'C');

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, "DRIVER'S COPY", 0, 1, 'C');
    }

    public function Body($ticket){
        // Title
        $this->SetFont('Arial','B',18);
        $this->Cell(0,10,'TRAFFIC VIOLATION TICKET',0,1,'C');
        $this->Ln(2);

        $this->SetFont('Arial','B',12);
        $this->Cell(40,8,'Ticket No.: ');
        $this->SetFont('Arial','',12);
        $this->Cell(60,8,$ticket['ticket_no'],0,1);

        $this->SetFont('Arial','B',12);
        $this->Cell(40,8,'Date Issued: ');
        $this->SetFont('Arial','',12);
        $this->Cell(60,8,$ticket['date_issued'],0,1);

        $this->SetFont('Arial','B',12);
        $this->Cell(40,8,'Location: ');
        $this->SetFont('Arial','',12);
        $this->Cell(60,8,$ticket['location'],0,1);

        $this->Ln(5);

        // Driver Information
        $this->SetFont('Arial','B',14);
        $this->Cell(0,8,'Driver Information',0,1);

        $this->SetFont('Arial','',12);
        $this->Cell(40,8,'Name: ');
        $this->Cell(80,8,$ticket['driver_name'],0,1);
        
        $this->Cell(40,8,'License No.: ');
        $this->Cell(80,8,$ticket['license_no'],0,1);

        $this->Ln(5);

        // Violation
        $this->SetFont('Arial','B',14);
        $this->Cell(0,8,'Violation Details',0,1);

        $this->SetFont('Arial','',12);
        $this->MultiCell(0,8,$ticket['violation']);

        $this->Ln(5);

        // Officer Info
        $this->SetFont('Arial','B',14);
        $this->Cell(0,8,'Issuing Officer',0,1);

        $this->SetFont('Arial','',12);
        $this->Cell(40,8,'Officer Name: ');
        $this->Cell(80,8,$ticket['officer_name'],0,1);

        $this->Ln(5);

        // Notes
        if (!empty($ticket['notes'])) {
            $this->SetFont('Arial','B',12);
            $this->Cell(0,8,"Officer's Notes:",0,1);

            $this->SetFont('Arial','',11);
            $this->MultiCell(0,7,$ticket['notes']);
            $this->Ln(8);
        }

        // Signatures
        $this->SetFont('Arial','',12);
        $this->Cell(90,10,'_________________________',0,0,'C');
        $this->Cell(90,10,'_________________________',0,1,'C');

        $this->Cell(90,6,'Driver Signature',0,0,'C');
        $this->Cell(90,6,'Officer Signature',0,1,'C');

        $this->Ln(10);

        // Footer line
        $this->Cell(0,10,str_repeat("_", 75),0,1,'C');

        // Payment note
        $this->SetFont('Arial','I',11);
        $this->MultiCell(0,7,
            "NOTE: You are required to settle the corresponding fine within 72 hours at the nearest LTO office. "
            ."Failure to comply may result in additional penalties or suspension of driving privileges."
        );
    }

    public function Footer(){
        $this->SetY(-20);
        $this->SetFont('Arial','B',10);
        $this->Cell(
            0,10,
            '--- This ticket is system generated. For this ticket to be legally valid, a physical signature is required. ---',
            0,1,'C'
        );
    }
}

// GET DATA FROM URL
$ticket = [
    "ticket_no"   => $_GET["ticket_no"] ?? "N/A",
    "driver_name" => $_GET["driver"] ?? "N/A",
    "license_no"  => $_GET["license"] ?? "N/A",
    "address"     => $_GET["address"] ?? "N/A",
    "vehicle_plate" => $_GET["plate"] ?? "N/A",
    "vehicle_type"  => $_GET["vehicle"] ?? "N/A",
    "violation"   => $_GET["violation"] ?? "N/A",
    "officer_name"=> $_GET["officer_name"] ?? "MDT Officer",
    "date_issued" => $_GET["date"] ?? "N/A",
    "location"    => $_GET["place"] ?? "N/A",
    "notes"       => $_GET["note"] ?? ""
];

$pdf = new GenerateTicket('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->Body($ticket);
$pdf->Output();
?>
<?php
session_start();

// 1. Database verbinding
$conn = new mysqli("127.0.0.1", "root", "", "urenregister", 3306);
if ($conn->connect_error) die("Verbindingsfout: " . $conn->connect_error);

// 2. TCPDF Auto-loader
$it = new RecursiveDirectoryIterator("C:/wamp64/www/");
foreach (new RecursiveIteratorIterator($it) as $file) {
    if (strtolower($file->getFilename()) === 'tcpdf.php') {
        require_once($file->getPathname());
        break;
    }
}

// 3. ID ophalen uit de URL
$id = isset($_GET['medewerker_ID']) ? (int)$_GET['medewerker_ID'] : 0;
if ($id == 0) die("Geen medewerker geselecteerd.");

// 4. Data ophalen voor DEZE medewerker
$stmt = $conn->prepare("SELECT * FROM medewerkers WHERE medewerker_ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) die("Medewerker niet gevonden.");

// 5. Berekeningen (gebruikt de 'uren' uit de database)
$aantal_uren = (float)$data['uren']; 
$uurloon     = 50.00; // Pas aan naar wens
$subtotaal   = $aantal_uren * $uurloon;
$btw         = $subtotaal * 0.21;
$totaal      = $subtotaal + $btw;

// 6. PDF Genereren
$pdf = new TCPDF('P', 'mm', 'A4');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();

// Factuur Header
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'FACTUUR VOOR: ' . $data['voornaam'] . ' ' . $data['achternaam'], 0, 1);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Functie: ' . $data['functie'], 0, 1);
$pdf->Ln(10);

// Tabel met dynamische gegevens
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(100, 10, 'Omschrijving', 1);
$pdf->Cell(30, 10, 'Uren', 1);
$pdf->Cell(30, 10, 'Tarief', 1);
$pdf->Cell(30, 10, 'Totaal', 1, 1);

$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(100, 10, 'Werkuren ' . $data['functie'], 1);
$pdf->Cell(30, 10, number_format($aantal_uren, 0), 1);
$pdf->Cell(30, 10, '€ ' . number_format($uurloon, 2), 1);
$pdf->Cell(30, 10, '€ ' . number_format($subtotaal, 2), 1, 1);

// Totalen
$pdf->Ln(5);
$pdf->Cell(190, 7, 'Subtotaal: € ' . number_format($subtotaal, 2), 0, 1, 'R');
$pdf->Cell(190, 7, 'BTW (21%): € ' . number_format($btw, 2), 0, 1, 'R');
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(190, 7, 'Totaal te betalen: € ' . number_format($totaal, 2), 0, 1, 'R');

$pdf->Output('Factuur_' . $data['achternaam'] . '.pdf', 'I');
$conn->close();
?>
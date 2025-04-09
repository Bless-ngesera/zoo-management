<?php
require_once __DIR__ . '/../config/database.php';

// Ensure TCPDF library is included manually
if (!file_exists(__DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php')) {
    die('Error: TCPDF library not found. Please download it from https://github.com/tecnickcom/TCPDF and place it in the "vendor/tecnickcom/tcpdf" directory.');
}

require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php'; // Include TCPDF library

try {
    // Initialize PDF
    if (!class_exists('TCPDF')) {
        throw new Exception('TCPDF class not found. Ensure the library is correctly placed in the "vendor/tecnickcom/tcpdf" directory.');
    }

    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Zoo Management System');
    $pdf->SetTitle('Animal Report');
    $pdf->SetSubject('Report');
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);

    // Fetch data from the database
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT name, description FROM animals");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Add content to the PDF
    $pdf->Write(0, 'Animal Report', '', 0, 'C', true, 0, false, false, 0);
    $pdf->Ln(10); // Add a line break
    foreach ($data as $row) {
        $pdf->Write(0, "Name: {$row['name']}", '', 0, 'L', true, 0, false, false, 0);
        $pdf->Write(0, "Description: {$row['description']}", '', 0, 'L', true, 0, false, false, 0);
        $pdf->Ln(5); // Add spacing between entries
    }

    // Output the PDF
    $pdf->Output('animal_report.pdf', 'D');
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>

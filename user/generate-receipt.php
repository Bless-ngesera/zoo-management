<?php
require_once __DIR__ . '/../config/database.php';

// Ensure Composer's autoload file is included
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    die('Error: Composer autoload file not found. Please run "composer install".');
}
require_once __DIR__ . '/../vendor/autoload.php'; // Include TCPDF library

use TCPDF;

try {
    // Fetch purchase details
    if (!isset($_GET['ticket_id'])) {
        throw new Exception('Ticket ID is required.');
    }
    $ticketId = $_GET['ticket_id'];

    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT * FROM tickets WHERE id = ?");
    $stmt->execute([$ticketId]);
    $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$ticket) {
        throw new Exception('Ticket not found.');
    }

    // Initialize PDF
    if (!class_exists('TCPDF')) {
        throw new Exception('TCPDF class not found. Ensure the library is installed via Composer.');
    }

    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Zoo Management System');
    $pdf->SetTitle('Ticket Receipt');
    $pdf->SetSubject('Receipt');
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);

    // Add receipt content
    $pdf->Write(0, 'Receipt', '', 0, 'C', true, 0, false, false, 0);
    $pdf->Ln(10); // Add a line break
    $pdf->Write(0, "Ticket ID: {$ticket['id']}", '', 0, 'L', true, 0, false, false, 0);
    $pdf->Write(0, "Name: {$ticket['name']}", '', 0, 'L', true, 0, false, false, 0);
    $pdf->Write(0, "Amount Paid: {$ticket['amount']}", '', 0, 'L', true, 0, false, false, 0);

    // Output the PDF
    $pdf->Output('receipt.pdf', 'D');
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>

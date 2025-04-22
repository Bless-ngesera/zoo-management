<?php
require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php'; // Use Composer autoloader
require_once __DIR__ . '/../config/database.php'; // Include database configuration

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = htmlspecialchars($_POST['full_name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $ticketType = htmlspecialchars($_POST['ticket_type']);
    $adults = intval($_POST['adults']);
    $children = intval($_POST['children']);
    $totalAmount = htmlspecialchars($_POST['total_amount']);
    $date = date('Y-m-d H:i:s');

    try {
        // Establish database connection
        $pdo = new PDO(DSN, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert ticket details into the database
        $stmt = $pdo->prepare("
            INSERT INTO tickets (full_name, email, phone, ticket_type, adults, children, total_amount, booking_date)
            VALUES (:full_name, :email, :phone, :ticket_type, :adults, :children, :total_amount, :booking_date)
        ");
        $stmt->execute([
            ':full_name' => $fullName,
            ':email' => $email,
            ':phone' => $phone,
            ':ticket_type' => $ticketType,
            ':adults' => $adults,
            ':children' => $children,
            ':total_amount' => $totalAmount,
            ':booking_date' => $date
        ]);
    } catch (PDOException $e) {
        die("Error saving ticket to database: " . $e->getMessage());
    }

    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('BLESS ZOO');
    $pdf->SetTitle('Zoo Ticket');
    $pdf->SetHeaderData('', 0, 'Welcome! Discover and connect with wildlife at BLESS ZOO.', '');
    $pdf->setHeaderFont(['helvetica', '', 12]);
    $pdf->setFooterFont(['helvetica', '', 10]);
    $pdf->SetMargins(15, 27, 15);
    $pdf->SetAutoPageBreak(TRUE, 25);
    $pdf->AddPage();

    // Generate QR Code Data
    $qrData = "BLESS ZOO Ticket\n"
             . "Full Name: $fullName\n"
             . "Email: $email\n"
             . "Phone: $phone\n"
             . "Ticket Type: " . ucfirst($ticketType) . "\n"
             . "Adults: $adults\n"
             . "Children: $children\n"
             . "Total Amount: $totalAmount Ugx\n"
             . "Booking Date: $date";

    // Ticket Content
    $html = "
        <h1 style='text-align: center;'>BLESS ZOO - Ticket Confirmation</h1>
        <p><strong>Full Name:</strong> $fullName</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Ticket Type:</strong> " . ucfirst($ticketType) . " Visitor</p>
        <p><strong>Adults:</strong> $adults</p>
        <p><strong>Children:</strong> $children</p>
        <p><strong>Total Amount:</strong> $totalAmount Ugx</p>
        <p><strong>Date of Booking:</strong> $date</p>
    ";

    $pdf->writeHTML($html, true, false, true, false, '');

    // Add QR Code below the ticket details on the right side
    $pdf->write2DBarcode($qrData, 'QRCODE,H', 130, 90, 40, 40, [], 'N'); // X=130, Y=90, Width=40, Height=40
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Text(130, 132, 'Scan for Verification'); // Label below the QR code

    $pdf->Output('zoo_ticket.pdf', 'D');
    exit;
} else {
    echo "Invalid request.";
}
?>

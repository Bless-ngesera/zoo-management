<?php
// Start output buffering to prevent premature output
ob_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../vendor/tecnickcom/tcpdf/tcpdf.php';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';

require_auth();
require_role('admin');

// Fetch data for reports
try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch ticket data
    $ticketStmt = $pdo->query("SELECT COUNT(*) AS total_tickets, SUM(total_amount) AS total_revenue FROM tickets");
    $ticketReport = $ticketStmt->fetch(PDO::FETCH_ASSOC);

    // Fetch animal data
    $animalStmt = $pdo->query("SELECT COUNT(*) AS total_animals FROM animals");
    $animalReport = $animalStmt->fetch(PDO::FETCH_ASSOC);

    // Fetch animal details
    $animalDetailsStmt = $pdo->query("SELECT name, species, habitat FROM animals");
    $animalDetails = $animalDetailsStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div style='color: red; font-weight: bold;'>Database error: " . htmlspecialchars($e->getMessage()) . "</div>";
    exit;
}

// Generate PDF reports for download
if (isset($_GET['download']) && ($_GET['download'] === 'tickets' || $_GET['download'] === 'animals')) {
    ob_end_clean(); // Clear the output buffer before generating the PDF

    $pdf = new \TCPDF();
    $pdf->SetCreator('Zoo Management System');
    $pdf->SetAuthor('Zoo Management');
    $pdf->SetTitle('Daily Report');
    $pdf->SetHeaderData('', 0, 'BLESS ZOO', 'Daily Report');
    $pdf->setHeaderFont(['helvetica', '', 10]);
    $pdf->setFooterFont(['helvetica', '', 8]);
    $pdf->SetMargins(15, 27, 15);
    $pdf->SetHeaderMargin(5);
    $pdf->SetFooterMargin(10);
    $pdf->SetAutoPageBreak(TRUE, 25);
    $pdf->AddPage();

    $currentDate = date('Y-m-d H:i:s'); // Get the current date and time

    if ($_GET['download'] === 'tickets') {
        $pdf->SetFont('helvetica', '', 12);
        $html = '<h1>Tickets Report</h1>';
        $html .= '<p>Date: <strong>' . $currentDate . '</strong></p>';
        $html .= '<p>Total Tickets: <strong>' . ($ticketReport['total_tickets'] ?? 0) . '</strong></p>';
        $html .= '<p>Total Revenue: <strong>' . number_format($ticketReport['total_revenue'] ?? 0, 2) . ' Ugx</strong></p>';
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('tickets_report.pdf', 'D');
    }

    if ($_GET['download'] === 'animals') {
        $pdf->SetFont('helvetica', '', 12);
        $html = '<h1>Animals Report</h1>';
        $html .= '<p>Date: <strong>' . $currentDate . '</strong></p>';
        $html .= '<p>Total Animals: <strong>' . ($animalReport['total_animals'] ?? 0) . '</strong></p>';
        $html .= '<h2>Animal Details</h2>';
        $html .= '<table border="1" cellpadding="5">';
        $html .= '<thead><tr><th><strong>Name</strong></th><th><strong>Species</strong></th><th><strong>Habitat</strong></th></tr></thead><tbody>';
        foreach ($animalDetails as $animal) {
            $html .= '<tr><td>' . htmlspecialchars($animal['name']) . '</td><td>' . htmlspecialchars($animal['species']) . '</td><td>' . htmlspecialchars($animal['habitat']) . '</td></tr>';
        }
        $html .= '</tbody></table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('animals_report.pdf', 'D');
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Reports</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            padding-top: 4rem; /* Adjust for fixed header height */
        }
        #profileDropdownMenu {
            display: none;
        }
        #profileDropdownButton:focus + #profileDropdownMenu,
        #profileDropdownButton:hover + #profileDropdownMenu {
            display: block;
        }
        #main-content {
            transition: margin-left 0.3s ease-in-out;
            margin-left: 16rem; /* Default margin for sidebar */
        }
        #main-content.expanded {
            margin-left: 0;
        }
        #sidebar {
            background-color: #3B82F6; /* Sidebar background color */
        }
        #hideSidebar {
            background-color: #3B82F6; /* Hide sidebar button background color */
        }
        #showSidebar {
            background-color: #3B82F6; /* Show sidebar button background color */
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Fixed Header -->
    <div class="fixed top-0 left-0 w-full bg-white p-4 flex justify-between items-center shadow-md z-50">
        <!-- Logo or Title -->
        <div class="text-xl font-bold text-primary" style="color: #3B82F6; font-weight: bolder; font-size: x-large;">
            ZOO <span style="color: #10B981;">MANAGEMENT</span> <span style="color: black">SYSTEM</span>
        </div>

        <!-- Profile Dropdown -->
        <div class="relative">
            <button id="profileDropdownButton" class="flex items-center space-x-2 bg-purple-600 text-white px-4 py-2 rounded-lg focus:outline-none">
                <img src="/zoo-management/image/admin.png" alt="Admin Avatar" class="w-8 h-8 rounded-full">
                <span>Admin</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div id="profileDropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg">
                <a href="/zoo-management/admin/profile.php" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                <a href="/zoo-management/admin/settings.php" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
                <a href="/zoo-management/logout.php" class="block px-4 py-2 text-red-500 hover:bg-gray-100">Log Out</a>
            </div>
        </div>
    </div>

    <div class="flex">
        <!-- Include Sidebar -->
        <?php include __DIR__ . '/../../includes/sidebar.php'; ?>

        <!-- Show Sidebar Button -->
        <button id="showSidebar" class="hidden fixed top-20 left-2 bg-blue-600 text-white p-2 rounded-full shadow-md focus:outline-none transition-transform transform">
            <i class="fas fa-chevron-right"></i>
        </button>

        <!-- Main Content -->
        <main id="main-content" class="flex-1 p-6 ml-64 transition-all">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Daily Reports</h1>

                <div class="space-y-6">
                    <!-- Tickets Report -->
                    <div class="bg-blue-100 border border-blue-300 rounded-lg p-4">
                        <h2 class="text-xl font-bold text-blue-800 mb-2">Tickets Report</h2>
                        <p>Total Tickets: <strong><?php echo $ticketReport['total_tickets'] ?? 0; ?></strong></p>
                        <p>Total Revenue: <strong><?php echo number_format($ticketReport['total_revenue'] ?? 0, 2); ?> Ugx</strong></p>
                        <a href="?download=tickets" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Download Tickets Report (PDF)
                        </a>
                    </div>

                    <!-- Animals Report -->
                    <div class="bg-green-100 border border-green-300 rounded-lg p-4">
                        <h2 class="text-xl font-bold text-green-800 mb-2">Animals Report</h2>
                        <p>Total Animals: <strong><?php echo $animalReport['total_animals'] ?? 0; ?></strong></p>
                        <a href="?download=animals" class="mt-4 inline-block bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                            Download Animals Report (PDF)
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const hideSidebar = document.getElementById('hideSidebar');
        const showSidebar = document.getElementById('showSidebar');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');

        // Ensure all elements exist before adding event listeners
        if (hideSidebar && showSidebar && sidebar && mainContent) {
            hideSidebar.addEventListener('click', function () {
                sidebar.classList.add('-translate-x-full');
                mainContent.classList.remove('ml-64');
                mainContent.classList.add('ml-0');
                hideSidebar.classList.add('hidden');
                showSidebar.classList.remove('hidden');
            });

            showSidebar.addEventListener('click', function () {
                sidebar.classList.remove('-translate-x-full');
                mainContent.classList.add('ml-64');
                mainContent.classList.remove('ml-0');
                showSidebar.classList.add('hidden');
                hideSidebar.classList.remove('hidden');
            });
        }
    });
    </script>
</body>
</html>
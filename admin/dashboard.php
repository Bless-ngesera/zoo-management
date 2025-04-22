<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

// Establish database connection
try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Require authentication
require_auth();

// Ensure the user has the 'admin' role
require_role('admin');

// Fetch statistics
$animal_count = $pdo->query("SELECT COUNT(*) FROM animals")->fetchColumn();
$user_count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$ticket_count = $pdo->query("SELECT COUNT(*) FROM tickets")->fetchColumn();
$alerts_count = $pdo->query("SELECT COUNT(*) FROM alerts")->fetchColumn(); // Alerts table
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#10B981',
                        danger: '#EF4444',
                        glass: 'rgba(255, 255, 255, 0.2)',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #f3f4f6;
        }
        .glass {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100">
    <?php include __DIR__ . '/../includes/profile-dropdown.php'; ?>
    <div class="flex h-screen pt-20">
        <?php include __DIR__ . '/../includes/sidebar.php'; ?>
        <main id="mainContent" class="ml-64 flex-1 p-6 transition-all">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
                <button id="darkModeToggle" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary-600">Toggle Dark Mode</button>
            </div>

            <!-- Analytics Widgets -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="glass p-6 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-primary text-white mr-4">
                            <i class="fas fa-paw"></i>
                        </div>
                        <div>
                            <p class="text-gray-500">Total Animals</p>
                            <h3 class="text-2xl font-bold"><?php echo $animal_count; ?></h3>
                        </div>
                    </div>
                </div>
                <div class="glass p-6 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-secondary text-white mr-4">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <p class="text-gray-500">Total Users</p>
                            <h3 class="text-2xl font-bold"><?php echo $user_count; ?></h3>
                        </div>
                    </div>
                </div>
                <div class="glass p-6 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-500 text-white mr-4">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div>
                            <p class="text-gray-500">Total Tickets</p>
                            <h3 class="text-2xl font-bold"><?php echo $ticket_count; ?></h3>
                        </div>
                    </div>
                </div>
                <div class="glass p-6 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-danger text-white mr-4">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div>
                            <p class="text-gray-500">Alerts</p>
                            <h3 class="text-2xl font-bold"><?php echo $alerts_count; ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="glass p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Weekly Visitors</h2>
                    <canvas id="visitorsChart" height="250"></canvas>
                </div>
                <div class="glass p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Ticket Types</h2>
                    <canvas id="ticketTypesChart" height="250"></canvas>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sidebar Toggle
        const hideSidebar = document.getElementById('hideSidebar');
        const showSidebar = document.getElementById('showSidebar');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

        hideSidebar.addEventListener('click', () => {
            // Hide sidebar
            sidebar.classList.add('-translate-x-full');
            mainContent.classList.remove('ml-64');
            mainContent.classList.add('ml-0');
            hideSidebar.classList.add('hidden');
            showSidebar.classList.remove('hidden');
        });

        showSidebar.addEventListener('click', () => {
            // Show sidebar
            sidebar.classList.remove('-translate-x-full');
            mainContent.classList.add('ml-64');
            mainContent.classList.remove('ml-0');
            showSidebar.classList.add('hidden');
            hideSidebar.classList.remove('hidden');
        });

        // Dark Mode Toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        darkModeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark');
            document.body.classList.toggle('bg-gray-900');
            document.body.classList.toggle('text-white');
        });

        // Visitors Chart
        const visitorsCtx = document.getElementById('visitorsChart').getContext('2d');
        new Chart(visitorsCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Visitors',
                    data: [120, 190, 170, 200, 250, 300, 280],
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Ticket Types Chart
        const ticketTypesCtx = document.getElementById('ticketTypesChart').getContext('2d');
        new Chart(ticketTypesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Ugandans', 'Foreigners'],
                datasets: [{
                    data: [65, 180],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(16, 185, 129, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'right' }
                }
            }
        });
    </script>
</body>
</html>

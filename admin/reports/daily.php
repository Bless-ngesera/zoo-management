<?php
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAuth();

// Fetch daily report data
$today = date('Y-m-d');
$stmt = $pdo->prepare("SELECT * FROM tickets WHERE DATE(created_at) = ?");
$stmt->execute([$today]);
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Reports</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-800">Daily Reports</h1>
        <table class="min-w-full mt-6 bg-white rounded-lg shadow-md">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($tickets as $ticket): ?>
                    <tr>
                        <td class="px-6 py-4"><?php echo htmlspecialchars($ticket['id']); ?></td>
                        <td class="px-6 py-4"><?php echo htmlspecialchars($ticket['ticket_type']); ?></td>
                        <td class="px-6 py-4"><?php echo htmlspecialchars($ticket['total_price']); ?></td>
                        <td class="px-6 py-4"><?php echo htmlspecialchars($ticket['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
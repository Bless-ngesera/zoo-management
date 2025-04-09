<?php
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/auth.php';

// Ensure $pdo is initialized
if (!isset($pdo)) {
    die('Error: Database connection not established.');
}

requireAuth();
require_role('admin');

// Fetch users
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white h-screen fixed">
            <div class="p-4 text-center font-bold text-xl border-b border-gray-700">
                Zoo Management
            </div>
            <nav class="flex-1">
                <ul class="space-y-2">
                    <li><a href="/zoo-management/admin/dashboard.php" class="block py-2 px-4 hover:bg-primary-600"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</a></li>
                    <li><a href="/zoo-management/admin/animals/manage.php" class="block py-2 px-4 hover:bg-primary-600"><i class="fas fa-paw mr-2"></i> Manage Animals</a></li>
                    <li><a href="/zoo-management/admin/animals/details.php" class="block py-2 px-4 hover:bg-primary-600"><i class="fas fa-info-circle mr-2"></i> View Animals</a></li>
                    <li><a href="/zoo-management/admin/users/manage.php" class="block py-2 px-4 hover:bg-primary-600"><i class="fas fa-users mr-2"></i> Users</a></li>
                    <li><a href="/zoo-management/admin/reports/daily.php" class="block py-2 px-4 hover:bg-primary-600"><i class="fas fa-chart-line mr-2"></i> Reports</a></li>
                    <li><a href="/zoo-management/chat/index.php" class="block py-2 px-4 hover:bg-primary-600"><i class="fas fa-comments mr-2"></i> Chatrooms</a></li>
                    <li><a href="/zoo-management/email/index.php" class="block py-2 px-4 hover:bg-primary-600"><i class="fas fa-envelope mr-2"></i> Email</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 ml-64 transition-all">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Manage Users</h1>
            <table class="min-w-full bg-white rounded-lg shadow-md">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($user['id']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($user['username']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($user['role']); ?></td>
                            <td class="px-6 py-4">
                                <a href="edit.php?id=<?php echo $user['id']; ?>" class="text-primary hover:underline">Edit</a>
                                <a href="delete.php?id=<?php echo $user['id']; ?>" class="text-red-500 hover:underline" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>

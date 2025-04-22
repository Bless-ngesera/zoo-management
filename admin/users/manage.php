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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #3B82F6; /* Set background color */
        }
        #sidebar {
            background-color: #3B82F6; /* Set sidebar background color */
        }
        #showSidebar {
            background-color: #3B82F6; /* Set hideSidebar button background color */
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Top Navigation Bar -->
    <div class="fixed top-0 left-0 w-full bg-white p-4 flex justify-between items-center shadow-md z-50">
        <div class="text-xl font-bold text-primary" style="color: #3B82F6; font-weight: bolder; font-size: x-large;">
            ZOO <span style="color: #10B981;">MANAGEMENT</span> <span style="color: black">SYSTEM</span>
        </div>
        <div class="relative">
            <button id="profileDropdownButton" class="flex items-center space-x-2 bg-purple-600 text-white px-4 py-2 rounded-lg focus:outline-none">
                <img src="/zoo-management/uploads/default-avatar.png" alt="Admin Avatar" class="w-8 h-8 rounded-full">
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

    <div class="flex pt-16">
        <!-- Include Sidebar -->
        <?php include __DIR__ . '/../../includes/sidebar.php'; ?>

        <!-- Main Content -->
        <main id="mainContent" class="flex-1 p-6 ml-64 transition-all">
            <div class="flex flex-wrap justify-between items-center mb-4 gap-4">
                <h1 class="text-3xl font-bold text-gray-800">Manage Users</h1>
                <a href="add.php" class="bg-[#10B981] text-white px-4 py-2 rounded-lg hover:bg-primary-600">
                    <i class="fas fa-user-plus mr-2"></i>Add New User
                </a>
            </div>
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

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownButton = document.getElementById('profileDropdownButton');
        const dropdownMenu = document.getElementById('profileDropdownMenu');

        dropdownButton.addEventListener('click', function () {
            dropdownMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function (event) {
            if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });

        const hideSidebar = document.getElementById('hideSidebar');
        const showSidebar = document.getElementById('showSidebar');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

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
    });
    </script>
</body>
</html>

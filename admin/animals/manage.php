<?php
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/auth.php';
require_auth();
require_role('admin');

// Fetch animals
$stmt = $pdo->query("SELECT * FROM animals");
$animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Animals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#10B981',
                        danger: '#EF4444',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <?php include __DIR__ . '/../../includes/profile-dropdown.php'; ?>
    <div class="flex h-screen pt-20">
        <?php include __DIR__ . '/../../includes/sidebar.php'; ?>
        <main id="mainContent" class="ml-64 flex-1 p-6 transition-all">
            <div class="container mx-auto p-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Manage Animals</h1>
                <a href="add.php" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-600 mb-4 inline-block">
                    <i class="fas fa-plus mr-2"></i>Add New Animal
                </a>
                <table class="min-w-full bg-white rounded-lg shadow-md">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Species</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($animals as $animal): ?>
                            <tr>
                                <td class="px-6 py-4">
                                    <img src="/zoo-management/<?php echo htmlspecialchars($animal['image']); ?>" alt="<?php echo htmlspecialchars($animal['name']); ?>" class="w-16 h-16 object-cover rounded">
                                </td>
                                <td class="px-6 py-4"><?php echo htmlspecialchars($animal['name']); ?></td>
                                <td class="px-6 py-4"><?php echo htmlspecialchars($animal['species']); ?></td>
                                <td class="px-6 py-4">
                                    <a href="details.php?id=<?php echo $animal['id']; ?>" class="text-primary hover:underline">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </a>
                                    <a href="edit.php?id=<?php echo $animal['id']; ?>" class="text-primary hover:underline ml-4">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <a href="delete.php?id=<?php echo $animal['id']; ?>" class="text-red-500 hover:underline ml-4" onclick="return confirm('Are you sure you want to delete?')">
                                        <i class="fas fa-trash-alt mr-1"></i>Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        const hideSidebar = document.getElementById('hideSidebar');
        const showSidebar = document.getElementById('showSidebar');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

        hideSidebar.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            mainContent.classList.remove('ml-64');
            mainContent.classList.add('ml-0');
            hideSidebar.classList.add('hidden');
            showSidebar.classList.remove('hidden');
        });

        showSidebar.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            mainContent.classList.add('ml-64');
            mainContent.classList.remove('ml-0');
            showSidebar.classList.add('hidden');
            hideSidebar.classList.remove('hidden');
        });
    </script>
</body>
</html>

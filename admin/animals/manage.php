<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/auth.php';
require_auth();
require_role('admin');

// Establish database connection
try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch animals from the database
try {
    $stmt = $pdo->query("SELECT id, name, description, image FROM animals");
    $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
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
    <div class="flex flex-col md:flex-row h-screen pt-20">
        <?php include __DIR__ . '/../../includes/sidebar.php'; ?>
        <main id="mainContent" class="flex-1 p-4 md:p-6 transition-all ml-64">
            <div class="container mx-auto">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4 md:mb-6">Manage Animals</h1>
                <?php if (isset($_GET['deleted']) && $_GET['deleted'] == '1'): ?>
                    <div class="text-center py-8">
                        <div class="text-green-500 text-4xl md:text-5xl mb-4">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h1 class="text-xl md:text-2xl font-bold text-gray-800 mb-2">Animal Deleted Successfully</h1>
                        <p class="text-gray-600 mb-6">The animal has been removed from the system.</p>
                    </div>
                <?php endif; ?>
                <a href="add.php" class="bg-primary text-white px-3 py-2 md:px-4 md:py-2 rounded-lg hover:bg-primary-600 mb-4 inline-block">
                    <i class="fas fa-plus mr-2"></i>Add New Animal
                </a>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (!empty($animals)): ?>
                                <?php foreach ($animals as $animal): ?>
                                    <tr>
                                        <td class="px-4 md:px-6 py-4"><?php echo htmlspecialchars($animal['id']); ?></td>
                                        <td class="px-4 md:px-6 py-4"><?php echo htmlspecialchars($animal['name']); ?></td>
                                        <td class="px-4 md:px-6 py-4"><?php echo htmlspecialchars($animal['description']); ?></td>
                                        <td class="px-4 md:px-6 py-4">
                                            <img src="/zoo-management/<?php echo htmlspecialchars($animal['image']); ?>" alt="<?php echo htmlspecialchars($animal['name']); ?>" class="w-12 h-12 md:w-16 md:h-16 object-cover rounded">
                                        </td>
                                        <td class="px-4 md:px-6 py-4">
                                            <a href="details.php?id=<?php echo $animal['id']; ?>" class="text-primary hover:underline">
                                                <i class="fas fa-eye mr-1"></i>View
                                            </a>
                                            <a href="edit.php?id=<?php echo $animal['id']; ?>" class="text-primary hover:underline ml-2 md:ml-4">
                                                <i class="fas fa-edit mr-1"></i>Edit
                                            </a>
                                            <a href="delete.php?id=<?php echo $animal['id']; ?>" class="text-red-500 hover:underline ml-2 md:ml-4" onclick="return confirm('Are you sure you want to delete?')">
                                                <i class="fas fa-trash-alt mr-1"></i>Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center px-4 md:px-6 py-4">No animals found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
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

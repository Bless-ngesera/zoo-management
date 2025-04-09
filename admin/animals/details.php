<?php
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../config/database.php';

// Establish database connection
try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

require_once __DIR__ . '/../../includes/auth.php';
require_auth();
require_role('admin');

// Fetch all animals from the database
$stmt = $pdo->query("SELECT name, species, habitat, description, image FROM animals");
$animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Details</title>
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
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    <?php include __DIR__ . '/../../includes/profile-dropdown.php'; ?>
    <div class="flex h-screen pt-20">
        <?php include __DIR__ . '/../../includes/sidebar.php'; ?>
        <main id="mainContent" class="ml-64 flex-1 p-6 transition-all">
            <div class="bg-white rounded-lg shadow-md p-6 max-w-5xl mx-auto">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Animal Details</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($animals as $animal): ?>
                        <div class="border rounded-lg p-4 shadow-sm">
                            <img src="/zoo-management/<?php echo htmlspecialchars($animal['image']); ?>" alt="<?php echo htmlspecialchars($animal['name']); ?>" class="h-32 w-full object-cover rounded mb-2">
                            <h3 class="text-lg font-bold text-gray-800"><?php echo htmlspecialchars($animal['name']); ?></h3>
                            <p class="text-sm text-gray-600">Species: <?php echo htmlspecialchars($animal['species']); ?></p>
                            <p class="text-sm text-gray-600">Habitat: <?php echo htmlspecialchars($animal['habitat']); ?></p>
                            <p class="text-sm text-gray-600">Description: <?php echo htmlspecialchars($animal['description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-6">
                    <a href="../dashboard.php" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-600 transition">Back to Dashboard</a>
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

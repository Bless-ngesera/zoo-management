<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . 'config/constants.php';
require_once __DIR__ . 'config/database.php';
require_once __DIR__ . 'includes/auth.php';
require_once __DIR__ . 'includes/header.php';

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

requireAuth();

// Fetch animals from the database
$stmt = $pdo->query("SELECT * FROM animals");
$animals = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Debugging: Check if animals are fetched
if (empty($animals)) {
    echo "<p class='text-red-500'>No animals found in the database. Please add some animals.</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animals</title>
    <link href="assets/css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold">Animals</h1>
        <p class="mt-2">Welcome to the Zoo Management System!</p>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Our Animals</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($animals as $animal): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="h-48 overflow-hidden">
                            <img src="<?php echo htmlspecialchars($animal['image']); ?>" alt="<?php echo htmlspecialchars($animal['name']); ?>" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <h3 class="text-xl font-bold text-gray-800 mb-1"><?php echo htmlspecialchars($animal['name']); ?></h3>
                            <p class="text-sm text-gray-500 mb-2"><span class="font-semibold">Species:</span> <?php echo htmlspecialchars($animal['species']); ?></p>
                            <p class="text-sm text-gray-500 mb-3"><span class="font-semibold">Habitat:</span> <?php echo htmlspecialchars($animal['habitat']); ?></p>
                            <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($animal['description']); ?></p>
                            <button class="text-primary font-medium hover:underline">View Details</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php
require_once __DIR__ . '/includes/footer.php';
?>
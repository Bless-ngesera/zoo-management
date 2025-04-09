<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/database.php';

$animals = []; // Initialize animals array to avoid undefined variable errors

// Fetch animals from the database
try {
    // Ensure DSN, DB_USER, and DB_PASS are defined in database.php
    if (!defined('DSN') || !defined('DB_USER') || !defined('DB_PASS')) {
        throw new Exception("Database configuration constants are not defined.");
    }

    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch animals
    $stmt = $pdo->query("SELECT name, description, image FROM animals");
    $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage()); // Temporarily display the error
} catch (Exception $e) {
    die("Error: " . $e->getMessage()); // Temporarily display the error
}

// Include header
require_once __DIR__ . '/../includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animals - Zoo Management</title>
    <link rel="stylesheet" href="/zoo-management/output.css">
</head>
<body>
    <main class="container mx-auto py-12">
        <h1 class="text-3xl font-bold text-center mb-8">Our Animals</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (!empty($animals)): ?>
                <?php foreach ($animals as $animal): ?>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <img src="/zoo-management/uploads/<?php echo file_exists(__DIR__ . '/../uploads/' . $animal['image']) 
                            ? htmlspecialchars($animal['image']) 
                            : 'placeholder.jpg'; ?>" 
                            alt="<?php echo htmlspecialchars($animal['name']); ?>" 
                            class="w-full h-48 object-cover rounded-lg mb-4">
                        <h3 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($animal['name']); ?></h3>
                        <p class="text-gray-600"><?php echo htmlspecialchars($animal['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-gray-600">No animals found.</p>
            <?php endif; ?>
        </div>
    </main>
    <?php
    // Include footer
    require_once __DIR__ . '/../includes/footer.php';
    ?>
</body>
</html>

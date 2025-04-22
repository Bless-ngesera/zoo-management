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

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $animalId = intval($_GET['id']);

    try {
        // Establish database connection
        $pdo = new PDO(DSN, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Delete the animal record
        $stmt = $pdo->prepare("DELETE FROM animals WHERE id = :id");
        $stmt->execute([':id' => $animalId]);

        // Redirect to the dashboard or a valid page with a success message
        header("Location: /zoo-management/admin/dashboard.php?message=AnimalDeleted+successfully");
        exit;
    } catch (PDOException $e) {
        die("Error deleting animal: " . htmlspecialchars($e->getMessage()));
    }
} else {
    // Redirect to the dashboard or a valid page with an error message
    header("Location: /zoo-management/admin/dashboard.php?error=Invalid+animal+ID");
    exit;
}
?>

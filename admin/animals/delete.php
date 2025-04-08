<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_auth();
require_role('admin');
require_once __DIR__ . '/../../../includes/header.php';

// In a real application, this would:
// 1. Get animal ID from $_GET['id']
// 2. Verify the animal exists
// 3. Delete the animal from database
// 4. Delete associated image file

// For this demo, we'll simulate a successful deletion
$deleted = true;
?>

<div class="bg-white rounded-lg shadow-md p-6 max-w-3xl mx-auto">
    <?php if ($deleted): ?>
        <div class="text-center py-8">
            <div class="text-green-500 text-5xl mb-4">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Animal Deleted Successfully</h1>
            <p class="text-gray-600 mb-6">The animal has been removed from the system.</p>
            <a href="../view.php" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition inline-block">
                <i class="fas fa-arrow-left mr-2"></i> Back to Animals
            </a>
        </div>
    <?php else: ?>
        <div class="text-center py-8">
            <div class="text-red-500 text-5xl mb-4">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Deletion Failed</h1>
            <p class="text-gray-600 mb-6">There was an error deleting the animal. Please try again.</p>
            <div class="flex justify-center space-x-4">
                <a href="../view.php" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition inline-block">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Animals
                </a>
                <a href="javascript:history.back()" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition inline-block">
                    <i class="fas fa-undo mr-2"></i> Try Again
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>
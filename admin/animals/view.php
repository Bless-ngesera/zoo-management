<?php
require_once __DIR__ . '/../../includes/auth.php'; // Corrected path
require_auth();
require_role('admin');
require_once __DIR__ . '/../../includes/header.php';
?>

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Animal Management</h1>
        <a href="add.php" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-600 transition flex items-center">
            <i class="fas fa-plus mr-2"></i> Add Animal
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Species</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Habitat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php
                // Fetch animals from the database
                require_once __DIR__ . '/../../config/database.php';
                $stmt = $pdo->query("SELECT * FROM animals");
                $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($animals as $animal) {
                    echo '
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="'.$animal['image'].'" alt="'.$animal['name'].'" class="w-16 h-16 object-cover rounded">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">'.$animal['name'].'</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">'.$animal['species'].'</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                '.$animal['habitat'].'
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="edit.php?id='.$animal['id'].'" class="text-primary hover:text-primary-600 mr-3">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="delete.php?id='.$animal['id'].'" class="text-red-600 hover:text-red-900" onclick="return confirm(\'Are you sure you want to delete this animal?\')">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex items-center justify-between mt-6">
        <div class="text-sm text-gray-500">
            Showing <span class="font-medium">1</span> to <span class="font-medium"><?php echo count($animals); ?></span> of <span class="font-medium"><?php echo count($animals); ?></span> results
        </div>
        <div class="flex space-x-2">
            <button class="px-3 py-1 border rounded text-gray-500 bg-white cursor-not-allowed" disabled>
                Previous
            </button>
            <button class="px-3 py-1 border rounded bg-primary text-white">
                1
            </button>
            <button class="px-3 py-1 border rounded text-gray-500 bg-white cursor-not-allowed" disabled>
                Next
            </button>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>
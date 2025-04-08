<?php

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../includes/auth.php';
require_auth();
require_role('admin');
// require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../config/database.php';

// Define helper functions
function validate_input($data) {
    return htmlspecialchars(trim($data));
}

function upload_image($file) {
    $upload_dir = __DIR__ . '/../../uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowed_types)) {
        return ['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and GIF are allowed.'];
    }

    if ($file['size'] > 5 * 1024 * 1024) { // 5MB limit
        return ['success' => false, 'message' => 'File size exceeds the 5MB limit.'];
    }

    $file_name = uniqid() . '-' . basename($file['name']);
    $file_path = $upload_dir . $file_name;

    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        return ['success' => true, 'path' => 'uploads/' . $file_name];
    } else {
        return ['success' => false, 'message' => 'Failed to upload the file.'];
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = validate_input($_POST['name']);
    $species = validate_input($_POST['species']);
    $habitat = validate_input($_POST['habitat']);
    $description = validate_input($_POST['description']);
    $created_by = $_SESSION['user_id'] ?? null; // Get the logged-in user's ID from the session

    // Handle file upload
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_result = upload_image($_FILES['image']);
        if ($upload_result['success']) {
            $image_path = $upload_result['path'];
        } else {
            $errors[] = $upload_result['message'];
        }
    }

    // Validate inputs
    $errors = [];
    if (empty($name)) $errors[] = 'Name is required.';
    if (empty($species)) $errors[] = 'Species is required.';
    if (empty($habitat)) $errors[] = 'Habitat is required.';
    if (empty($image_path)) $errors[] = 'Image is required.';
    if (empty($created_by)) $errors[] = 'User ID is missing. Please log in again.';

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO animals (name, species, habitat, description, image, created_by) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $species, $habitat, $description, $image_path, $created_by]);
            $success = true;
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Zoo Management System</title>
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-6">Add New Animal</h1>

                    <?php if (isset($success)): ?>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            Animal added successfully! <a href="manage.php" class="font-semibold underline">View all animals</a>
                        </div>
                    <?php elseif (!empty($errors)): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <?php foreach ($errors as $error): ?>
                                <p><?php echo $error; ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-gray-700 mb-1">Animal Name*</label>
                                <input type="text" id="name" name="name" required
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                                    value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
                            </div>

                            <div>
                                <label for="species" class="block text-gray-700 mb-1">Species*</label>
                                <input type="text" id="species" name="species" required
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                                    value="<?php echo isset($species) ? htmlspecialchars($species) : ''; ?>">
                            </div>
                        </div>

                        <div>
                            <label for="habitat" class="block text-gray-700 mb-1">Habitat*</label>
                            <select id="habitat" name="habitat" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                                <option value="">Select Habitat</option>
                                <option value="Savanna" <?php echo (isset($habitat) && $habitat === 'Savanna') ? 'selected' : ''; ?>>Savanna</option>
                                <option value="Forest" <?php echo (isset($habitat) && $habitat === 'Forest') ? 'selected' : ''; ?>>Forest</option>
                                <option value="Jungle" <?php echo (isset($habitat) && $habitat === 'Jungle') ? 'selected' : ''; ?>>Jungle</option>
                                <option value="Desert" <?php echo (isset($habitat) && $habitat === 'Desert') ? 'selected' : ''; ?>>Desert</option>
                                <option value="Aquatic" <?php echo (isset($habitat) && $habitat === 'Aquatic') ? 'selected' : ''; ?>>Aquatic</option>
                                <option value="Arctic" <?php echo (isset($habitat) && $habitat === 'Arctic') ? 'selected' : ''; ?>>Arctic</option>
                            </select>
                        </div>

                        <div>
                            <label for="description" class="block text-gray-700 mb-1">Description</label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"><?php echo isset($description) ? htmlspecialchars($description) : ''; ?></textarea>
                        </div>

                        <div>
                            <label for="image" class="block text-gray-700 mb-1">Image*</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                        <p class="mb-2 text-sm text-gray-500">
                                            <span class="font-semibold">Click to upload</span> or drag and drop
                                        </p>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF (MAX. 5MB)</p>
                                    </div>
                                    <input id="image" name="image" type="file" class="hidden" accept="image/*" required />
                                </label>
                            </div>
                            <div id="image-preview" class="mt-2 hidden">
                                <img id="preview-image" class="h-32 object-cover rounded">
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4 pt-4">
                            <a href="manage.php" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                                Cancel
                            </a>
                            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition">
                                Save Animal
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </body>
</html>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');
    const previewImage = document.getElementById('preview-image');

    imageInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                imagePreview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>

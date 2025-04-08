<?php
require_once __DIR__ . '/../../config/database.php'; // Include database connection
require_once __DIR__ . '/../../includes/auth.php'; // Include authentication
require_auth();
require_role('admin');

// Fetch animal details
$animal_id = $_GET['id'] ?? null;
if (!$animal_id) {
    die("Animal ID is required.");
}

$stmt = $pdo->prepare("SELECT * FROM animals WHERE id = ?");
$stmt->execute([$animal_id]);
$animal = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$animal) {
    die("Animal not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $species = htmlspecialchars(trim($_POST['species']));
    $habitat = htmlspecialchars(trim($_POST['habitat']));
    $description = htmlspecialchars(trim($_POST['description']));

    // Handle file upload
    $image_path = $animal['image']; // Keep the existing image path by default
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../../uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['image']['type'], $allowed_types)) {
            $file_name = uniqid() . '-' . basename($_FILES['image']['name']);
            $file_path = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {
                $image_path = 'uploads/' . $file_name;
            } else {
                $errors[] = "Failed to upload the image.";
            }
        } else {
            $errors[] = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
        }
    }

    // Validate inputs
    $errors = [];
    if (empty($name)) $errors[] = 'Name is required.';
    if (empty($species)) $errors[] = 'Species is required.';
    if (empty($habitat)) $errors[] = 'Habitat is required.';

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("UPDATE animals SET name = ?, species = ?, habitat = ?, description = ?, image = ? WHERE id = ?");
            $stmt->execute([$name, $species, $habitat, $description, $image_path, $animal_id]);
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
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Animal</h1>

                <!-- Success or Error Messages -->
                <?php if (isset($success)): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        Animal updated successfully! <a href="manage.php" class="font-semibold underline">View all animals</a>
                    </div>
                <?php elseif (!empty($errors)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <?php foreach ($errors as $error): ?>
                            <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Edit Form Section -->
                <form method="POST" enctype="multipart/form-data" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-gray-700 mb-1">Animal Name*</label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                                value="<?php echo htmlspecialchars($animal['name']); ?>">
                        </div>
                        
                        <div>
                            <label for="species" class="block text-gray-700 mb-1">Species*</label>
                            <input type="text" id="species" name="species" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                                value="<?php echo htmlspecialchars($animal['species']); ?>">
                        </div>
                    </div>
                    
                    <div>
                        <label for="habitat" class="block text-gray-700 mb-1">Habitat*</label>
                        <select id="habitat" name="habitat" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                            <option value="">Select Habitat</option>
                            <option value="Savanna" <?php echo ($animal['habitat'] === 'Savanna') ? 'selected' : ''; ?>>Savanna</option>
                            <option value="Forest" <?php echo ($animal['habitat'] === 'Forest') ? 'selected' : ''; ?>>Forest</option>
                            <option value="Jungle" <?php echo ($animal['habitat'] === 'Jungle') ? 'selected' : ''; ?>>Jungle</option>
                            <option value="Desert" <?php echo ($animal['habitat'] === 'Desert') ? 'selected' : ''; ?>>Desert</option>
                            <option value="Aquatic" <?php echo ($animal['habitat'] === 'Aquatic') ? 'selected' : ''; ?>>Aquatic</option>
                            <option value="Arctic" <?php echo ($animal['habitat'] === 'Arctic') ? 'selected' : ''; ?>>Arctic</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="description" class="block text-gray-700 mb-1">Description</label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"><?php echo htmlspecialchars($animal['description']); ?></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 mb-1">Current Image</label>
                        <img src="/zoo-management/<?php echo htmlspecialchars($animal['image']); ?>" alt="Current animal image" class="h-32 object-cover rounded mb-2">
                        
                        <label for="image" class="block text-gray-700 mb-1">New Image (Leave blank to keep current)</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-500">
                                        <span class="font-semibold">Click to upload</span>
                                    </p>
                                </div>
                                <input id="image" name="image" type="file" class="hidden" accept="image/*" />
                            </label>
                        </div>
                        <div id="image-preview" class="mt-2 hidden">
                            <p class="text-sm text-gray-500 mb-1">New image preview:</p>
                            <img id="preview-image" class="h-32 object-cover rounded">
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-4 pt-4">
                        <a href="manage.php" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Cancel
                        </a>
                        <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition">
                            Update Animal
                        </button>
                    </div>
                </form>
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
                } else {
                    imagePreview.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>


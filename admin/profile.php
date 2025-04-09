<?php
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_auth();
require_role('admin');

// Fetch admin profile data (replace with actual database query in a real app)
$admin = [
    'username' => 'admin',
    'email' => 'admin@zoo.com',
    'full_name' => 'Admin User',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = validate_input($_POST['full_name']);
    $email = validate_input($_POST['email']);

    // Update logic here (e.g., update the database)
    $admin['full_name'] = $full_name;
    $admin['email'] = $email;
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="p-6 max-w-3xl mx-auto bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">Admin Profile</h1>
    <?php if (isset($success)): ?>
        <p class="text-green-600">Profile updated successfully!</p>
    <?php endif; ?>
    <form method="POST" class="space-y-4">
        <div>
            <label for="full_name" class="block text-gray-700">Full Name</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($admin['full_name']); ?>" class="w-full px-4 py-2 border rounded-lg">
        </div>
        <div>
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" class="w-full px-4 py-2 border rounded-lg">
        </div>
        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg">Update Profile</button>
    </form>
</div>
</body>
</html>

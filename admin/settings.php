<?php
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_auth();
require_role('admin');

// Example settings (replace with actual settings logic)
$settings = [
    'site_name' => 'Zoo Management System',
    'timezone' => 'UTC',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $site_name = validate_input($_POST['site_name']);
    $timezone = validate_input($_POST['timezone']);

    // Update logic here (e.g., update the database)
    $settings['site_name'] = $site_name;
    $settings['timezone'] = $timezone;
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="p-6 max-w-3xl mx-auto bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">Settings</h1>
    <?php if (isset($success)): ?>
        <p class="text-green-600">Settings updated successfully!</p>
    <?php endif; ?>
    <form method="POST" class="space-y-4">
        <div>
            <label for="site_name" class="block text-gray-700">Site Name</label>
            <input type="text" id="site_name" name="site_name" value="<?php echo htmlspecialchars($settings['site_name']); ?>" class="w-full px-4 py-2 border rounded-lg">
        </div>
        <div>
            <label for="timezone" class="block text-gray-700">Timezone</label>
            <input type="text" id="timezone" name="timezone" value="<?php echo htmlspecialchars($settings['timezone']); ?>" class="w-full px-4 py-2 border rounded-lg">
        </div>
        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg">Save Settings</button>
    </form>
</div>
</body>
</html>

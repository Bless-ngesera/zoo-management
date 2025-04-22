<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../includes/auth.php'; // Corrected path
require_once __DIR__ . '/../../includes/header.php'; // Corrected path
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../config/database.php';
require_auth();
require_role('admin');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = validate_input($_POST['username']);
    $email = validate_input($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = validate_input($_POST['role']);
    $full_name = validate_input($_POST['full_name']);
    $phone = validate_input($_POST['phone']);

    // Validate inputs
    $errors = [];
    if (empty($username)) $errors[] = 'Username is required';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
    if (empty($password)) $errors[] = 'Password is required';
    if ($password !== $confirm_password) $errors[] = 'Passwords do not match';
    if (empty($role)) $errors[] = 'Role is required';
    if (empty($full_name)) $errors[] = 'Full name is required';

    if (empty($errors)) {
        // In a real app, this would:
        // 1. Hash the password
        // 2. Save to database
        // 3. Send welcome email
        $success = true;
    }
}
?>

<div class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-md p-6 max-w-3xl w-full">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Add New User</h1>
        
        <?php if (isset($success)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                User created successfully! <a href="index.php" class="font-semibold underline">View all users</a>
            </div>
        <?php elseif (!empty($errors)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="username" class="block text-gray-700 mb-1">Username*</label>
                    <input type="text" id="username" name="username" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                        value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
                </div>
                
                <div>
                    <label for="email" class="block text-gray-700 mb-1">Email*</label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                        value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-gray-700 mb-1">Password*</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                
                <div>
                    <label for="confirm_password" class="block text-gray-700 mb-1">Confirm Password*</label>
                    <input type="password" id="confirm_password" name="confirm_password" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
            </div>
            
            <div>
                <label for="full_name" class="block text-gray-700 mb-1">Full Name*</label>
                <input type="text" id="full_name" name="full_name" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                    value="<?php echo isset($full_name) ? htmlspecialchars($full_name) : ''; ?>">
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="phone" class="block text-gray-700 mb-1">Phone Number</label>
                    <input type="tel" id="phone" name="phone"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                        value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>">
                </div>
                
                <div>
                    <label for="role" class="block text-gray-700 mb-1">Role*</label>
                    <select id="role" name="role" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">Select Role</option>
                        <option value="admin" <?php echo (isset($role) && $role === 'admin') ? 'selected' : ''; ?>>Admin</option>
                        <option value="staff" <?php echo (isset($role) && $role === 'staff') ? 'selected' : ''; ?>>Staff</option>
                        <option value="user" <?php echo (isset($role) && $role === 'user') ? 'selected' : ''; ?>>User</option>
                    </select>
                </div>
            </div>
            
            <div class="pt-4">
                <div class="flex items-center">
                    <input type="checkbox" id="send_welcome_email" name="send_welcome_email" class="mr-2" checked>
                    <label for="send_welcome_email" class="text-gray-700">Send welcome email with login details</label>
                </div>
            </div>
            
            <div class="flex justify-end space-x-4 pt-4">
                <a href="index.php" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition">
                    Create User
                </button>
            </div>
        </form>
    </div>
</div>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>
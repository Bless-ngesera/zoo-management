<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_auth();
require_role('admin');
require_once __DIR__ . '/../../../includes/header.php';

// Sample user data - in real app this would come from database
$user = [
    'id' => 1,
    'username' => 'staff1',
    'email' => 'staff@zoo.com',
    'full_name' => 'Staff Member',
    'phone' => '+91 9876543210',
    'role' => 'staff',
    'status' => 'active',
    'created_at' => '2023-01-15',
    'last_login' => '2023-06-20 14:30:00'
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = validate_input($_POST['username']);
    $email = validate_input($_POST['email']);
    $role = validate_input($_POST['role']);
    $full_name = validate_input($_POST['full_name']);
    $phone = validate_input($_POST['phone']);
    $status = validate_input($_POST['status']);
    $change_password = isset($_POST['change_password']);
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validate inputs
    $errors = [];
    if (empty($username)) $errors[] = 'Username is required';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
    if (empty($role)) $errors[] = 'Role is required';
    if (empty($full_name)) $errors[] = 'Full name is required';
    if (empty($status)) $errors[] = 'Status is required';
    
    if ($change_password) {
        if (empty($password)) $errors[] = 'Password is required';
        if ($password !== $confirm_password) $errors[] = 'Passwords do not match';
    }

    if (empty($errors)) {
        // In a real app, this would:
        // 1. Update user in database
        // 2. If password changed, hash and update it
        $user['username'] = $username;
        $user['email'] = $email;
        $user['role'] = $role;
        $user['full_name'] = $full_name;
        $user['phone'] = $phone;
        $user['status'] = $status;
        
        $success = true;
    }
}
?>

<div class="bg-white rounded-lg shadow-md p-6 max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit User</h1>
    
    <?php if (isset($success)): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            User updated successfully! <a href="index.php" class="font-semibold underline">View all users</a>
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
                    value="<?php echo htmlspecialchars($user['username']); ?>">
            </div>
            
            <div>
                <label for="email" class="block text-gray-700 mb-1">Email*</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                    value="<?php echo htmlspecialchars($user['email']); ?>">
            </div>
        </div>
        
        <div>
            <label for="full_name" class="block text-gray-700 mb-1">Full Name*</label>
            <input type="text" id="full_name" name="full_name" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                value="<?php echo htmlspecialchars($user['full_name']); ?>">
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="phone" class="block text-gray-700 mb-1">Phone Number</label>
                <input type="tel" id="phone" name="phone"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                    value="<?php echo htmlspecialchars($user['phone']); ?>">
            </div>
            
            <div>
                <label for="role" class="block text-gray-700 mb-1">Role*</label>
                <select id="role" name="role" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">Select Role</option>
                    <option value="admin" <?php echo ($user['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="staff" <?php echo ($user['role'] === 'staff') ? 'selected' : ''; ?>>Staff</option>
                    <option value="user" <?php echo ($user['role'] === 'user') ? 'selected' : ''; ?>>User</option>
                </select>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="status" class="block text-gray-700 mb-1">Status*</label>
                <select id="status" name="status" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="active" <?php echo ($user['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                    <option value="inactive" <?php echo ($user['status'] === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                    <option value="suspended" <?php echo ($user['status'] === 'suspended') ? 'selected' : ''; ?>>Suspended</option>
                </select>
            </div>
            
            <div class="flex items-end">
                <div class="w-full">
                    <div class="flex items-center">
                        <input type="checkbox" id="change_password" name="change_password" class="mr-2">
                        <label for="change_password" class="text-gray-700">Change Password</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="password_fields" class="hidden grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="password" class="block text-gray-700 mb-1">New Password</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
            
            <div>
                <label for="confirm_password" class="block text-gray-700 mb-1">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
        </div>
        
        <div class="border-t border-gray-200 pt-4">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Account Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                <div>
                    <p><span class="font-medium">Created:</span> <?php echo date('M d, Y', strtotime($user['created_at'])); ?></p>
                </div>
                <div>
                    <p><span class="font-medium">Last Login:</span> <?php echo date('M d, Y H:i', strtotime($user['last_login'])); ?></p>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-4 pt-4">
            <a href="index.php" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition">
                Update User
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const changePasswordCheckbox = document.getElementById('change_password');
    const passwordFields = document.getElementById('password_fields');
    
    changePasswordCheckbox.addEventListener('change', function() {
        if (this.checked) {
            passwordFields.classList.remove('hidden');
            document.getElementById('password').required = true;
            document.getElementById('confirm_password').required = true;
        } else {
            passwordFields.classList.add('hidden');
            document.getElementById('password').required = false;
            document.getElementById('confirm_password').required = false;
        }
    });
});
</script>

<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>
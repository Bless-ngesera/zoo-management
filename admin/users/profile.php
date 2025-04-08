<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_auth();
require_once __DIR__ . '/../../../includes/header.php';

// Sample user data - in real app this would come from database
$user = [
    'id' => 1,
    'username' => 'admin',
    'email' => 'admin@zoo.com',
    'full_name' => 'Admin User',
    'phone' => '+91 9876543210',
    'role' => 'admin',
    'status' => 'active',
    'created_at' => '2023-01-01',
    'last_login' => '2023-06-20 09:45:00',
    'avatar' => 'https://images.unsplash.com/photo-1633332755192-727a05c4013d?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&h=200&q=80'
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = validate_input($_POST['full_name']);
    $phone = validate_input($_POST['phone']);
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $change_password = !empty($current_password) || !empty($new_password) || !empty($confirm_password);

    // Validate inputs
    $errors = [];
    if (empty($full_name)) $errors[] = 'Full name is required';
    
    if ($change_password) {
        if (empty($current_password)) $errors[] = 'Current password is required';
        if (empty($new_password)) $errors[] = 'New password is required';
        if ($new_password !== $confirm_password) $errors[] = 'New passwords do not match';
        // In real app, would verify current password matches
    }

    if (empty($errors)) {
        // In a real app, this would:
        // 1. Update user in database
        // 2. If password changed, verify current password and update to new one
        $user['full_name'] = $full_name;
        $user['phone'] = $phone;
        
        $success = true;
    }
}
?>

<div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">My Profile</h1>
    
    <?php if (isset($success)): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            Profile updated successfully!
        </div>
    <?php elseif (!empty($errors)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Profile Picture Section -->
        <div class="w-full md:w-1/3">
            <div class="border rounded-lg p-4">
                <div class="flex flex-col items-center">
                    <div class="relative mb-4">
                        <img src="<?php echo htmlspecialchars($user['avatar']); ?>" 
                            alt="Profile Picture" 
                            class="w-32 h-32 rounded-full object-cover border-4 border-white shadow">
                        <button class="absolute bottom-0 right-0 bg-primary text-white p-2 rounded-full hover:bg-primary-600 transition">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($user['full_name']); ?></h2>
                    <p class="text-gray-600 mb-2">@<?php echo htmlspecialchars($user['username']); ?></p>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                        <?php echo ucfirst($user['role']); ?>
                    </span>
                </div>
                
                <div class="mt-6 space-y-2 text-sm">
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-envelope mr-2 text-primary"></i>
                        <span><?php echo htmlspecialchars($user['email']); ?></span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-phone mr-2 text-primary"></i>
                        <span><?php echo htmlspecialchars($user['phone']); ?></span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-calendar-alt mr-2 text-primary"></i>
                        <span>Member since <?php echo date('M Y', strtotime($user['created_at'])); ?></span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-sign-in-alt mr-2 text-primary"></i>
                        <span>Last login: <?php echo date('M d, Y H:i', strtotime($user['last_login'])); ?></span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Profile Form Section -->
        <div class="w-full md:w-2/3">
            <form method="POST" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="username" class="block text-gray-700 mb-1">Username</label>
                        <input type="text" id="username" 
                            class="w-full px-4 py-2 border rounded-lg bg-gray-100 cursor-not-allowed"
                            value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                    </div>
                    
                    <div>
                        <label for="email" class="block text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" 
                            class="w-full px-4 py-2 border rounded-lg bg-gray-100 cursor-not-allowed"
                            value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                    </div>
                </div>
                
                <div>
                    <label for="full_name" class="block text-gray-700 mb-1">Full Name*</label>
                    <input type="text" id="full_name" name="full_name" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                        value="<?php echo htmlspecialchars($user['full_name']); ?>">
                </div>
                
                <div>
                    <label for="phone" class="block text-gray-700 mb-1">Phone Number</label>
                    <input type="tel" id="phone" name="phone"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                        value="<?php echo htmlspecialchars($user['phone']); ?>">
                </div>
                
                <div class="border-t border-gray-200 pt-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Change Password</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="current_password" class="block text-gray-700 mb-1">Current Password</label>
                            <input type="password" id="current_password" name="current_password"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="new_password" class="block text-gray-700 mb-1">New Password</label>
                                <input type="password" id="new_password" name="new_password"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                            </div>
                            
                            <div>
                                <label for="confirm_password" class="block text-gray-700 mb-1">Confirm Password</label>
                                <input type="password" id="confirm_password" name="confirm_password"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-4 pt-4">
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>
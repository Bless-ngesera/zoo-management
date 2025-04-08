<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_auth();
require_role('admin');
require_once __DIR__ . '/../../../includes/header.php';

// Sample ticket settings - in real app this would come from database
$ticketSettings = [
    'indian_adult_price' => 200,
    'indian_child_price' => 100,
    'foreign_adult_price' => 20,
    'foreign_child_price' => 10,
    'family_package_price' => 500,
    'annual_pass_price' => 2000,
    'max_tickets_per_booking' => 10,
    'advance_booking_days' => 30,
    'refund_policy' => 'Tickets can be refunded up to 24 hours before the visit date with a 10% cancellation fee.'
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $indian_adult_price = (int)$_POST['indian_adult_price'];
    $indian_child_price = (int)$_POST['indian_child_price'];
    $foreign_adult_price = (int)$_POST['foreign_adult_price'];
    $foreign_child_price = (int)$_POST['foreign_child_price'];
    $family_package_price = (int)$_POST['family_package_price'];
    $annual_pass_price = (int)$_POST['annual_pass_price'];
    $max_tickets_per_booking = (int)$_POST['max_tickets_per_booking'];
    $advance_booking_days = (int)$_POST['advance_booking_days'];
    $refund_policy = validate_input($_POST['refund_policy']);

    // Validate inputs
    $errors = [];
    if ($indian_adult_price < 0) $errors[] = 'Indian adult price must be positive';
    if ($indian_child_price < 0) $errors[] = 'Indian child price must be positive';
    if ($foreign_adult_price < 0) $errors[] = 'Foreign adult price must be positive';
    if ($foreign_child_price < 0) $errors[] = 'Foreign child price must be positive';
    if ($family_package_price < 0) $errors[] = 'Family package price must be positive';
    if ($annual_pass_price < 0) $errors[] = 'Annual pass price must be positive';
    if ($max_tickets_per_booking < 1) $errors[] = 'Max tickets per booking must be at least 1';
    if ($advance_booking_days < 1) $errors[] = 'Advance booking days must be at least 1';
    if (empty($refund_policy)) $errors[] = 'Refund policy is required';

    if (empty($errors)) {
        // In a real app, this would save to database
        $ticketSettings['indian_adult_price'] = $indian_adult_price;
        $ticketSettings['indian_child_price'] = $indian_child_price;
        $ticketSettings['foreign_adult_price'] = $foreign_adult_price;
        $ticketSettings['foreign_child_price'] = $foreign_child_price;
        $ticketSettings['family_package_price'] = $family_package_price;
        $ticketSettings['annual_pass_price'] = $annual_pass_price;
        $ticketSettings['max_tickets_per_booking'] = $max_tickets_per_booking;
        $ticketSettings['advance_booking_days'] = $advance_booking_days;
        $ticketSettings['refund_policy'] = $refund_policy;
        
        $success = true;
    }
}
?>

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">System Settings</h1>
        <div class="flex space-x-2">
            <a href="../dashboard.php" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <div class="border-b border-gray-200 mb-6">
        <nav class="flex space-x-4">
            <a href="general.php" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                General
            </a>
            <a href="tickets.php" class="px-4 py-2 text-sm font-medium text-primary border-b-2 border-primary">
                Tickets
            </a>
            <a href="notifications.php" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                Notifications
            </a>
            <a href="security.php" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                Security
            </a>
        </nav>
    </div>
    
    <?php if (isset($success)): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            Ticket settings updated successfully!
        </div>
    <?php elseif (!empty($errors)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="border rounded-lg p-4">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Indian Visitors</h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="indian_adult_price" class="block text-gray-700 mb-1">Adult Price (₹)</label>
                        <div class="flex items-center">
                            <span class="mr-2">₹</span>
                            <input type="number" id="indian_adult_price" name="indian_adult_price" min="0" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                                value="<?php echo $ticketSettings['indian_adult_price']; ?>">
                        </div>
                    </div>
                    
                    <div>
                        <label for="indian_child_price" class="block text-gray-700 mb-1">Child Price (₹)</label>
                        <div class="flex items-center">
                            <span class="mr-2">₹</span>
                            <input type="number" id="indian_child_price" name="indian_child_price" min="0" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                                value="<?php echo $ticketSettings['indian_child_price']; ?>">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border rounded-lg p-4">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Foreign Visitors</h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="foreign_adult_price" class="block text-gray-700 mb-1">Adult Price ($)</label>
                        <div class="flex items-center">
                            <span class="mr-2">$</span>
                            <input type="number" id="foreign_adult_price" name="foreign_adult_price" min="0" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                                value="<?php echo $ticketSettings['foreign_adult_price']; ?>">
                        </div>
                    </div>
                    
                    <div>
                        <label for="foreign_child_price" class="block text-gray-700 mb-1">Child Price ($)</label>
                        <div class="flex items-center">
                            <span class="mr-2">$</span>
                            <input type="number" id="foreign_child_price" name="foreign_child_price" min="0" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                                value="<?php echo $ticketSettings['foreign_child_price']; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="border rounded-lg p-4">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Special Packages</h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="family_package_price" class="block text-gray-700 mb-1">Family Package (₹)</label>
                        <div class="flex items-center">
                            <span class="mr-2">₹</span>
                            <input type="number" id="family_package_price" name="family_package_price" min="0" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                                value="<?php echo $ticketSettings['family_package_price']; ?>">
                        </div>
                        <p class="text-sm text-gray-500 mt-1">2 adults + 2 children</p>
                    </div>
                    
                    <div>
                        <label for="annual_pass_price" class="block text-gray-700 mb-1">Annual Pass (₹)</label>
                        <div class="flex items-center">
                            <span class="mr-2">₹</span>
                            <input type="number" id="annual_pass_price" name="annual_pass_price" min="0" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                                value="<?php echo $ticketSettings['annual_pass_price']; ?>">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border rounded-lg p-4">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Booking Settings</h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="max_tickets_per_booking" class="block text-gray-700 mb-1">Max Tickets per Booking</label>
                        <input type="number" id="max_tickets_per_booking" name="max_tickets_per_booking" min="1" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                            value="<?php echo $ticketSettings['max_tickets_per_booking']; ?>">
                    </div>
                    
                    <div>
                        <label for="advance_booking_days" class="block text-gray-700 mb-1">Advance Booking (Days)</label>
                        <input type="number" id="advance_booking_days" name="advance_booking_days" min="1" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                            value="<?php echo $ticketSettings['advance_booking_days']; ?>">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="border rounded-lg p-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Refund Policy</h2>
            <textarea id="refund_policy" name="refund_policy" rows="4" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"><?php echo htmlspecialchars($ticketSettings['refund_policy']); ?></textarea>
        </div>
        
        <div class="flex justify-end space-x-4 pt-4">
            <button type="reset" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Reset Changes
            </button>
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition">
                Save Settings
            </button>
        </div>
    </form>
</div>

<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>
<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_auth();
require_role('admin');
require_once __DIR__ . '/../../../includes/header.php';

// Sample settings data - in real app this would come from database
$settings = [
    'zoo_name' => 'Wildlife Adventure Zoo',
    'contact_email' => 'info@wildlifezoo.com',
    'contact_phone' => '+91 1800 123 4567',
    'address' => '123 Zoo Road, Bengaluru, Karnataka 560001',
    'opening_hours' => '9:00 AM - 6:00 PM (All Days)',
    'ticket_terms' => '1. Tickets are non-refundable\n2. Children under 3 enter free\n3. Valid ID required for discounts',
    'maintenance_mode' => false
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $zoo_name = validate_input($_POST['zoo_name']);
    $contact_email = validate_input($_POST['contact_email']);
    $contact_phone = validate_input($_POST['contact_phone']);
    $address = validate_input($_POST['address']);
    $opening_hours = validate_input($_POST['opening_hours']);
    $ticket_terms = validate_input($_POST['ticket_terms']);
    $maintenance_mode = isset($_POST['maintenance_mode']);

    // Validate inputs
    $errors = [];
    if (empty($zoo_name)) $errors[] = 'Zoo name is required';
    if (empty($contact_email) || !filter_var($contact_email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid contact email is required';
    if (empty($contact_phone)) $errors[] = 'Contact phone is required';
    if (empty($address)) $errors[] = 'Address is required';
    if (empty($opening_hours)) $errors[] = 'Opening hours are required';

    if (empty($errors)) {
        // In a real app, this would save to database
        $settings['zoo_name'] = $zoo_name;
        $settings['contact_email'] = $contact_email;
        $settings['contact_phone'] = $contact_phone;
        $settings['address'] = $address;
        $settings['opening_hours'] = $opening_hours;
        $settings['ticket_terms'] = $ticket_terms;
        $settings['maintenance_mode'] = $maintenance_mode;
        
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
            <a href="general.php" class="px-4 py-2 text-sm font-medium text-primary border-b-2 border-primary">
                General
            </a>
            <a href="tickets.php" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
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
            Settings updated successfully!
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
            <div>
                <label for="zoo_name" class="block text-gray-700 mb-1">Zoo Name*</label>
                <input type="text" id="zoo_name" name="zoo_name" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                    value="<?php echo htmlspecialchars($settings['zoo_name']); ?>">
            </div>
            
            <div>
                <label for="contact_email" class="block text-gray-700 mb-1">Contact Email*</label>
                <input type="email" id="contact_email" name="contact_email" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                    value="<?php echo htmlspecialchars($settings['contact_email']); ?>">
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="contact_phone" class="block text-gray-700 mb-1">Contact Phone*</label>
                <input type="tel" id="contact_phone" name="contact_phone" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                    value="<?php echo htmlspecialchars($settings['contact_phone']); ?>">
            </div>
            
            <div>
                <label for="opening_hours" class="block text-gray-700 mb-1">Opening Hours*</label>
                <input type="text" id="opening_hours" name="opening_hours" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                    value="<?php echo htmlspecialchars($settings['opening_hours']); ?>">
            </div>
        </div>
        
        <div>
            <label for="address" class="block text-gray-700 mb-1">Address*</label>
            <textarea id="address" name="address" rows="2" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"><?php echo htmlspecialchars($settings['address']); ?></textarea>
        </div>
        
        <div>
            <label for="ticket_terms" class="block text-gray-700 mb-1">Ticket Terms & Conditions</label>
            <textarea id="ticket_terms" name="ticket_terms" rows="4"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"><?php echo htmlspecialchars($settings['ticket_terms']); ?></textarea>
        </div>
        
        <div class="border-t border-gray-200 pt-4">
            <div class="flex items-center">
                <input type="checkbox" id="maintenance_mode" name="maintenance_mode" 
                    class="mr-2" <?php echo $settings['maintenance_mode'] ? 'checked' : ''; ?>>
                <label for="maintenance_mode" class="text-gray-700">Enable Maintenance Mode</label>
            </div>
            <p class="text-sm text-gray-500 mt-1">When enabled, only administrators can access the site.</p>
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
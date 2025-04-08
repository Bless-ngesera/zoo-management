<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_auth();
require_role('admin');
require_once __DIR__ . '/../../../includes/header.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adults = isset($_POST['adults']) ? (int)$_POST['adults'] : 0;
    $children = isset($_POST['children']) ? (int)$_POST['children'] : 0;
    $visitor_name = validate_input($_POST['visitor_name']);
    $passport_number = validate_input($_POST['passport_number']);
    $nationality = validate_input($_POST['nationality']);
    
    // Validate inputs
    $errors = [];
    if ($adults < 1) $errors[] = 'At least 1 adult is required';
    if (empty($visitor_name)) $errors[] = 'Visitor name is required';
    if (empty($passport_number)) $errors[] = 'Passport number is required';
    if (empty($nationality)) $errors[] = 'Nationality is required';
    
    if (empty($errors)) {
        // Calculate total
        $adult_price = 20; // Would normally come from database
        $child_price = 10; // Would normally come from database
        $total = ($adults * $adult_price) + ($children * $child_price);
        
        // In a real app, this would save to database
        $ticket_id = 'FR-' . strtoupper(uniqid());
        $success = true;
    }
}
?>

<div class="bg-white rounded-lg shadow-md p-6 max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Foreign Visitor Ticket</h1>
    
    <?php if (isset($success)): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <h2 class="font-bold">Ticket Booked Successfully!</h2>
            <p class="mt-1">Ticket ID: <?php echo $ticket_id; ?></p>
            <p>Total Amount: $<?php echo $total; ?></p>
            <div class="mt-3">
                <button onclick="window.print()" class="bg-primary text-white px-4 py-1 rounded hover:bg-primary-600 transition mr-2">
                    <i class="fas fa-print mr-1"></i> Print Ticket
                </button>
                <a href="foreign.php" class="bg-gray-200 text-gray-700 px-4 py-1 rounded hover:bg-gray-300 transition">
                    <i class="fas fa-plus mr-1"></i> New Booking
                </a>
            </div>
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
                <label for="visitor_name" class="block text-gray-700 mb-1">Visitor Name*</label>
                <input type="text" id="visitor_name" name="visitor_name" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                    value="<?php echo isset($visitor_name) ? htmlspecialchars($visitor_name) : ''; ?>">
            </div>
            
            <div>
                <label for="passport_number" class="block text-gray-700 mb-1">Passport Number*</label>
                <input type="text" id="passport_number" name="passport_number" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                    value="<?php echo isset($passport_number) ? htmlspecialchars($passport_number) : ''; ?>">
            </div>
        </div>
        
        <div>
            <label for="nationality" class="block text-gray-700 mb-1">Nationality*</label>
            <select id="nationality" name="nationality" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                <option value="">Select Nationality</option>
                <option value="USA" <?php echo (isset($nationality) && $nationality === 'USA') ? 'selected' : ''; ?>>United States</option>
                <option value="UK" <?php echo (isset($nationality) && $nationality === 'UK') ? 'selected' : ''; ?>>United Kingdom</option>
                <option value="CAN" <?php echo (isset($nationality) && $nationality === 'CAN') ? 'selected' : ''; ?>>Canada</option>
                <option value="AUS" <?php echo (isset($nationality) && $nationality === 'AUS') ? 'selected' : ''; ?>>Australia</option>
                <option value="GER" <?php echo (isset($nationality) && $nationality === 'GER') ? 'selected' : ''; ?>>Germany</option>
                <option value="FRA" <?php echo (isset($nationality) && $nationality === 'FRA') ? 'selected' : ''; ?>>France</option>
                <option value="JPN" <?php echo (isset($nationality) && $nationality === 'JPN') ? 'selected' : ''; ?>>Japan</option>
                <option value="OTH" <?php echo (isset($nationality) && $nationality === 'OTH') ? 'selected' : ''; ?>>Other</option>
            </select>
        </div>
        
        <div class="border-t border-gray-200 pt-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Ticket Details</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 mb-1">Adults (18+ years)</label>
                    <div class="flex items-center">
                        <button type="button" class="w-10 h-10 border rounded-l-lg flex items-center justify-center" onclick="updateCount('adults', -1)">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" id="adults" name="adults" min="1" value="<?php echo isset($adults) ? $adults : 1; ?>" 
                            class="w-full h-10 border-t border-b text-center focus:outline-none">
                        <button type="button" class="w-10 h-10 border rounded-r-lg flex items-center justify-center" onclick="updateCount('adults', 1)">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">$20 per adult</p>
                </div>
                
                <div>
                    <label class="block text-gray-700 mb-1">Children (3-17 years)</label>
                    <div class="flex items-center">
                        <button type="button" class="w-10 h-10 border rounded-l-lg flex items-center justify-center" onclick="updateCount('children', -1)" <?php echo (isset($children) && $children <= 0) ? 'disabled' : ''; ?>>
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" id="children" name="children" min="0" value="<?php echo isset($children) ? $children : 0; ?>" 
                            class="w-full h-10 border-t border-b text-center focus:outline-none">
                        <button type="button" class="w-10 h-10 border rounded-r-lg flex items-center justify-center" onclick="updateCount('children', 1)">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">$10 per child</p>
                </div>
            </div>
        </div>
        
        <div class="bg-gray-50 p-4 rounded-lg">
            <div class="flex justify-between items-center">
                <h3 class="font-medium text-gray-800">Total Amount</h3>
                <div class="text-2xl font-bold" id="total-amount">
                    $<?php echo isset($total) ? $total : '20'; ?>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-4 pt-2">
            <a href="../manage.php" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition">
                Confirm Booking
            </button>
        </div>
    </form>
</div>

<script>
function updateCount(field, change) {
    const input = document.getElementById(field);
    let value = parseInt(input.value) + change;
    
    // Ensure value doesn't go below minimum
    if (field === 'adults' && value < 1) value = 1;
    if (field === 'children' && value < 0) value = 0;
    
    input.value = value;
    calculateTotal();
}

function calculateTotal() {
    const adults = parseInt(document.getElementById('adults').value);
    const children = parseInt(document.getElementById('children').value);
    const adultPrice = 20;
    const childPrice = 10;
    const total = (adults * adultPrice) + (children * childPrice);
    
    document.getElementById('total-amount').textContent = '$' + total;
}

// Initial calculation
document.addEventListener('DOMContentLoaded', calculateTotal);
</script>

<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>
<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/constants.php'; // Corrected path
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../includes/functions.php';
?>

<div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Book Your Zoo Tickets</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Ticket Selection -->
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Select Ticket Type</h2>
            
            <div class="space-y-4">
                <div class="border rounded-lg p-4 hover:border-primary transition cursor-pointer ticket-option" data-type="ugadan">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full border-2 border-primary flex items-center justify-center mr-3">
                            <div class="w-4 h-4 rounded-full bg-primary hidden"></div>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Ugandan Visitor</h3>
                            <p class="text-sm text-gray-500">For residents of Uganda</p>
                        </div>
                        <div class="ml-auto font-bold text-primary">15,000 Ugx</div>
                    </div>
                </div>
                
                <div class="border rounded-lg p-4 hover:border-primary transition cursor-pointer ticket-option" data-type="foreign">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full border-2 border-gray-300 flex items-center justify-center mr-3">
                            <div class="w-4 h-4 rounded-full bg-primary hidden"></div>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Foreign Visitor</h3>
                            <p class="text-sm text-gray-500">For international visitors</p>
                        </div>
                        <div class="ml-auto font-bold text-primary">25,000 Ugx</div>
                    </div>
                </div>
            </div>
            
            <!-- Visitor Details -->
            <div class="mt-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Visitor Details</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 mb-1">Full Name</label>
                        <input type="text" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">Email</label>
                        <input type="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Booking Summary -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Booking Summary</h2>
            
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-600">Ticket Type</span>
                    <span class="font-medium" id="summary-type">Not selected</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Adults (18+)</span>
                    <div class="flex items-center">
                        <button class="w-8 h-8 rounded-full border flex items-center justify-center" id="adult-minus">-</button>
                        <span class="mx-3 w-8 text-center" id="adult-count">0</span>
                        <button class="w-8 h-8 rounded-full border flex items-center justify-center" id="adult-plus">+</button>
                    </div>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Children (3-17)</span>
                    <div class="flex items-center">
                        <button class="w-8 h-8 rounded-full border flex items-center justify-center" id="child-minus">-</button>
                        <span class="mx-3 w-8 text-center" id="child-count">0</span>
                        <button class="w-8 h-8 rounded-full border flex items-center justify-center" id="child-plus">+</button>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 my-4"></div>
                
                <div class="flex justify-between font-medium">
                    <span>Total Amount</span>
                    <span id="total-amount">0 Ugx</span>
                </div>
                
                <button class="w-full bg-primary text-white py-3 rounded-lg font-medium hover:bg-primary-600 transition mt-6">
                    Proceed to Payment
                </button>
                
                <p class="text-sm text-gray-500 mt-4">
                    <i class="fas fa-lock mr-1"></i> Your payment information is secure
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ticket type selection
    const ticketOptions = document.querySelectorAll('.ticket-option');
    ticketOptions.forEach(option => {
        option.addEventListener('click', function() {
            ticketOptions.forEach(opt => {
                opt.querySelector('.border-2').classList.remove('border-primary');
                opt.querySelector('.border-2').classList.add('border-gray-300');
                opt.querySelector('.bg-primary').classList.add('hidden');
            });
            
            this.querySelector('.border-2').classList.add('border-primary');
            this.querySelector('.border-2').classList.remove('border-gray-300');
            this.querySelector('.bg-primary').classList.remove('hidden');
            
            const type = this.getAttribute('data-type');
            document.getElementById('summary-type').textContent = 
                type === 'ugadan' ? 'Ugadan Visitor' : 'Foreign Visitor';
            calculateTotal();
        });
    });
    
    // Counter functionality
    const adultCount = document.getElementById('adult-count');
    const childCount = document.getElementById('child-count');
    
    document.getElementById('adult-plus').addEventListener('click', function() {
        adultCount.textContent = parseInt(adultCount.textContent) + 1;
        calculateTotal();
    });
    
    document.getElementById('adult-minus').addEventListener('click', function() {
        if (parseInt(adultCount.textContent) > 0) {
            adultCount.textContent = parseInt(adultCount.textContent) - 1;
            calculateTotal();
        }
    });
    
    document.getElementById('child-plus').addEventListener('click', function() {
        childCount.textContent = parseInt(childCount.textContent) + 1;
        calculateTotal();
    });
    
    document.getElementById('child-minus').addEventListener('click', function() {
        if (parseInt(childCount.textContent) > 0) {
            childCount.textContent = parseInt(childCount.textContent) - 1;
            calculateTotal();
        }
    });
    
    // Calculate total amount
    function calculateTotal() {
        const type = document.querySelector('.ticket-option .border-primary')?.parentElement.getAttribute('data-type');
        const adults = parseInt(adultCount.textContent);
        const children = parseInt(childCount.textContent);
        
        if (!type) return;
        
        let total = 0;
        if (type === 'ugadan') {
            total = (adults * 200) + (children * 100);
            document.getElementById('total-amount').textContent = '₹' + total;
        } else {
            total = (adults * 20) + (children * 10);
            document.getElementById('total-amount').textContent = '$' + total;
        }
    }
});
</script>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
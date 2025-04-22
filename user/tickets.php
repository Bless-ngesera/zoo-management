<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if required files exist before including
$requiredFiles = [
    __DIR__ . '/../config/constants.php',
    __DIR__ . '/../config/database.php',
    __DIR__ . '/../includes/auth.php',
    __DIR__ . '/../includes/header.php',
    __DIR__ . '/../includes/functions.php',
    __DIR__ . '/../includes/footer.php'
];

foreach ($requiredFiles as $file) {
    if (!file_exists($file)) {
        die("Error: Required file missing - " . basename($file));
    }
}

// Include required files
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/functions.php';

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Zoo Management</title>
    <link rel="stylesheet" href="/zoo-management/output.css"> <!-- Updated to use output.css -->

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.8;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../image/zoo-home.jpg') no-repeat center center/cover;
            color: white;
            text-align: center;
            padding: 5rem 2rem;

        }
        .hero h1 {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .hero p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }
        .section {
            padding: 3rem 1.5rem;
            background: white;
            margin: 1.5rem auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
        }
        .section h2 {
            font-size: 2.5rem;
            font-weight: bolder;
            color: #2c3e50;
            margin-bottom: 1rem;
            text-align: center;
        }
        .section p {
            font-size: 1.2rem;
            color: #555;
            text-align: justify;
        }
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        .team-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .team-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .team-card img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 1rem;
        }
        .map-placeholder {
            background: #e0e0e0;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            color: #555;
            font-size: 1.2rem;
        }
        .map-placeholder iframe {
            width: 100%;
            height: 300px;
            border: 0;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .contact-info {
            text-align: center;
            font-size: 1.2rem;
            margin-top: 1rem;
        }
        .contact-info strong {
            color: #2c3e50;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            .hero p {
                font-size: 1.2rem;
            }
            .section {
                padding: 2rem 1rem;
            }
            .section h2 {
                font-size: 2rem;
            }
            .section p {
                font-size: 1rem;
            }
            .team-card img {
                width: 120px;
                height: 120px;
            }
        }

        @media (max-width: 480px) {
            .hero {
                padding: 3rem 1rem;
            }
            .hero h1 {
                font-size: 2rem;
            }
            .hero p {
                font-size: 1rem;
            }
            .section {
                padding: 1.5rem 0.5rem;
            }
            .section h2 {
                font-size: 1.8rem;
            }
            .section p {
                font-size: 0.9rem;
            }
            .team-card img {
                width: 100px;
                height: 100px;
            }
        }
    </style>
</head>
<body>
    <section class="hero" >
        <h1>BOOK TICKETS AT
        <span class="font-semibold text-gray-500 text-6xl" style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;"> 
        <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#3B82F6] to-[#10B981]">BLESS ZOO</span> 
        </h1>
        <p> Book a ticket, discover the wonders of wildlife and join us in our mission to protect nature.</p>
    </section>  

    <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto mt-8 mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Book Your Zoo Tickets</h1>
        
        <form action="/zoo-management/user/generate-ticket.php" method="POST" id="ticket-form">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Ticket Selection -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Select Ticket Type</h2>
                    
                    <div class="space-y-4">
                        <div class="border rounded-lg p-4 hover:border-primary transition cursor-pointer ticket-option" data-type="ugandan">
                            <input type="radio" name="ticket_type" value="ugandan" class="hidden">
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
                            <input type="radio" name="ticket_type" value="foreign" class="hidden">
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
                                <input type="text" name="full_name" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-1">Phone Number</label>
                                <input type="tel" name="phone" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
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
                                <button type="button" class="w-8 h-8 rounded-full border flex items-center justify-center" id="adult-minus">-</button>
                                <input type="hidden" name="adults" id="adult-input" value="0">
                                <span class="mx-3 w-8 text-center" id="adult-count">0</span>
                                <button type="button" class="w-8 h-8 rounded-full border flex items-center justify-center" id="adult-plus">+</button>
                            </div>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Children (3-17)</span>
                            <div class="flex items-center">
                                <button type="button" class="w-8 h-8 rounded-full border flex items-center justify-center" id="child-minus">-</button>
                                <input type="hidden" name="children" id="child-input" value="0">
                                <span class="mx-3 w-8 text-center" id="child-count">0</span>
                                <button type="button" class="w-8 h-8 rounded-full border flex items-center justify-center" id="child-plus">+</button>
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-200 my-4"></div>
                        
                        <div class="flex justify-between font-medium">
                            <span>Total Amount</span>
                            <input type="hidden" name="total_amount" id="total-input" value="0">
                            <span id="total-amount">0 Ugx</span>
                        </div>
                        
                        <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-medium hover:bg-primary-600 transition mt-6">
                            Get Tickets
                        </button>
                        
                        <p class="text-sm text-gray-500 mt-4">
                            <i class="fas fa-lock mr-1"></i> Your payment information is secure
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
</body>
</html>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const ticketOptions = document.querySelectorAll('.ticket-option');
    const adultCount = document.getElementById('adult-count');
    const childCount = document.getElementById('child-count');
    const totalAmount = document.getElementById('total-amount');
    const summaryType = document.getElementById('summary-type');
    const adultInput = document.getElementById('adult-input');
    const childInput = document.getElementById('child-input');
    const totalInput = document.getElementById('total-input');

    ticketOptions.forEach(option => {
        option.addEventListener('click', function() {
            ticketOptions.forEach(opt => {
                opt.querySelector('.border-2').classList.remove('border-primary');
                opt.querySelector('.border-2').classList.add('border-gray-300');
                opt.querySelector('.bg-primary').classList.add('hidden');
                opt.querySelector('input').checked = false;
            });

            this.querySelector('.border-2').classList.add('border-primary');
            this.querySelector('.border-2').classList.remove('border-gray-300');
            this.querySelector('.bg-primary').classList.remove('hidden');
            this.querySelector('input').checked = true;

            const type = this.getAttribute('data-type');
            summaryType.textContent = type === 'ugandan' ? 'Ugandan Visitor' : 'Foreign Visitor';
            calculateTotal();
        });
    });

    document.getElementById('adult-plus').addEventListener('click', function() {
        adultCount.textContent = parseInt(adultCount.textContent) + 1;
        adultInput.value = adultCount.textContent;
        calculateTotal();
    });

    document.getElementById('adult-minus').addEventListener('click', function() {
        if (parseInt(adultCount.textContent) > 0) {
            adultCount.textContent = parseInt(adultCount.textContent) - 1;
            adultInput.value = adultCount.textContent;
            calculateTotal();
        }
    });

    document.getElementById('child-plus').addEventListener('click', function() {
        childCount.textContent = parseInt(childCount.textContent) + 1;
        childInput.value = childCount.textContent;
        calculateTotal();
    });

    document.getElementById('child-minus').addEventListener('click', function() {
        if (parseInt(childCount.textContent) > 0) {
            childCount.textContent = parseInt(childCount.textContent) - 1;
            childInput.value = childCount.textContent;
            calculateTotal();
        }
    });

    function calculateTotal() {
        const selectedOption = document.querySelector('.ticket-option input:checked');
        if (!selectedOption) {
            totalAmount.textContent = '0 Ugx';
            totalInput.value = 0;
            return;
        }

        const type = selectedOption.value;
        const adults = parseInt(adultCount.textContent) || 0;
        const children = parseInt(childCount.textContent) || 0;

        let total = 0;
        if (type === 'ugandan') {
            total = (adults * 15000) + (children * 7500);
        } else if (type === 'foreign') {
            total = (adults * 25000) + (children * 12500);
        }

        totalAmount.textContent = total.toLocaleString() + ' Ugx';
        totalInput.value = total;
    }

    calculateTotal();
});
</script>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
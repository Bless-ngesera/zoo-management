<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .hero {
            background: url('image/zoo-home.jpg') no-repeat center center/cover;
            color: white;
            text-align: center;
            padding: 6rem 2rem;
            position: relative;
        }
        .hero-overlay {
            background: rgba(0, 0, 0, 0.4);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .hero-content {
            position: relative;
            z-index: 1;
        }
        .stats-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            text-align: center;
        }
        .testimonial-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            text-align: center;
        }
        @keyframes slideInOut {
            0% {
                transform: translateX(-100%);
                opacity: 0;
            }
            25% {
                transform: translateX(0);
                opacity: 1;
            }
            75% {
                transform: translateX(0);
                opacity: 1;
            }
            100% {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        .animate-slide {
            display: inline-block;
            animation: slideInOut 5s linear infinite;
        }
    </style>
</head>
<body>
    <!-- Hero Banner -->
    <header class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="text-5xl font-bold mb-4 animate-slide">Welcome to <span style="color: #3B82F6;">BLESS</span> <span style="color: #10B981;">ZOO</span></h1>
            <p class="text-xl mb-6">Discover the wonders of wildlife and join us in our mission to protect nature.</p>
            <div class="flex justify-center gap-4">
                <a href="<?php echo BASE_URL; ?>user/tickets.php" class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary-dark">Buy Tickets</a>
                <a href="user/animals.php" class="bg-secondary text-white px-6 py-3 rounded-lg hover:bg-secondary-dark">Explore Animals</a>
            </div>
        </div>
    </header>
    <!-- Quick Stats -->
    <section class="container mx-auto py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="stats-card">
                <h2 class="text-3xl font-bold text-primary">500+</h2>
                <p class="text-gray-600">Animal Species</p>
            </div>
            <div class="stats-card">
                <h2 class="text-3xl font-bold text-primary">1M+</h2>
                <p class="text-gray-600">Annual Visitors</p>
            </div>
            <div class="stats-card">
                <h2 class="text-3xl font-bold text-primary">50+</h2>
                <p class="text-gray-600">Conservation Projects</p>
            </div>
            <div class="stats-card">
                <h2 class="text-3xl font-bold text-primary">30+</h2>
                <p class="text-gray-600">Years in Operation</p>
            </div>
        </div>
    </section>

    <!-- Featured Animals -->
    <section class="container mx-auto py-12">
        <h2 class="text-3xl font-bold text-center mb-8">Featured Animals</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Animal Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <img src="image/lion.jpg" alt="Animal 1" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold mb-2">Lion</h3>
                <p class="text-gray-600">lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <img src="image/leopard.jpg" alt="Animal 1" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold mb-2">Lion</h3>
                <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <img src="image/panda.jpg" alt="Animal 1" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold mb-2">Lion</h3>
                <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <img src="image/monkey.jpg" alt="Animal 1" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold mb-2">Lion</h3>
                <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <img src="image/gorilla.jpg" alt="Animal 1" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold mb-2">Lion</h3>
                <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <img src="image/folk.jpg" alt="Animal 1" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold mb-2">Lion</h3>
                <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <img src="image/zebraa.jpg" alt="Animal 1" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold mb-2">Lion</h3>
                <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <img src="image/zebra.jpg" alt="Animal 1" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold mb-2">Lion</h3>
                <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <img src="image/croco.jpg" alt="Animal 1" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold mb-2">Lion</h3>
                <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <img src="image/snake.jpg" alt="Animal 1" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold mb-2">Lion</h3>
                <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <img src="image/parrots.jpg" alt="Animal 1" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold mb-2">Lion</h3>
                <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <img src="image/calao.jpg" alt="Animal 1" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold mb-2">Lion</h3>
                <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <img src="image/penguin.jpg" alt="Animal 1" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold mb-2">Lion</h3>
                <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            


            <!-- ...repeat for other animals... -->
        </div>
    </section>

    <!-- Upcoming Events -->
    <section class="container mx-auto py-12">
        <h2 class="text-3xl font-bold text-center mb-8">Upcoming Events</h2>
        <div class="flex overflow-x-auto gap-6">
            <!-- Event Card -->
            <div class="bg-white rounded-lg shadow-md p-6 min-w-[300px]">
                <h3 class="text-xl font-bold mb-2">Wildlife Photography Workshop</h3>
                <p class="text-gray-600 mb-4">Date: 25th June 2023</p>
                <p class="text-gray-600 mb-4">Learn the art of wildlife photography with experts.</p>
                <a href="event-details.php?id=1" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary-dark">Book Now</a>
            </div>
            <!-- ...repeat for other events... -->
        </div>
    </section>

    <!-- Visitor Information -->
    <section class="container mx-auto py-12">
        <h2 class="text-3xl font-bold text-center mb-8">Visitor Information</h2>
        <div class="bg-white rounded-lg shadow-md p-6">
            <details class="mb-4">
                <summary class="font-bold text-lg">Opening Hours</summary>
                <p class="text-gray-600 mt-2">Monday-Friday: 9:00 AM - 5:00 PM</p>
                <p class="text-gray-600">Saturday-Sunday: 8:00 AM - 6:00 PM</p>
            </details>
            <details class="mb-4">
                <summary class="font-bold text-lg">Ticket Prices</summary>
                <p class="text-gray-600 mt-2">Adults: $20, Children: $10</p>
            </details>
            <details class="mb-4">
                <summary class="font-bold text-lg">Parking & Accessibility</summary>
                <p class="text-gray-600 mt-2">Free parking available. Wheelchair accessible.</p>
            </details>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="container mx-auto py-12">
        <h2 class="text-3xl font-bold text-center mb-8">What Our Visitors Say</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Testimonial Card -->
            <div class="testimonial-card">
                <p class="text-gray-600 mb-4">"An amazing experience! The staff were friendly, and the animals were well cared for."</p>
                <p class="text-yellow-500">⭐⭐⭐⭐⭐</p>
                <p class="text-gray-600 mt-2">- John Doe</p>
            </div>
            <!-- ...repeat for other testimonials... -->
        </div>
    </section>

    <!-- Newsletter Signup -->
    <section class="container mx-auto py-12 text-center">
        <h2 class="text-3xl font-bold mb-4">Stay Updated</h2>
        <p class="text-gray-600 mb-6">Subscribe to our newsletter for the latest updates and events.</p>
        <form action="subscribe.php" method="POST" class="flex justify-center gap-4">
            <input type="email" name="email" placeholder="Enter your email" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark">Subscribe</button>
        </form>
    </section>

    <?php
    require_once __DIR__ . '/includes/footer.php';
    ?>
</body>
</html>
<?php
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ...existing code... -->
</head>
<body>
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome to Zoo Management System</h1>
            <p class="text-gray-600">Explore our amazing collection of animals and plan your visit</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Featured Animals -->
            <div class="bg-primary-50 rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow">
                <div class="text-center mb-4">
                    <i class="fas fa-paw text-4xl text-primary mb-2"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Our Animals</h2>
                </div>
                <p class="text-gray-600 mb-4">Discover our diverse collection of animals from around the world.</p>
                <a href="<?php echo USER_URL; ?>animals.php" class="inline-block bg-primary text-white px-4 py-2 rounded hover:bg-primary-600 transition">
                    View Animals
                </a>
            </div>

            <!-- Tickets -->
            <div class="bg-secondary-50 rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow">
                <div class="text-center mb-4">
                    <i class="fas fa-ticket-alt text-4xl text-secondary mb-2"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Plan Your Visit</h2>
                </div>
                <p class="text-gray-600 mb-4">Book your tickets online for a seamless zoo experience.</p>
                <a href="<?php echo USER_URL; ?>tickets.php" class="inline-block bg-secondary text-white px-4 py-2 rounded hover:bg-secondary-600 transition">
                    Get Tickets
                </a>
            </div>

            <!-- Contact -->
            <div class="bg-yellow-50 rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow">
                <div class="text-center mb-4">
                    <i class="fas fa-envelope text-4xl text-yellow-500 mb-2"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Contact Us</h2>
                </div>
                <p class="text-gray-600 mb-4">Have questions? Reach out to our friendly staff.</p>
                <a href="<?php echo USER_URL; ?>contact.php" class="inline-block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
                    Contact
                </a>
            </div>
        </div>

        <div class="mt-12 bg-gray-50 p-6 rounded-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">About Our Zoo</h2>
            <p class="text-gray-600 mb-4">
                Our zoo is home to over 500 animals representing more than 100 species. We're committed to conservation,
                education, and providing unforgettable experiences for our visitors.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Opening Hours</h3>
                    <ul class="text-gray-600 space-y-2">
                        <li>Monday-Friday: 9:00 AM - 5:00 PM</li>
                        <li>Saturday-Sunday: 8:00 AM - 6:00 PM</li>
                        <li>Holidays: 8:00 AM - 7:00 PM</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Location</h3>
                    <p class="text-gray-600">123 Zoo Avenue, Wildlife City, WC 12345</p>
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.215373510324!2d-73.987844924239!3d40.74844097138978!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9b3117469%3A0xd134e199a405a163!2sEmpire%20State%20Building!5e0!3m2!1sen!2sus!4v1711234247893!5m2!1sen!2sus" 
                        class="w-full h-48 mt-2 rounded border-0" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
require_once __DIR__ . '/includes/footer.php';
?>
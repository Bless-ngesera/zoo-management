<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Include header
require_once __DIR__ . '/../includes/header.php'; // Corrected path to header.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Zoo Management</title>
    <link rel="stylesheet" href="/zoo-management/styles.css"> <!-- Ensure styles.css exists -->
</head>
<body>
    <main class="container mx-auto p-6">
        <section class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Welcome to Our Zoo</h2>
            <p class="text-gray-600">
                Our zoo is home to over 500 animals representing more than 100 species. We are committed to conservation, education, and providing unforgettable experiences for our visitors.
            </p>
        </section>
        <section class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Our Mission</h2>
            <p class="text-gray-600">
                We aim to protect endangered species, educate the public about wildlife, and create a safe and enriching environment for our animals.
            </p>
        </section>
        <section class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Visit Us</h2>
            <p class="text-gray-600">
                Come and explore our zoo to learn more about the amazing creatures we care for. We look forward to your visit!
            </p>
            <ul class="text-gray-600 mt-4">
                <li><strong>Opening Hours:</strong> Monday-Friday: 9:00 AM - 5:00 PM, Saturday-Sunday: 8:00 AM - 6:00 PM</li>
                <li><strong>Location:</strong> 123 Zoo Avenue, Wildlife City, WC 12345</li>
            </ul>
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.215373510324!2d-73.987844924239!3d40.74844097138978!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9b3117469%3A0xd134e199a405a163!2sEmpire%20State%20Building!5e0!3m2!1sen!2sus!4v1711234247893!5m2!1sen!2sus" 
                class="w-full h-48 mt-4 rounded border-0" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </section>
    </main>
    <?php
    // Include footer
    require_once __DIR__ . '/../includes/footer.php'; // Corrected path to footer.php
    ?>
</body>
</html>

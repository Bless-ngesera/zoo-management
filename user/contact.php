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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = validate_input($_POST['name']);
    $email = validate_input($_POST['email']);
    $subject = validate_input($_POST['subject']);
    $message = validate_input($_POST['message']);
    
    // Basic validation
    $errors = [];
    if (empty($name)) $errors[] = 'Name is required';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
    if (empty($subject)) $errors[] = 'Subject is required';
    if (empty($message)) $errors[] = 'Message is required';
    
    if (empty($errors)) {
        // In a real application, you would send an email here
        $success = true;
    }
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

<section class="hero">
    <h1>CONTACT
    <span class="font-semibold text-gray-500 text-6xl" style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;"> 
    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#3B82F6] to-[#10B981]">BLESS ZOO</span> 
    </h1>
    <p>Contact and join us in our mission to protect nature.</p>
</section>

<div class="mt-6 mb-6 bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Contact Us</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Contact Form -->
        <div>
            <?php if (isset($success)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    Thank you for your message! We'll get back to you soon.
                </div>
            <?php elseif (!empty($errors)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" class="space-y-4">
                <div>
                    <label for="name" class="block text-gray-700 mb-1">Full Name</label>
                    <input type="text" id="name" name="name" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                        value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
                </div>
                
                <div>
                    <label for="email" class="block text-gray-700 mb-1">Email Address</label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                        value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                </div>
                
                <div>
                    <label for="subject" class="block text-gray-700 mb-1">Subject</label>
                    <input type="text" id="subject" name="subject" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                        value="<?php echo isset($subject) ? htmlspecialchars($subject) : ''; ?>">
                </div>
                
                <div>
                    <label for="message" class="block text-gray-700 mb-1">Message</label>
                    <textarea id="message" name="message" rows="5" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" id="newsletter" name="newsletter" class="mr-2">
                    <label for="newsletter" class="text-gray-700">Subscribe to our newsletter</label>
                </div>
                
                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition">
                    Send Message
                </button>
            </form>
        </div>
        
        <!-- Contact Information -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Our Information</h2>
            
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="text-primary mr-3 mt-1">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">Address</h3>
                        <p class="text-gray-600">123 Zoo Avenue, Wildlife City, WC 12345</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="text-primary mr-3 mt-1">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">Phone</h3>
                        <p class="text-gray-600">+1 (555) 123-4567</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="text-primary mr-3 mt-1">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">Email</h3>
                        <p class="text-gray-600">info@zoomanagement.com</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="text-primary mr-3 mt-1">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">Opening Hours</h3>
                        <p class="text-gray-600">Monday - Friday: 9:00 AM - 5:00 PM</p>
                        <p class="text-gray-600">Saturday - Sunday: 8:00 AM - 6:00 PM</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-6">
                <h3 class="font-medium text-gray-800 mb-2">Follow Us</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-600 hover:text-primary transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-primary transition">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-primary transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-primary transition">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
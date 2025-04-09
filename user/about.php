<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include header
require_once __DIR__ . '/../includes/header.php';
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
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/zoo-management/images/hero-banner.jpg') no-repeat center center/cover;
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
    <main>
        <!-- Hero Banner -->
        <section class="hero">
            <h1>Welcome to Our Zoo</h1>
            <p>Discover the wonders of wildlife and join us in our mission to protect nature.</p>
        </section>

        <!-- Mission Statement -->
        <section class="section">
            <h2>Our Mission</h2>
            <p>
                At our zoo, we are dedicated to conserving wildlife, educating the public, and creating a safe haven for animals. 
                We strive to inspire a love for nature and foster a deeper understanding of the importance of biodiversity.
            </p>
        </section>

        <!-- History/Background -->
        <section class="section">
            <h2>Our History</h2>
            <p>
                Established in 1990, our zoo has grown from a small wildlife sanctuary to a world-class conservation center. 
                Over the years, we have achieved numerous milestones, including the successful breeding of endangered species 
                and partnerships with global conservation organizations.
            </p>
        </section>

        <!-- Team Section -->
        <section class="section">
            <h2>Meet Our Team</h2>
            <div class="team-grid">
                <div class="team-card">
                    <img src="../image/director.jpg" alt="Director">
                    <h3 style="font-weight: 800; font-size: x-large;">Ikuzo Nzabanita Caleb</h3>
                    <p>Director</p>
                </div>
                <div class="team-card">
                    <img src="/zoo-management/images/zookeeper.jpg" alt="Head Zookeeper">
                    <h3 style="font-weight: 800; font-size: x-large;">Kambale Muvunja Ezechias</h3>
                    <p>Head Zookeeper</p>
                </div>
                <div class="team-card">
                    <img src="../image/vegeterian.jpg" alt="Veterinarian">
                    <h3 style="font-weight: 800; font-size: x-large;">Muhindo Ngesera Blessing</h3>
                    <p>Veterinarian</p>
                </div>
            </div>
        </section>

        <!-- Conservation Efforts -->
        <section class="section">
            <h2>Conservation Efforts</h2>
            <p>
                We are proud to collaborate with leading conservation organizations to protect endangered species and their habitats. 
                Our efforts include breeding programs, habitat restoration, and community education initiatives.
            </p>
        </section>

        <!-- Visitor Statistics -->
        <section class="section">
            <h2>Visitor Statistics</h2>
            <p>
                Our zoo is home to over 500 animals representing more than 100 species. Each year, we welcome over 1 million visitors 
                who come to experience the beauty of wildlife and learn about conservation.
            </p>
        </section>

        <!-- Contact Information and Map -->
        <section class="section">
            <h2>Contact Us</h2>
            <div class="contact-info">
                <p><strong>Address:</strong> 123 Zoo Avenue, Wildlife City, WC 12345</p>
                <p><strong>Email:</strong> contact@zoo-management.com</p>
                <p><strong>Phone:</strong> +256 763 123 456</p>
            </div>
            <div class="map-placeholder">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.816511747002!2d32.4768286735573!3d0.054554664372570616!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x177d869122a1c245%3A0x42f1a3495527a926!2sUganda%20Wildlife%20Conservation%20Education%20Centre!5e0!3m2!1sen!2sug!4v1744161260409!5m2!1sen!2sug" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </section>
    </main>
    <?php
    // Include footer
    require_once __DIR__ . '/../includes/footer.php';
    ?>
</body>
</html>

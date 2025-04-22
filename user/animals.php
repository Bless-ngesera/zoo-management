<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/constants.php'; // Corrected path
require_once __DIR__ . '/../config/database.php'; // Corrected path

$animals = []; // Initialize animals array to avoid undefined variable errors

// Fetch animals from the database
try {
    // Ensure DSN, DB_USER, and DB_PASS are defined in database.php
    if (!defined('DSN') || !defined('DB_USER') || !defined('DB_PASS')) {
        throw new Exception("Database configuration constants are not defined.");
    }

    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch animals
    $stmt = $pdo->query("SELECT name, description, image FROM animals");
    $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage()); // Temporarily display the error
} catch (Exception $e) {
    die("Error: " . $e->getMessage()); // Temporarily display the error
}

// Include header
require_once __DIR__ . '/../includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animals - Zoo Management</title>
    <link rel="stylesheet" href="/zoo-management/output.css">
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

        /* Responsive styling for animal images */
        .animal-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>

    <section class="hero">
                <h1>ANIMALS AT
                <span class="font-semibold text-gray-500 text-6xl" style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;"> 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#3B82F6] to-[#10B981]">BLESS ZOO</span> 
                </h1>
                <p>Discover the wonders of wildlife and join us in our mission to protect nature.</p>
    </section>
    <main class="container mx-auto py-12">
        <h1 class="text-3xl font-bold text-center mb-8">Our Animals</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (!empty($animals)): ?>
                <?php foreach ($animals as $animal): ?>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <?php 
                        // Use the image filename from the database and check if it exists in /uploads/animal_images/
                        $imagePath = __DIR__ . '../uploads/' . $animal['image'];
                        $imageUrl = file_exists($imagePath) 
                            ? '/uploads/' . htmlspecialchars($animal['image']) 
                            : '/uploads/default.jpg';
                        ?>
                        <img src="<?php echo $imageUrl; ?>" 
                             alt="<?php echo htmlspecialchars($animal['name']); ?>" 
                             class="w-full h-48 object-cover rounded-t mx-auto mb-4">
                        <h3 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($animal['name']); ?></h3>
                        <p class="text-gray-600"><?php echo htmlspecialchars($animal['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-gray-600">No animals found.</p>
            <?php endif; ?>
        </div>
    </main>
    <?php
    // Include footer
    require_once __DIR__ . '/../includes/footer.php';
    ?>
</body>
</html>

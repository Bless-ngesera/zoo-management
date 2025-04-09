<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/includes/auth.php';

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to the appropriate dashboard if already authenticated
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: ' . ADMIN_URL . 'dashboard.php');
    } else {
        header('Location: ' . USER_URL . 'index.php');
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['authenticated'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];

        // Redirect based on role
        if ($user['role'] === 'admin') {
            header('Location: ' . ADMIN_URL . 'dashboard.php');
        } else {
            header('Location: ' . USER_URL . 'index.php');
        }
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}

// Include header
require_once __DIR__ . '/includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#10B981',
                        danger: '#EF4444',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-image: url('image/zoo-bg.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form {
            background: rgba(255, 255, 255, 0.2); /* Light transparent background */
            backdrop-filter: blur(10px); /* Blurred background */
            border: 1px solid rgba(255, 255, 255, 0.3); /* Subtle border */
            padding: 20px;
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); /* Shadow effect */
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="form">
            <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-sm">
                <h1 class="text-2xl font-bold mb-4">Login</h1>
                <?php if (isset($error)): ?>
                    <p class="text-red-500 mb-4"><?php echo $error; ?></p>
                <?php endif; ?>
                <form method="POST" action="">
                    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                    <div class="mb-4">
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" id="username" name="username" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                    </div>
                    <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary-dark">Login</button>
                </form>
            </div>
        </div>
    </div>
    <?php
    // Include footer
    require_once __DIR__ . '/includes/footer.php';
    ?>
</body>
</html>

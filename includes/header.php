<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo Management System</title>
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
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-7">
                    <div>
                        <a href="<?php echo BASE_URL; ?>" class="flex items-center py-4 px-2">
                            <span class="font-semibold text-gray-500 text-4xl" style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;"> 
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#3B82F6] to-[#10B981]">BLESS ZOO</span> 
                            </span>
                        </a>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-1">
                    <a href="<?php echo BASE_URL; ?>" class="py-4 px-2 text-gray-500 font-semibold hover:text-primary transition duration-300">Home</a>
                    <a href="<?php echo USER_URL; ?>../user/animals.php" class="py-4 px-2 text-gray-500 font-semibold hover:text-primary transition duration-300">Animals</a>
                    <a href="<?php echo USER_URL; ?>tickets.php" class="py-4 px-2 text-gray-500 font-semibold hover:text-primary transition duration-300">Tickets</a>
                    <a href="<?php echo USER_URL; ?>contact.php" class="py-4 px-2 text-gray-500 font-semibold hover:text-primary transition duration-300">Contact</a>
                    <a href="<?php echo USER_URL; ?>about.php" class="py-4 px-2 text-gray-500 font-semibold hover:text-primary transition duration-300">About</a>
                    <a href="<?php echo BASE_URL; ?>login.php" class="py-4 px-2 text-gray-500 font-semibold hover:text-primary transition duration-300">Admin</a>
                </div>
            </div>
        </div>
    </nav>
    <main class="container mx-auto px-4 py-8"></main>
</body>
</html>
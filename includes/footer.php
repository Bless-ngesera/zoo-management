</main>
<footer class="bg-green-900 text-gray-100 py-10">
    <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">
        <!-- Branding & Description -->
        <div>
            <img src="../uploads/zms_logo.jpg" alt="Zoo Logo" class="mb-4 w-18 h-16">
            <p class="text-sm">Conserving wildlife since 1990. Join us in protecting endangered species and their habitats.</p>
        </div>
        
        <!-- Quick Links -->
        <div>
            <h3 class="font-semibold text-lg mb-4">Quick Links</h3>
            <ul class="space-y-2">
                <li><a href="/zoo-management/index.php" class="hover:text-yellow-400">Home</a></li>
                <li><a href="/zoo-management/user/animals.php" class="hover:text-yellow-400">Animals</a></li>
                <li><a href="/zoo-management/user/tickets.php" class="hover:text-yellow-400">Tickets</a></li>
                <li><a href="/zoo-management/user/contact.php" class="hover:text-yellow-400">Contact</a></li>
            </ul>
        </div>
        
        <!-- Contact Info -->
        <div>
            <h3 class="font-semibold text-lg mb-4">Contact Info</h3>
            <ul class="space-y-2 text-sm">
                <li>Plot 56/57 Lugard Avenue, Johnston Rd, Entebbe</li>
                <li>Phone: +256 763 321 655</li>
                <li>Email: <a href="mailto:contact@blesszoo-management.com" class="hover:text-yellow-400">info@zooms.com</a></li>
                <li>Opening Hours: 9:00 AM - 6:00 PM</li>
            </ul>
        </div>
        
        <!-- Newsletter Signup -->
        <div>
            <h3 class="font-semibold text-lg mb-4">Newsletter Signup</h3>
            <form action="#" method="POST" class="space-y-4">
                <input type="email" name="email" placeholder="Enter your email" class="w-full px-4 py-2 rounded bg-gray-800 text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <button type="submit" class="w-full bg-yellow-400 text-green-900 py-2 rounded hover:bg-yellow-500 transition">Subscribe</button>
            </form>
            <p class="text-xs mt-2">By subscribing, you agree to our <a href="#" class="hover:text-yellow-400">Privacy Policy</a>.</p>
        </div>
    </div>
    
    <div class="border-t border-gray-700 mt-10 pt-6">
        <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
            <!-- Social Media & Legal -->
            <div class="flex space-x-4 mb-4 md:mb-0">
                <a href="#" class="hover:text-yellow-400" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-yellow-400" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-yellow-400" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-yellow-400" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
            </div>
            <div class="text-sm text-center md:text-left">
                &copy; <?php echo date('Y'); ?> BLESSZooMS. All rights reserved. 
                <a href="#" class="hover:text-yellow-400">Privacy Policy</a> | 
                <a href="#" class="hover:text-yellow-400">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
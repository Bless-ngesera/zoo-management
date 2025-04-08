<div class="fixed top-0 left-0 w-full bg-white p-4 flex justify-between items-center shadow-md z-50">
    <!-- Logo or Title -->
    <div class="text-xl font-bold text-primary" style="color: #3B82F6; font-weight: bolder; font-size: x-large;">ZOO <span style="color: #10B981;">MANAGEMENT</span> <span style="color: black">SYSTEM</span> </div>

    <!-- Profile Dropdown -->
    <div class="relative">
        <button id="profileDropdownButton" class="flex items-center space-x-2 bg-purple-600 text-white px-4 py-2 rounded-lg focus:outline-none">
            <img src="/zoo-management/uploads/default-avatar.png" alt="Admin Avatar" class="w-8 h-8 rounded-full">
            <span>Admin</span>
            <i class="fas fa-chevron-down"></i>
        </button>
        <div id="profileDropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg">
            <a href="/zoo-management/admin/profile.php" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
            <a href="/zoo-management/admin/settings.php" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
            <a href="/zoo-management/logout.php" class="block px-4 py-2 text-red-500 hover:bg-gray-100">Log Out</a>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownButton = document.getElementById('profileDropdownButton');
        const dropdownMenu = document.getElementById('profileDropdownMenu');

        dropdownButton.addEventListener('click', function () {
            dropdownMenu.classList.toggle('hidden');
        });
    });
</script>

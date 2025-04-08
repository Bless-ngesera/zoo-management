<aside id="sidebar" class="fixed top-20 left-0 h-full w-64 bg-primary text-white flex flex-col transition-transform transform">
    <div class="p-4 text-center font-bold text-2xl flex items-center justify-between">
        <span>Admin</span>
        <button id="hideSidebar" class="text-white focus:outline-none">
            <i class="fas fa-chevron-left"></i>
        </button>
    </div>
    <nav class="flex-1">
        <ul class="space-y-2">
            <li><a href="/zoo-management/admin/dashboard.php" class="block py-2 px-4 hover:bg-primary-600"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</a></li>
            <li><a href="/zoo-management/admin/animals/manage.php" class="block py-2 px-4 hover:bg-primary-600"><i class="fas fa-paw mr-2"></i> Manage Animals</a></li>
            <li><a href="/zoo-management/admin/animals/details.php" class="block py-2 px-4 hover:bg-primary-600"><i class="fas fa-info-circle mr-2"></i> View Animals</a></li>
            <li><a href="/zoo-management/admin/users/manage.php" class="block py-2 px-4 hover:bg-primary-600"><i class="fas fa-users mr-2"></i> Users</a></li>
            <li><a href="/zoo-management/admin/reports/daily.php" class="block py-2 px-4 hover:bg-primary-600"><i class="fas fa-chart-line mr-2"></i> Reports</a></li>
            <li><a href="/zoo-management/chat/index.php" class="block py-2 px-4 hover:bg-primary-600"><i class="fas fa-comments mr-2"></i> Chatrooms</a></li>
            <li><a href="/zoo-management/email/index.php" class="block py-2 px-4 hover:bg-primary-600"><i class="fas fa-envelope mr-2"></i> Email</a></li>
        </ul>
    </nav>
</aside>
<button id="showSidebar" class="fixed top-20 left-0 bg-primary text-white px-4 py-2 rounded-r-lg hidden focus:outline-none">
    <i class="fas fa-chevron-right"></i>
</button>

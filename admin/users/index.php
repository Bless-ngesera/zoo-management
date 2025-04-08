<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_auth();
require_role('admin');
require_once __DIR__ . '/../../../includes/header.php';
?>

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">User Management</h1>
        <a href="add.php" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-600 transition flex items-center">
            <i class="fas fa-plus mr-2"></i> Add User
        </a>
    </div>

    <div class="mb-6">
        <div class="relative">
            <input type="text" placeholder="Search users..." class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
            <button class="absolute right-3 top-2 text-gray-400 hover:text-primary">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Login</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center text-primary">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">Admin User</div>
                                <div class="text-sm text-gray-500">admin</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">admin@zoo.com</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                            Admin
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Today, 09:45 AM</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Active
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="edit.php?id=1" class="text-primary hover:text-primary-600 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to deactivate this user?')">
                            <i class="fas fa-ban"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">Staff Member</div>
                                <div class="text-sm text-gray-500">staff1</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">staff@zoo.com</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                            Staff
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Yesterday, 02:30 PM</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Active
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="edit.php?id=2" class="text-primary hover:text-primary-600 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to deactivate this user?')">
                            <i class="fas fa-ban"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">Inactive User</div>
                                <div class="text-sm text-gray-500">user1</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">user@example.com</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                            User
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1 week ago</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Inactive
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="edit.php?id=3" class="text-primary hover:text-primary-600 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="text-green-600 hover:text-green-900" onclick="return confirm('Are you sure you want to activate this user?')">
                            <i class="fas fa-check"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex items-center justify-between mt-6">
        <div class="text-sm text-gray-500">
            Showing <span class="font-medium">1</span> to <span class="font-medium">3</span> of <span class="font-medium">3</span> results
        </div>
        <div class="flex space-x-2">
            <button class="px-3 py-1 border rounded text-gray-500 bg-white cursor-not-allowed" disabled>
                Previous
            </button>
            <button class="px-3 py-1 border rounded bg-primary text-white">
                1
            </button>
            <button class="px-3 py-1 border rounded text-gray-500 bg-white cursor-not-allowed" disabled>
                Next
            </button>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>
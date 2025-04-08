<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_auth();
require_role('admin');
require_once __DIR__ . '/../../../includes/header.php';
?>

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Ticket Management</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Ticket Price Configuration -->
        <div class="border rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Update Ticket Prices</h2>
            
            <form class="space-y-4">
                <div>
                    <label class="block text-gray-700 mb-1">Indian Visitor (Adult)</label>
                    <div class="flex items-center">
                        <span class="mr-2">₹</span>
                        <input type="number" value="200" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                </div>
                
                <div>
                    <label class="block text-gray-700 mb-1">Indian Visitor (Child)</label>
                    <div class="flex items-center">
                        <span class="mr-2">₹</span>
                        <input type="number" value="100" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                </div>
                
                <div>
                    <label class="block text-gray-700 mb-1">Foreign Visitor (Adult)</label>
                    <div class="flex items-center">
                        <span class="mr-2">$</span>
                        <input type="number" value="20" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                </div>
                
                <div>
                    <label class="block text-gray-700 mb-1">Foreign Visitor (Child)</label>
                    <div class="flex items-center">
                        <span class="mr-2">$</span>
                        <input type="number" value="10" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                </div>
                
                <div class="pt-2">
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition">
                        Update Prices
                    </button>
                </div>
            </form>
        </div>

        <!-- Ticket Types -->
        <div class="border rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Ticket Types</h2>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-medium">Standard Ticket</h3>
                        <p class="text-sm text-gray-500">Basic zoo entry</p>
                    </div>
                    <div class="flex items-center">
                        <span class="text-green-500 mr-2"><i class="fas fa-check-circle"></i></span>
                        <span>Active</span>
                    </div>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-medium">Family Package</h3>
                        <p class="text-sm text-gray-500">2 adults + 2 children</p>
                    </div>
                    <div class="flex items-center">
                        <span class="text-green-500 mr-2"><i class="fas fa-check-circle"></i></span>
                        <span>Active</span>
                    </div>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-medium">Annual Pass</h3>
                        <p class="text-sm text-gray-500">Unlimited yearly access</p>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-400 mr-2"><i class="fas fa-times-circle"></i></span>
                        <span>Inactive</span>
                    </div>
                </div>
                
                <div class="pt-2">
                    <button class="text-primary font-medium hover:underline flex items-center">
                        <i class="fas fa-plus mr-1"></i> Add New Ticket Type
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Ticket Sales -->
    <div class="border rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Recent Ticket Sales</h2>
            <a href="search.php" class="text-primary hover:underline">View All</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visitor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">#TKT-1001</td>
                        <td class="px-6 py-4 whitespace-nowrap">Indian (2A+1C)</td>
                        <td class="px-6 py-4 whitespace-nowrap">Rahul Sharma</td>
                        <td class="px-6 py-4 whitespace-nowrap">Today, 10:30 AM</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹500</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Completed
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">#TKT-1002</td>
                        <td class="px-6 py-4 whitespace-nowrap">Foreign (1A)</td>
                        <td class="px-6 py-4 whitespace-nowrap">John Smith</td>
                        <td class="px-6 py-4 whitespace-nowrap">Today, 11:15 AM</td>
                        <td class="px-6 py-4 whitespace-nowrap">$20</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Completed
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">#TKT-1003</td>
                        <td class="px-6 py-4 whitespace-nowrap">Indian (1A)</td>
                        <td class="px-6 py-4 whitespace-nowrap">Priya Patel</td>
                        <td class="px-6 py-4 whitespace-nowrap">Today, 1:45 PM</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹200</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>
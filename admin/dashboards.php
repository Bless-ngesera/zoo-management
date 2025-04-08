<?php
require_once __DIR__ . '/../../includes/auth.php';
require_auth();
require_role('admin');
require_once __DIR__ . '/../../includes/header.php';
?>

<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Admin Dashboard</h1>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-primary-50 rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-primary text-white mr-4">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div>
                    <p class="text-gray-500">Today's Tickets</p>
                    <h3 class="text-2xl font-bold">124</h3>
                </div>
            </div>
        </div>
        
        <div class="bg-green-50 rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-500 text-white mr-4">
                    <i class="fas fa-rupee-sign"></i>
                </div>
                <div>
                    <p class="text-gray-500">Today's Revenue</p>
                    <h3 class="text-2xl font-bold">₹24,800</h3>
                </div>
            </div>
        </div>
        
        <div class="bg-purple-50 rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-500 text-white mr-4">
                    <i class="fas fa-paw"></i>
                </div>
                <div>
                    <p class="text-gray-500">Total Animals</p>
                    <h3 class="text-2xl font-bold">87</h3>
                </div>
            </div>
        </div>
        
        <div class="bg-yellow-50 rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-500 text-white mr-4">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <p class="text-gray-500">Total Staff</p>
                    <h3 class="text-2xl font-bold">32</h3>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white border rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Weekly Visitors</h2>
            <canvas id="visitorsChart" height="250"></canvas>
        </div>
        
        <div class="bg-white border rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Ticket Types</h2>
            <canvas id="ticketTypesChart" height="250"></canvas>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="bg-white border rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Activity</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">John Doe</td>
                        <td class="px-6 py-4 whitespace-nowrap">Added new animal (Lion)</td>
                        <td class="px-6 py-4 whitespace-nowrap">10 minutes ago</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">Jane Smith</td>
                        <td class="px-6 py-4 whitespace-nowrap">Updated ticket prices</td>
                        <td class="px-6 py-4 whitespace-nowrap">1 hour ago</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">Admin</td>
                        <td class="px-6 py-4 whitespace-nowrap">System maintenance</td>
                        <td class="px-6 py-4 whitespace-nowrap">2 hours ago</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Visitors Chart
    const visitorsCtx = document.getElementById('visitorsChart').getContext('2d');
    const visitorsChart = new Chart(visitorsCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Visitors',
                data: [120, 190, 170, 200, 250, 300, 280],
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 2,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Ticket Types Chart
    const ticketTypesCtx = document.getElementById('ticketTypesChart').getContext('2d');
    const ticketTypesChart = new Chart(ticketTypesCtx, {
        type: 'doughnut',
        data: {
            labels: ['Indian', 'Foreign', 'Group', 'Student'],
            datasets: [{
                data: [65, 25, 5, 5],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.7)',
                    'rgba(16, 185, 129, 0.7)',
                    'rgba(139, 92, 246, 0.7)',
                    'rgba(234, 179, 8, 0.7)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
});
</script>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>
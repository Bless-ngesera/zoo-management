<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_auth();
require_role('admin');
require_once __DIR__ . '/../../../includes/header.php';

// Get current month and year
$currentMonth = date('m');
$currentYear = date('Y');
$monthName = date('F');
?>

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Monthly Reports</h1>
        <div class="flex items-center space-x-4">
            <button onclick="window.print()" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-print mr-2"></i> Print Report
            </button>
            <button class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-600 transition">
                <i class="fas fa-download mr-2"></i> Export
            </button>
        </div>
    </div>

    <div class="mb-6">
        <form class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
            <div class="flex-1">
                <label for="month-select" class="block text-gray-700 mb-1">Select Month</label>
                <div class="flex items-center space-x-2">
                    <input type="month" id="month-select" name="month" 
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                        value="<?php echo date('Y-m'); ?>">
                    <span class="whitespace-nowrap">
                        <?php echo $monthName . ' ' . $currentYear; ?>
                    </span>
                </div>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition h-[42px]">
                    Generate Report
                </button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="border rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Monthly Summary</h2>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Visitors</span>
                    <span class="font-medium">1,542</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Indian Tickets</span>
                    <span class="font-medium">1,278</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Foreign Tickets</span>
                    <span class="font-medium">264</span>
                </div>
                <div class="border-t border-gray-200 my-2"></div>
                <div class="flex justify-between font-bold">
                    <span>Total Revenue</span>
                    <span>₹291,200</span>
                </div>
            </div>
        </div>

        <div class="border rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Weekly Performance</h2>
            <div class="h-64">
                <canvas id="weeklyPerformanceChart"></canvas>
            </div>
        </div>

        <div class="border rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Revenue Sources</h2>
            <div class="h-64">
                <canvas id="revenueSourcesChart"></canvas>
            </div>
        </div>
    </div>

    <div class="border rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Daily Averages</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Day</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg Visitors</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg Revenue</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Best Day</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Best Revenue</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">Monday</td>
                        <td class="px-6 py-4 whitespace-nowrap">48</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹8,200</td>
                        <td class="px-6 py-4 whitespace-nowrap">Week 3</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹9,800</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">Tuesday</td>
                        <td class="px-6 py-4 whitespace-nowrap">42</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹7,600</td>
                        <td class="px-6 py-4 whitespace-nowrap">Week 4</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹8,400</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">Wednesday</td>
                        <td class="px-6 py-4 whitespace-nowrap">51</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹9,200</td>
                        <td class="px-6 py-4 whitespace-nowrap">Week 2</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹10,600</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">Thursday</td>
                        <td class="px-6 py-4 whitespace-nowrap">58</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹10,400</td>
                        <td class="px-6 py-4 whitespace-nowrap">Week 4</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹12,200</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">Friday</td>
                        <td class="px-6 py-4 whitespace-nowrap">72</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹13,600</td>
                        <td class="px-6 py-4 whitespace-nowrap">Week 1</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹15,800</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">Saturday</td>
                        <td class="px-6 py-4 whitespace-nowrap">85</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹16,200</td>
                        <td class="px-6 py-4 whitespace-nowrap">Week 2</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹18,400</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">Sunday</td>
                        <td class="px-6 py-4 whitespace-nowrap">78</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹15,000</td>
                        <td class="px-6 py-4 whitespace-nowrap">Week 3</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹17,200</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="border rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Monthly Trends</h2>
        <div class="h-96">
            <canvas id="monthlyTrendsChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Weekly Performance Chart
    const weeklyPerformanceCtx = document.getElementById('weeklyPerformanceChart').getContext('2d');
    const weeklyPerformanceChart = new Chart(weeklyPerformanceCtx, {
        type: 'bar',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Visitors',
                data: [320, 380, 420, 422],
                backgroundColor: 'rgba(59, 130, 246, 0.7)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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

    // Revenue Sources Chart
    const revenueSourcesCtx = document.getElementById('revenueSourcesChart').getContext('2d');
    const revenueSourcesChart = new Chart(revenueSourcesCtx, {
        type: 'doughnut',
        data: {
            labels: ['Ticket Sales', 'Merchandise', 'Food & Beverage', 'Donations'],
            datasets: [{
                data: [255200, 24000, 10800, 1200],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.7)',
                    'rgba(16, 185, 129, 0.7)',
                    'rgba(234, 179, 8, 0.7)',
                    'rgba(139, 92, 246, 0.7)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });

    // Monthly Trends Chart
    const monthlyTrendsCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
    const monthlyTrendsChart = new Chart(monthlyTrendsCtx, {
        type: 'line',
        data: {
            labels: Array.from({length: 31}, (_, i) => i + 1),
            datasets: [{
                label: 'Daily Visitors',
                data: [42,38,45,52,68,72,65,48,42,51,58,72,85,78,52,48,55,62,78,82,75,58,52,61,68,82,95,88,62,58,65],
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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

    // Update month display when month input changes
    document.getElementById('month-select').addEventListener('change', function() {
        const date = new Date(this.value + '-01');
        const monthName = date.toLocaleString('default', { month: 'long' });
        const year = date.getFullYear();
        this.nextElementSibling.textContent = monthName + ' ' + year;
    });
});
</script>

<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>
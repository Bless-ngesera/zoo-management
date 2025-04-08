<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_auth();
require_role('admin');
require_once __DIR__ . '/../../../includes/header.php';

// Calculate week start and end dates
$currentWeekStart = date('Y-m-d', strtotime('monday this week'));
$currentWeekEnd = date('Y-m-d', strtotime('sunday this week'));
?>

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Weekly Reports</h1>
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
                <label for="week-select" class="block text-gray-700 mb-1">Select Week</label>
                <div class="flex items-center space-x-2">
                    <input type="week" id="week-select" name="week" 
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                        value="<?php echo date('Y-\WW', strtotime($currentWeekStart)); ?>">
                    <span class="whitespace-nowrap">
                        <?php echo date('M d', strtotime($currentWeekStart)) . ' - ' . date('M d, Y', strtotime($currentWeekEnd)); ?>
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
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Weekly Summary</h2>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Visitors</span>
                    <span class="font-medium">342</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Indian Tickets</span>
                    <span class="font-medium">278</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Foreign Tickets</span>
                    <span class="font-medium">64</span>
                </div>
                <div class="border-t border-gray-200 my-2"></div>
                <div class="flex justify-between font-bold">
                    <span>Total Revenue</span>
                    <span>₹61,200</span>
                </div>
            </div>
        </div>

        <div class="border rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Daily Visitors</h2>
            <div class="h-64">
                <canvas id="dailyVisitorsChart"></canvas>
            </div>
        </div>

        <div class="border rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Revenue Breakdown</h2>
            <div class="h-64">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <div class="border rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Daily Performance</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Day</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visitors</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Indian Tickets</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foreign Tickets</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">% of Week</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">Monday</td>
                        <td class="px-6 py-4 whitespace-nowrap">42</td>
                        <td class="px-6 py-4 whitespace-nowrap">32</td>
                        <td class="px-6 py-4 whitespace-nowrap">10</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹7,400</td>
                        <td class="px-6 py-4 whitespace-nowrap">12.1%</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">Tuesday</td>
                        <td class="px-6 py-4 whitespace-nowrap">38</td>
                        <td class="px-6 py-4 whitespace-nowrap">30</td>
                        <td class="px-6 py-4 whitespace-nowrap">8</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹6,800</td>
                        <td class="px-6 py-4 whitespace-nowrap">11.1%</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">Wednesday</td>
                        <td class="px-6 py-4 whitespace-nowrap">45</td>
                        <td class="px-6 py-4 whitespace-nowrap">38</td>
                        <td class="px-6 py-4 whitespace-nowrap">7</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹8,200</td>
                        <td class="px-6 py-4 whitespace-nowrap">13.4%</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">Thursday</td>
                        <td class="px-6 py-4 whitespace-nowrap">52</td>
                        <td class="px-6 py-4 whitespace-nowrap">45</td>
                        <td class="px-6 py-4 whitespace-nowrap">7</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹9,400</td>
                        <td class="px-6 py-4 whitespace-nowrap">15.4%</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">Friday</td>
                        <td class="px-6 py-4 whitespace-nowrap">68</td>
                        <td class="px-6 py-4 whitespace-nowrap">55</td>
                        <td class="px-6 py-4 whitespace-nowrap">13</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹12,600</td>
                        <td class="px-6 py-4 whitespace-nowrap">20.6%</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">Saturday</td>
                        <td class="px-6 py-4 whitespace-nowrap">72</td>
                        <td class="px-6 py-4 whitespace-nowrap">58</td>
                        <td class="px-6 py-4 whitespace-nowrap">14</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹13,200</td>
                        <td class="px-6 py-4 whitespace-nowrap">21.6%</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">Sunday</td>
                        <td class="px-6 py-4 whitespace-nowrap">65</td>
                        <td class="px-6 py-4 whitespace-nowrap">60</td>
                        <td class="px-6 py-4 whitespace-nowrap">5</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹13,000</td>
                        <td class="px-6 py-4 whitespace-nowrap">21.2%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Daily Visitors Chart
    const dailyVisitorsCtx = document.getElementById('dailyVisitorsChart').getContext('2d');
    const dailyVisitorsChart = new Chart(dailyVisitorsCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Visitors',
                data: [42, 38, 45, 52, 68, 72, 65],
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

    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: ['Indian', 'Foreign', 'Other'],
            datasets: [{
                label: 'Revenue',
                data: [55600, 5600, 0],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.7)',
                    'rgba(16, 185, 129, 0.7)',
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

    // Update week display when week input changes
    document.getElementById('week-select').addEventListener('change', function() {
        const year = this.value.substring(0, 4);
        const week = this.value.substring(6);
        const firstDay = new Date(year, 0, 1 + (week - 1) * 7);
        const lastDay = new Date(firstDay);
        lastDay.setDate(firstDay.getDate() + 6);
        
        const options = { month: 'short', day: 'numeric' };
        const startStr = firstDay.toLocaleDateString('en-US', options);
        const endStr = lastDay.toLocaleDateString('en-US', { 
            month: 'short', 
            day: 'numeric', 
            year: 'numeric' 
        });
        
        this.nextElementSibling.textContent = startStr + ' - ' + endStr;
    });
});
</script>

<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>
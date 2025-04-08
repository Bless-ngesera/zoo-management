<?php
require_once __DIR__ . '/../../includes/auth.php';
require_auth();
require_role('admin');
require_once __DIR__ . '/../../includes/header.php';

// Check system requirements
$requirements = [
    'PHP Version >= 8.0' => version_compare(PHP_VERSION, '8.0.0', '>='),
    'PDO Extension' => extension_loaded('pdo'),
    'MySQLi Extension' => extension_loaded('mysqli'),
    'GD Library' => extension_loaded('gd'),
    'File Uploads' => ini_get('file_uploads'),
    'Upload Max Filesize' => ini_get('upload_max_filesize'),
    'Post Max Size' => ini_get('post_max_size'),
    'Memory Limit' => ini_get('memory_limit'),
    'Max Execution Time' => ini_get('max_execution_time'),
    'Required Directories Writable' => [
        '/config' => is_writable(__DIR__ . '/../../config'),
        '/uploads' => is_writable(__DIR__ . '/../../uploads'),
        '/cache' => is_writable(__DIR__ . '/../../cache')
    ]
];

// Check database connection
try {
    require_once __DIR__ . '/../../config/database.php';
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db_connected = true;
} catch (PDOException $e) {
    $db_connected = false;
    $db_error = $e->getMessage();
}
?>

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">System Configuration Check</h1>
        <div class="flex space-x-2">
            <a href="../dashboard.php" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <div class="space-y-6">
        <div class="border rounded-lg p-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">System Requirements</h2>
            
            <div class="space-y-2">
                <?php foreach ($requirements as $label => $value): ?>
                    <?php if (is_array($value)): ?>
                        <div class="mb-4">
                            <h3 class="font-medium text-gray-800 mb-2"><?php echo $label; ?></h3>
                            <div class="space-y-2 pl-4">
                                <?php foreach ($value as $dir => $writable): ?>
                                    <div class="flex items-center">
                                        <span class="w-40"><?php echo $dir; ?></span>
                                        <span class="<?php echo $writable ? 'text-green-500' : 'text-red-500'; ?>">
                                            <?php echo $writable ? '✓ Writable' : '✗ Not Writable'; ?>
                                        </span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="flex items-center">
                            <span class="w-64"><?php echo $label; ?></span>
                            <span class="<?php echo $value ? 'text-green-500' : 'text-red-500'; ?>">
                                <?php if (is_bool($value)): ?>
                                    <?php echo $value ? '✓ Passed' : '✗ Failed'; ?>
                                <?php else: ?>
                                    <?php echo $value; ?>
                                <?php endif; ?>
                            </span>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="border rounded-lg p-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Database Connection</h2>
            
            <?php if ($db_connected): ?>
                <div class="flex items-center text-green-500">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>Successfully connected to database</span>
                </div>
                
                <div class="mt-4">
                    <h3 class="font-medium text-gray-800 mb-2">Database Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p><span class="font-medium">Host:</span> <?php echo htmlspecialchars($db_host); ?></p>
                            <p><span class="font-medium">Name:</span> <?php echo htmlspecialchars($db_name); ?></p>
                        </div>
                        <div>
                            <p><span class="font-medium">User:</span> <?php echo htmlspecialchars($db_user); ?></p>
                            <p><span class="font-medium">Tables:</span> 
                                <?php 
                                    $tables = $db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
                                    echo count($tables) . ' tables found';
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="flex items-center text-red-500">
                    <i class="fas fa-times-circle mr-2"></i>
                    <span>Failed to connect to database</span>
                </div>
                <div class="mt-2 text-sm text-gray-600">
                    <?php echo htmlspecialchars($db_error); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="border rounded-lg p-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Deployment Checklist</h2>
            
            <div class="space-y-3">
                <div class="flex items-start">
                    <input type="checkbox" id="check1" class="mt-1 mr-2">
                    <label for="check1" class="flex-1">Configure database settings in <code>config/database.php</code></label>
                </div>
                <div class="flex items-start">
                    <input type="checkbox" id="check2" class="mt-1 mr-2">
                    <label for="check2" class="flex-1">Set up cron jobs for scheduled tasks (reports, cleanup)</label>
                </div>
                <div class="flex items-start">
                    <input type="checkbox" id="check3" class="mt-1 mr-2">
                    <label for="check3" class="flex-1">Configure email settings for notifications</label>
                </div>
                <div class="flex items-start">
                    <input type="checkbox" id="check4" class="mt-1 mr-2">
                    <label for="check4" class="flex-1">Set up backup strategy for database and uploads</label>
                </div>
                <div class="flex items-start">
                    <input type="checkbox" id="check5" class="mt-1 mr-2">
                    <label for="check5" class="flex-1">Configure proper file permissions (755 for directories, 644 for files)</label>
                </div>
                <div class="flex items-start">
                    <input type="checkbox" id="check6" class="mt-1 mr-2">
                    <label for="check6" class="flex-1">Set up SSL certificate for secure connections</label>
                </div>
            </div>
        </div>

        <div class="border rounded-lg p-4 bg-blue-50">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Deployment Instructions</h2>
            <p class="text-gray-600 mb-4">Follow these steps to deploy the application to a production server:</p>
            
            <div class="space-y-4">
                <div>
                    <h3 class="font-medium text-gray-800">1. Server Requirements</h3>
                    <ul class="list-disc pl-5 text-gray-600 space-y-1 mt-1">
                        <li>Linux server with Apache/Nginx</li>
                        <li>PHP 8.0+ with required extensions</li>
                        <li>MySQL 5.7+ or MariaDB 10.2+</li>
                        <li>Composer for dependency management</li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-medium text-gray-800">2. Installation Steps</h3>
                    <ol class="list-decimal pl-5 text-gray-600 space-y-1 mt-1">
                        <li>Upload all files to your server</li>
                        <li>Run <code>composer install</code> to install dependencies</li>
                        <li>Create database and import schema (schema.sql)</li>
                        <li>Configure <code>config/database.php</code> with your credentials</li>
                        <li>Set up cron jobs for scheduled tasks</li>
                        <li>Configure web server to point to the <code>public</code> directory</li>
                    </ol>
                </div>
                
                <div>
                    <h3 class="font-medium text-gray-800">3. Post-Installation</h3>
                    <ul class="list-disc pl-5 text-gray-600 space-y-1 mt-1">
                        <li>Create an admin user through the interface</li>
                        <li>Configure system settings</li>
                        <li>Set up backup strategy</li>
                        <li>Monitor error logs for any issues</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>
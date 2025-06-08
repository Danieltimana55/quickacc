<?php
// Debug script to check for errors

// Display all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Output basic server info
echo "<h1>PHP Info</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";

// Check for .env file
echo "<h2>Environment File</h2>";
if (file_exists(__DIR__ . '/../.env')) {
    echo "<p style='color:green'>.env file exists</p>";
} else {
    echo "<p style='color:red'>.env file NOT found - this is a critical issue!</p>";
}

// Check database connection
echo "<h2>Database Connection</h2>";
try {
    $dbConfigFile = __DIR__ . '/../config/database.php';
    if (file_exists($dbConfigFile)) {
        echo "<p>Database config file exists</p>";
        include $dbConfigFile;
        
        if (isset($connections['mysql'])) {
            $host = getenv('DB_HOST') ?: $connections['mysql']['host'] ?? 'localhost';
            $port = getenv('DB_PORT') ?: $connections['mysql']['port'] ?? '3306';
            $database = getenv('DB_DATABASE') ?: $connections['mysql']['database'] ?? 'forge';
            $username = getenv('DB_USERNAME') ?: $connections['mysql']['username'] ?? 'forge';
            $password = getenv('DB_PASSWORD') ?: $connections['mysql']['password'] ?? '';
            
            echo "<p>Attempting to connect to MySQL: $host:$port</p>";
            
            $pdo = new PDO("mysql:host=$host;port=$port", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "<p style='color:green'>Successfully connected to MySQL server</p>";
            
            // Check if database exists
            $stmt = $pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database'");
            if ($stmt->rowCount() > 0) {
                echo "<p style='color:green'>Database '$database' exists</p>";
            } else {
                echo "<p style='color:red'>Database '$database' does NOT exist</p>";
            }
        } else {
            echo "<p style='color:red'>MySQL config not found in database.php</p>";
        }
    } else {
        echo "<p style='color:red'>Database config file NOT found</p>";
    }
} catch (PDOException $e) {
    echo "<p style='color:red'>Database connection failed: " . $e->getMessage() . "</p>";
}

// Check for Inertia related issues
echo "<h2>Inertia Setup</h2>";
$inertiaMiddleware = __DIR__ . '/../app/Http/Middleware/HandleInertiaRequests.php';
if (file_exists($inertiaMiddleware)) {
    echo "<p style='color:green'>Inertia middleware file exists</p>";
} else {
    echo "<p style='color:red'>Inertia middleware NOT found</p>";
}

// Check for compiled assets
echo "<h2>Compiled Assets</h2>";
$publicManifest = __DIR__ . '/build/manifest.json';
if (file_exists($publicManifest)) {
    echo "<p style='color:green'>Vite manifest file exists</p>";
    $manifest = json_decode(file_get_contents($publicManifest), true);
    echo "<pre>" . print_r($manifest, true) . "</pre>";
} else {
    echo "<p style='color:red'>Vite manifest file NOT found - have you run 'npm run build'?</p>";
}

// Check for JS errors
echo "<h2>Frontend Debugging</h2>";
echo "<p>Add this script to your HTML head to detect JS errors:</p>";
echo "<pre>
&lt;script&gt;
window.addEventListener('error', function(e) {
    console.error('JS Error:', e.message);
    document.body.innerHTML += '&lt;div style=\"position:fixed;top:0;left:0;right:0;background:red;color:white;padding:10px;z-index:9999\"&gt;' + 
        'JavaScript Error: ' + e.message + ' at ' + e.filename + ':' + e.lineno + 
        '&lt;/div&gt;';
});
&lt;/script&gt;
</pre>";

// Output Laravel logs
echo "<h2>Recent Laravel Logs</h2>";
$logFile = __DIR__ . '/../storage/logs/laravel.log';
if (file_exists($logFile)) {
    echo "<p>Log file exists</p>";
    $logs = file_exists($logFile) ? file($logFile) : [];
    $lastLogs = array_slice($logs, -20);
    echo "<pre>" . implode("", $lastLogs) . "</pre>";
} else {
    echo "<p style='color:red'>Log file NOT found</p>";
} 
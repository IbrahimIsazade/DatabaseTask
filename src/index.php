<?php
// Autoloader (PSR-4 Standard)
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/src/';
    $len = strlen($prefix);

    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use App\Database\SqliteConnection;
use App\Models\User;

// 1. Initialize SQLite Database
$dbPath = __DIR__ . '/database.db';
$db = new SqliteConnection($dbPath);

// 2. Initialize User Model
$userSystem = new User($db);

echo "<h3>Testing User System</h3>";

// 3. Test Registration
$userSystem->register("XausMaster", "SecurePass2026!");

// 4. Test Login (Success)
$userSystem->login("XausMaster", "SecurePass2026!");

// 5. Test Login (Failure)
$userSystem->login("XausMaster", "WrongPassword");
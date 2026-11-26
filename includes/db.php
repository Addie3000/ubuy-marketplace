<?php
// Live credentials live in config.live.php, which exists ONLY on the server.
// Locally (XAMPP) that file doesn't exist, so the defaults below are used.
$live = __DIR__ . '/config.live.php';

if (file_exists($live)) {
    require $live;
} else {
    $host     = 'localhost';
    $dbname   = 'ubuy_db';
    $username = 'root';
    $password = '';
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed.");
}
?>

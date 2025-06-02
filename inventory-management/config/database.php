<?php
// Database configuration settings
$host = 'localhost'; // Database host
$dbname = 'inventory_db'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    // Create a new PDO instance
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    // Handle connection error
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
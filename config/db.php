<?php
// config/db.php

$host = "localhost";
$dbname = "php_dev_marketplace";
$username = "root";
$password = "";

// $host = "sql113.infinityfree.com";
// $dbname = "if0_40717533_php_dev_marketplace";
// $username = "if0_40717533";
// $password = "EuHpCKYPr1U";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

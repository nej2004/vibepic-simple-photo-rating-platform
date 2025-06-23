<?php
if ($_SERVER['HTTPS'] === 'on') {
    header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    exit();
}
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Test PHP
echo "<h1>PHP is working</h1>";

// Test MySQL
$conn = new mysqli('localhost', 'root', '', 'vibepic');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "<h2>Database connected</h2>";

// Test file permissions
$test_file = 'uploads/test.txt';
file_put_contents($test_file, 'test');
if (file_exists($test_file)) {
    echo "<h2>File permissions OK</h2>";
    unlink($test_file);
} else {
    echo "<h2 style='color:red'>File permission error</h2>";
}
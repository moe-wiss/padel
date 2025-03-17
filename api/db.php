<?php
$host = "localhost";
$user = "court_user"; // Use root temporarily to test
$password = "12345678"; // Default empty password in XAMPP
$dbname = "court_booking";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "DB Connected!";
}
?>

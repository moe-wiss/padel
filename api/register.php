<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';
var_dump($_POST); // Add this for testing

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

// Check if email exists
$check = $conn->query("SELECT id FROM users WHERE email='$email'");
if ($check->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "Email already exists"]);
    exit;
}

// Insert user
$conn->query("INSERT INTO users (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$password')");
$user_id = $conn->insert_id;

// Generate OTP (example: 1234)
$otp = rand(1000,9999);
$expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));
$conn->query("INSERT INTO otp (user_id, otp_code, expires_at) VALUES ('$user_id', '$otp', '$expires')");

// Send OTP (for now, just return it)
echo json_encode(["status" => "success", "otp" => $otp]);
?>

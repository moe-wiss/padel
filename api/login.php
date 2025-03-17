<?php
include 'db.php';

header('Content-Type: application/json');

$email = $_POST['email'];
$password = $_POST['password'];

$result = $conn->query("SELECT * FROM users WHERE email='$email'");
if ($result->num_rows == 0) {
    echo json_encode(["status" => "error", "message" => "User not found"]);
    exit;
}

$user = $result->fetch_assoc();
if (password_verify($password, $user['password'])) {
    echo json_encode(["status" => "success", "user_id" => $user['id'], "message" => "Login successful"]);
} else {
    echo json_encode(["status" => "error", "message" => "Incorrect password"]);
}
?>


<?php
include 'db.php';
header('Content-Type: application/json');

// ✅ POST → Register New User + Generate OTP
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);

    // Check if email exists
    $check = $conn->query("SELECT id FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email already exists"]);
        exit;
    }

    // Insert user
    $conn->query("INSERT INTO users (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$password')");
    $user_id = $conn->insert_id;

    // 🔥 Generate OTP
    $otp = rand(1000,9999);
    $expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));

    // Insert OTP linked to user_id
    $conn->query("INSERT INTO otp (user_id, otp_code, expires_at) VALUES ('$user_id', '$otp', '$expires')");

    // Fetch user data to return
    $user_result = $conn->query("SELECT id, name, email, phone FROM users WHERE id = '$user_id'");
    $user = $user_result->fetch_assoc();

    // Return user + OTP to app
    echo json_encode([
        "status" => "success",
        "user" => $user,
        "otp" => $otp
    ]);
    exit;
}

// ✅ GET → Fetch All Users
$result = $conn->query("SELECT id, name, email, phone, created_at FROM users");
$users = [];
while($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode(["status" => "success", "users" => $users]);
?>

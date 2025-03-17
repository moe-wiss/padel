<?php
include 'db.php';

header('Content-Type: application/json');

$user_id = $_POST['user_id'];
$otp_code = $_POST['otp_code'];

$result = $conn->query("SELECT * FROM otp WHERE user_id='$user_id' AND otp_code='$otp_code'");
if ($result->num_rows == 0) {
    echo json_encode(["status" => "error", "message" => "Invalid OTP"]);
    exit;
}

echo json_encode(["status" => "success", "message" => "OTP verified"]);
?>

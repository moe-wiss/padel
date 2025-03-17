<?php
include 'db.php';

header('Content-Type: application/json');

$user_id = $_GET['user_id'];

$result = $conn->query("SELECT * FROM bookings WHERE user_id = '$user_id'");

$bookings = [];
while($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

echo json_encode(["status" => "success", "bookings" => $bookings]);
?>

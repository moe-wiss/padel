<?php
include 'db.php';
header('Content-Type: application/json');

// POST → Create booking
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $court_id = $_POST['court_id'];
    $booking_date = $_POST['booking_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $booking_type = $_POST['booking_type'];

    $conn->query("INSERT INTO bookings (court_id, user_id, booking_type, booking_date, start_time, end_time, status) 
    VALUES ('$court_id', '$user_id', '$booking_type', '$booking_date', '$start_time', '$end_time', 'pending')");

    $booking_id = $conn->insert_id;

    echo json_encode(["status" => "success", "booking_id" => $booking_id, "message" => "Booking created successfully"]);
    exit;
}

// GET → Get all bookings
$result = $conn->query("SELECT * FROM bookings");
$bookings = [];
while($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

echo json_encode(["status" => "success", "bookings" => $bookings]);
?>

<?php
include 'db.php';
header('Content-Type: application/json');

// POST → Record payment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];
    $status = $_POST['status'];
    $paid_at = date('Y-m-d H:i:s');

    $conn->query("INSERT INTO payments (booking_id, amount, payment_method, status, paid_at) 
    VALUES ('$booking_id', '$amount', '$payment_method', '$status', '$paid_at')");

    // Update booking status if payment completed
    if($status == 'completed') {
        $conn->query("UPDATE bookings SET status='confirmed' WHERE id='$booking_id'");
    }

    echo json_encode(["status" => "success", "message" => "Payment recorded"]);
    exit;
}

// GET → Get all payments
$result = $conn->query("SELECT * FROM payments");
$payments = [];
while($row = $result->fetch_assoc()) {
    $payments[] = $row;
}

echo json_encode(["status" => "success", "payments" => $payments]);
?>

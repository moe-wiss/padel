<?php
include 'db.php';
header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM calendar");
$calendar = [];
while($row = $result->fetch_assoc()) {
    $row['available_slots'] = json_decode($row['available_slots'], true);
    $calendar[] = $row;
}

echo json_encode(["status" => "success", "calendar" => $calendar]);
?>

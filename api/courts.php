<?php
include 'db.php';

header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM courts");

$courts = [];
while($row = $result->fetch_assoc()) {
    $courts[] = $row;
}

echo json_encode(["status" => "success", "courts" => $courts]);
?>

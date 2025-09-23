<?php
global $pdo;
include "../db_connection.php";

$location  = $_POST['location'];
$level     = $_POST['level'];
$date_time = $_POST['date_time'];
$resources = $_POST['resources'];
$active    = $_POST['active'];

$sql = "INSERT INTO siniestros (location, level, date_time, resources, active) 
        VALUES (?, ?, ?, ?, ?)";

$stmt = $pdo->prepare($sql);

if ($stmt->execute([$location, $level, $date_time, $resources, $active])) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => $stmt->errorInfo()[2]
    ]);
}

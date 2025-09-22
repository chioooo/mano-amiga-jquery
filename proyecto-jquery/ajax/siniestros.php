<?php
global $pdo;
header('Content-Type: application/json');

require "db_connection.php";

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'list') {
    $result = $pdo->query("SELECT * FROM siniestros");
    $rows = [];
    while($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    echo json_encode($rows);

} elseif ($action === 'create') {
    $location = $_POST['location'] ?? '';
    $level = $_POST['level'] ?? 1;
    $date_time = $_POST['date_time'] ?? '';
    $resources = $_POST['resources'] ?? '';

    $stmt = $pdo->prepare("INSERT INTO siniestros (location, level, date_time, resources) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $location, $level, $date_time, $resources);

    if ($stmt->execute()) {
        echo json_encode(["status"=>"success"]);
    } else {
        echo json_encode(["status"=>"error","message"=>"No se pudo crear el siniestro"]);
    }

    $stmt->close();
}

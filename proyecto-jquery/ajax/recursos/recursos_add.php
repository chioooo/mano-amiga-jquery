<?php
global $pdo;
session_start();
include __DIR__ . "/../db_connection.php";

header('Content-Type: application/json');

// Obtengo el usuario de la sesión
$usuario_id = intval($_SESSION['user_id'] ?? 0);

// Datos enviados por POST

$name         = $_POST['name'] ?? null;
$description  = $_POST['description'] ?? null;
$category     = $_POST['category'] ?? null;
$quantity     = $_POST['quantity'] ?? null;
$siniestro_id = $_POST['siniestro_id'] ?? null;

try {
    $sql = "INSERT INTO recursos (name, description, category, quantity, usuario_id, siniestro_id) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$name, $description, $category, $quantity, $usuario_id, $siniestro_id])) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => $stmt->errorInfo()[2]
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
<?php
global $pdo;
session_start();
include __DIR__ . "/../db_connection.php";

header('Content-Type: application/json');

$usuario_id   = intval($_SESSION['user_id'] ?? 0);
$siniestro_id = $_POST['siniestro_id'] ?? null;

if (!$usuario_id || !$siniestro_id) {
    echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
    exit;
}

try {
    $sql = "UPDATE usuarios SET siniestro_id = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$siniestro_id, $usuario_id])) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se pudo actualizar"]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

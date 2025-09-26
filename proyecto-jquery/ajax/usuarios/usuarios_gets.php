<?php
global $pdo;
session_start();
include __DIR__ . "/../db_connection.php";

header('Content-Type: application/json');

$usuario_id = intval($_SESSION['user_id'] ?? 0);

try {
    $sql = "SELECT u.id, u.full_name, u.username, u.is_admin, u.siniestro_id, u.fecha_registro,
                   s.level AS siniestro_level, s.location AS siniestro_location, s.date_time AS siniestro_date
            FROM usuarios u
            LEFT JOIN siniestros s ON u.siniestro_id = s.id
            WHERE u.id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$usuario_id]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($user ?: []);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

<?php
global $pdo;
include "../db_connection.php";

$id = intval($_GET["id"] ?? 0);

if ($id <= 0) {
    echo json_encode(null);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM siniestros WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo json_encode($row);


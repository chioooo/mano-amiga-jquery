<?php
global $pdo;
include "../db_connection.php";

$sql = "SELECT * FROM usuarios ORDER BY id DESC";
$stmt = $pdo->query($sql);

$usuarios = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $usuarios[] = $row;
}

echo json_encode($usuarios);

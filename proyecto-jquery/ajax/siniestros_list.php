<?php
global $pdo;
include "db_connection.php";

$sql = "SELECT * FROM siniestros ORDER BY id DESC";
$stmt = $pdo->query($sql);

$siniestros = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $siniestros[] = $row;
}

echo json_encode($siniestros);

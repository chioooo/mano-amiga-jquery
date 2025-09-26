<?php
global $pdo;
include "../db_connection.php";

$sql = "SELECT * FROM recursos ORDER BY id DESC";
$stmt = $pdo->query($sql);

$recursos = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $recursos[] = $row;
}

echo json_encode($recursos);
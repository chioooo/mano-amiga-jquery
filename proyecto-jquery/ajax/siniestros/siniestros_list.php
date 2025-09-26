<?php
global $pdo;
include "../db_connection.php";

$sql = "SELECT s.*, 
               COUNT(u.id) AS total_voluntarios
        FROM siniestros s
        LEFT JOIN usuarios u 
               ON u.siniestro_id = s.id 
              AND u.is_admin = 0
        GROUP BY s.id
        ORDER BY s.id DESC";

$stmt = $pdo->query($sql);

$siniestros = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $siniestros[] = $row;
}

echo json_encode($siniestros);

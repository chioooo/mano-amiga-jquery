<?php
global $pdo;
include "../db_connection.php";

$id = intval($_POST["id"] ?? 0);
$full_name = $_POST["fullname"] ?? "";
$username = $_POST["username"] ?? "";
$password = $_POST["password"] ?? "";
$is_admin = intval($_POST["active"] ?? 0);

if ($id <= 0) {
    echo json_encode(["status" => "error", "message" => "ID inválido"]);
    exit;
}

$stmt = $pdo->prepare("UPDATE usuarios 
    SET full_name = ?, username = ?, password = ?, is_admin = ? 
    WHERE id = ?");

if ($stmt->execute([$full_name, $username, $password, $is_admin, $id])) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->errorInfo()]);
}

<?php
global $pdo;
include "../db_connection.php";

$id = intval($_POST["id"] ?? 0);
$name = $_POST["name"] ?? "";
$description = $_POST["description"] ?? "";
$category = $_POST["category"] ?? "";
$quantity = $_POST["quantity"] ?? "";

if ($id <= 0) {
    echo json_encode(["status" => "error", "message" => "ID inválido"]);
    exit;
}

$stmt = $pdo->prepare("UPDATE recursos 
    SET name = ?, description = ?, category = ?, quantity = ? 
    WHERE id = ?");

if ($stmt->execute([$name, $description, $category, $quantity, $id])) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->errorInfo()]);
}
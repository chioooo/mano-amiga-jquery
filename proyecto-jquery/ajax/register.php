<?php
global $pdo;
header('Content-Type: application/json');
require "db_connection.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = trim($_POST["fullname"] ?? '');
    $username = trim($_POST["username"] ?? '');
    $password = trim($_POST["password"] ?? '');

    if (!empty($fullname) && !empty($username) && !empty($password)) {
        $check = $pdo->prepare("SELECT id FROM usuarios WHERE username = ?");
        $check->execute([$username]);

        if ($check->rowCount() > 0) {
            echo json_encode(["status" => "error", "message" => "El nombre de usuario ya existe"]);
            exit;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO usuarios (full_name, username, password) VALUES (?, ?, ?)");
        $stmt->execute([$fullname, $username, $hashedPassword]);

        echo json_encode(["status" => "success", "message" => "Usuario registrado correctamente"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios"]);
    }
    exit;
}

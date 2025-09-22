<?php
global $pdo;
session_start();

header('Content-Type: application/json');

require "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? '');
    $password = trim($_POST["password"] ?? '');

    if (!empty($username) && !empty($password)) {

        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'];

            echo json_encode([
                "status" => "success",
                "message" => "Inicio de sesión exitoso",
                "is_admin" => $user['is_admin']
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Usuario o contraseña incorrectos"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Debes llenar todos los campos"]);
    }
    exit;
}
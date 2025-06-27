<?php
header("Content-Type: application/json");

include_once '../includes/user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (!isset($data['username']) || !isset($data['password'])) {
        http_response_code(400);
        echo json_encode(["error" => "Parámetros incompletos"]);
        exit();
    }

    $username = $data['username'];
    $password = $data['password'];

    $user = new User();

    if ($user->userExists($username, $password)) {
        $tipo = $user->getTipoUsuario($username);
        echo json_encode([
            "status" => "success",
            "usuario" => $username,
            "tipo_usuario" => $tipo
        ]);
    } else {
        http_response_code(401);
        echo json_encode(["error" => "Credenciales inválidas"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido"]);
}

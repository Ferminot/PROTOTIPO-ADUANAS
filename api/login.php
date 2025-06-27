<?php
// api.php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

include_once '../includes/db.php';

class API extends DB {
    public function getUsuarios() {
        $query = $this->connect()->query("SELECT id, nombre, username, tipo_usuario FROM usuarios");
        $usuarios = [];

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $usuarios[] = $row;
        }

        return $usuarios;
    }
}

$api = new API();
echo json_encode($api->getUsuarios());

<?php
session_start();
header('Content-Type: application/json');

// Verificar sesión y tipo usuario
if (!isset($_SESSION['user']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit();
}

// Obtener datos JSON enviados
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['tipoTramite'], $input['descripcion'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos incompletos']);
    exit();
}

$tipoTramite = trim($input['tipoTramite']);
$descripcion = trim($input['descripcion']);
$usuario = $_SESSION['user']; // o id de usuario según tengas

if (empty($tipoTramite) || empty($descripcion)) {
    http_response_code(400);
    echo json_encode(['error' => 'Los campos no pueden estar vacíos']);
    exit();
}

// Aquí conecta con tu base de datos
// Ejemplo con mysqli (ajusta datos de conexión)
$host = 'localhost';
$db   = 'usuarios'; // Cambia por tu DB
$user = 'root';       // Cambia por tu usuario DB
$pass = '';           // Cambia por tu password DB

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Error de conexión a la base de datos']);
    exit();
}

// Prepara la inserción
$stmt = $conn->prepare("INSERT INTO tramites (usuario, tipo_tramite, descripcion, fecha_solicitud, estado) VALUES (?, ?, ?, NOW(), 'pendiente')");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Error preparando la consulta']);
    exit();
}

$stmt->bind_param('sss', $usuario, $tipoTramite, $descripcion);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Trámite registrado con éxito']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Error al guardar trámite']);
}

$stmt->close();
$conn->close();
?>

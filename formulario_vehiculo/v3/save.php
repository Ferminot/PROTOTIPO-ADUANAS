<?php
// Headers for API
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// DB connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "registro_vehiculo";
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}

// Determine request method
$method = $_SERVER["REQUEST_METHOD"];

// Helper: get JSON body if sent
function getJsonInput() {
    $json = file_get_contents("php://input");
    return json_decode($json, true);
}

switch ($method) {
    case 'GET':
        // Return all vehicles (or one by patente)
        if (isset($_GET['patente'])) {
            $patente = $_GET['patente'];
            $stmt = $conn->prepare("SELECT * FROM vehiculos WHERE patente = ?");
            $stmt->bind_param("s", $patente);
        } else {
            $stmt = $conn->prepare("SELECT * FROM vehiculos");
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $vehiculos = [];

        while ($row = $result->fetch_assoc()) {
            $vehiculos[] = $row;
        }

        echo json_encode($vehiculos);
        $stmt->close();
        break;

    case 'POST':
        $input = $_POST ?: getJsonInput();

        if (
            isset($input['rut_conductor'], $input['patente'],
                  $input['tipo_vehiculo'], $input['marca'],
                  $input['fecha_retorno'])
        ) {
            $stmt = $conn->prepare("INSERT INTO vehiculos (rut_conductor, patente, tipo_vehiculo, marca, fecha_retorno) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss",
                $input['rut_conductor'],
                $input['patente'],
                $input['tipo_vehiculo'],
                $input['marca'],
                $input['fecha_retorno']
            );

            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Registro Guardado."]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => $stmt->error]);
            }

            $stmt->close();
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Faltan datos."]);
        }
        break;

    case 'DELETE':
        $input = getJsonInput();
        if (isset($input['patente'])) {
            $patente = $input['patente'];
            $stmt = $conn->prepare("DELETE FROM vehiculos WHERE patente = ?");
            $stmt->bind_param("s", $patente);

            if ($stmt->execute() && $stmt->affected_rows > 0) {
                echo json_encode(["success" => true, "message" => "Vehículo eliminado."]);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Vehículo no encontrado."]);
            }

            $stmt->close();
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Debe especificar 'patente' para eliminar."]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido."]);
        break;
}

$conn->close();
?>

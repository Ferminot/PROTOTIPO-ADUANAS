<?php
// Show errors (for development)
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check that all required POST fields are set
    if (
        isset($_POST['rut_conductor']) &&
        isset($_POST['patente']) &&
        isset($_POST['tipo_vehiculo']) &&
        isset($_POST['marca']) &&
        isset($_POST['fecha_retorno'])
    ) {
        // Database connection details
        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "registro_vehiculo";

        // Create DB connection
        $conn = new mysqli($host, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Sanitize inputs
        $rut = htmlspecialchars($_POST['rut_conductor']);
        $patente = htmlspecialchars($_POST['patente']);
        $tipo_vehiculo = htmlspecialchars($_POST['tipo_vehiculo']);
        $marca = htmlspecialchars($_POST['marca']);
        $fecha_retorno = htmlspecialchars($_POST['fecha_retorno']);

        // Prepare SQL query
        $sql = "INSERT INTO vehiculos (rut_conductor, patente, tipo_vehiculo, marca, fecha_retorno) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // 5 string values => "sssss"
            $stmt->bind_param("sssss", $rut, $patente, $tipo_vehiculo, $marca, $fecha_retorno);

            if ($stmt->execute()) {
                echo "✅ Registro Guardado Exitosamente.";
            } else {
                echo "❌ Error al guardar: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "❌ Error preparando la consulta: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "❌ Faltan datos del formulario.";
    }
} else {
    echo "⛔ Acceso inválido. Por favor, envía el formulario.";
}
?>

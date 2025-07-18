<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['tipo_usuario'] !== 'sag') {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mensaje = trim($_POST["mensaje"]);

    if (!empty($mensaje)) {
        include_once __DIR__ . '/../includes/db.php';
        $conn = (new DB())->connect();

        $stmt = $conn->prepare("INSERT INTO alertas (mensaje, fecha_emision) VALUES (:mensaje, NOW())");
        $stmt->bindValue(':mensaje', $mensaje, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Redirigir de vuelta al panel SAG con mensaje opcional
            header("Location: ../vistas/home_sag.php?alerta=ok");
            exit();
        } else {
            header("Location: ../vistas/home_sag.php?error=bd");
            exit();
        }
    } else {
        header("Location: ../vistas/home_sag.php?error=mensaje");
        exit();
    }
}
?>

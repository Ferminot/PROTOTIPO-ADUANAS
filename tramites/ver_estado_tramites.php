<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    header("Location: ../index.php");
    exit();
}

include_once __DIR__ . '/../includes/db.php'; // tu conexión a BD

$user = $_SESSION['user'];

// Consulta de trámites para el usuario
$conn = (new DB())->connect();
$stmt = $conn->prepare("SELECT id, tipo_tramite, estado, fecha_solicitud FROM tramites WHERE usuario = :usuario ORDER BY fecha_solicitud DESC");
$stmt->execute(['usuario' => $user]);
$tramites = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estado de Trámites</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f4f8; color: #333; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #007bff; color: white; }
    </style>
</head>
<body>
    <h1>Estado de tus Trámites</h1>
    <?php if (count($tramites) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID Trámite</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Fecha de Solicitud</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tramites as $tramite): ?>
                <tr>
                    <td><?= htmlspecialchars($tramite['id']) ?></td>
                    <td><?= htmlspecialchars($tramite['tipo_tramite']) ?></td>
                    <td><?= htmlspecialchars($tramite['estado']) ?></td>
                    <td><?= htmlspecialchars($tramite['fecha_solicitud']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No tienes trámites registrados.</p>
    <?php endif; ?>
    <a href="../vistas/home_cliente.php">Volver al panel</a>
</body>
</html>

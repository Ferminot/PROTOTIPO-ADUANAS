<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['tipo_usuario'] !== 'agente') {
    header("Location: ../index.php");
    exit();
}

include_once __DIR__ . '/../includes/db.php';

$conn = (new DB())->connect();
$stmt = $conn->query("SELECT id, mensaje, fecha_emision FROM alertas ORDER BY fecha_emision DESC");
$alertas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alertas Emitidas</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #fdf6e3; color: #333; }
        h1 { color: #b38600; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; }
        th { background-color: #f4e1b5; }
    </style>
</head>
<body>
    <h1>Alertas del SAG</h1>
    <?php if (count($alertas) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alertas as $alerta): ?>
                    <tr>
                        <td><?= htmlspecialchars($alerta['id']) ?></td>
                        <td><?= htmlspecialchars($alerta['mensaje']) ?></td>
                        <td><?= htmlspecialchars($alerta['fecha_emision']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay alertas por el momento.</p>
    <?php endif; ?>
    <a href="../vistas/home_agente.php">Volver al panel</a>
</body>
</html>

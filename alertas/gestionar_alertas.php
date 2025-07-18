<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['tipo_usuario'] !== 'sag') {
    header("Location: ../index.php");
    exit();
}

include_once __DIR__ . '/../includes/db.php';
$conn = (new DB())->connect();

// Manejar eliminación si viene POST con id_alerta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_id'])) {
    $idEliminar = intval($_POST['eliminar_id']);
    $stmtDelete = $conn->prepare("DELETE FROM alertas WHERE id = ?");
    $stmtDelete->execute([$idEliminar]);
    // Después de eliminar, redirigimos para evitar reenvío del formulario
    header("Location: gestionar_alertas.php");
    exit();
}

// Obtener alertas actuales
$stmt = $conn->query("SELECT id, mensaje, fecha_emision FROM alertas ORDER BY fecha_emision DESC");
$alertas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Gestionar Alertas Sanitarias</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #fdf6e3; color: #333; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4e1b5; }
        form { display: inline; }
        button.delete-btn {
            background-color: #d9534f;
            border: none;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }
        button.delete-btn:hover {
            background-color: #c9302c;
        }
        a.back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #2e7d32;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Alertas Sanitarias Actuales</h1>

    <?php if (count($alertas) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mensaje</th>
                    <th>Fecha Emisión</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alertas as $alerta): ?>
                    <tr>
                        <td><?= htmlspecialchars($alerta['id']) ?></td>
                        <td><?= htmlspecialchars($alerta['mensaje']) ?></td>
                        <td><?= htmlspecialchars($alerta['fecha_emision']) ?></td>
                        <td>
                            <form method="POST" onsubmit="return confirm('¿Eliminar esta alerta?');">
                                <input type="hidden" name="eliminar_id" value="<?= $alerta['id'] ?>" />
                                <button type="submit" class="delete-btn">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay alertas sanitarias en este momento.</p>
    <?php endif; ?>

    <a class="back-link" href="../vistas/home_agente.php">Volver al panel</a>
</body>
</html>

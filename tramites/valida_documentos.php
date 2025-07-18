<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['tipo_usuario'] !== 'agente') {
    header("Location: ../index.php");
    exit();
}

include_once __DIR__ . '/../includes/db.php';
$conn = (new DB())->connect();

// Si se ha enviado una validación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idTramite = $_POST['id'];
    $accion = $_POST['accion']; // 'aprobar' o 'rechazar'

    $nuevoEstado = ($accion === 'aprobar') ? 'aprobado' : 'rechazado';

    $stmt = $conn->prepare("UPDATE tramites SET estado = :estado WHERE id = :id");
    $stmt->execute(['estado' => $nuevoEstado, 'id' => $idTramite]);
}

// Obtener trámites pendientes
$stmt = $conn->query("SELECT id, usuario, tipo_tramite, fecha_solicitud FROM tramites WHERE estado = 'pendiente'");
$tramites = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validar Documentos</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f4f8; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #007bff; color: white; }
        form { display: inline; }
        button { padding: 6px 12px; margin-right: 5px; }
    </style>
</head>
<body>
    <h1>Validar Documentos Pendientes</h1>

    <?php if (count($tramites) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Tipo de Trámite</th>
                    <th>Fecha de Solicitud</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tramites as $t): ?>
                    <tr>
                        <td><?= $t['id'] ?></td>
                        <td><?= htmlspecialchars($t['usuario']) ?></td>
                        <td><?= htmlspecialchars($t['tipo_tramite']) ?></td>
                        <td><?= $t['fecha_solicitud'] ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="id" value="<?= $t['id'] ?>">
                                <button name="accion" value="aprobar">✅ Aprobar</button>
                                <button name="accion" value="rechazar">❌ Rechazar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay documentos pendientes.</p>
    <?php endif; ?>

    <br><br>
    <a href="../home_agente.php">Volver al panel</a>
</body>
</html>

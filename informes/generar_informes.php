<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['tipo_usuario'] !== 'agente') {
    header("Location: ../index.php");
    exit();
}

include_once __DIR__ . '/../includes/db.php';

$conn = (new DB())->connect();

$resultados = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'] ?? '';
    $fechaInicio = $_POST['fecha_inicio'] ?? '';
    $fechaFin = $_POST['fecha_fin'] ?? '';

    if (!$tipo || !$fechaInicio || !$fechaFin) {
        die("Complete todos los campos.");
    }

    // Validar que el tipo sea uno de los permitidos
    $tiposValidos = ['transito', 'importacion', 'exportacion'];
    if (!in_array($tipo, $tiposValidos)) {
        die("Tipo inválido.");
    }

    $stmt = $conn->prepare("SELECT * FROM tramites WHERE tipo_tramite = ? AND fecha_solicitud BETWEEN ? AND ?");
    $stmt->execute([$tipo, $fechaInicio, $fechaFin]);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generar Informe</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f9f9f9; }
        h1 { color: #b38600; }
        form { margin-bottom: 20px; }
        input, select { padding: 10px; margin: 5px 0; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; }
        th { background: #ffeaa7; }
    </style>
</head>
<body>
    <h1>Generar Informe</h1>
    <form method="POST">
        <label>Tipo de Trámite:</label>
        <select name="tipo" required>
            <option value="">Seleccione tipo</option>
            <option value="transito" <?= (isset($tipo) && $tipo === 'transito') ? 'selected' : '' ?>>Tránsito</option>
            <option value="importacion" <?= (isset($tipo) && $tipo === 'importacion') ? 'selected' : '' ?>>Importación</option>
            <option value="exportacion" <?= (isset($tipo) && $tipo === 'exportacion') ? 'selected' : '' ?>>Exportación</option>
        </select><br>
        <label>Fecha Inicio:</label>
        <input type="date" name="fecha_inicio" required value="<?= htmlspecialchars($fechaInicio ?? '') ?>"><br>
        <label>Fecha Fin:</label>
        <input type="date" name="fecha_fin" required value="<?= htmlspecialchars($fechaFin ?? '') ?>"><br>
        <button type="submit">Generar</button>
    </form>

    <?php if (!empty($resultados)): ?>
        <h2>Resultados</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Tipo de Trámite</th>
                <th>Estado</th>
                <th>Fecha de Solicitud</th>
            </tr>
            <?php foreach ($resultados as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['usuario']) ?></td>
                    <td><?= htmlspecialchars($row['tipo_tramite']) ?></td>
                    <td><?= htmlspecialchars($row['estado']) ?></td>
                    <td><?= htmlspecialchars($row['fecha_solicitud']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <p>No se encontraron resultados.</p>
    <?php endif; ?>

    <a href="../vistas/home_agente.php">Volver al panel</a>
</body>
</html>

<?php


if (!isset($_SESSION['user']) || $_SESSION['tipo_usuario'] !== 'agente') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Panel Agente Aduanas - SG-MA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #2c3e50;
            margin: 20px;
            min-height: 100vh;
            position: relative;
        }
        header {
            margin-bottom: 20px;
            position: relative;
        }
        h1 {
            margin: 0;
            font-size: 2rem;
        }
        a.logout {
            position: absolute;
            top: 0;
            right: 0;
            text-decoration: none;
            color: #2c3e50;
            font-weight: bold;
            border: 1px solid #2c3e50;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }
        a.logout:hover {
            background-color: #2c3e50;
            color: white;
        }
        .welcome {
            margin-bottom: 20px;
        }
        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            max-width: 700px;
        }
        .btn {
            background-color: #2980b9;
            color: white;
            padding: 15px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            flex: 1 1 200px;
            text-align: center;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #1c5980;
        }
        .btn.disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<header>
    <h1>Bienvenido, Agente de Aduanas</h1>
    <a class="logout" href="/PAGINA_ADUANAS/includes/logout.php">Cerrar sesión</a>
</header>

<div class="welcome">
    <p>Este es tu panel principal en el sistema SG-MA, donde podrás gestionar y fiscalizar trámites aduaneros.</p>
</div>

<div class="actions">
    <button class="btn">Validar Documentos</button>
    <button class="btn">Revisar Ingresos/Egresos</button>
    <button class="btn">Generar Reportes</button>
    <button class="btn disabled" title="Próximamente">Monitoreo en Tiempo Real</button>
    <button class="btn disabled" title="Próximamente">Alertas y Notificaciones</button>
</div>

</body>
</html>

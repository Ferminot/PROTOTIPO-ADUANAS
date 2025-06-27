<?php

if (!isset($_SESSION['user']) || $_SESSION['tipo_usuario'] !== 'sag') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Panel SAG - SG-MA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f2f1;
            color: #004d40;
            margin: 20px;
            position: relative;
            min-height: 100vh;
        }
        header {
            margin-bottom: 20px;
            position: relative;
        }
        h1 {
            font-size: 2rem;
            margin: 0;
        }
        .welcome {
            margin-bottom: 20px;
        }
        .action-box {
            background: #004d40;
            color: white;
            padding: 20px;
            border-radius: 6px;
            max-width: 600px;
        }
        a.logout {
            position: absolute;
            top: 0;
            right: 0;
            text-decoration: none;
            color: #004d40;
            font-weight: bold;
            border: 1px solid #004d40;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }
        a.logout:hover {
            background-color: #004d40;
            color: white;
        }
    </style>
</head>
<body>

<header>
    <h1>Bienvenido, Oficial SAG</h1>
    <a class="logout" href="/PAGINA_ADUANAS/includes/logout.php">Cerrar sesión</a>
</header>

<div class="welcome">
    <p>Este es tu panel principal dentro del sistema SG-MA.</p>
</div>

<div class="action-box">
    <h2>Validación de Productos Agrícolas</h2>
    <p>Accede a las listas actualizadas de productos agrícolas prohibidos y realiza validaciones en tiempo real para asegurar el cumplimiento de la normativa.</p>
    <p><em>(Esta funcionalidad estará disponible en próximas versiones del sistema.)</em></p>
</div>

</body>
</html>

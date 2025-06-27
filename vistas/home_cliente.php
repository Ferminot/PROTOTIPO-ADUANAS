<?php


if (!isset($_SESSION['user']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Panel Cliente - SG-MA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            color: #003366;
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
        a.logout {
            position: absolute;
            top: 0;
            right: 0;
            text-decoration: none;
            color: #003366;
            font-weight: bold;
            border: 1px solid #003366;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }
        a.logout:hover {
            background-color: #003366;
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
            background-color: #007bff;
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
            background-color: #0056b3;
        }
        .btn.disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<header>
    <h1>Bienvenido, Cliente</h1>
    <a class="logout" href="/PAGINA_ADUANAS/includes/logout.php">Cerrar sesión</a>
</header>

<div class="welcome">
    <p>Este es tu panel principal dentro del sistema SG-MA. Aquí podrás realizar y consultar tus trámites.</p>
</div>

<div class="actions">
    <button class="btn">Consultar Estado de Trámites</button>
    <button class="btn">Registrar Vehículo Temporal</button>
    <button class="btn">Subir Documentos para Autorización</button>
    <button class="btn disabled" title="Próximamente">Generar Informe Personalizado</button>
    <button class="btn disabled" title="Próximamente">Recibir Notificaciones</button>
</div>

</body>
</html>

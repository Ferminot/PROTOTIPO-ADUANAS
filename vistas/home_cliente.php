<?php


if(!isset($_SESSION['user']) || $_SESSION['tipo_usuario'] !== 'cliente'){
    header("Location: ../index.php");
    exit();
}
$user = new User();
$user->setUser($_SESSION['user']);
$nombreUsuario = $user->getNombre();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Panel Cliente - SG-MA</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #001f3f, #003366);
            color: #cce6ff;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        body {
            min-height: 100vh;
        }
        .container {
            max-width: 720px;
            width: 90%;
            text-align: center;
        }
        header {
            margin-bottom: 30px;
        }
        h1 {
            font-size: 2.4rem;
            color: #66b2ff; /* Azul claro */
            margin-bottom: 40px;
        }
        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            justify-content: center;
        }
        .action-card {
            background: #004080; /* Azul oscuro */
            border-radius: 10px;
            padding: 25px;
            flex: 1 1 280px;
            cursor: pointer;
            color: #cce6ff;
            box-shadow: 0 5px 12px rgba(102,178,255,0.3);
            transition: box-shadow 0.3s ease, background-color 0.3s ease;
            user-select: none;
        }
        .action-card:hover {
            box-shadow: 0 8px 20px rgba(102,178,255,0.7);
            background-color: #0059b3;
        }
        .action-card h2 {
            margin-top: 0;
            color: #99ccff; /* Azul muy claro */
        }
        .action-card p {
            font-size: 1rem;
            color: #b3d1ff;
        }
        a.logout {
            position: fixed;
            top: 20px;
            right: 20px;
            text-decoration: none;
            color: #66b2ff;
            font-weight: bold;
            border: 2px solid #66b2ff;
            padding: 10px 18px;
            border-radius: 6px;
            background-color: #003366;
            transition: background-color 0.3s ease, color 0.3s ease;
            z-index: 10;
        }
        a.logout:hover {
            background-color: #66b2ff;
            color: #003366;
            border-color: #66b2ff;
        }
        .hidden {
            display: none;
            background: #00264d;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            color: #cce6ff;
            text-align: left;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #99ccff;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: none;
            font-size: 1rem;
            background-color: #005080;
            color: #cce6ff;
        }
        button.submit-btn {
            margin-top: 12px;
            background-color: #66b2ff;
            border: none;
            color: #003366;
            padding: 12px 22px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        button.submit-btn:hover {
            background-color: #99ccff;
            color: #001a33;
        }
    </style>
    <script>
        function toggleForm(id) {
            const form = document.getElementById(id);
            if(form.style.display === 'block'){
                form.style.display = 'none';
            } else {
                // Ocultar todos los formularios primero
                document.querySelectorAll('.hidden').forEach(el => el.style.display = 'none');
                form.style.display = 'block';
                form.scrollIntoView({behavior: 'smooth'});
            }
        }
        function submitDemoForm(e) {
            e.preventDefault();
            alert('Formulario enviado (demo, no funcional)');
        }
    </script>
</head>
<body>
<div class="container">
    <header>
        <h1>Bienvenido, Cliente</h1>
        <p style="color: #99ccff; font-size: 1.2rem; margin-top: -10px;"><?php echo htmlspecialchars($nombreUsuario); ?></p>

    </header>

    <div class="actions">
        <div class="action-card" onclick="toggleForm('estadoTramites')">
            <h2>Ver Estado de Trámites</h2>
            <p>Consulta en qué estado se encuentran tus solicitudes y trámites aduaneros.</p>
        </div>
        <div class="action-card" onclick="toggleForm('solicitarTramite')">
            <h2>Solicitar Nuevo Trámite</h2>
            <p>Inicia una nueva solicitud de trámite con los datos necesarios.</p>
        </div>
        <div class="action-card" onclick="toggleForm('consultarDocumentos')">
            <h2>Consultar Documentos Adjuntos</h2>
            <p>Visualiza y descarga documentos relacionados a tus trámites.</p>
        </div>
        <div class="action-card" onclick="toggleForm('soporteAyuda')">
            <h2>Soporte y Ayuda</h2>
            <p>Accede a recursos, guías y preguntas frecuentes.</p>
        </div>
    </div>

    <!-- Formularios demo -->
    <div id="estadoTramites" class="hidden">
        <h3>Estado de Trámites</h3>
        <p>Listado demo de trámites con su estado:</p>
        <ul>
            <li>Trámite 001 - En revisión</li>
            <li>Trámite 002 - Aprobado</li>
            <li>Trámite 003 - Pendiente de documentos</li>
        </ul>
    </div>

    <div id="solicitarTramite" class="hidden">
        <h3>Solicitar Nuevo Trámite</h3>
        <form onsubmit="submitDemoForm(event)">
            <div class="form-group">
                <label for="tipoTramite">Tipo de Trámite</label>
                <select id="tipoTramite" name="tipoTramite" required>
                    <option value="">Seleccione...</option>
                    <option value="importacion">Importación</option>
                    <option value="exportacion">Exportación</option>
                    <option value="transito">Tránsito</option>
                </select>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <button type="submit" class="submit-btn">Enviar Solicitud</button>
        </form>
    </div>

    <div id="consultarDocumentos" class="hidden">
        <h3>Documentos Adjuntos</h3>
        <p>Lista demo de documentos relacionados a trámites:</p>
        <ul>
            <li>Factura Comercial - Trámite 001</li>
            <li>Guía de Transporte - Trámite 002</li>
            <li>Certificado Sanitario - Trámite 003</li>
        </ul>
    </div>

    <div id="soporteAyuda" class="hidden">
        <h3>Soporte y Ayuda</h3>
        <p>Para más información, contacta a soporte@aduanas.cl o revisa el manual de usuario.</p>
    </div>
</div>

<a class="logout" href="/PAGINA_ADUANAS/includes/logout.php">Cerrar sesión</a>

</body>
</html>

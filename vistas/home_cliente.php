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
        /* Modal styles */
        .modal {
            position: fixed;
            z-index: 20;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.4);
            display: none;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .modal-content {
            background-color: #004080;
            padding: 25px 30px;
            border-radius: 12px;
            max-width: 460px;
            width: 100%;
            color: #cce6ff;
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.7);
        }
        .close {
            color: #99ccff;
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .modal-content label {
            color: #99ccff;
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

        // Modal control for Registro Vehículo
        function showModal(id) {
            document.getElementById(id).style.display = 'flex';
        }
        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
        window.onclick = function(event) {
            const modal = document.getElementById('modalRegistrarVehiculo');
            if(event.target === modal) {
                modal.style.display = 'none';
            }
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
        <div class="action-card" onclick="window.location.href='tramites/ver_estado_tramites.php'">
            <h2>Ver Estado de Trámites</h2>
            <p>Consulta en qué estado se encuentran tus solicitudes y trámites aduaneros.</p>
        </div>
        <div class="action-card" onclick="toggleForm('solicitarTramite')">
            <h2>Solicitar Nuevo Trámite</h2>
            <p>Inicia una nueva solicitud de trámite con los datos necesarios.</p>
        </div>
        <div class="action-card" onclick="toggleForm('soporteAyuda')">
            <h2>Soporte y Ayuda</h2>
            <p>Accede a recursos, guías y preguntas frecuentes.</p>
        </div>
        <div class="action-card" onclick="showModal('modalRegistrarVehiculo')">
            <h2>Registrar Vehículo</h2>
            <p>Registra vehículos que necesites para tus trámites.</p>
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
        <form id="formSolicitarTramite">
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
        <div id="mensajeTramite" style="margin-top: 10px;"></div>

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

<!-- Modal Registro de Vehículo -->
<div id="modalRegistrarVehiculo" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modalRegistrarVehiculo')">&times;</span>
        <h3>Registro de Vehículo</h3>
        <form action="/PAGINA_ADUANAS/registro_vehiculos/save.php" method="POST">
            <div class="form-group">
                <label for="rut_conductor">RUT del Conductor:</label>
                <input type="text" name="rut_conductor" id="rut_conductor" required>
            </div>
            <div class="form-group">
                <label for="patente">Patente:</label>
                <input type="text" name="patente" id="patente" required>
            </div>
            <div class="form-group">
                <label for="tipo_vehiculo">Tipo de Vehículo:</label>
                <input type="text" name="tipo_vehiculo" id="tipo_vehiculo" required>
            </div>
            <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" name="marca" id="marca" required>
            </div>
            <div class="form-group">
                <label for="fecha_retorno">Fecha de Retorno:</label>
                <input type="date" name="fecha_retorno" id="fecha_retorno" required>
            </div>
            <button type="submit" class="submit-btn">Registrar Vehículo</button>
        </form>
    </div>
</div>

<a class="logout" href="/PAGINA_ADUANAS/includes/logout.php">Cerrar sesión</a>
<script>
document.getElementById('formSolicitarTramite').addEventListener('submit', async (e) => {
    e.preventDefault();

    const tipoTramite = document.getElementById('tipoTramite').value;
    const descripcion = document.getElementById('descripcion').value;
    const mensajeDiv = document.getElementById('mensajeTramite');

    try {
        const response = await fetch('/PAGINA_ADUANAS/tramites/guardar_tramite.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ tipoTramite, descripcion })
        });

        const result = await response.json();

        if (response.ok) {
            mensajeDiv.style.color = 'lightgreen';
            mensajeDiv.textContent = result.message;
            e.target.reset();
        } else {
            mensajeDiv.style.color = 'lightcoral';
            mensajeDiv.textContent = result.error || 'Error inesperado';
        }
    } catch (error) {
        mensajeDiv.style.color = 'lightcoral';
        mensajeDiv.textContent = 'Error al conectar con el servidor.';
    }
});
</script>

</body>
</html>

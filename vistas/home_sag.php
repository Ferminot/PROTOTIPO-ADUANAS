<?php

if(!isset($_SESSION['user']) || $_SESSION['tipo_usuario'] !== 'sag'){
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
    <title>Panel Oficial SAG - SG-MA</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #d0f0c0, #6bbf59);
            color: #1a3b1a;
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
            color: #2e7d32; /* Verde fuerte */
            margin-bottom: 0;
        }
        h1 span {
            display: block;
            color: #4caf50; /* Verde más claro */
            font-size: 1.2rem;
            margin-top: 4px;
        }
        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            justify-content: center;
        }
        .action-card {
            background: #2e7d32; /* Verde fuerte */
            border-radius: 10px;
            padding: 25px;
            flex: 1 1 280px;
            cursor: pointer;
            color: #d0f0c0;
            box-shadow: 0 5px 12px rgba(46,125,50,0.4);
            transition: box-shadow 0.3s ease, background-color 0.3s ease;
            user-select: none;
        }
        .action-card:hover {
            box-shadow: 0 8px 20px rgba(76,175,80,0.7);
            background-color: #4caf50; /* Verde más claro */
        }
        .action-card h2 {
            margin-top: 0;
            color: #aed581; /* Verde pastel */
        }
        .action-card p {
            font-size: 1rem;
            color: #c5e1a5;
        }
        a.logout {
            position: fixed;
            top: 20px;
            right: 20px;
            text-decoration: none;
            color: #2e7d32;
            font-weight: bold;
            border: 2px solid #2e7d32;
            padding: 10px 18px;
            border-radius: 6px;
            background-color: #d0f0c0;
            transition: background-color 0.3s ease, color 0.3s ease;
            z-index: 10;
        }
        a.logout:hover {
            background-color: #2e7d32;
            color: white;
            border-color: #2e7d32;
        }
        .hidden {
            display: none;
            background: #aed581;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            color: #1a3b1a;
            text-align: left;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #558b2f;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: none;
            font-size: 1rem;
            background-color: #c5e1a5;
            color: #1a3b1a;
        }
        button.submit-btn {
            margin-top: 12px;
            background-color: #4caf50;
            border: none;
            color: #1a3b1a;
            padding: 12px 22px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        button.submit-btn:hover {
            background-color: #81c784;
            color: #0b2e0b;
        }
    </style>
    <script>
        function toggleForm(id) {
            const form = document.getElementById(id);
            if(form.style.display === 'block'){
                form.style.display = 'none';
            } else {
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
        <h1>Bienvenido, Oficial SAG <span><?php echo htmlspecialchars($nombreUsuario); ?></span></h1>
    </header>

    <div class="actions">
        
        <div class="action-card" onclick="window.location.href='alertas/gestionar_alertas.php'">
            <h2>Consultar Alertas Sanitarias</h2>
            <p>Consulta alertas y bórralas si es necesario.</p>
        </div>
        <div class="action-card" onclick="toggleForm('emitirAlerta')">
            <h2>Emitir Alerta Sanitaria</h2>
            <p>Envía una alerta fitosanitaria para informar a aduanas de riesgos detectados.</p>
        </div>
        <div class="action-card" onclick="toggleForm('soporteAyuda')">
            <h2>Soporte y Ayuda</h2>
            <p>Accede a recursos, guías y preguntas frecuentes para tu trabajo.</p>
        </div>
    </div>

    <!-- Formularios demo -->
    <div id="validacionProductos" class="hidden">
        <h3>Validar Productos Agrícolas</h3>
        <form onsubmit="submitDemoForm(event)">
            <div class="form-group">
                <label for="producto">Producto</label>
                <input type="text" id="producto" name="producto" placeholder="Nombre del producto" required>
            </div>
            <div class="form-group">
                <label for="lugar">Lugar de Inspección</label>
                <input type="text" id="lugar" name="lugar" placeholder="Lugar o punto de inspección" required>
            </div>
            <div class="form-group">
                <label for="resultado">Resultado</label>
                <select id="resultado" name="resultado" required>
                    <option value="">Seleccione...</option>
                    <option value="aprobado">Aprobado</option>
                    <option value="rechazado">Rechazado</option>
                </select>
            </div>
            <button type="submit" class="submit-btn">Enviar Validación</button>
        </form>
    </div>

    <div id="consultarAlertas" class="hidden">
        <h3>Consultar Alertas Sanitarias</h3>
        <p>Listado demo de alertas actuales:</p>
        <ul>
            <li>Alerta 001 - Producto X en cuarentena</li>
            <li>Alerta 002 - Zona Y con riesgo fitosanitario</li>
            <li>Alerta 003 - Revisión adicional requerida en puerto Z</li>
        </ul>
    </div>

    <div id="emitirAlerta" class="hidden">
        <h3>Emitir Alerta Sanitaria</h3>
        <form method="POST" action="sag/emitir_alerta_sag.php">
            <div class="form-group">
                <label for="mensaje">Mensaje de la Alerta</label>
                <textarea id="mensaje" name="mensaje" rows="4" placeholder="Describe la alerta fitosanitaria..." required></textarea>
            </div>
            <button type="submit" class="submit-btn">Emitir Alerta</button>
        </form>
    </div>


    <div id="soporteAyuda" class="hidden">
        <h3>Soporte y Ayuda</h3>
        <p>Para más información, contacta a soporte@aduanas.cl o revisa el manual de usuario.</p>
    </div>
</div>

<a class="logout" href="/PAGINA_ADUANAS/includes/logout.php">Cerrar sesión</a>

</body>
</html>

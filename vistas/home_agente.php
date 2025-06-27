<?php
if(!isset($_SESSION['user']) || $_SESSION['tipo_usuario'] !== 'agente'){
    header("Location: ../index.php");
    exit();
}
$user = new User();
$user->setUser($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Panel Agente Aduanas - SG-MA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #fff8e1, #c8c8c8);
            color: #333;
            margin: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        header {
            margin-bottom: 30px;
            text-align: center;
        }
        h1 {
            font-size: 2.5rem;
            color: #b38600;
        }
        .actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            width: 100%;
            max-width: 700px;
            padding: 0 20px;
        }
        .action-card {
            background: #444;
            border-radius: 12px;
            padding: 25px;
            cursor: pointer;
            color: #fff8e1;
            box-shadow: 0 8px 15px rgba(184,134,0,0.2);
            transition: 0.3s;
        }
        .action-card:hover {
            box-shadow: 0 12px 25px rgba(184,134,0,0.5);
            transform: translateY(-5px);
        }
        .action-card h2 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #ffeb3b;
        }
        .action-card p {
            font-size: 1rem;
            color: #ffecb3;
        }
        a.logout {
            position: fixed;
            top: 20px;
            right: 20px;
            text-decoration: none;
            color: #b38600;
            font-weight: bold;
            border: 2px solid #b38600;
            padding: 10px 18px;
            border-radius: 6px;
            background-color: #fff8e1;
            transition: 0.3s;
            z-index: 10;
        }
        a.logout:hover {
            background-color: #b38600;
            color: white;
        }
        .modal {
            position: fixed;
            z-index: 20;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.4);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .modal-content {
            background-color: #444;
            padding: 25px 30px;
            border-radius: 12px;
            max-width: 420px;
            width: 100%;
            color: #fff8e1;
            position: relative;
        }
        .close {
            color: #ffeb3b;
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            background-color: #555;
            border: none;
            color: #fff8e1;
            border-radius: 6px;
        }
        button {
            background-color: #b38600;
            color: white;
            padding: 12px 22px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<header>
    <h1>Bienvenido, Agente de Aduanas <?php echo htmlspecialchars($user->getNombre()); ?></h1>
</header>
<div class="actions">
    <div class="action-card" id="validarDocumentosBtn">
        <h2>Validar Documentos</h2>
        <p>Revisa y aprueba los documentos.</p>
    </div>
    <div class="action-card">
        <h2>Revisar Alertas</h2>
        <p>Consulta alertas sobre riesgos.</p>
    </div>
    <div class="action-card" id="generarInformesBtn">
        <h2>Generar Informes</h2>
        <p>Reportes sobre flujos y alertas.</p>
    </div>
    <div class="action-card" id="registrarVehiculoBtn">
        <h2>Registrar Vehículo</h2>
        <p>Registrar vehículos que cruzan la frontera.</p>
    </div>
</div>
<a class="logout" href="/PAGINA_ADUANAS/includes/logout.php">Cerrar sesión</a>
<!-- Modals -->
<div id="modalValidar" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close" data-modal="modalValidar">&times;</span>
    <h3>Formulario de Validación</h3>
    <form onsubmit="event.preventDefault(); alert('Validado'); this.reset(); document.getElementById('modalValidar').style.display='none';">
      <label for="numDoc">Número Documento:</label>
      <input type="text" id="numDoc" required><br><br>
      <label for="fecha">Fecha:</label>
      <input type="date" id="fecha" required><br><br>
      <label for="obs">Observaciones:</label>
      <textarea id="obs"></textarea><br><br>
      <button type="submit">Enviar</button>
    </form>
  </div>
</div>
<div id="modalInformes" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close" data-modal="modalInformes">&times;</span>
    <h3>Generar Informe</h3>
    <form onsubmit="event.preventDefault(); alert('Informe generado'); this.reset(); document.getElementById('modalInformes').style.display='none';">
      <label for="tipoInforme">Tipo de Informe:</label>
      <select id="tipoInforme" required>
        <option value="">Seleccione tipo</option>
        <option value="personas">Personas</option>
        <option value="vehiculos">Vehículos</option>
      </select><br><br>
      <label for="fechaInicio">Fecha Inicio:</label>
      <input type="date" id="fechaInicio" required><br><br>
      <label for="fechaFin">Fecha Fin:</label>
      <input type="date" id="fechaFin" required><br><br>
      <textarea placeholder="Comentarios opcionales"></textarea><br><br>
      <button type="submit">Generar</button>
    </form>
  </div>
</div>
<div id="modalRegistrarVehiculo" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close" data-modal="modalRegistrarVehiculo">&times;</span>
    <h3>Registro de Vehículo</h3>
    <form action="/PAGINA_ADUANAS/registro_vehiculos/save.php" method="POST">
      <label for="rut_conductor">RUT del Conductor:</label>
      <input type="text" name="rut_conductor" required><br><br>
      <label for="patente">Patente:</label>
      <input type="text" name="patente" required><br><br>
      <label for="tipo_vehiculo">Tipo de Vehículo:</label>
      <input type="text" name="tipo_vehiculo" required><br><br>
      <label for="marca">Marca:</label>
      <input type="text" name="marca" required><br><br>
      <label for="fecha_retorno">Fecha de Retorno:</label>
      <input type="date" name="fecha_retorno" required><br><br>
      <button type="submit">Registrar</button>
    </form>
  </div>
</div>
<script>
  document.getElementById('validarDocumentosBtn').onclick = () => document.getElementById('modalValidar').style.display = 'flex';
  document.getElementById('generarInformesBtn').onclick = () => document.getElementById('modalInformes').style.display = 'flex';
  document.getElementById('registrarVehiculoBtn').onclick = () => document.getElementById('modalRegistrarVehiculo').style.display = 'flex';
  document.querySelectorAll('.close').forEach(el => el.onclick = () => document.getElementById(el.dataset.modal).style.display = 'none');
  window.onclick = e => { if (e.target.classList.contains('modal')) e.target.style.display = 'none'; };
</script>
</body>
</html>

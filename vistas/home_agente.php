<?php
// home_agente.php

// No session_start porque ya está en index.php

if(!isset($_SESSION['user']) || $_SESSION['tipo_usuario'] !== 'agente'){
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
        color: #b38600; /* Amarillo oscuro */
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
        background: #444444; /* Gris oscuro */
        border-radius: 12px;
        padding: 25px;
        cursor: pointer;
        color: #fff8e1; /* Amarillo claro */
        box-shadow: 0 8px 15px rgba(184,134,0,0.2);
        transition: box-shadow 0.3s ease, transform 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .action-card:hover {
        box-shadow: 0 12px 25px rgba(184,134,0,0.5);
        transform: translateY(-5px);
    }
    .action-card h2 {
        margin-top: 0;
        margin-bottom: 10px;
        color: #ffeb3b; /* Amarillo brillante */
        font-size: 1.4rem;
    }
    .action-card p {
        font-size: 1rem;
        color: #ffecb3; /* Amarillo pastel */
        flex-grow: 1;
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
        transition: background-color 0.3s ease, color 0.3s ease;
        z-index: 10;
    }
    a.logout:hover {
        background-color: #b38600;
        color: white;
        border-color: #b38600;
    }

    /* Modal styles */
    .modal {
        position: fixed;
        z-index: 20;
        left: 0; top: 0;
        width: 100%; height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }
    .modal-content {
        background-color: #444444;
        padding: 25px 30px;
        border-radius: 12px;
        max-width: 420px;
        width: 100%;
        color: #fff8e1;
        box-shadow: 0 10px 25px rgba(184,134,0,0.6);
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
    .close:hover {
        color: #b38600;
    }
    input, textarea, select {
        width: 100%;
        padding: 10px;
        margin-top: 6px;
        background-color: #555;
        border: none;
        color: #fff8e1;
        border-radius: 6px;
        font-size: 1rem;
        box-sizing: border-box;
    }
    button {
        background-color: #b38600;
        color: white;
        padding: 12px 22px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.3s ease;
        float: right;
        margin-top: 15px;
        font-size: 1rem;
    }
    button:hover {
        background-color: #ffeb3b;
        color: #444;
    }
</style>

<header>
    <h1>Bienvenido, Agente de Aduanas <?php echo htmlspecialchars($user->getNombre()); ?></h1>

</header>

<div class="actions">
    <div class="action-card" id="validarDocumentosBtn" tabindex="0" role="button" aria-pressed="false">
        <h2>Validar Documentos</h2>
        <p>Revisa y aprueba los documentos de ingreso y salida para asegurar el cumplimiento normativo.</p>
    </div>
    <div class="action-card">
        <h2>Revisar Alertas y Riesgos</h2>
        <p>Consulta alertas emitidas por el sistema sobre posibles riesgos en el cruce fronterizo.</p>
    </div>
    <div class="action-card" id="generarInformesBtn" tabindex="0" role="button" aria-pressed="false">
        <h2>Generar Informes</h2>
        <p>Crea reportes básicos sobre el flujo de personas y vehículos para supervisión.</p>
    </div>
    <div class="action-card">
        <h2>Ayuda y Manuales</h2>
        <p>Accede a recursos y guías rápidas para facilitar tus tareas diarias.</p>
    </div>
</div>


<a class="logout" href="/PAGINA_ADUANAS/includes/logout.php">Cerrar sesión</a>

<!-- Modal Validar Documentos -->
<div id="modalValidar" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close" data-modal="modalValidar">&times;</span>
    <h3>Formulario de Validación</h3>
    <form id="formValidacion" onsubmit="return validarForm(event)">
      <label for="numDoc">Número Documento:</label><br>
      <input type="text" id="numDoc" name="numDoc" required><br><br>
      <label for="fecha">Fecha:</label><br>
      <input type="date" id="fecha" name="fecha" required><br><br>
      <label for="obs">Observaciones:</label><br>
      <textarea id="obs" name="obs" rows="3"></textarea><br><br>
      <button type="submit">Enviar</button>
    </form>
  </div>
</div>

<!-- Modal Generar Informes -->
<div id="modalInformes" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close" data-modal="modalInformes">&times;</span>
    <h3>Generar Informe</h3>
    <form id="formInforme" onsubmit="return generarInforme(event)">
      <label for="tipoInforme">Tipo de Informe:</label><br>
      <select id="tipoInforme" name="tipoInforme" required>
        <option value="" disabled selected>Seleccione tipo</option>
        <option value="flujo_personas">Flujo de Personas</option>
        <option value="flujo_vehiculos">Flujo de Vehículos</option>
        <option value="alertas_riesgos">Alertas y Riesgos</option>
      </select><br><br>
      <label for="fechaInicio">Fecha Inicio:</label><br>
      <input type="date" id="fechaInicio" name="fechaInicio" required><br><br>
      <label for="fechaFin">Fecha Fin:</label><br>
      <input type="date" id="fechaFin" name="fechaFin" required><br><br>
      <label for="comentarios">Comentarios:</label><br>
      <textarea id="comentarios" name="comentarios" rows="3"></textarea><br><br>
      <button type="submit">Generar</button>
    </form>
  </div>
</div>

<script>
document.getElementById('validarDocumentosBtn').onclick = function() {
  document.getElementById('modalValidar').style.display = 'block';
};

document.getElementById('generarInformesBtn').onclick = function() {
  document.getElementById('modalInformes').style.display = 'block';
};

document.querySelectorAll('.close').forEach(function(elem){
  elem.onclick = function() {
    const modalId = this.getAttribute('data-modal');
    document.getElementById(modalId).style.display = 'none';
  };
});

window.onclick = function(event) {
  if(event.target.classList.contains('modal')) {
    event.target.style.display = 'none';
  }
};

function validarForm(event) {
  event.preventDefault();
  alert('Documento validado (simulado)');
  document.getElementById('formValidacion').reset();
  document.getElementById('modalValidar').style.display = 'none';
  return false;
}

function generarInforme(event) {
  event.preventDefault();
  alert('Informe generado (simulado)');
  document.getElementById('formInforme').reset();
  document.getElementById('modalInformes').style.display = 'none';
  return false;
}
</script>

</body>
</html>

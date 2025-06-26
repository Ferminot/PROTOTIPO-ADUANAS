<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['tipo_usuario'] !== 'agente') {
    header("Location: ../index.php");
    exit();
}
?>

<h1>Bienvenido, Agente de Aduanas</h1>
<p>Aquí puedes gestionar solicitudes, verificar documentación y responder a clientes.</p>
<a href="/PAGINA_ADUANAS/includes/logout.php">Cerrar sesión</a>
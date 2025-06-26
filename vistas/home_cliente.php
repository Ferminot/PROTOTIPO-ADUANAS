<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    header("Location: ../index.php");
    exit();
}
?>

<h1>Bienvenido, Cliente</h1>
<p>Este es tu espacio para consultar tus trámites, documentos y notificaciones.</p>
<a href="/PAGINA_ADUANAS/includes/logout.php">Cerrar sesión</a>
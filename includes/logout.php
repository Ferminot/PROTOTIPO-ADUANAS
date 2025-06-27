<?php
session_start(); // Asegúrate de que la sesión esté iniciada

include_once 'user_session.php';

$userSession = new UserSession();
$userSession->closeSession();

header("Location: ../index.php");
exit();
?>

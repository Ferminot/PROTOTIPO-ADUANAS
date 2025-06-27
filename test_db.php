<?php
include 'includes/db.php';

$db = new DB();
$conn = $db->connect();

if ($conn) {
    echo "✅ Conexión a la base de datos exitosa.";
} else {
    echo "❌ Error de conexión.";
}
?>

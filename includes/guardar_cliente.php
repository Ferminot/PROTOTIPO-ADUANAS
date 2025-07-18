<?php
include 'db.php'; // tu conexión PDO

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recoger y limpiar datos
    $nombre = trim($_POST['nombre'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validar campos obligatorios
    if (empty($nombre) || empty($username) || empty($password)) {
        echo "<script>alert('Por favor, complete todos los campos.'); window.history.back();</script>";
        exit();
    }

    try {
        $db = new DB();
        $conn = $db->connect();

        // Verificar si el usuario ya existe
        $stmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE username = :username");
        $stmt->execute(['username' => $username]);
        if ($stmt->fetchColumn() > 0) {
            echo "<script>alert('El nombre de usuario ya existe. Por favor elija otro.'); window.history.back();</script>";
            exit();
        }

        // Insertar nuevo usuario con contraseña en MD5
        $insert = $conn->prepare("INSERT INTO usuarios (username, password, nombre, tipo_usuario) VALUES (:username, MD5(:password), :nombre, 'cliente')");
        $insert->execute([
            'username' => $username,
            'password' => $password,
            'nombre' => $nombre
        ]);

        
        // Registro exitoso: redirigir a login con mensaje
        echo "<script>alert('Registro exitoso. Ahora puede iniciar sesión.'); window.location.href = '../vistas/login.php';</script>";


    } catch (PDOException $e) {
        // Puedes guardar $e->getMessage() en un log para debugging
        echo "<script>alert('Ocurrió un error en el registro. Intente más tarde.'); window.history.back();</script>";
    }

} else {
    // Si no es POST, redirige al formulario
    header("Location: ../vistas/registro_cliente.html");
    exit();
}

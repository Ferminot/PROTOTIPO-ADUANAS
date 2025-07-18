<?php
session_start();

include_once 'includes/user.php';
include_once 'includes/user_session.php';

$userSession = new UserSession();
$user = new User();

$errorLogin = null;  // Para mensajes de error en login

// Si ya hay usuario logueado, ir directo a su home según tipo
if (isset($_SESSION['user'])) {
    $userForm = $_SESSION['user'];
    $user->setUser($userForm);
    $tipo = $user->getTipoUsuario($userForm);

    $_SESSION['tipo_usuario'] = $tipo;

    switch ($tipo) {
        case 'cliente':
            include_once 'vistas/home_cliente.php';
            exit();
        case 'agente':
            include_once 'vistas/home_agente.php';
            exit();
        case 'sag':
            include_once 'vistas/home_sag.php';
            exit();
        default:
            $errorLogin = "Tipo de usuario no reconocido";
            include_once 'vistas/login.php';
            exit();
    }
}

// Si envían formulario login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
    $userForm = trim($_POST['username']);
    $passForm = trim($_POST['password']);

    if ($user->userExists($userForm, $passForm)) {
        $userSession->setCurrentUser($userForm);
        $user->setUser($userForm);

        $tipo = $user->getTipoUsuario($userForm);
        $_SESSION['tipo_usuario'] = $tipo;
        $_SESSION['nombre_usuario'] = $user->getNombre();

        switch($tipo){
        case 'cliente':
            echo "Hola, cliente!";
        break;
        case 'agente':
            echo "Hola, agente!";
        break;
        case 'sag':
            echo "Hola, sag!";
        break;
        default:
            $errorLogin = "Tipo de usuario no reconocido";
            include_once 'vistas/login.php';
        }
    } else {
        $errorLogin = "Nombre de usuario y/o contraseña incorrectos";
        include_once 'vistas/login.php';
        exit();
    }
}

// Si no hay sesión ni formulario, mostrar login
include_once 'vistas/login.php';
exit();

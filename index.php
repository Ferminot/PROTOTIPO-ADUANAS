<?php

include_once 'includes/user.php';
include_once 'includes/user_session.php';



$userSession = new UserSession();
$user = new User();
$nombreUsuario = $user->getNombre();



if(isset($_SESSION['user'])){
    $userForm = $userSession->getCurrentUser();
    $user->setUser($userForm);
    $tipo = $user->getTipoUsuario($userForm);
    // Asegúrate de guardar el tipo en la sesión también
    $_SESSION['tipo_usuario'] = $tipo;


    switch($tipo){
        case 'cliente':
            include_once 'vistas/home_cliente.php';
            break;
        case 'agente':
            include_once 'vistas/home_agente.php';
            break;
        case 'sag':
            include_once 'vistas/home_sag.php';
            break;
        default:
            $errorLogin = "Tipo de usuario no reconocido";
            include_once 'vistas/login.php';
    }

}else if(isset($_POST['username']) && isset($_POST['password'])){
    
    $userForm = $_POST['username'];
    $passForm = $_POST['password'];

    $user = new User();
    if($user->userExists($userForm, $passForm)){
    $userSession->setCurrentUser($userForm);
    $user->setUser($userForm);

    // Obtener tipo de usuario
    $tipo = $user->getTipoUsuario($userForm);
    $_SESSION['tipo_usuario'] = $tipo;
    $_SESSION['nombre_usuario'] = $user->getNombre();
    // Redirigir según tipo
    switch($tipo){
        case 'cliente':
            include_once 'vistas/home_cliente.php';
            break;
        case 'agente':
            include_once 'vistas/home_agente.php';
            break;
        case 'sag':
            include_once 'vistas/home_sag.php';
            break;
        default:
            $errorLogin = "Tipo de usuario no reconocido";
            include_once 'vistas/login.php';
    }


    }else{
        //echo "No existe el usuario";
        $errorLogin = "Nombre de usuario y/o password incorrecto";
        include_once 'vistas/login.php';
    }
}else{
    //echo "login";
    include_once 'vistas/login.php';
}



?>
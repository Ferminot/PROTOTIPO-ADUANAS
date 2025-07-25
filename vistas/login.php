<?php
// Aquí incluye o crea la instancia de User y UserSession si usas clases separadas
include_once __DIR__ . '/../includes/user.php';
include_once __DIR__ . '/../includes/user_session.php';

$errorLogin = '';

$userSession = new UserSession();
$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userForm = $_POST['username'];
    $passForm = $_POST['password'];

    if ($user->userExists($userForm, $passForm)) {
        $userSession->setCurrentUser($userForm);
        $user->setUser($userForm);

        // Redirige a la página correspondiente según tipo
        $tipo = $user->getTipoUsuario($userForm);
        $_SESSION['tipo_usuario'] = $tipo;
        $_SESSION['nombre_usuario'] = $user->getNombre();

        switch ($tipo) {
            case 'cliente':
                header('Location: /Pagina_Aduanas/vistas/home_cliente.php');
                exit();
            case 'agente':
                header('Location: /Pagina_Aduanas/vistas/home_agente.php');
                exit();
            case 'sag':
                header('Location: /Pagina_Aduanas/vistas/home_sag.php');
                exit();
            default:
                $errorLogin = "Tipo de usuario no reconocido";
        }
    } else {
        $errorLogin = "Nombre de usuario y/o password incorrecto";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login SG-MA</title>
  <style>
    /* (aquí va tu CSS exactamente igual) */
    * {margin:0; padding:0; box-sizing:border-box;}
    body {
      font-family: 'Georgia', serif;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(to top, #dfefff, #ffffff, #b3d9ff);
      overflow: hidden;
      position: relative;
    }
    .pillar {
      position: absolute;
      bottom: 0;
      width: 140px;
      height: 300px;
      background: linear-gradient(to top, #ffe082, #ffca28, #fdd835);
      border-left: 6px solid #c6a700;
      border-right: 6px solid #c6a700;
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
      border-radius: 8px 8px 0 0;
      z-index: 0;
      left: 50%;
      transform: translateX(-50%);
    }
    .pillar::before {
      content: '';
      position: absolute;
      top: 0;
      width: 100%;
      height: 30px;
      background: #fff8e1;
      border-top: 4px double #c6a700;
      border-bottom: 4px double #c6a700;
      box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.2);
    }
    form {
      position: relative;
      z-index: 1;
      background-color: #2c2c2c;
      padding: 40px;
      border-radius: 10px;
      width: 340px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
      color: white;
      text-align: left;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #ffe082;
    }
    label {
      display: block;
      margin-bottom: 8px;
    }
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
    }
    input[type="submit"] {
      width: 100%;
      padding: 12px;
      background-color: #ffd54f;
      border: none;
      border-radius: 5px;
      color: #3a3a3a;
      font-weight: bold;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    input[type="submit"]:hover {
      background-color: #fff176;
    }
    .error {
      background-color: #ff4d4d;
      color: white;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 15px;
      text-align: center;
    }
    .registro-link {
      text-align: center;
      margin-top: 15px;
    }
    .registro-link a {
      color: #ffd54f;
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="pillar"></div>

  <form method="POST">
    <?php if ($errorLogin): ?>
      <div class="error"><?php echo htmlspecialchars($errorLogin); ?></div>
    <?php endif; ?>

    <h2>Iniciar Sesión</h2>

    <label for="username">Usuario</label>
    <input type="text" name="username" id="username" required>

    <label for="password">Contraseña</label>
    <input type="password" name="password" id="password" required>

    <input type="submit" value="Iniciar Sesión">

    <div class="registro-link">
      ¿Eres nuevo? <a href="/PAGINA_ADUANAS/vistas/registro_cliente.html">Regístrate como Cliente</a>
    </div>
  </form>
</body>
</html>

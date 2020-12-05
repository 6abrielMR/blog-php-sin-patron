<?php
// Iniciar la sesión y la conexión a bd
require_once 'includes/conexion.php';
// Recoger datos del formulario
if (isset($_POST)) {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  // Consulta para comprobar las credenciales del usuario
  $sql = "select * from usuarios where email = '$email'";
  $login = mysqli_query($db, $sql);

  if ($login && mysqli_num_rows($login) == 1) {
    $usuario = mysqli_fetch_assoc($login);
    var_dump($usuario);

    // Comprobar la contraseña / cifrar
    $verify = password_verify($password, $usuario['password']);

    if ($verify) {
      // Utilizar una sesión para guardar los datos del usuario logueado
      $_SESSION['usuario'] = $usuario;

      if (isset($_SESSION['error_login'])) {
        unset($_SESSION['error_login']);
      }
    } else {
      // Si algo falla enviar una sesión con el falló
      $_SESSION['error_login'] = "Login incorrecto";
    }
  } else {
    $_SESSION['error_login'] = "Login incorrecto";
  }
}
// Redirigir al index.php
header("Location: index.php");

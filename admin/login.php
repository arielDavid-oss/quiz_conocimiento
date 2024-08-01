<?php
session_start();
include ("funciones.php");

//obtengo la configuración
//para comprobar el usuario y la contraseña
$config = obtenerConfiguracion();

//pregunto si se presionó el boton ingresar (login)
if (isset($_POST['login'])) {
    //tomo los datos que vienen del cliente
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

// comparo con los datos del usuario guardados en la base de datos
if (($usuario == $config['usuario']) && ($password == $config['password'])) {
    $_SESSION['usuarioLogeado'] = "Administrador";
    $mensaje_exito = "Inicio de sesión exitoso";
    header("Location: index.php?mensaje_exito=" . urlencode($mensaje_exito));
} else {
    $mensaje_error = "El nombre de usuario o la contraseña son incorrectos";
    header("Location: login.php?mensaje_error=" . urlencode($mensaje_error));
}
exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="estilo.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <title>Quiz Game</title>
</head>
<body>
    <div class="contenedor-login">
        <h1>QUIZ GAME</h1>
        <div class="contenedor-form">
            <h3>Administrador</h3>
            <hr>
            <form id="form_sesion" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="fila">
                    <label for="usuario">Usuario</label>
                    <div class="entrada">
                        <i class="fa-solid fa-user"></i>
                        <input id="usuario" type="text" name="usuario">
                    </div>
                   
                </div>
                <div class="fila">
                    <label for="contra">Contraseña</label>
                    <div class="entrada">
                        <i class="fa-solid fa-key"></i>
                        <input id="contra" type="password" name="password">
                    </div>
                </div>
                <hr>
                <div class="text-center">
                <input id="iniciar_sesion" type="submit" name="login" value="Ingresar" class="btn">
                </div>
            </form>

        </div>

    </div>
    <script>
          const mensajeError = "<?php echo isset($_GET['mensaje_error']) ? $_GET['mensaje_error'] : ''; ?>";
        const mensajeExito = "<?php echo isset($_GET['mensaje_exito']) ? $_GET['mensaje_exito'] : ''; ?>";
    </script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html> 
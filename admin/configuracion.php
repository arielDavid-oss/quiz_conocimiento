<?php
session_start();

//Si el usuario no está logeado lo enviamos al login
if (!$_SESSION['usuarioLogeado']) {
    header("Location: login.php");
    exit();
}
// Inicializar variables
$mensaje_exito = "";
$mensaje_error = "";
include("funciones.php");

$config = obtenerConfiguracion();
$temas = obetenerTodosLosTemas();
$fechaActual = date('Y-m-d');

/******************************************************* */
// ACTUALIZAMOS LA CONFIGURACIÓN
if (isset($_GET['actualizar'])) {
    include("conexion.php");

    $usuario = $_GET['usuario'];
    $password = $_GET['password'];

    $query = "UPDATE config SET usuario='$usuario', password='$password' WHERE id='1'";

    // Preparamos la consulta para actualizar la configuración
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = 'Credenciales actualizadas';
        $_SESSION['message_type'] = 'success'; // Tipo de mensaje (éxito)
    } else {
        $_SESSION['message'] = 'Error al actualizar';
        $_SESSION['message_type'] = 'error'; // Tipo de mensaje (error)
    }

    // Redirigimos a la página de configuración
    header("Location: configuracion.php");
    exit(); // Para detener la ejecución
}


//Insertamos una nueva partida
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("conexion.php");

    $nombre = $_POST['nombre_partida'];
    $tema = $_POST['tema'];
    $fecha = $_POST['fecha'];
    $totalPreguntas = $_POST['total_preguntas'];
    $Tiempo_por_pregunta = $_POST['Tiempo_por_pregunta'];

    if (agregarNuevaPartida($nombre, $tema, $fecha, $totalPreguntas, $Tiempo_por_pregunta)) {
        $mensaje_exito = "Partida creada con éxito";
        header("Location: configuracion.php?mensaje_exito=" . urlencode($mensaje_exito));
    } else {
        $mensaje_error = "No se pudo crear la partida";
        header("Location: configuracion.php?mensaje_error=" . urlencode($mensaje_error));
    }
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
    <title>QUIZ GAME</title>
</head>
<body>
    <div class="contenedor">
        <header>
            <h1>QUIZ GAME</h1>
        </header>
        <div class="contenedor-info">
            <?php include("nav.php") ?>
            <div class="panel">
                <h2>Configuración del Administrador</h2>
                <hr>
                <section id="configuracion">
                    <form id="form_action_actualizar" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
                        <div class="form-group">
                            <label for="usuario">Usuario</label>
                            <input type="text" id = "usuario" name="usuario" value="<?php echo $config['usuario']?>" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="text" id = "password" name="password" value="<?php echo $config['password']?>" required>
                        </div>
                        <hr>
                        <button id="btn_actualizar" name="actualizar" class="btn btn-primary">Actualizar Credenciales</button>
                    </form>
                    <br>
                    <form id="crear-partida-form" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                        <h2>Configurar nueva Partida</h2>
                        <div class="form-group">
                            <label for="nombre" class="text-center">Nombre</label>
                            <input id="nombre" class="text-center" placeholder="Nombre de Partida" name="nombre_partida" required>
                        </div>
                        <div class="form-group">
                            <label for="tema" class="text-center" style="margin-left: 18px;">Tema</label>
                            <select class="form-select text-center" name="tema" id="tema">
                                <option selected>Eliga el Tema</option>
                                <?php while ($row = mysqli_fetch_assoc($temas)) : ?>
                                    <option value="<?php echo $row['id'] ?>">
                                        <?php echo $row['nombre'] ?>
                                    </option>
                                <?php endwhile ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fecha" class="text-center">Fecha</label>
                            <input class="text-center" id="fecha" type="date" min="<?php echo htmlspecialchars($fechaActual); ?>" value="<?php echo $fechaActual; ?>" name="fecha" required>
                        </div>
                        <div class="form-group">
                            <label for="preguntas" class="text-center">Número de Preguntas</label>
                            <input class="text-center" id="preguntas" type="number" placeholder="Digite el número total de preguntas" min="1" name="total_preguntas" required>
                        </div>
                        <div class="form-group">
                            <label for="tiempo" class="text-center">Tiempo por Pregunta</label>
                            <input class="text-center" id="tiempo" type="number" placeholder="Digite el tiempo en segundos" min="5" max="20" name="Tiempo_por_pregunta" required>
                        </div>
                        <hr>
                        <button id="crear_partida" name="Alta" class="btn btn-primary text-center">Crear Partida</button>
                    </form>
                </section>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <script>paginaActiva(3);</script>
        <script>
        // Mostrar mensaje de éxito o error si existe
        <?php if (isset($_SESSION['message'])): ?>
            Swal.fire({
                icon: '<?php echo $_SESSION['message_type']; ?>',
                title: 'Mensaje',
                text: '<?php echo $_SESSION['message']; ?>'
            });
            <?php 
            // Limpiamos el mensaje después de mostrarlo
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            ?>
        <?php endif; ?>
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
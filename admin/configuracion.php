<?php
session_start();

//Si el usuario no esta logeado lo enviamos al login
if (!$_SESSION['usuarioLogeado']) {
    header("Location: login.php");
}

include("funciones.php");

$config = obtenerConfiguracion();
$temas = obteneNombreTemas();
// Obtener la fecha actual en formato DD-MM-YYYY
$fechaActual = date('Y-m-d');
/******************************************************* */
//ACTUALIZAMOSS LA CONFIGURACION
if (isset($_GET['actualizar'])) {
    //nos conectamos a la base de datos
    include("conexion.php");

    //tomamos los datos que vienen del formulario
    $usuario = $_GET['usuario'];
    $password = $_GET['password'];

    //Armamos el query para actualizar en la tabla configuracion
    $query = "UPDATE config SET usuario='$usuario', password='$password' WHERE id='1'";

    //actualizamos en la tabla configuracion
    if (mysqli_query($conn, $query)) { //Se actualizo correctamente
        $mensaje = "La configuración se actualizo correctamente";
        header("Location: configuracion.php");
    } else {
        $mensaje = "No se pudo actualizar en la BD" . mysqli_error($conn);
    }
}

//Insertamos una nueva partida
if (isset($_GET['Alta'])) {
    //nos conectamos a la base de datos
    include("conexion.php");
    //Recuperamos los parametros del formulario Configurar quiz
    $nombre = $_GET['nombre_partida'];
    $tema = $_GET['tema'];
    $fecha = $_GET['fecha'];
    $totalPreguntas = $_GET['total_preguntas'];
    $Tiempo_por_pregunta = $_GET['Tiempo_por_pregunta'];
    //Mnadar a llamr el metodo
    agregarNuevaPartida($nombre,$tema,$fecha,$totalPreguntas,$Tiempo_por_pregunta);
    header("Location: configuracion.php");
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
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
                        <div class="form-group">
                            <label for="">Usuario</label>
                            <input type="text" name="usuario" value = "<?php echo $config['usuario']?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="text" name="password" value = "<?php echo $config['password']?>" required>
                        </div>
                        <hr>
                        <button name="actualizar" class="btn btn-primary ">Actualizar Credenciales</button>
                    </form>
                    <br>
                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="get">
                    <h2>Configurar nuevo Quiz</h2>
                    <div class="form-group">
                         <label class="text-center">Nombre</label>
                         <input class="text-center" placeholder="Nombre de Partida" name="nombre_partida" required>
                    </div> 
                    <div class="form-group">
                         <label class="text-center" style="margin-left: 18px;">Tema</label>
                         <select class="form-select text-center" name="tema" id="tema">
                         <option selected>Eliga el Tema</option>
                         <?php while ($row = mysqli_fetch_assoc($temas)) : ?>
                            <option value = "<?php echo $row['nombre']?>"><?php echo $row['nombre']?></option>
                            <?php endwhile?>
                         </select>
                    </div>
                    <div class="form-group">
                         <label class="text-center">Fecha</label>
                         <input class="text-center" type="date" min="<?php echo htmlspecialchars($fechaActual); ?>" value ="<?php echo $fechaActual; ?>" name="fecha" required>
                    </div>
                    <div class="form-group">
                         <label class="text-center">Número de Preguntas</label>
                         <input class="text-center" type="number" placeholder="Digite el número total de preguntas" min="1" name="total_preguntas" required>
                    </div>
                    <div class="form-group">
                         <label class="text-center">Tiempo por Pregunta</label>
                         <input class="text-center" type="number" placeholder="Digite el tiempo en segundos" min="5" max="20" name="Tiempo_por_pregunta" required>
                    </div>
                    <hr>
                    <button name ="Alta" class="btn btn-primary text-center">Crear Partida</button>
                </form>
            </section>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <script>paginaActiva(3);</script> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
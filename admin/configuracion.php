<?php
session_start();

//Si el usuario no esta logeado lo enviamos al login
if (!$_SESSION['usuarioLogeado']) {
    header("Location: login.php");
}

include("funciones.php");

$config = obtenerConfiguracion();

/******************************************************* */
//ACTUALIZAMOSS LA CONFIGURACION
if (isset($_GET['actualizar'])) {
    //nos conectamos a la base de datos
    include("conexion.php");

    //tomamos los datos que vienen del formulario
    $usuario = $_GET['usuario'];
    $password = $_GET['password'];
    $totalPreguntas = $_GET['totalPreguntas'];
    $tiempoPregunta = $_GET['Tiempo_por_pregunta'];

    //Armamos el query para actualizar en la tabla configuracion
    $query = "UPDATE config SET usuario='$usuario', password='$password', 
    totalPreguntas='$totalPreguntas', Tiempo_por_pregunta ='$tiempoPregunta' WHERE id='1'";

    //actualizamos en la tabla configuracion
    if (mysqli_query($conn, $query)) { //Se actualizo correctamente
        $mensaje = "La configuración se actualizo correctamente";
        header("Location: index.php");
    } else {
        $mensaje = "No se pudo actualizar en la BD" . mysqli_error($conn);
    }
}
//ELIMINAR PREGUNTAS
if (isset($_GET['eliminarPreguntas'])) {
    //nos conectamos a la base de datos
    include("conexion.php");
    //sentiencia para eliminar los datos de toda la tabla
    $query ="TRUNCATE TABLE preguntas";
    //eliminamos los datos de la tabla preguntas
    if (mysqli_query($conn, $query)) { //Se eliminó correctamente
        $mensaje = "Se eliminaron los datos de la tabla preguntas";
        header("Location: index.php");
    } else {
        $mensaje = "No se pudo eliminar en la BD" . mysqli_error($conn);
    }
}
//ELIMINAMOS LAS PREGUNTAS Y LAS CATEGORIAS
if (isset($_GET['eliminarTodo'])) {
    //nos conectamos a la base de datos
    include("conexion.php");
    //sentiencia para eliminar los datos de la tabla
    $query1 ="TRUNCATE TABLE preguntas";
    $query2 ="TRUNCATE TABLE temas";
    //eliminamos los datos de la tabla preguntas
    if (mysqli_query($conn, $query1)) { //Se eliminó correctamente
        if (mysqli_query($conn, $query2)) { //Se eliminó correctamente
            $mensaje = "Se eliminaron las preguntas y las categorias";
            header("Location: index.php");
        } else {
            $mensaje = "No se pudo eliminar las categorias en la BD" . mysqli_error($conn);
        }
    } else {
        $mensaje = "No se pudo eliminar en la BD" . mysqli_error($conn);
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
                        <div class="fila">
                            <label for="">Usuario:</label>
                            <input type="text" name="usuario" id="" value = "<?php echo $config['usuario']?>" required>
                        </div>
                        <div class="fila">
                            <label for="">Password</label>
                            <input type="text" name="password" id="" value = "<?php echo $config['password']?>" required>
                        </div>
                        <div class="fila">
                            <label for="">Total Preguntas por Juego</label>
                            <input type="number" placeholder="Digite el numero de preguntas por juego" name="totalPreguntas" id="" value = "<?php echo $config['totalPreguntas']?>" required>
                        </div>
                        <div class="fila">
                            <label for="">Tiempo por Pregunta</label>
                            <input type="number" placeholder="Digite el tiempo en segundos" min="5" max="20" name="Tiempo_por_pregunta" id="" value = "<?php echo $config['Tiempo_por_pregunta']?>" required>
                        </div>
                        <hr>
                        <input type="submit" value="Actualizar Configuracion" name="actualizar" class="btn-actualizar">
                    </form>
                </section>

                <h2>Preguntas y Categorías</h2>
                <hr>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get" class="form-eliminar">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <input type="submit" value="Eliminar Preguntas" name="eliminarPreguntas" class="btn btn-danger btn-lg">
                    <input type="submit" value="Eliminar Preguntas y Categorías" name="eliminarTodo" class="btn btn-danger btn-lg">
                </form>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <script>paginaActiva(3);</script> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
<?php
session_start();

//Si el usuario no esta logeado lo enviamos al login
if (!$_SESSION['usuarioLogeado']) {
    header("Location:login.php");
}

include("funciones.php");

//Se presióno el botón Nuevo Tema
if(isset($_GET['nuevoTema'])){
    //tomamos los datos que vienen del formulario
    $tema = $_GET['nombreTema'];
    $mensaje = agregarNuevoTema($tema);
    $mensaje_exito = "Tema nuevo agrego con exito";
    header("Location: nuevapregunta.php?mensaje_exito=" . urldecode($mensaje_exito));
}
//Se presióno el botón Eliminar Tema
if(isset($_GET['eliminarTema'])){
    //tomamos los datos que vienen del formulario
    $tema = $_GET['nombreTema'];
    $mensaje = eliminarTema($tema);
    $mensaje_exito = "Tema eliminnado con exito";
    header("Location: nuevapregunta.php?mensaje_exito=" . urldecode($mensaje_exito));
}
/******************************************************* */
//GUARDAMOS LA PREGUNTA
if (isset($_GET['guardar'])) {
    //nos conectamos a la base de datos
    include("conexion.php");

    //tomamos los datos que vienen del fosrmulario
    // elimina texto con formato de etiqueta html
    $pregunta = htmlspecialchars($_GET['pregunta']);
    $opcion_a = htmlspecialchars($_GET['opcion_a']);
    $opcion_b = htmlspecialchars($_GET['opcion_b']);
    $opcion_c = htmlspecialchars($_GET['opcion_c']);
    $opcion_d = htmlspecialchars($_GET['opcion_d']);
    $id_tema = $_GET['tema'];
    $correcta = $_GET['correcta'];

   //Armamos el query para insertar en la tabla preguntas
   $query = "INSERT INTO preguntas (id, tema, pregunta, opcion_a, opcion_b, opcion_c, opcion_d, correcta)
   VALUES (NULL, '$id_tema','$pregunta', '$opcion_a','$opcion_b','$opcion_c','$opcion_d','$correcta')";

    //insertamos en la tabla preguntas
    if (mysqli_query($conn, $query)) { //Se insertó correctamente
        $mensaje_exito = "La pregunta se inserto correctamente";
        header("Location: nuevapregunta.php?mensaje_exito= ". urlencode($mensaje_exito));
    } else {
        $mensaje_error = "No se pudo insertar en la BD";
        header("Location: nuevapregunta.php?mensaje_error= ". urlencode($mensaje_error));
    }
}

//Obtengo todos los temas de la bd
$resltado_temas = obetenerTodosLosTemas();


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="estilo.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Quiz Game</title>
</head>
<body>
    <div class="contenedor">
        <header>
            <h1>QUIZ GAME</h1>
        </header>
        <div class="contenedor-info">
            <?php include("nav.php") ?>
            <div class="panel">
                <h2>Complete la Pregunta</h2>
                <hr>
                <section id="nuevaPregunta">
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
                        <div class="fila">
                        <label for="">Tema: </label>
                            <select name="tema" id="tema">
                                <?php while ($row = mysqli_fetch_assoc($resltado_temas)) : ?>
                                    <option value="<?php echo $row['id'] ?>">
                                        <?php echo $row['nombre'] ?>
                                    </option>
                                <?php endwhile ?>
                        </select>
                            <span class="agregarTema" onclick="agregarTema()">
                            <i class="fa-solid fa-circle-plus"></i></span>
                            <span class="agregarTema" onclick="eliminarTema()">
                            <i class="bi bi-dash-circle"></i></span>
                        </div>
                        <div class="fila">
                            <label for="">Pregunta:</label>
                            <textarea name="pregunta" id="" cols="30" rows="10" required></textarea>
                        </div>
                        <div class="opciones">
                            <div class="opcion">
                                <label for="">Opcion A</label>
                                <input type="text" name="opcion_a" required>
                            </div>
                            <div class="opcion">
                                <label for="">Opcion B</label>
                                <input type="text" name="opcion_b" required>
                            </div>
                            <div class="opcion">
                                <label for="">Opcion C</label>
                                <input type="text" name="opcion_c" required>
                            </div>
                            <div class="opcion">
                                <label for="">Opcion D</label>
                                <input type="text" name="opcion_d" required>
                            </div>
                        </div>
                        <div class="opcion">
                            <label for="">Correcta</label>
                            <select name="correcta" id="" class="correcta">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>
                        <hr>
                        <input type="submit" value="Guardar Pregunta" name="guardar" class="btn-guardar">
                    </form>

                    <?php if (isset($_GET['guardar'])) : ?>
                        <span> <?php echo $mensaje ?></span>
                    <?php endif ?>
                </section>
            </div>
        </div>
    </div>

    <!-- Ventana Modal para nuevo Tema -->
    <div id="modalTema" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" onclick="cerrarTema()">&times;</span>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
                <label for="">Agregar Nuevo Tema</label>
                <input type="text"   name="nombreTema" required>
                <input type="submit" name="nuevoTema" value="Guardar Tema" class="btn">
            </form>
        </div>
    </div>

    <div id="eliminaTema" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" onclick="cerrar_Tema()">&times;</span>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
                <label for="">Eliminar Tema</label>
                <input type="text"   name="nombreTema" required>
                <input type="submit" name="eliminarTema" value="Eliminar Tema" class="btn">
            </form>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
          const mensajeError = "<?php echo isset($_GET['mensaje_error']) ? $_GET['mensaje_error'] : ''; ?>";
          const mensajeExito = "<?php echo isset($_GET['mensaje_exito']) ? $_GET['mensaje_exito'] : ''; ?>";
    </script>
    <script>paginaActiva(1);</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
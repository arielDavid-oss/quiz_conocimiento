<?php
session_start();

// Si el usuario no está logeado lo enviamos al index
//if (!isset($_SESSION['usuario'])) {
  //  header("Location: index.php");
    //exit; // Aseguramos que el script se detenga después de redirigir
//}

include("admin/funciones.php");

$confi = obtenerConfiguracion();
$totalPreguntasPorJuego = $confi['totalPreguntas'];
$TiempoPregunta = $confi['Tiempo_por_pregunta'];
$nombreEquipo = $_SESSION['equipo_id'];

if (isset($_GET['siguiente'])) {
    // Guardar la respuesta seleccionada por el usuario o marcar como no contestada
    if (isset($_GET['respuesta'])) {
        $_SESSION['respuestas_usuario'][$_SESSION['numPreguntaActual']] = $_GET['respuesta'];
    } else {
        $_SESSION['respuestas_usuario'][$_SESSION['numPreguntaActual']] = 'no_contestada';
    }

    // Controlar si la respuesta está bien
    if (isset($_GET['respuesta']) && $_SESSION['respuesta_correcta'] == $_GET['respuesta']) {
        $_SESSION['correctas']++;
    }

    // Aumentar el número de pregunta actual
    $_SESSION['numPreguntaActual']++;

    if ($_SESSION['numPreguntaActual'] < $totalPreguntasPorJuego) {
        $preguntaActual = obtenerPreguntaPorId($_SESSION['idPreguntas'][$_SESSION['numPreguntaActual']]);
        $_SESSION['respuesta_correcta'] = $preguntaActual['correcta'];
    } else {
        $_SESSION['incorrectas'] = $totalPreguntasPorJuego - $_SESSION['correctas'];
        $_SESSION['nombreCategoria'] = obtenerNombreTema($_SESSION['idCategoria']);
        $_SESSION['score'] = number_format(($_SESSION['correctas'] * 100) / $totalPreguntasPorJuego, 2);

        // Redirigir a la página de resultados
        header("Location: final.php");
        exit();
    }
} else {
    $_SESSION['correctas'] = 0;
    $_SESSION['numPreguntaActual'] = 0;
    $_SESSION['preguntas'] = obtenerIdsPreguntasPorCategoria($_SESSION['idCategoria']);
    $_SESSION['idPreguntas'] = array();

    foreach ($_SESSION['preguntas'] as $idPregunta) {
        array_push($_SESSION['idPreguntas'], $idPregunta['id']);
    }

    shuffle($_SESSION['idPreguntas']);
    $preguntaActual = obtenerPreguntaPorId($_SESSION['idPreguntas'][0]);
    $_SESSION['respuesta_correcta'] = $preguntaActual['correcta'];

    // Inicializar arreglo de respuestas del usuario
    $_SESSION['respuestas_usuario'] = array();

}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUIZ GAME</title>
    <!--Script ajax para que cargas las animaciones JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/easy-pie-chart/2.1.6/jquery.easypiechart.min.js" charset="utf-8"></script>
    <!--Link de bootstrap para utlizar clases CSS o JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container-juego" id="container-juego">
        <header class="header">
            <div class="categoria">
                <?php echo obtenerNombreTema($preguntaActual['tema']) ?>
            </div>
        </header>
        <div class="info">
            <div class="estadoPregunta">
                Pregunta <span class="numPregunta"><?php echo $_SESSION['numPreguntaActual'] + 1?></span> de <?php echo $totalPreguntasPorJuego ?>
                <br>
                Equipo: <span class="numPregunta"><?php echo $nombreEquipo?> </span>
            </div>
            <h3>
                <?php echo $preguntaActual['pregunta']?>
            </h3>
            <form id="form-pregunta" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
                <div class="opciones">
                    <label for="respuesta1" onclick="seleccionar(this)" class="op1">
                        <p><?php echo $preguntaActual['opcion_a']?></p>
                        <input type="radio" name="respuesta" value="A" id="respuesta1">
                    </label>
                    <label for="respuesta2" onclick="seleccionar(this)" class="op2">
                        <p><?php echo $preguntaActual['opcion_b']?></p>
                        <input type="radio" name="respuesta" value="B" id="respuesta2">
                    </label>
                    <label for="respuesta3" onclick="seleccionar(this)" class="op3">
                        <p><?php echo $preguntaActual['opcion_c']?></p>
                        <input type="radio" name="respuesta" value="C" id="respuesta3">
                    </label>
                    <label for="respuesta4" onclick="seleccionar(this)" class="op4">
                        <p><?php echo $preguntaActual['opcion_d']?></p>
                        <input type="radio" name="respuesta" value="D" id="respuesta4">
                    </label>
                </div>
                <div class="boton">
                    <input type="hidden" name="siguiente" value="1">
                    <input type="submit" id="btn_siguiente" value="Siguiente" name="siguiente" disabled>
                </div>
            </form>
            <br>
            <div id="contador"> <?php echo $TiempoPregunta; ?></div>            
        </div>
    </div>
    <script>
        //Mandar el tiempo asignado en la configuración al archivo juego.js
        var tiempoPregunta = <?php echo $TiempoPregunta; ?>;
    </script>
    <script src="juego.js"></script>
    <!--Script de bootstrap para JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

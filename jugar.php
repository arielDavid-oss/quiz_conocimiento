<?php
session_start();

// Si el usuario no está logueado, redirigir al index
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

include("admin/funciones.php");

$confi = obtenerConfiguracion();
$totalPreguntasPorJuego = $confi['totalPreguntas'];

// Variables que controlan la partida
if (isset($_GET['siguiente'])) { // Ya está jugando
    // Aumentar contador de preguntas respondidas
    aumentarRespondidas();

    // Verificar si la respuesta es correcta
    if (isset($_GET['respuesta']) && $_SESSION['respuesta_correcta'] == $_GET['respuesta']) {
        $_SESSION['correctas']++;
    }

    // Aumentar número de pregunta actual
    $_SESSION['numPreguntaActual']++;

    if ($_SESSION['numPreguntaActual'] < $totalPreguntasPorJuego) {
        // Obtener y actualizar pregunta actual
        $preguntaActual = obtenerPreguntaPorId($_SESSION['idPreguntas'][$_SESSION['numPreguntaActual']]);
        $_SESSION['respuesta_correcta'] = $preguntaActual['correcta'];
    } else {
        // Calcular respuestas incorrectas y redirigir a resultados finales
        $_SESSION['incorrectas'] = $totalPreguntasPorJuego - $_SESSION['correctas'];
        $_SESSION['nombreCategoria'] = obtenerNombreTema($_SESSION['idCategoria']);
        $_SESSION['score'] = ($_SESSION['correctas'] * 100) / $totalPreguntasPorJuego;
        header("Location: final.php");
        exit();
    }

} else { // Comenzó a jugar
    $_SESSION['correctas'] = 0;
    $_SESSION['numPreguntaActual'] = 0;
    $_SESSION['preguntas'] = obtenerIdsPreguntasPorCategoria($_SESSION['idCategoria']);
    $_SESSION['idPreguntas'] = array();

    foreach ($_SESSION['preguntas'] as $idPregunta) {
        $_SESSION['idPreguntas'][] = $idPregunta['id'];
    }

    // Desordenar el arreglo de preguntas
    shuffle($_SESSION['idPreguntas']);
    $preguntaActual = obtenerPreguntaPorId($_SESSION['idPreguntas'][0]);
    $_SESSION['respuesta_correcta'] = $preguntaActual['correcta'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUIZ GAME</title>
    <link rel="stylesheet" href="estilo.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/easy-pie-chart/2.1.6/jquery.easypiechart.min.js" charset="utf-8"></script>
</head>
<body>
    <div class="container-juego" id="container-juego">
        <header class="header">
            <div class="categoria">
                <?php echo obtenerNombreTema($preguntaActual['tema']) ?>
            </div>
            <a href="index.php">Quizgame.com</a>
        </header>
        <div class="info">
            <div class="estadoPregunta">
<<<<<<< HEAD
                Pregunta <span class="numPregunta"><?php echo $_SESSION['numPreguntaActual'] + 1?></span> de <?php echo $totalPreguntasPorJuego ?>
=======
                Pregunta <span class="numPregunta"><?php echo $_SESSION['numPreguntaActual'] + 1 ?></span> de <?php echo $totalPreguntasPorJuego ?>
>>>>>>> a242e7f69e065aac4452547174dd464a63fe074e
            </div>
            <h3>
                <?php echo $preguntaActual['pregunta'] ?>
            </h3>
            <form id="form-pregunta" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
                <div class="opciones">
                    <label for="respuesta1" onclick="seleccionar(this)" class="op1">
                        <p><?php echo $preguntaActual['opcion_a'] ?></p>
                        <input type="radio" name="respuesta" value="A" id="respuesta1" required>
                    </label>
                    <label for="respuesta2" onclick="seleccionar(this)" class="op2">
                        <p><?php echo $preguntaActual['opcion_b'] ?></p>
                        <input type="radio" name="respuesta" value="B" id="respuesta2" required>
                    </label>
                    <label for="respuesta3" onclick="seleccionar(this)" class="op3">
                        <p><?php echo $preguntaActual['opcion_c'] ?></p>
                        <input type="radio" name="respuesta" value="C" id="respuesta3" required>
                    </label>
                </div>
                <div class="boton">
                    <input type="hidden" name="siguiente" value="1">
                    <input type="submit" value="Siguiente">
                </div>
            </form>
<<<<<<< HEAD
        </div>
    </div>
    <script src="juego.js"></script>
    <script>
        var tiempoLimite = 10; // Tiempo en segundos
        var contador = tiempoLimite;
        var timerId;

        // Función para actualizar el contador de tiempo
        function actualizarContador() {
            contador--;
            document.getElementById('contador').textContent = contador;
            if (contador <= 0) {
                clearInterval(timerId);
                document.getElementById('preguntaForm').submit(); // Enviar formulario al agotarse el tiempo
            }
        }

        // Iniciar el contador de tiempo al cargar la página
        timerId = setInterval(actualizarContador, 1000); // Actualizar cada segundo

        // Detener el contador si se presiona el botón Siguiente antes de que se agote el tiempo
        document.getElementById('siguienteBtn').addEventListener('click', function() {
            clearInterval(timerId); // Detener el contador
        });
    </script>
=======
            <br>
            <div id="contador">10</div>
        </div>
    </div>
    <script src="juego.js"></script>
>>>>>>> a242e7f69e065aac4452547174dd464a63fe074e
</body>
</html>

<?php
session_start();

// Si el usuario no está logeado lo enviamos al index
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit; // Aseguramos que el script se detenga después de redirigir
}

include("admin/funciones.php");

$confi = obtenerConfiguracion();
$totalPreguntasPorJuego = $confi['totalPreguntas'];

// Obtener tiempo límite de la pregunta actual desde la base de datos
$preguntaActual = obtenerPreguntaPorId($_SESSION['idPreguntas'][$_SESSION['numPreguntaActual']]);
$tiempoLimite = $preguntaActual['contador'];

if (isset($_GET['siguiente'])) {
    aumentarRespondidas();

    if ($_SESSION['respuesta_correcta'] == $_GET['respuesta']) {
        $_SESSION['correctas']++;
    } elseif ($_GET['respuesta'] === 'N') {
        // Si la respuesta es nula (tiempo agotado)
        // Aquí podrías manejar cualquier lógica adicional si es necesario
    }

    $_SESSION['numPreguntaActual']++;

    if ($_SESSION['numPreguntaActual'] < $totalPreguntasPorJuego) {
        $preguntaActual = obtenerPreguntaPorId($_SESSION['idPreguntas'][$_SESSION['numPreguntaActual']]);
        $_SESSION['respuesta_correcta'] = $preguntaActual['correcta'];
        $tiempoLimite = $preguntaActual['contador'];
    } else {
        $_SESSION['incorrectas'] = $totalPreguntasPorJuego - $_SESSION['correctas'];
        $_SESSION['nombreCategoria'] = obtenerNombreTema($_SESSION['idCategoria']);
        $_SESSION['score'] = number_format(($_SESSION['correctas'] * 100) / $totalPreguntasPorJuego, 2);
        header("Location: final.php");
        exit; // Aseguramos que el script se detenga después de redirigir
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
    $tiempoLimite = $preguntaActual['contador']; 
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
                
            </div>
            <div id="tiempoRestante">Tiempo restante: <span id="contador2" class="contador-rojo"><?php echo $tiempoLimite ?></span> segundos</div>
            <h3>
                <?php echo $preguntaActual['pregunta']?>
            </h3>
            <form id="preguntaForm" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
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
                    <label for="respuestaN" style="display: none;">Respuesta Nula</label>
                    <input type="radio" name="respuesta" value="N" id="respuestaN" style="display: none;" checked>
                </div>
                <div class="boton">
                    <input type="submit" value="Siguiente" name="siguiente" id="siguienteBtn">
                </div>
            </form>
            
        </div>
    </div>
    <script src="juego.js"></script>
    <script>
        var tiempoLimite = 10; // 5 segundos
        var contador = tiempoLimite;
        var timerId;

        // Función para actualizar el contador de tiempo
        function actualizarContador() {
            contador--;
            document.getElementById('contador2').textContent = contador;
            if (contador <= 0) {
                clearInterval(timerId);
                document.getElementById('siguienteBtn').click();
            }
        }

        // Iniciar el contador de tiempo
        timerId = setInterval(actualizarContador, 1000); // Actualizar cada segundo
    </script>
</body>
</html>

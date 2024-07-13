<?php
session_start();

//Si el usuario no esta logeado lo enviamos al index
if (!$_SESSION['usuario']) {
    header("Location: index.php");
}
include("admin/funciones.php");
aumentarCompletados();

$score = $_SESSION['score'];
$tema =  $_SESSION['nombreCategoria'];
$scoreFormatted = (intval($score) == $score) ? intval($score) : number_format($score, 1);

// Guardar resultados en un objeto $_SESSION
$_SESSION['resultados'] = array(
    'correctas' => $_SESSION['correctas'],
    'incorrectas' => $_SESSION['incorrectas'],
    'preguntas' => array()
);

// Obtener y guardar las preguntas y respuestas del quiz
foreach($_SESSION['idPreguntas'] as $idPregunta){
    $pregunta = obtenerPreguntaPorId($idPregunta);
    $respuestaUsuario = isset($_SESSION['respuestas'][$idPregunta]) ? $_SESSION['respuestas'][$idPregunta] : '';
    $_SESSION['resultados']['preguntas'][] = array(
        'pregunta' => $pregunta['pregunta'],
        'opcion_a' => $pregunta['opcion_a'],
        'opcion_b' => $pregunta['opcion_b'],
        'opcion_c' => $pregunta['opcion_c'],
        'opcion_d' => $pregunta['opcion_d'],
        'correcta' => $pregunta['correcta'],
        'respuesta_usuario' => $respuestaUsuario
    );
}

// Verificar si quedan equipos por jugar
$siguienteEquipoDisponible = isset($_SESSION['equipoActualIndex']) && $_SESSION['equipoActualIndex'] + 1 < count($_SESSION['equipos']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/easy-pie-chart/2.1.6/jquery.easypiechart.min.js" charset="utf-8"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="estilo.css">
    <title>QUIZ GAME</title>
</head>
<body>

    <div class="container-final" id="container-final">
        <div class="info">
            <h2>RESULTADO FINAL</h2>
            <br>
            <div class="categoria">
            <h3><?php echo $tema; ?></h3>
            </div>
            <div class="estadistica">
                <div class="acierto">
                    <span class="correctas numero"> <?php echo $_SESSION['correctas'] ?></span>
                    CORRECTAS
                </div>
                <div class="acierto">
                    <span class="incorrectas numero"> <?php echo $_SESSION['incorrectas'] ?></span>
                    INCORRECTAS
                </div>
            </div>
            <div class="score">
                <div class="box">
                    <div class="chart" data-percent="<?php echo $scoreFormatted; ?>">
                    <?php echo $scoreFormatted; ?>%
                    </div>
                    <br>
                    <h2>PUNTUACION</h2>
                </div>
            </div>

            <?php if ($siguienteEquipoDisponible): ?>
                <?php $_SESSION['equipoActualIndex']++; ?>
                <a href="index.php" class="btn btn-primary">Siguiente Equipo</a>
            <?php else: ?>
                <a href="index.php" class="btn btn-primary">Ir al Menú</a>
            <?php endif; ?>
            <a href="resultados.php" class="btn btn-info">Resultados</a>
        </div>
    </div>
    <script src="juego.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
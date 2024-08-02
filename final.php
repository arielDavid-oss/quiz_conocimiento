<?php
session_start();

include("admin/funciones.php");


$score = $_SESSION['score'];
//$puntuacion = $score / 10;
$tema =  $_SESSION['nombreCategoria'];
$nombreEquipo = $_SESSION['equipo_id'];
$scoreFormatted = (intval($score) == $score) ? intval($score) : number_format($score, 1);
cambiar_estado($nombreEquipo, $scoreFormatted);
$rankig_equipos = puntuaciones();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="estilo.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>QUIZ GAME</title>
</head>
<body>
    <div class="container-final" id="container-final">
        <div class="info">
            <h2>RESULTADO FINAL</h2>
            <br>
            <div class="categoria">
            <h3> Equipo: <?php echo $nombreEquipo; ?></h3>
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

            <a href="resultados.php" type="button" class="btn btn-info">Resultados</a>
        </div>
        <div class="derecha">
            <ul class="list-group">
                <h2>Ranking de Equipos</h2>
                <?php foreach ($rankig_equipos as $index => $equipo) : ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo htmlspecialchars($equipo['nombre_equipo']); 
                        if ($index == 0) {
                            echo ' <i class="bi bi-trophy-fill text-warning"></i>';
                        } elseif ($index == 1) {
                            echo ' <i class="bi bi-trophy-fill text-secondary"></i>';
                        } elseif ($index == 2) {
                            echo ' <i class="bi bi-trophy-fill text-danger"></i>';
                        }
                        ?>
                        <span class="badge bg-primary rounded-pill"><?php echo htmlspecialchars($equipo['puntuacion']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
    </div>
    </div>
    <script src="juego.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
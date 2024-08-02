<?php
session_start();

include ("admin/funciones.php");

// Obtener el nombre de la categoría de tema escogido
$tema = $_SESSION['nombreCategoria'];
$nombreEquipo = $_SESSION['equipo_id'];
$partida = $_SESSION['idPartida'];
$miembros = buscar_miembros($nombreEquipo);
// Obtener las respuestas del usuario
$respuestasUsuario = $_SESSION['respuestas_usuario'];

// Guardar las respuestas del usuario en la base de datos
$resultados = $_SESSION['resultados'];
$correctas = $resultados['correctas'];
$incorrectas = $resultados['incorrectas'];
$preguntas = $resultados['preguntas'];

foreach ($preguntas as $index => $pregunta) {
    //$pregunta_id = $pregunta['id'];
    $respuesta_usuario = isset($respuestasUsuario[$index]) ? $respuestasUsuario[$index] : 'no_contestada';
    $es_correcta = strtolower($respuesta_usuario) === strtolower($pregunta['correcta']) ? 1 : 0;

    // Llamar a la función guardar_resultados
    guardar_resultados($tema, $nombreEquipo, $partida, $respuesta_usuario, $es_correcta);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados del Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin/estilo.css">
    <link rel="stylesheet" href="estilo.css">
    <style>
        .caja-correcta { background-color: green; color: white; }
        .caja-incorrecta { background-color: red; color: white; }
    </style>
</head>
<body>
<div class="contenedor">
    <header class="text-center">
        <h1>QUIZ GAME</h1>
    </header>
    <div class="contenedor-info">
        <div class="panel">
            <div class="text-center"><h2><?php echo $tema; ?></h2></div>
            <div class="text-center"><h3> Equipo: <?php echo $nombreEquipo; ?>
            <?php $gruposMostrados = [];
            foreach ($miembros as $miembro): 
            if (!in_array($miembro['grupo'], $gruposMostrados)): 
            $gruposMostrados[] = $miembro['grupo'];?>
            <?php echo $miembro['grupo']; ?></h3>
            <?php endif; ?>
            <?php endforeach; ?>
            <h4>Integrantes</h4>
            <?php // Mostrar los integrantes de este grupo
            foreach ($miembros as $miembroGrupo): ?>
            <h5><?php echo $miembroGrupo['nombre']; ?></h5><?php endforeach; ?>
                </div>
            <section id="listadoPreguntas">
                <div class="text-center">
                    <h5>Correctas: <?php echo $_SESSION['resultados']['correctas']; ?>
                    Incorrectas: <?php echo $_SESSION['resultados']['incorrectas']; ?></h5>
                </div>
                <?php foreach ($_SESSION['resultados']['preguntas'] as $index => $pregunta): ?>
                    <div class="contenedor-pregunta">
                        <p class="pregunta"><?php echo $pregunta['pregunta']; ?></p>
                        <?php 
                            $opciones = ['a', 'b', 'c', 'd'];
                            $opcionCorrecta = strtolower($pregunta['correcta']);
                            foreach ($opciones as $opcion):
                                $clase = '';
                                if (isset($respuestasUsuario[$index])) {
                                    if ($opcion === $opcionCorrecta) {
                                        $clase = 'caja-correcta';
                                    } elseif (strtolower($respuestasUsuario[$index]) === $opcion) {
                                        $clase = 'caja-incorrecta';
                                    }
                                }
                        ?>
                        <div class="opciones_Resultados">
                            <span class="cajas <?php echo $clase; ?>"><?php echo strtoupper($opcion); ?></span>
                            <span class="texto"><?php echo $pregunta['opcion_' . $opcion]; ?></span>
                        </div>
                        <?php endforeach; ?>
                        <p><strong>Respuesta Correcta:</strong> <?php echo $pregunta['opcion_' . $opcionCorrecta]; ?></p>
                        <!-- Manejar un condicional si no se contestó la pregunta -->
                        <p><strong>Tu Respuesta:</strong> 
                            <?php
                            if ($respuestasUsuario[$index] == 'no_contestada') {
                                echo "No respondiste esta pregunta.";
                            } else {
                                echo $pregunta['opcion_' . strtolower($respuestasUsuario[$index])];
                            }
                            ?>
                        </p>
                    </div>                  
                <?php endforeach; ?>
            </section>
        </div>
    </div>
    <br>
    <div class="text-center">
        <a type="button" class="btn btn-success" href="crear_equipo.php">Jugar otra vez</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

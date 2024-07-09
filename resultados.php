<?php 
session_start();
// Si el usuario no está logeado lo enviamos al index
if (!$_SESSION['usuario']) {
    header("Location:index.php");
    exit;
}
include("admin/funciones.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Resultados</title>
    <link rel="stylesheet" href="admin/estilo.css">
</head>
<body>
<div class="contenedor">
    <header class="text-center">
        <h1>QUIZ GAME</h1>
    </header>
    <div class="contenedor-info">
        <div class="panel">
            <h2>Resultados del Quiz</h2>
            <hr>
            <section id="listadoPreguntas">
                <span>Respuestas Correctas:<?php echo $_SESSION['resultados']['correctas']; ?></span>
                <span>Respuestas Incorrectas: <?php echo $_SESSION['resultados']['incorrectas']; ?></span>              
                <?php foreach ($_SESSION['resultados']['preguntas'] as $pregunta): ?>
                    <div class="contenedor-pregunta">
                        <p class="pregunta"><?php echo $pregunta['pregunta']; ?></p>
                        <?php 
                            $opciones = ['a', 'b', 'c', 'd'];
                            foreach ($opciones as $opcion):
                                $clase = '';
                                if ($pregunta['correcta'] == $pregunta['opcion_' . $opcion]) {
                                    $clase = 'pintarVerde';
                                } elseif ($pregunta['respuesta_usuario'] == $pregunta['opcion_' . $opcion] && $pregunta['respuesta_usuario'] != $pregunta['correcta']) {
                                    $clase = 'pintarRojo';
                                }
                        ?>
                        <div class="opcion <?php $clase; ?>">
                            <span class="caja"><?php echo strtoupper($opcion); ?></span>
                            <span class="texto"><?php echo $pregunta['opcion_' . $opcion]; ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>                  
                <?php endforeach; ?>
            </section>
        </div>
    </div>
    <br>
    <div class="text-center">
        <a type="button" class="btn btn-success" href="index.php">Ir al Menú</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
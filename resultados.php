<?php 
session_start();
//Si el usuario no esta logeado lo enviamos al index
if (!$_SESSION['usuario']) {
    header("Location:index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
    <link rel="stylesheet" href="admin/estilo.css">
</head>
<body>
<div class="contenedor">
        <header>
            <h1>QUIZ GAME</h1>
        </header>
        <div class="contenedor-info">
            <div class="panel">
                <h2>Resultados del Quiz</h2>
                <hr>
                <section id="listadoPreguntas">
                <span>Respuestas Correctas: <?php echo $_SESSION['resultados']['correctas']; ?></span>
                <span>Respuestas Incorrectas: <?php echo $_SESSION['resultados']['incorrectas']; ?></span>              
                <?php foreach ($_SESSION['resultados']['preguntas'] as $pregunta): ?>
                    <div class="contenedor-pregunta">
                        <p class="pregunta"><?php echo $pregunta['pregunta']; ?></p>
                        <div class="opcion">
                            <span class="caja <?php echo ($pregunta['respuesta_usuario'] == 'A' && $pregunta['correcta'] == 'A') ? 'pintarVerde' :
                            (($pregunta['respuesta_usuario'] == 'A' && $pregunta['correcta'] != 'A') ? 'pintarRojo' : ''); ?>">A</span>
                            <span class="texto"><?php echo $pregunta['opcion_a']; ?></span>
                        </div>

                        <div class="opcion">
                            <span class="caja <?php echo ($pregunta['respuesta_usuario'] == 'B' && $pregunta['correcta'] == 'B') ? 'pintarVerde' :
                             (($pregunta['respuesta_usuario'] == 'B' && $pregunta['correcta'] != 'B') ? 'pintarRojo' : ''); ?>">B</span>
                            <span class="texto"><?php echo $pregunta['opcion_b']?></span>
                        </div>
                        <div class="opcion">
                            <span class="caja <?php echo ($pregunta['respuesta_usuario'] == 'C' && $pregunta['correcta'] == 'C') ? 'pintarVerde' :
                             (($pregunta['respuesta_usuario'] == 'C' && $pregunta['correcta'] != 'C') ? 'pintarRojo' : ''); ?>">C</span>
                            <span class="texto"><?php echo $pregunta['opcion_c']?></span>
                        </div>
                        <div class="opcion">
                            <span class="caja <?php echo ($pregunta['respuesta_usuario'] == 'D' && $pregunta['correcta'] == 'D') ? 'pintarVerde' :
                             (($pregunta['respuesta_usuario'] == 'D' && $pregunta['correcta'] != 'D') ? 'pintarRojo' : ''); ?>">D</span>
                            <span class="texto"><?php echo $pregunta['opcion_d']?></span>
                        </div>
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
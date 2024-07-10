<?php
session_start();

// Si el usuario no está logueado lo enviamos al index
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$tema = $_SESSION['nombreCategoria'];
$respuesta = $_SESSION['respuesta_usuario'];
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
</head>
</head>
<body>
<div class="contenedor">
    <header class="text-center">
        <h1>QUIZ GAME</h1>
    </header>
    <div class="contenedor-info">
        <div class="panel">
            <div class="text-center"><h2><?php echo $tema; ?></h2></div>
            <hr>
            <section id="listadoPreguntas">
                <div class="text-center">
                    <h5>Correctas: <?php echo $_SESSION['resultados']['correctas']; ?></h5>
                    <h5>Incorrectas: <?php echo $_SESSION['resultados']['incorrectas']; ?></h5>
                </div>
                <?php foreach ($_SESSION['resultados']['preguntas'] as $pregunta): ?>
                    <div class="contenedor-pregunta">
                        <p class="pregunta"><?php echo $pregunta['pregunta']; ?></p>
                        <?php 
                            $opciones = ['a', 'b', 'c', 'd'];
                            $opcionUsuario = $pregunta['respuesta_usuario'];
                            $opcionCorrecta = $pregunta['correcta'];
                            
                            foreach ($opciones as $opcion):
                        ?>
                        <div class="opciones_Resultados">
                            <span class="cajas"><?php echo strtoupper($opcion); ?></span>
                            <span class="texto"><?php echo $pregunta['opcion_' . $opcion]; ?></span>
                        </div>
                        <?php endforeach; ?>
                        <p><strong>Respuesta Correcta:</strong> <?php echo $pregunta['opcion_' . strtolower($opcionCorrecta)]; ?></p>
                        <p><strong>Tu Respuesta:</strong> <?php echo $pregunta['opcion_' . strtolower($opcionUsuario)]; ?></p>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

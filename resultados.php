<?php
session_start();

// Si el usuario no está logueado lo enviamos al index
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$tema = $_SESSION['nombreCategoria'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados del Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin/estilo.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .contenedor {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .panel {
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .pregunta {
            font-weight: bold;
        }
        .opcion {
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }
        .pintarVerde {
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .pintarRojo {
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        .opcion span {
            display: inline-block;
            vertical-align: middle;
        }
        .caja {
            font-weight: bold;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 50%;
            margin-right: 10px;
        }
        .texto {
            margin-left: 10px;
        }
        .btn {
            margin-top: 20px;
        }
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
                            $opcionUsuario = $pregunta['respuesta_usuario'];
                            $opcionCorrecta = $pregunta['correcta'];

                            $opciones = ['a', 'b', 'c', 'd'];
                            foreach ($opciones as $opcion):
                                $clase = '';
                                // Marcar la respuesta correcta en verde y la incorrecta en rojo
                                if ($pregunta['opcion_' . $opcion] == $opcionCorrecta) {
                                    $clase = 'pintarVerde';
                                } elseif ($pregunta['opcion_' . $opcion] == $opcionUsuario && $pregunta['opcion_' . $opcion] != $opcionCorrecta) {
                                    $clase = 'pintarRojo';
                                }
                        ?>
                        <div class="opcion <?php echo $clase; ?>">
                            <span class="caja"><?php echo strtoupper($opcion); ?></span>
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

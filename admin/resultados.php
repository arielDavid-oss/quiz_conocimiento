<?php 
session_start();

// Si el usuario no está logueado lo enviamos al login
if (!isset($_SESSION['usuarioLogeado'])) {
    header("Location: login.php");
    exit();
}
include("funciones.php");
$nombre_equipo = isset($_GET['equipos']) ? $_GET['equipos'] : '';
$partida = isset($_GET['partida']) ? $_GET['partida'] : '';
$tema = isset($_GET['tema']) ? $_GET['tema'] : '';
$calif = isset($_GET['calificacion']) ? $_GET['calificacion'] : '';
$miembros = buscar_miembros($nombre_equipo);
// Devuelve todas las preguntas del tema, las opciones y la respuesta correcta
$preguntas = obtenerPreguntasPorTema($tema);
// Devuelve las letras seleccionadas por el usuario [a,b,c,d] y si están correctas o incorrectas 1 o 0
$respuestas = respuestas($nombre_equipo, $partida);

// Depurar para verificar contenido de respuestas
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="../estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .caja-correcta { background-color: green; color: white; }
        .caja-incorrecta { background-color: red; color: white; }
    </style>
    <title>QUIZ GAME</title>
</head>
<body>
    <div class="contenedor">
    <header>
        <h1>QUIZ GAME</h1>
    </header>
    <div class="contenedor-info">
        <?php include('nav.php')?>
        <div class="panel">
            <div class="card text-center" style="width: 42rem;">
                <h2>Respuestas del equipo <?php echo htmlspecialchars($nombre_equipo); ?></h2>
            </div>
            <div class="card text-center estilo" style="width: 42rem;">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        Integrantes del grupo: 
                        <?php 
                        $gruposMostrados = [];
                        foreach ($miembros as $miembro): 
                            if (!in_array($miembro['grupo'], $gruposMostrados)): 
                                $gruposMostrados[] = $miembro['grupo'];
                                echo $miembro['grupo']; 
                            endif; 
                        endforeach; ?>
                    </li>
                    <li class="list-group-item">Calificación: <?php echo $calif/10?></li>
                    <?php foreach ($miembros as $miembroGrupo): ?>
                        <li class="list-group-item"><?php echo htmlspecialchars($miembroGrupo['nombre']); ?></li>
                    <?php endforeach; ?>
                </ul>    
            </div>
            <br>
            <section id="listadoPreguntas">
                <?php foreach ($preguntas as $index => $pregunta): ?>
                    <div class="contenedor-pregunta">
                        <p class="pregunta"><?php echo $index + 1; ?>. <?php echo htmlspecialchars($pregunta['pregunta']); ?></p>
                        <div class="opciones_Resultados texto">
                        <?php $claseRespuesta = $respuestas[$index]['correcta'] ? 'caja-correcta' : 'caja-incorrecta';?>
                        <?php if ($respuestas[$index]['respuestas'] !== 'no_contestada') : ?>
                        <span class="cajas <?php echo $claseRespuesta; ?>">
                            
                        <?php echo htmlspecialchars($respuestas[$index]['respuestas']); ?></span><?php endif; ?>         
                        <?php 
                        $letraSeleccionada = strtolower($respuestas[$index]['respuestas']);
                        switch ($letraSeleccionada) {
                            case 'a':
                                echo htmlspecialchars($pregunta['opcion_a']);
                                break;
                            case 'b':
                                echo htmlspecialchars($pregunta['opcion_b']);
                                break;
                            case 'c':
                                echo htmlspecialchars($pregunta['opcion_c']);
                                break;
                            case 'd':
                                echo htmlspecialchars($pregunta['opcion_d']);
                                break;
                            default:
                                echo "No se seleccionó ninguna respuesta.";
                        }
                        ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
            <div class="text-center">
            <button onclick="window.print()" class="btn btn-primary">Imprimir Página</button>
            </div>
        </div>
    </div>
    </div>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
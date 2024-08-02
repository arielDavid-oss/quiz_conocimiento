<?php
session_start();

// Si el usuario no está logueado lo enviamos al login
if (!isset($_SESSION['usuarioLogeado'])) {
    header("Location: login.php");
    exit();
}

include("funciones.php");

if (isset($_GET['seleccionar_tema']) && isset($_GET['tema'])) {
    $tema = intval($_GET['tema']); // Asegurarse de que el valor sea un entero
    if ($tema > 0) {
        // Variable que guarda los resultados de las preguntas del tema elegido
        $preguntas = obtenerPreguntasPorTema($tema);
    }
}

// Obtengo todos los temas de la BD
$resultado_temas = obetenerTodosLosTemas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="estilo.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <title>Quiz Game</title>
</head>
<body>
    <div class="contenedor">
        <header>
            <h1>QUIZ GAME</h1>
        </header>
        <div class="contenedor-info">
            <?php include("nav.php") ?>
            <div class="panel">
                <h2>Listado de Preguntas</h2>
                <hr>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
                    <div class="form-group">
                        <label for="tema" class="text-center" style="margin-left: 15px;">Tema</label>
                        <select class="form-select text-center" name="tema" id="tema">
                            <option value="none" selected></option>
                            <?php while ($row = mysqli_fetch_assoc($resultado_temas)) : ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>">
                                    <?php echo htmlspecialchars($row['nombre']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="text-center" style="margin-bottom: 5px;"><button class="btn btn-info" name="seleccionar_tema">Consultar</button></div>
                </form>
                <section id="listadoPreguntas">
                <?php if (!empty($preguntas)) : ?>
                    <?php foreach ($preguntas as $columna) : ?>
                        <div class="contenedor-pregunta">
                            <header>
                                <span class="tema"><?php echo obtenerNombreTema($columna['tema']); ?></span>
                                <div class="opciones">
                                    <i class="fa-solid fa-pen-to-square" onclick="editarPregunta(<?php echo $columna['id']; ?>)"></i>
                                    <i class="fa-solid fa-trash" onclick="abrirModalEliminar(<?php echo $columna['id']; ?>)"></i>                
                                </div>
                            </header>
                            <p class="pregunta"><?php echo htmlspecialchars($columna['pregunta']); ?></p>
                            <div class="opcion">
                                <div class="caja <?php echo ($columna['correcta'] == 'A') ? 'pintarVerde' : ''; ?>">
                                    A
                                </div>
                                <span class="texto"><?php echo htmlspecialchars($columna['opcion_a']); ?></span>
                            </div>
                            <div class="opcion">
                                <span class="caja <?php echo ($columna['correcta'] == 'B') ? 'pintarVerde' : ''; ?>">B</span>
                                <span class="texto"><?php echo htmlspecialchars($columna['opcion_b']); ?></span>
                            </div>
                            <div class="opcion">
                                <span class="caja <?php echo ($columna['correcta'] == 'C') ? 'pintarVerde' : ''; ?>">C</span>
                                <span class="texto"><?php echo htmlspecialchars($columna['opcion_c']); ?></span>
                            </div>
                            <div class="opcion">
                                <span class="caja <?php echo ($columna['correcta'] == 'D') ? 'pintarVerde' : ''; ?>">D</span>
                                <span class="texto"><?php echo htmlspecialchars($columna['opcion_d']); ?></span>
                            </div>
                        </div>   
                    <?php endforeach; ?>
                <?php endif; ?>
                </section>                
            </div>
        </div>
    </div>
    <!-- The Modal para la eliminación de una Pregunta -->
    <div id="modalPregunta" class="modal">
        <!-- Modal content clase del CSS -->
        <div class="modal-content">
            <p>¿Está seguro que desea eliminar la Pregunta?</p>
            <button onclick="eliminarPregunta()" class="btn">Sí</button>
            <button onclick="cerrarEliminar()" class="btn">Cancelar</button>
        </div>
    </div>
    <script src="script.js"></script>
    <script src="mensajes.js"></script>
    <script>paginaActiva(2);</script>   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
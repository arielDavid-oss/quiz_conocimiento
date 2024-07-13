<?php
session_start();

include("admin/funciones.php");

// Aumentar la visita cada vez que se carga la página
aumentarVisita();

// Obtener las categorías disponibles
$categorias = obtenerCategorias();

// Verificar si se ha seleccionado una categoría para jugar
if (isset($_GET['idCategoria'])) {
    $_SESSION['idCategoria'] = $_GET['idCategoria'];
    header("Location: jugar.php"); // Redirigir al archivo de juego
    exit();
}

// Verificar si existen equipos registrados en la sesión
if (!isset($_SESSION['equipos']) || empty($_SESSION['equipos'])) {
    // Redirigir a la página de crear_equipo.php si no hay equipos registrados
    header("Location: crear_equipo.php");
    exit();
}

// Obtener el índice del equipo actual que está jugando
$equipoActualIndex = isset($_SESSION['equipoActualIndex']) ? $_SESSION['equipoActualIndex'] : 0;

// Verificar si se ha seleccionado un tema para el equipo actual
if (isset($_POST['seleccionar_tema'])) {
    // Aquí deberías procesar la selección del tema y avanzar al siguiente equipo si es necesario
    // Por simplicidad, aquí solo avanzaremos al siguiente equipo
    $_SESSION['equipoActualIndex']++;
    header("Location: index.php"); // Redirigir para mostrar el siguiente equipo
    exit();
}
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
    <title>QUIZ GAME</title>
    <style>
        .equipo-actual {
            color: white;
        }
    </style>
</head>
<body>
    <div class="container" id="container">
        <div class="left">
            <div class="logo">
                QUIZ GAME
            </div>
            <h2>PON A PRUEBA TUS CONOCIMIENTOS!!</h2>
        </div>
        <div class="right">
            <h3>Elige una categoría</h3>
            <div class="categorias">
                <?php while ($cat = mysqli_fetch_assoc($categorias)): ?>
                    <div class="categoria">
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET" id="<?php echo $cat['tema'] ?>">
                            <input type="hidden" name="idCategoria" value="<?php echo $cat['tema'] ?>">
                            <a href="javascript:{}" onclick="document.getElementById('<?php echo $cat['tema'] ?>').submit(); return false;">
                                <?php echo obtenerNombreTema($cat['tema']) ?>
                            </a>
                        </form>
                    </div>
                <?php endwhile ?>
            </div>

            <h3>Equipos registrados:</h3>
            <?php if ($equipoActualIndex < count($_SESSION['equipos'])): ?>
                <h4 class="equipo-actual">Es el turno del equipo: <?php echo $_SESSION['equipos'][$equipoActualIndex]['nombre_equipo']; ?></h4>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                    <button type="submit" name="seleccionar_tema" style="display:none;"></button>
                </form>
            <?php else: ?>
                <p>Todos los equipos han jugado. Puedes reiniciar el proceso si deseas.</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

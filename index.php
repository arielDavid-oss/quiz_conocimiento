<?php
session_start();
include("admin/funciones.php");

if (!isset($_SESSION['equipos']) || !isset($_SESSION['equipoActualIndex'])) {
    header("Location: admin/crear_equipo.php");
    exit();
}

$equipos = $_SESSION['equipos'];
$equipoActualIndex = $_SESSION['equipoActualIndex'];

if ($equipoActualIndex >= count($equipos)) {
    // Todos los equipos han seleccionado un tema, redirigir al juego
    header("Location: jugar.php");
    exit();
}

$equipoActual = $equipos[$equipoActualIndex];
$nombreEquipo = $equipoActual['nombre_equipo'];

$categorias = obtenerCategorias();

if(isset($_GET['idCategoria'])){
    $_SESSION['usuario'] = "usuario";
    $_SESSION['idCategoria'] = $_GET['idCategoria'];
    $_SESSION['equipoActualIndex']++;
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="estilo.css">
    <title>QUIZ GAME</title>
</head>
<body>
    <div class="container" id="cantainer">
        <div class="left">
            <div class="logo">
                QUIZ GAME
            </div>
            <h2>PON A PRUEBA TUS CONOCIMIENTOS!!</h2>
        </div>
        <div class="right">
            <h3>Equipo Actual: <?php echo $nombreEquipo; ?></h3>
            <h3>Elige una categoría</h3>
            <!-- <div id="timer">Tiempo restante: 6</div> -->
            <div class="categorias">
                <?php while ($cat = mysqli_fetch_assoc($categorias)):?>
                <div class="categoria">
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" id="<?php echo $cat['tema']?>">
                        <input type="hidden" name="idCategoria" value="<?php echo $cat['tema']?>">
                        <a href="javascript:{}" onclick="document.getElementById(<?php echo $cat['tema']?>).submit(); return false;">
                            <?php echo obtenerNombreTema($cat['tema'])?>
                        </a>
                    </form>
                </div>
                <?php endwhile?>
            </div>
        </div>
    </div>
    <script>
        // // Temporizador
        // let timerElement = document.getElementById('timer');
        // let timeLeft = 6;

        // function updateTimer() {
        //     timeLeft--;
        //     timerElement.textContent = 'Tiempo restante: ' + timeLeft;
        //     if (timeLeft <= 0) {
        //         clearInterval(timerInterval);
        //         location.reload(); // Recargar la página cuando el tiempo se agote
        //     }
        // }

        // let timerInterval = setInterval(updateTimer, 1000);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
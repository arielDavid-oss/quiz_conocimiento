<?php
session_start();
// session_destroy();

include("admin/funciones.php");

$partida = partidas_disponibles();
// Verificar si 'equipo_id' está en la sesión
if (empty($_SESSION['equipo_id'])) {
    header("Location: crear_equipo.php");
}
$nombreEquipo = $_SESSION['equipo_id'];



if(isset($_GET['idCategoria'])){
    //session_start();
    //$_SESSION['usuario'] = "usuario";
    $_SESSION['idPartida'] = $_GET['idPartida'];
    $_SESSION['idCategoria'] = $_GET['idCategoria'];
    header("Location: jugar.php");
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>QUIZ GAME</title>
</head>
<body>
    <div class="container" id="cantainer">
        <div class="left">
            <div class="logo">
                QUIZ GAME
            </div>
            <br>
            <h2>PON A PRUEBA TUS CONOCIMIENTOS!!</h2>
        </div>
        <div class="right">
            <h3>Elige una partida <?php echo $nombreEquipo ?></h3>
            <div class="categorias">
                <?php while ($cat = mysqli_fetch_assoc($partida)):?>
                <div class="categoria">
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" id="<?php echo $cat['tema']?>">
                        <input type="hidden" name="idCategoria" value="<?php echo $cat['tema']?>">
                        <input type="hidden" name="idPartida" value="<?php echo $cat['nombre']?>">
                        <a href="javascript:{}" onclick="document.getElementById(<?php echo $cat['tema']?>).submit(); return false;">
                        <?php echo $cat['nombre']; ?>
                        <br>    
                        <?php echo obtenerNombreTema($cat['tema'])?>
                        </a>
                    </form>
                </div>
                <?php endwhile?>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
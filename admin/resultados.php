<?php 
session_start();

// Si el usuario no está logueado lo enviamos al login
if (!isset($_SESSION['usuarioLogeado'])) {
    header("Location: login.php");
    exit();
}
include("funciones.php");
$nombre_equipo = isset($_GET['nombre_equipo']) ? $_GET['nombre_equipo'] : '';
$miembros = buscar_miembros($nombre_equipo);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <h2>Respuestas del equipo <?php echo $nombre_equipo; ?></h2>
            <div class="text-center"><h4>Integrantes</h4>
            <?php foreach ($miembros as $miembroGrupo): ?><h5><?php echo $miembroGrupo['nombre']; ?></h5><?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>



    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
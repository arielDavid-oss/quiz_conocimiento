<?php
session_start();

include("admin/funciones.php");
include("admin/conexion.php"); // Incluye tu archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar la creación del equipo
    $nombreEquipo = $_POST["nombre_equipo"];
    //Mandamos a llamar la función crear equipo
    crearEquipo($nombreEquipo);
    // Redireccionar a la página de inicio o donde prefieras
    header("Location:integrar_equipo.php");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <link rel="stylesheet" href="estilo.css">
    <title>Crear Equipo</title>
</head>
<body>
    <div class="container">
        <div class="left">
            <div class="logo">
                QUIZ GAME
            </div>
            <h2>Crear Equipo</h2>
        </div>
        <div class="right text-center">
            <h3><i class="fa-solid fa-user-shield"></i> Ingresa el nombre del equipo</h3>
            <br>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="input-container">
            <i class="fa-solid fa-yin-yang"></i>
                <input class="text-center" type="text" name="nombre_equipo" placeholder="Nombre del equipo" required>
                </div>
                <br>
                <button class="btn btn-primary text-center" type="submit"><i class="fa-solid fa-circle-check"></i> Crear Equipo</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

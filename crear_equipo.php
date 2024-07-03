<?php
session_start();

include("admin/funciones.php");
include("admin/conexion.php"); // Incluye tu archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar la creación del equipo
    $nombreEquipo = $_POST["nombre_equipo"];
    $cantidadIntegrantes = 0; // Inicialmente el equipo no tiene integrantes
    // Insertar el nuevo equipo en la base de datos
    $query = "INSERT INTO equipos (nombre_equipo, numerointegrantes) VALUES ('$nombreEquipo', $cantidadIntegrantes)";
    mysqli_query($conn, $query);
    // Redireccionar a la página de inicio o donde prefieras
    header("Location:index.php");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <div class="right">
            <h3>Ingresa el nombre de tu equipo</h3>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <input type="text" name="nombre_equipo" placeholder="Nombre del equipo" required>
                <button type="submit">Crear Equipo</button>
            </form>
        </div>
        <footer>
            <a href="https://www.youtube.com/c/CódigoWeb">By Código Web  <i class="fa-brands fa-youtube"></i> </a>
        </footer>
    </div>
</body>
</html>

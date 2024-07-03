<?php
session_start();
include("admin/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idEquipo = $_POST["equipo"];
    $nombre = $_POST["nombre"];
    $edad = $_POST["edad"];
    $rol = $_POST["rol"];

    // Inserta los datos en la tabla de integrantes
    $query = "INSERT INTO integrantes (equipo_id, nombre, edad, rol) VALUES ('$idEquipo', '$nombre', '$edad', '$rol')";
    
    if (mysqli_query($conn, $query)) {
        header("Location:index.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

$query = "SELECT id, nombre_equipo FROM equipos";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
    $equiposDisponibles = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $equiposDisponibles = array();
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
    <title>Integrar Equipo</title>
</head>
<body>
    <div class="container">
        <div class="left">
            <div class="logo">
                QUIZ GAME
            </div>
            <h2>Integrar Equipo</h2>
        </div>
        <div class="right">
            <h3>Elige un equipo para integrarte</h3>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <select name="equipo" required>
                    <?php foreach($equiposDisponibles as $equipo): ?>
                        <option value="<?php echo $equipo['id']; ?>"><?php echo $equipo['nombre_equipo']; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="nombre" placeholder="Nombre" required>
                <input type="number" name="edad" placeholder="Edad" required>
                <input type="text" name="rol" placeholder="Rol">
                <button type="submit">Integrarme al equipo</button>
            </form>
        </div>
        <footer>
            <a href="https://www.youtube.com/c/CódigoWeb">By Código Web  <i class="fa-brands fa-youtube"></i> </a>
        </footer>
    </div>
</body>
</html>

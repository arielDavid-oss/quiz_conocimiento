<?php
session_start();
include("admin/conexion.php");
include("admin/funciones.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idEquipo = $_POST["equipo"];
    $nombres = $_POST["nombre"];
    $grupo = $_POST["grupo"];

    
    if (count($nombres) >= 2 && count($nombres) <= 5) {
        $_SESSION['equipo_id'] = $idEquipo;
        foreach ($nombres as $index => $nombre) {
            agregarJugador($idEquipo, $nombre, $grupo);
        }
        header("Location:index.php");
    } else {
        echo "<script>alert('Debes agregar entre 2 y 5 jugadores.');</script>";
    }
}
 
    //Mandar a llamar la funcion de obtener equipos disponibles
    $equiposDisponibles = obtenerEquipos();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <link rel="stylesheet" href="estilo.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <div class="derecha text-center">
            <h3><i class="fa-solid fa-user-shield"></i> Agregar integrantes</h3>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <select name="equipo" required>
                    <?php foreach ($equiposDisponibles as $equipo): ?>
                        <option value="<?php echo $equipo['nombre_equipo']; ?>"><?php echo $equipo['nombre_equipo']; ?></option>
                    <?php endforeach; ?>
                </select>
                <input class="text-center" type="text" name="grupo" placeholder="Grupo" required>
                <div id="player-list" class="text-center">
                    <br>
                    <div class="input-container">
                 <i class="bi bi-person-circle"></i> 
                 <input class="text-center" type="text" name="nombre[]" placeholder="Nombre completo" required>
                 </div>
                 <div class="input-container">
                        <i class="bi bi-person-circle"></i> 
                        <input class="text-center" type="text" name="nombre[]" placeholder="Nombre completo" required>
                    </div>
                </div>
                <br>
                <button type="button" class="btn btn-primary" onclick="agregarJugador()"><i class="bi bi-person-add"></i> Agregar jugador</button>
                <button class="btn btn-success" type="submit"><i class="bi bi-person-check"></i> Integrar al equipo</button>
                <br>
                <br>
                <div class="text-center">
                <button type="button" class="btn btn-danger" onclick="removerJugador()"><i class="bi bi-person-add"></i> Eliminar jugador</button>
                </div>
            </form>
        </div>
    </div>
    <script src="juego.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
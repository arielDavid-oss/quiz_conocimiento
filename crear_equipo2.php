<?php
session_start();

// Incluir el archivo de funciones correctamente
include("admin/funciones.php");

// Procesar el formulario de creación de equipo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['crear_equipo'])) {
        $nombre_equipo = $_POST['nombre_equipo'];
        crearEquipo($nombre_equipo);
        header("Location: crear_equipo2.php");
        exit();
    } elseif (isset($_POST['agregar_jugador'])) {
        $equipo_id = $_POST['equipo_id'];
        $nombre_jugador = $_POST['nombre_jugador'];
        agregarJugador($equipo_id, $nombre_jugador);
        header("Location: crear_equipo2.php");
        exit();
    } elseif (isset($_POST['siguiente'])) {
        $equiposResult = obtenerEquipos();
        $equipos = [];
        while ($equipo = mysqli_fetch_assoc($equiposResult)) {
            $equipos[] = $equipo;
        }
        $_SESSION['equipos'] = $equipos; // Guardar los equipos en la sesión como array
        $_SESSION['equipoActualIndex'] = 0; // Inicializar el índice del equipo actual
        header("Location: index.php"); // Ruta ajustada si `img` está fuera de `admin`
        exit();
    } elseif (isset($_POST['borrar_equipo'])) {
        $equipo_id = $_POST['equipo_id'];
        borrarEquipo($equipo_id);
        header("Location: crear_equipo2.php");
        exit();
    }
}

$equipos = obtenerEquipos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="admin/estilo.css">
    <title>Crear Equipo - QUIZ GAME</title>
</head>
<body>
    <div class="contenedor">
        <header>
            <h1>Crear Equipo</h1>
        </header>
        <div class="contenedor-info">
        
            <div class="panel">
                <h2>Crear un nuevo equipo</h2>
                <form action="crear_equipo.php" method="post">
                    <label for="nombre_equipo">Nombre del equipo:</label>
                    <input type="text" id="nombre_equipo" name="nombre_equipo" required>
                    <button type="submit" name="crear_equipo">Crear Equipo</button>
                </form>
                <hr>
                <h2>Agregar jugadores a un equipo</h2>
                <form action="crear_equipo.php" method="post">
                    <label for="equipo_id">Selecciona un equipo:</label>
                    <select id="equipo_id" name="equipo_id" required>
                        <?php while ($equipo = mysqli_fetch_assoc($equipos)): ?>
                            <option value="<?php echo $equipo['id']; ?>"><?php echo $equipo['nombre_equipo']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <label for="nombre_jugador">Nombre del jugador:</label>
                    <input type="text" id="nombre_jugador" name="nombre_jugador" required>
                    <button type="submit" name="agregar_jugador">Agregar Jugador</button>
                </form>
                <hr>
                <h2>Borrar un equipo</h2>
                <form action="crear_equipo.php" method="post">
                    <label for="equipo_id">Selecciona un equipo para borrar:</label>
                    <select id="equipo_id" name="equipo_id" required>
                        <?php
                        // Resetear el puntero del resultado de equipos para reutilizarlo
                        mysqli_data_seek($equipos, 0);
                        while ($equipo = mysqli_fetch_assoc($equipos)): ?>
                            <option value="<?php echo $equipo['id']; ?>"><?php echo $equipo['nombre_equipo']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <button type="submit" name="borrar_equipo">Borrar Equipo</button>
                </form>
                <hr>
                <form action="crear_equipo2.php" method="post">
                    <button type="submit" name="siguiente">Siguiente</button>
                </form>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
<!--<script>paginaActiva(0);</script>-->  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> 
</body>
</html>


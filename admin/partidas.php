<?php
session_start();

// Si el usuario no está logueado lo enviamos al login
if (!isset($_SESSION['usuarioLogeado'])) {
    header("Location: login.php");
    exit();
}
include("funciones.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['id'];
    if (!borar_partidas($nombre)) {
        $mensaje_exito = "Partida eliminada con éxito";
        header("Location: partidas.php?mensaje_exito=" . urlencode($mensaje_exito));
    } else {
        $mensaje_error = "No se pudo borrar la partida";
        header("Location: partidas.php?mensaje_error=" . urlencode($mensaje_error));
    }
    exit();
}

$partidas = obtenerPartidas();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
            <?php include("nav.php") ?>
            <div class="panel">
                <h2>Historial de Partidas</h2>
                <table class="table table-bordered border-primary table-hover">
                    <thead class="text-center table-dark">
                        <tr style="color:white;">
                            <th>Tema</th>
                            <th>Partida</th>
                            <th>Fecha</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php foreach ($partidas as $partida): ?>
                            <tr>
                                <td><?php echo obtenerNombreTema($partida['tema']); ?></td>
                                <td><a href="participantes.php?partida=<?php echo urlencode($partida['nombre']); ?>&tema=<?php echo urlencode($partida['tema']); ?>"><?php echo htmlspecialchars($partida['nombre']); ?></a></td>
                                <td><?php echo $partida['fecha']; ?></td>
                                <td>
                                    <form class="form_data_eliminar" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($partida['id']); ?>">
                                        <button id="btn_eliminar" class="btn btn-danger eliminar-partida-btn" name="eliminar">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script>paginaActiva(3);</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
       const mensajeError = "<?php echo isset($_GET['mensaje_error']) ? $_GET['mensaje_error'] : ''; ?>";
        const mensajeExito = "<?php echo isset($_GET['mensaje_exito']) ? $_GET['mensaje_exito'] : ''; ?>";
    </script>
</body>
</html>
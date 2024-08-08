<?php
session_start();

// Si el usuario no está logueado lo enviamos al login
if (!isset($_SESSION['usuarioLogeado'])) {
    header("Location: login.php");
    exit();
}
include("funciones.php");
$nombrePartida = isset($_GET['partida']) ? $_GET['partida'] : '';
$tema = isset($_GET['tema']) ? $_GET['tema'] : '';
actualizar_estado($nombrePartida);
$equipos_participantes = obtener_equipos_partidas($nombrePartida);
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
            <?php include("nav.php") ?>
            <div class="panel">
            <h2>Equipos participantes en <?php echo $nombrePartida ?></h2>
            <table class="table table-bordered border-primary table-hover">
                        <thead class="text-center table-dark">
                        <tr style="color:white;">
                            <th>Equipo</th>
                            <th>Puntuacion</th>
                        </tr>
                        </thead>
                    <tbody class="text-center">
                        <?php foreach ($equipos_participantes as $equipos): ?>
                            <tr>
                            <input type="hidden" value="<?php echo $tema?>">
                            <td><a href="resultados.php?partida=<?php echo urlencode($nombrePartida); ?>&tema=<?php echo urldecode($tema); ?>&calificacion=<?php echo urldecode($equipos['puntuacion']); ?>&equipos=<?php echo urlencode($equipos['nombre_equipo']); ?>"><?php echo htmlspecialchars($equipos['nombre_equipo']); ?></a></td>
                            <td><?php echo $equipos['puntuacion']/10; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
                    </table>
            </div>
        </div>
    </div>

<script src="script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
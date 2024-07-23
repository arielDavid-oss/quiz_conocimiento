<?php
session_start();
// session_destroy();

include("admin/funciones.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["decision"] == "crear_equipo") {
        header("Location:crear_equipo.php");
    } elseif ($_POST["decision"] == "integrar_equipo") {
        header("Location:integrar_equipo.php");
    }
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
    <style>
        /* Estilos para los botones */
        button {
            padding: 10px 20px;
            margin: 10px;
            border: none;
            background-color: #3498db;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.3s;
        }

        /* Efecto de hover */
        button:hover {
            background-color: #2980b9;
            transform: scale(1.1);
        }
    </style>
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
            <h3>Elige una opción</h3>
            <div class="opciones">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <input type="hidden" name="decision" value="crear_equipo">
                    <button type="submit">Crear un equipo</button>
                </form>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <input type="hidden" name="decision" value="integrar_equipo">
                    <button type="submit">Integrarme a un equipo</button>
                </form>
            </div>
        </div>  
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

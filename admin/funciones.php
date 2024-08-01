<?php
//Función para obtener el registro de la configuración del sitio
function obtenerConfiguracion()
{
    include("conexion.php");
    //Comprobamos si existe el registro 1 que mantiene la configuraciòn
    //Añadimos un alias AS total para identificar mas facil
    $query = "SELECT COUNT(*) AS total FROM config";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);


    if ($row['total'] == '0') {
        //No existe el registro 1 - DEBO INSERTAR el registro por primera vez
      $query = "INSERT INTO config (id,usuario,password)
        VALUES ('1', 'admin')";

        if (mysqli_query($conn, $query)) { //Se insertó correctamente

        } else {
            echo "No se pudo insertar en la BD" .mysqli_errno($conn);
        }
    }

    //Selecciono el registro dela configuración
    $query = "SELECT * FROM config  WHERE id='1'";
    $result = mysqli_query($conn, $query);
    $config = mysqli_fetch_assoc($result);
    return $config;
}

//funcion para agrear un nuevo tema a la BD
function agregarNuevoTema($tema){
    include("conexion.php");
    //armamos el query para insertar en la tabla temas
    $query = "INSERT INTO temas (id, nombre)
    VALUES (NULL, '$tema')";

    //insertamos en la tabla temas
    if (mysqli_query($conn, $query)) { //Se insertó correctamente
        $mensaje = "El fue agregado correctamente";
        header("Location: index.php");
    } else {
        $mensaje = "No se pudo insertar en la BD" . mysqli_errno($conn);
    }
    return $mensaje;
}

function eliminarTema($tema){
    include("conexion.php");
    $query = "DELETE FROM temas where nombre = '$tema'";
    mysqli_query($conn, $query);
} 

//funcion para agregar una nueva partida
function agregarNuevaPartida($nombre,$tema,$fecha,$totalPreguntas,$Tiempo_por_pregunta){
    include('conexion.php');
    $query = "INSERT INTO partida(nombre, tema, fecha, totalPreguntas, Tiempo_por_pregunta)
    VALUES ('$nombre','$tema','$fecha','$totalPreguntas','$Tiempo_por_pregunta')";
   
    //insertamos en la tabla partida
    if (mysqli_query($conn, $query)) { //Se insertó correctamente
        $mensaje = "Partida creada con exito";
    } else {
        $mensaje = "No se pudo insertar en la BD" . mysqli_errno($conn);
    }
    return $mensaje;
}

// Recupera todos los temas de la tabla 'temas'.
function obetenerTodosLosTemas() {
    include("conexion.php");
    $query = "SELECT * FROM temas";
    $result = mysqli_query($conn, $query);
    return $result;
}

function obteneNombreTemas() {
    include("conexion.php");
    $query = "SELECT nombre FROM temas";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Recupera el nombre de un tema por su ID de la tabla 'temas'.
function obtenerNombreTema($id) {
    include("conexion.php");
    $query = "SELECT * FROM temas WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $tema = mysqli_fetch_array($result);
    return $tema['nombre'];
}

// Recupera todas las preguntas de la tabla 'preguntas'.
function obetenerTodasLasPreguntas() {
    include("conexion.php");
    $query = "SELECT * FROM preguntas";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Recupera una pregunta específica por su ID de la tabla 'preguntas'.
function obtenerPreguntaPorId($id) {
    include("conexion.php");
    $query = "SELECT * FROM preguntas WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $pregunta = mysqli_fetch_array($result);
    return $pregunta;
}

// Obtener todas las preguntas del tema seleccionada
function obtenerPreguntasPorTema($tema) {
    include("conexion.php");
    $query = "SELECT * FROM preguntas WHERE tema = $tema";
    $result = mysqli_query($conn, $query);
    $preguntas = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $preguntas[] = $row;
    }

    return $preguntas;
}


// Devuelve el número total de preguntas en la tabla 'preguntas'.
function obtenerTotalPreguntas() {
    include("conexion.php");
    $query = "SELECT COUNT(*) AS total FROM preguntas";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

// Devuelve el número total de preguntas para un tema específico.
function totalPreguntasPorCategoria($tema) {
    include("conexion.php");
    $query = "SELECT COUNT(*) AS total FROM preguntas WHERE tema = '$tema'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

// Recupera todas las categorías y el conteo de temas distintos de la tabla 'preguntas'.
function obtenerCategorias() {
    include("conexion.php");
    $query = "SELECT tema, COUNT(DISTINCT tema) FROM preguntas GROUP BY tema";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Recupera los IDs de preguntas para un tema específico.
function obtenerIdsPreguntasPorCategoria($tema) {
    include("conexion.php");
    $query = "SELECT id FROM preguntas WHERE tema = $tema";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Crea un nuevo equipo con el nombre dado.
function crearEquipo($nombre_equipo) {
    include("conexion.php");
    $query = "INSERT INTO equipos (nombre_equipo) VALUES ('$nombre_equipo')";
    mysqli_query($conn, $query);
}

// Agrega un jugador a un equipo específico.
function agregarJugador($equipo_id, $nombre_jugador, $grupo) {
    include("conexion.php");
    $query = "INSERT INTO miembros (equipo_id, nombre, grupo) VALUES ('$equipo_id', '$nombre_jugador','$grupo')";
    mysqli_query($conn, $query);
}

// Cambia el estado de un equipo a verdadero.
function cambiar_estado($nombreEquipo) {
    include("conexion.php");
    $query = "UPDATE `equipos`SET `estado` = true WHERE `nombre_equipo` = '$nombreEquipo'";
    mysqli_query($conn, $query);
}

// Busca los miembros de un equipo específico por su nombre.
function buscar_miembros($nombreEquipo) {
    include("conexion.php");
    $query = "SELECT `nombre`,`grupo` FROM `miembros` WHERE `equipo_id` = '$nombreEquipo'";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Recupera todos los equipos cuyo estado es falso.
function obtenerEquipos() {
    include("conexion.php");
    $query = "SELECT * FROM equipos where estado = false";
    $result = mysqli_query($conn, $query);
    return $result;
}

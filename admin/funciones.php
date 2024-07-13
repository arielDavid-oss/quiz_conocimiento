<?php
$conexion;

function conectarBaseDatos() {
    global $conexion;
    $servidor = "localhost:3306";
    $usuario = "root";
    $password = "12345";
    $baseDatos = "bd_quiz";

    $conexion = new mysqli($servidor, $usuario, $password, $baseDatos);

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }
}

// Llama a la función para establecer la conexión a la base de datos
conectarBaseDatos();

// Función para obtener temas disponibles
function obtenerTemasDisponibles() {
    global $conexion;
    $query = "SELECT * FROM temas WHERE usado = 0";
    $resultado = mysqli_query($conexion, $query);
    $temas = array();
    while ($row = mysqli_fetch_assoc($resultado)) {
        $temas[] = $row;
    }
    return $temas;
}

// Función para marcar un tema como usado
function marcarTemaComoUsado($idTema) {
    global $conexion;
    $query = "UPDATE temas SET usado = 1 WHERE id = $idTema";
    mysqli_query($conexion, $query);
}

// Función para obtener el registro de la configuración del sitio
function obtenerConfiguracion() {
    global $conexion;
    $query = "SELECT * FROM config WHERE id='1'";
    $result = mysqli_query($conexion, $query);
    $config = mysqli_fetch_assoc($result);

    // Si no existe el registro de configuración, insertarlo por primera vez
    if (!$config) {
        $queryInsert = "INSERT INTO config (id, usuario, password, totalPreguntas, Tiempo_por_pregunta)
                        VALUES (NULL, 'admin', 'admin', '3', '10')";
        mysqli_query($conexion, $queryInsert);
        // Obtener la configuración después de insertar
        $result = mysqli_query($conexion, $query);
        $config = mysqli_fetch_assoc($result);
    }

    return $config;
}

// Función para agregar un nuevo tema a la BD
function agregarNuevoTema($tema) {
    global $conexion;
    $query = "INSERT INTO temas (nombre) VALUES ('$tema')";
    if (mysqli_query($conexion, $query)) {
        $mensaje = "El tema fue agregado correctamente";
    } else {
        $mensaje = "No se pudo insertar en la BD: " . mysqli_error($conexion);
    }
    return $mensaje;
}

function obtenerTodosLosTemas() {
    global $conexion;
    $query = "SELECT * FROM temas";
    $result = mysqli_query($conexion, $query);
    return $result;
}

function obtenerNombreTema($id) {
    global $conexion;
    $query = "SELECT nombre FROM temas WHERE id = '$id'";
    $result = mysqli_query($conexion, $query);
    $tema = mysqli_fetch_assoc($result);
    return $tema['nombre'];
}

function obtenerTodasLasPreguntas() {
    global $conexion;
    $query = "SELECT * FROM preguntas";
    $result = mysqli_query($conexion, $query);
    return $result;
}

function obtenerPreguntaPorId($id) {
    global $conexion;
    $query = "SELECT * FROM preguntas WHERE id = $id";
    $result = mysqli_query($conexion, $query);
    $pregunta = mysqli_fetch_assoc($result);
    return $pregunta;
}

function obtenerTotalPreguntas() {
    global $conexion;
    // Añadimos un alias AS total para identificar más fácil
    $query = "SELECT COUNT(*) AS total FROM preguntas";
    $result = mysqli_query($conexion, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function totalPreguntasPorCategoria($tema) {
    global $conexion;
    $query = "SELECT COUNT(*) AS total FROM preguntas WHERE tema = '$tema'";
    $result = mysqli_query($conexion, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function obtenerCategorias() {
    global $conexion;
    // Contamos la cantidad de cada categoría
    $query = "SELECT tema, COUNT(DISTINCT tema) FROM preguntas GROUP BY tema";
    $result = mysqli_query($conexion, $query);
    return $result;
}

function obtenerIdsPreguntasPorCategoria($tema) {
    global $conexion;
    $query = "SELECT id FROM preguntas WHERE tema = $tema";
    $result = mysqli_query($conexion, $query);
    return $result;
}

function aumentarVisita() {
    global $conexion;
    // Selecciono el registro de la estadística
    $query = "SELECT visitas FROM estadisticas WHERE id='1'";
    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $estadistica = mysqli_fetch_assoc($result);
        $visitas = $estadistica['visitas'] + 1;
        $query = "UPDATE estadisticas SET visitas = '$visitas' WHERE id='1'";
        mysqli_query($conexion, $query);
    } else {
        echo "No se encontró el registro de estadísticas.";
    }
}

function aumentarRespondidas() {
    global $conexion;
    // Selecciono el registro de la estadística
    $query = "SELECT respondidas FROM estadisticas WHERE id='1'";
    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $estadistica = mysqli_fetch_assoc($result);
        $respondidas = $estadistica['respondidas'] + 1;
        $query = "UPDATE estadisticas SET respondidas = '$respondidas' WHERE id='1'";
        mysqli_query($conexion, $query);
    } else {
        echo "No se encontró el registro de estadísticas.";
    }
}

function aumentarCompletados() {
    global $conexion;
    // Selecciono el registro de la estadística
    $query = "SELECT completados FROM estadisticas WHERE id='1'";
    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $estadistica = mysqli_fetch_assoc($result);
        $completados = $estadistica['completados'] + 1;
        $query = "UPDATE estadisticas SET completados = '$completados' WHERE id='1'";
        mysqli_query($conexion, $query);
    } else {
        echo "No se encontró el registro de estadísticas.";
    }
}

function crearEquipo($nombre_equipo) {
    global $conexion;
    $query = "INSERT INTO equipos (nombre_equipo) VALUES ('$nombre_equipo')";
    mysqli_query($conexion, $query);
}

function agregarJugador($equipo_id, $nombre_jugador) {
    global $conexion;
    $query = "INSERT INTO miembros (equipo_id, nombre) VALUES ('$equipo_id', '$nombre_jugador')";
    mysqli_query($conexion, $query);
}

function obtenerEquipos() {
    global $conexion;
    $query = "SELECT * FROM equipos";
    $result = mysqli_query($conexion, $query);
    return $result;
}

// Función para seleccionar el tema por equipo
function seleccionarTemaEquipo($equipo_id, $tema_id) {
    global $conexion;
    $query = "UPDATE equipos SET tema_seleccionado = '$tema_id' WHERE id = '$equipo_id'";
    mysqli_query($conexion, $query);
}

// Función para avanzar al siguiente equipo que debe seleccionar tema
function siguienteEquipoSeleccionarTema() {
    global $conexion;
    $query = "SELECT id FROM equipos WHERE tema_seleccionado IS NULL ORDER BY id ASC LIMIT 1";
    $result = mysqli_query($conexion, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $equipo = mysqli_fetch_assoc($result);
        $_SESSION['equipo_id'] = $equipo['id'];
        return true;
    } else {
        // Todos los equipos han seleccionado tema
        return false;
    }
}

// Función para obtener información de un equipo por su ID
function obtenerEquipoPorId($equipo_id) {
    global $conexion;
    $query = "SELECT * FROM equipos WHERE id = '$equipo_id'";
    $result = mysqli_query($conexion, $query);
    $equipo = mysqli_fetch_assoc($result);
    return $equipo;
}

function reactivarTemas() {
    global $conexion;
    $query = "UPDATE temas SET usado = 0";
    mysqli_query($conexion, $query);
}

function marcarTodosLosTemasComoDisponibles() {
    global $conexion;
    $query = "UPDATE temas SET usado = 0";
    mysqli_query($conexion, $query);
}

function borrarEquipo($equipo_id) {
    global $conexion;
    $query = "DELETE FROM equipos WHERE id = $equipo_id";
    mysqli_query($conexion, $query);
}

?>

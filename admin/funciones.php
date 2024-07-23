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
        $query = "INSERT INTO config (id,usuario,password,totalPreguntas,Tiempo_por_pregunta)
        VALUES (NULL, 'admin', 'admin','3','10')";

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


function obetenerTodosLosTemas()
{
    include("conexion.php");
    $query = "SELECT * FROM temas";
    $result = mysqli_query($conn, $query);
    return $result;
}
function obtenerNombreTema($id){
    include("conexion.php");
    $query = "SELECT * FROM temas WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $tema = mysqli_fetch_array($result);
    
    return $tema['nombre'];
}

function obetenerTodasLasPreguntas()
{
    include("conexion.php");
    $query = "SELECT * FROM preguntas";
    $result = mysqli_query($conn, $query);
    return $result;
}

function obtenerPreguntaPorId($id){
    include("conexion.php");
    $query = "SELECT * FROM preguntas WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $pregunta = mysqli_fetch_array($result);
    return $pregunta;
}

function obtenerPreguntasPorTema($tema){
    include("conexion.php");
    $query = "SELECT * FROM preguntas WHERE tema = $tema";
    $result = mysqli_query($conn, $query);
    $preguntas = mysqli_fetch_array($result);
    return $preguntas;
}

function obtenerTotalPreguntas(){
    include("conexion.php");
    //Añadimos un alias AS total para identificar mas facil
    $query = "SELECT COUNT(*) AS total FROM preguntas";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);  
    return $row['total'];
}

function totalPreguntasPorCategoria($tema){
    include("conexion.php");
    $query = "SELECT COUNT(*) AS total FROM preguntas WHERE tema = '$tema'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);  
    return $row['total'];
}

function obtenerCategorias(){
    include("conexion.php");
    //ACOntamos la cantidad de cada categoria
    $query = "SELECT tema, COUNT(DISTINCT tema) FROM preguntas GROUP BY tema";
    $result = mysqli_query($conn, $query);
    return $result;
}
function obtenerIdsPreguntasPorCategoria($tema){
    include("conexion.php");
    $query = "SELECT id FROM preguntas WHERE tema = $tema";
    $result = mysqli_query($conn, $query);
    return $result;
}

function crearEquipo($nombre_equipo) {
    include("conexion.php");
    $query = "INSERT INTO equipos (nombre_equipo) VALUES ('$nombre_equipo')";
    mysqli_query($conn, $query);
}

function agregarJugador($equipo_id, $nombre_jugador, $grupo) {
    include("conexion.php");
    $query = "INSERT INTO miembros (equipo_id, nombre, grupo) VALUES ('$equipo_id', '$nombre_jugador','$grupo')";
    mysqli_query($conn, $query);
}

function cambiar_estado($nombreEquipo){
    include("conexion.php");
    $query = "UPDATE `equipos`SET `estado` = true WHERE `nombre_equipo` = '$nombreEquipo'";
    mysqli_query($conn, $query);
}

function buscar_miembros($nombreEquipo){
    include("conexion.php");
    $query = "SELECT `nombre`,`grupo` FROM `miembros` WHERE `equipo_id` = '$nombreEquipo'";
    $result = mysqli_query($conn, $query);
    return $result;
}

function obtenerEquipos() {
    include("conexion.php");
    $query = "SELECT * FROM equipos where estado = false";
    $result = mysqli_query($conn, $query);
    return $result;
}
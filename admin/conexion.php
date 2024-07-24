<?php
//datos del servidor
$server	="localhost:3306";
$username	="root";
$password	="12345";
$bd		  ="bd_quiz";

//creamos una conexión
$conn = mysqli_connect($server, $username, $password, $bd);

//Chequeamos la conexión
if(!$conn){
	die("Conexión fallida:" . mysqli_connect_error());
}

?>
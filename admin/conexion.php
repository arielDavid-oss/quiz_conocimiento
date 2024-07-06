<?php
//datos del servidor
$server		="localhost:3306";
$username	="root";
$password	="12345";
//$server	="140.84.176.234";
//$username	="socceradmin";
//$password	="Ult1m0g4n4d0r";
$bd			="bd_quiz";

//creamos una conexión
$conn = mysqli_connect($server, $username, $password, $bd);

//Chequeamos la conexión
if(!$conn){
	die("Conexión fallida:" . mysqli_connect_error());
}

?>
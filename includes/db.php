<?php
// Conexión a la base de datos
$host = 'localhost';
$dbname = 'sistema_viajes';
$username = 'root';
$password = '';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) 
{
  die("Error en la conexión: " . mysqli_connect_error());
}	
?>
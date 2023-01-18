<?php 

$servidor="localhost:3307"; //127.0.0.1
$baseDeDatos="app";
$usuario="root";
$contrasenia = "";


try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$baseDeDatos", $usuario, $contrasenia);
    //echo "conectado correctamente"
}catch(Exception $error){
echo $error->getMessage();
}


?>
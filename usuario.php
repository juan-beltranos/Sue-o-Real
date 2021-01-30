<?php

// Importar la conexión
require 'includes/config/database.php';
$db = conectarDB();

// Crear un email y password
$email = " sueñoreal2@gmail.com";
$password = "2021sueñoreal";

$passwordHash = password_hash($password, PASSWORD_BCRYPT);


// Query para crear el usuario
$query = " INSERT INTO usuarios (email, password) VALUES ( '${email}', '${passwordHash}'); ";

// echo $query;

// Agregarlo a la base de datos
mysqli_query($db, $query);
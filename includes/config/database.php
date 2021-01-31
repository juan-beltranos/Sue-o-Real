<?php

function conectarDB(): mysqli
{
    $db = mysqli_connect('localhost', 'u940788076_vilmaospina', 'Sueñoreal2021', 'u940788076_suenoreal2021');
    if (!$db) {
        echo "Error no se pudo conectar";
        exit;
    }
    return $db;
}
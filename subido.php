<!DOCTYPE html>
<html lang="es">
    <head>
        <meta name="author" content= "Saúl Otero García" />
        <meta name="author" content= "Celia Torres Montero" />
        <meta name="description" content="" />
        <meta charset="utf-8">
        <title>Iniciación Saúl</title>
        <link rel="stylesheet" href="inicializador.css">
        <link rel="stylesheet" href="index.css">
    </head>
<body>
<?php

include "funciones.php";

$nombre=$_FILES['archivo']['name'];
$guardar=$_FILES['archivo']['tmp_name'];
if(!file_exists('articulos')){
    mkdir('articulos',0777,true);
    if(file_exists('articulos')){
        if(move_uploaded_file($guardar,'articulos/'.$nombre)){
            $error= "El archivo se ha guardado correctamente";
            formularioEnviarAr($error);
        }else{
            $error= "El archivo no se ha guardado correctamente";
            formularioEnviarAr($error);
        }
    }
}else{
    if(move_uploaded_file($guardar,'articulos/'.$nombre)){
        $error= "El archivo se ha guardado correctamente";
        formularioEnviarAr($error);
    }else{
        $error= "El archivo no se ha guardado correctamente ".$_FILES['archivo']['error'];;
        formularioEnviarAr($error);
    }
}

pie();
?>
</body>
</html>
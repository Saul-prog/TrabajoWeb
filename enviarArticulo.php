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
$usuario=(isset($_SESSION['usuario'])?$_SESSION['usuario']:2);
encabezado($usuario);

if($_POST['enviarAr']){
    if(isset($_POST['titulo'])){
        if(isset($_POST['resumen'])){
            if(isset($_POST['archivo'])){
            
            }else{
                $error='<p>Falta un archivo<p>';
            formularioEnviarAr($error);
            }
        }else{
            $error='<p>Falta un resumen<p>';
        formularioEnviarAr($error);
        }
    }else{
        $error='<p>Falta tiutlo<p>';
        formularioEnviarAr($error);
    }
}else{


formularioEnviarAr()
    
}

pie();
?>
</body>
</html>
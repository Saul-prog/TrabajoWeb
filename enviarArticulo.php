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
$error='';
$boton=(isset($_POST['enviarAr'])?$_POST['enviarAr']:false);
$titulo=(isset($_POST['titulo'])?$_POST['titulo']:false);
$resumen=(isset($_POST['resumen'])?$_POST['resumen']:false);
if($boton){
    if(isset($_POST['titulo'])){
        if(isset($_POST['resumen'])){
            
                $nombre=( isset($_FILES['archivo']['name'])?$_FILES['archivo']['name']:null);
                $guardar=( isset($_FILES['archivo']['tmp_name'])?$_FILES['archivo']['tmp_name']:null);
                $dir_subida='articulos/';
                if(!file_exists('articulos')){
                    mkdir('articulos',0777,true);
                    if(file_exists('articulos')){
                        if(move_uploaded_file($_FILES['archivo']['tmp_name'],'articulos/'.basename($_FILES['archivo']['name']))){
                            $error= "El archivo se ha guardado correctamente";
                            formularioEnviarAr($error);
                        }else{
                            $error= "El archivo no se ha guardado correctamente";
                            formularioEnviarAr($error);
                        }
                    }
                }else{
                    if(move_uploaded_file($_FILES['archivo']['tmp_name'],'articulos/'.basename($_FILES['archivo']['name']))){
                        $error= "Archivo guardado correctamente";

                        formularioEnviarAr($error);
                    }else{
                        $error= "El archivo no se ha guardado correctamente";
                        formularioEnviarAr($error);
                    }
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


formularioEnviarAr($error);
    
}

pie();
?>
</body>
</html>
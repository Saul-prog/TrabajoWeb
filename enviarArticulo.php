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
?>
<section class="comentario">
  		<h2 class="comentario">Enviar artículo</h2>
        <article class="comentario">
<?php
$error='';
$boton=(isset($_POST['enviarAr'])?$_POST['enviarAr']:null);
$titulo=(isset($_POST['titulo'])?$_POST['titulo']:null);
$resumen=(isset($_POST['resumen'])?$_POST['resumen']:null);
$observaciones=(isset($_POST['observaciones'])?$_POST['observaciones']:'');
$autor=(isset($_SESSION['autor'])?$_SESSION['autor']:'FALTA POR PONER NOMBRE DEL AUTOR');
if($boton!=null){
    if($titulo!=null){
        if($resumen!=null){
            $nombre=( isset($_FILES['archivo']['name'])?$_FILES['archivo']['name']:null);
                $guardar=( isset($_FILES['archivo']['tmp_name'])?$_FILES['archivo']['tmp_name']:null);
                            $con=conectar();
                            nuevoArtRevision($con,$autor,$titulo,$resumen,$observaciones,$nombre);
                            $con->close();
                
                $dir_subida='articulos/';
                if(!file_exists('articulos')){
                    mkdir('articulos',0777,true);
                    if(file_exists('articulos')){
                        if(move_uploaded_file($_FILES['archivo']['tmp_name'],'articulos/'.$nombre)){
                            $error= "El archivo se ha guardado correctamente";
                            
                            formularioEnviarAr($error);
                            
                        }else{
                            $error= "El archivo no se ha guardado correctamente";
                            formularioEnviarAr($error);
                        }
                    }
                }else{
                    if(move_uploaded_file($_FILES['archivo']['tmp_name'],'articulos/'.$nombre)){
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
    
}?>
</article>
</section>
<?php
pie();
?>
</body>
</html>
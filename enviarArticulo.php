<!DOCTYPE html>
<html lang="es">
    <head>
        <meta name="author" content= "Saúl Otero García" />
        <meta name="author" content= "Celia Torres Montero" />
        <meta name="description" content="ciencia, revista, noticias" />
        <meta charset="utf-8">
        <title>Fm-cia</title>
        <link rel="stylesheet" href="inicializador.css">
        <link rel="stylesheet" href="index.css">
        <link rel="icon" type="image/jpeg" href="imagenes/Iconos/FermioP.jpeg">
    </head>
<body>
<?php
session_start();
include "funciones.php";
$tipo_user=(isset($_SESSION['tipo_usuario'])?$_SESSION['tipo_usuario']:2);
if($tipo_user==2){
   header('refresh:0;url=index.php');
}
$con=conectar();
encabezado($tipo_user,$con);
?>
<section class="comentario">
  		<h2 class="comentario">Enviar artículo</h2>
        <article class="comentario">
<?php
$error='';
$boton=(isset($_POST['enviarAr'])?$_POST['enviarAr']:null);
$titulo=(isset($_POST['titulo'])?$_POST['titulo']:null);
$autores=(isset($_POST['autores'])?$_POST['autores']:null);
$biografia=(isset($_POST['bio'])?$_POST['bio']:null);
$resumen=(isset($_POST['resumen'])?$_POST['resumen']:null);
$observaciones=(isset($_POST['observaciones'])?$_POST['observaciones']:'');
$autor=(isset($_SESSION['autor'])?$_SESSION['autor']:'FALTA POR PONER NOMBRE DEL AUTOR');

if($autores!=null)
{
    $autor=$autor.', '.$autores;
}

if($boton!=null){
    if($titulo!=null){
        if($resumen!=null){
            $nombre=( isset($_FILES['archivo']['name'])?$_FILES['archivo']['name']:null);
                $guardar=( isset($_FILES['archivo']['tmp_name'])?$_FILES['archivo']['tmp_name']:null);
                            $con=conectar();
                            nuevoArtRevision($con,$autor,$biografia,$titulo,$resumen,$observaciones,$nombre);
                            $con->close();
                
                
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
                        $error= "Artículo enviado correctamente";

                        formularioEnviarAr($error);
                    }else{
                        $error= "El artículo no se ha enviado correctamente";
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
pie("peque");
?>
</body>
</html>
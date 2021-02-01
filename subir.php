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
session_start();

$tipo_usuario=(isset($_SESSION['tipo_usuario'])?$_SESSION['tipo_usuario']:2);
///------------Cambiar
$tipo_usuario=1;
if($tipo_usuario!=1)
    header('refresh:0;url=index.php');

encabezado($tipo_usuario);
/*$usuario=(isset($_SESSION['usuario'])?$_SESSION['usuario']:null);
if($usuario==null)
    header('refresh:0;url=index.php');*/
$con=conectar();
?>
<section class="comentario">
<h2 class="comentario">Publicar artículo</h2>
  <article class="comentario">
      <h3 class="comentario">&nbsp;</h3>
      <form action="subir.php" method="psot" enctype="multipart/form-data">
      <p>Identificador: <br><input type="text" name="id_art" placeholder="Identificador del artículo"><br></p>
      <p>Categoria: <br><?php desplegableCat($con);?><br></p>
      <p>Categoria: <br><?php desplegableSubCat($con);?><br></p>
      <p>Imagen: <br><input type="file" name="imagen"></p>
      <p>Contraseña del administrador <br><input type="password" placeholder="Contraseña del administrador"><br></p>
      <p class="guardar"><input type="submit" id="boton" value="Publicar"></p>
      </form>
</article>
</section>
<?php



$boton=(isset($_POST['boton']));
if($boton){
$id_art=(isset($_POST['id_art'])?$_POST['id_art']:null);
$fila=existeArt($con,$id_art)
    if($fila!=false){
        $nombre=( isset($_FILES['imagen']['name'])?$_FILES['imagen']['name']:null);
        $guardar=( isset($_FILES['imagen']['tmp_name'])?$_FILES['imagen']['tmp_name']:null);
        subirImagen($nombre,$guardar);
        publicar($con,$fila);
    }else{
        echo '<p>Debe introducir un identificador</p>';
    }
}
pie();
?>
</body>
</html>
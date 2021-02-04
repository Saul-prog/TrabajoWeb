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

$tipo_user=(isset($_SESSION['tipo_usuario'])?$_SESSION['tipo_usuario']:2);
$usuario=(isset($_SESSION['usuario'])?$_SESSION['usuario']:null);
if($tipo_user==2)
    header('refresh:0;url=index.php');

    $con=conectar();
    encabezado($tipo_user,$con);
?>
<section class="comentario">
<h2 class="comentario">Publicar artículo</h2>
  <article class="comentario">
      <h3 class="comentario">&nbsp;</h3>
      <form action="publicarArticulo.php" method="post" enctype="multipart/form-data">
      <p>Identificador der artículo: <br><input type="text" name="id_art" placeholder="Identificador del artículo"><br></p>
      <p>Categoria: <br><?php desplegableCat($con);?><br></p>
      <p>Subcategoria: <br><?php desplegableSubCat($con);?><br></p>
      <p>Imagen: <br><input type="file" name="imagen"></p>
      <p>Contraseña del administrador <br><input type="password" name="contrasena" placeholder="Contraseña del administrador"><br></p>
      <p class="guardar"><input type="submit" name="boton" value="Publicar"></p>
      </form>
</article>
</section>
<?php



$boton=(isset($_POST['boton'])?$_POST['boton']:null);
echo $boton;
if($boton=='Publicar'){
$id_art=(isset($_POST['id_art'])?$_POST['id_art']:null);
$categoria=(isset($_POST['categoria'])?$_POST['categoria']:null);
$contrasena=(isset($_POST['contrasena'])?$_POST['contrasena']:null);
$subcategoria=(isset($_POST['subcategoria'])?$_POST['subcategoria']:null);
$fila=existeArt($con,$id_art);
    if(comprobarContrasena($con,$contrasena,$usuario)){
        if($fila!=false){
            $nombre=( isset($_FILES['imagen']['name'])?$_FILES['imagen']['name']:null);
            $guardar=( isset($_FILES['imagen']['tmp_name'])?$_FILES['imagen']['tmp_name']:null);
            $subida=subirImagen($nombre,$guardar);
            echo '$subida';
                if($subida=='ok'){
                publicar($con,$fila,$categoria,$subcategoria,$nombre);
                }else{
                    echo '<p>No se ha publicado corectamente</p>';
                }
            }else{
            echo '<p>Debe introducir un identificador</p>';
            }
        }else{
        echo '<p>Contraseña erronea</p>';
    }
}else{
    echo 'no ha entrado';
}
pie();
?>
</body>
</html>
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
session_start();
include "funciones.php";
$usuario=(isset($_SESSION['tipo_usuario'])?$_SESSION['tipo_usuario']:2);
if($usuario==2){
    header('refresh:0;url=index.php');
}
encabezado($usuario);
$con=conectar();
$nombreUsuario=(isset($_SESSION['nombreUsuario'])?$_SESSION['nombreUsuario']:null);?>

<section class="comentario">
<h2 class="comentario">Crear nueva categoría</h2>
    <article class="comentario">
        <?php
        $boton=(isset($_POST['boton'])?$_POST['boton']:'no pulsado');
        if($boton=='Crear'){
            $nombre=(isset($_POST['nombreCat'])?$_POST['nombreCat']:null);
            if($nombre==null){
                echo '<p>Debe introducir un nombre</p>';
            }else{
                $contrasena=(isset($_POST['contrasenaCre'])?$_POST['contrasenaCre']:null);
                if(comprobarContrasena($con,$contrasena,$nombreUsuario)){
                    $check=(isset($_POST['essub'])?$_POST['essub']:null);
                        if($check=='si'){
                            $padre=$_POST['categoria'];
                            crearSubCategoria($con,$nombre,$padre);
                            
                        }else{
                            crearCategoria($con,$nombre);
                        }
                }else{
                    echo '<p>Contraseña no válida</p>';
                }
                
            }
        }

        ?>
        <h3 class="comentario">&nbsp;</h3>
        <form action="gestionCategorias.php" method="post">
            <p>Categoría nueva: <br><input type="text" name="nombreCat"placeholder="Nueva categoría"></p>
            
            <input type="checkbox" id="essub" name="essub" value="si"> <label for="essub">Marcar si es Subcategoría</label><br>
            <p>Si es subcategoría, indique la que corresponde<br><?php desplegableCat($con);?><p>
            <p>Contraseña del administrador <br><input type="password" name="contrasenaCre" placeholder="Contraseña del administrador"></p>
            
            <p class="guardar"><input type="submit" name="boton" value="Crear"></p>
        </form> 
   
    </article>
</section>


<section class="comentario">
<h2 class="comentario">Eliminar categoría</h2>
    <article class="comentario">
        <?php
            if($boton=='Eliminar'){
                $nombreElm=(isset($_POST['catEliminar'])?$_POST['catEliminar']:null);
                if($nombre==null){
                    echo '<p>Seleccione la Categoría a eliminar</p>';
                }else{
                    if(comprobarContrasena($con,$contrasena,$idusuario)){
                        eliminarCategoria($con,$nombreElm);
                    }else{
                        echo '<p>Contraseña no válida</p>';
                    }
                }
            }
        ?>
        <h3 class="comentario">&nbsp;</h3>
        <form action="gestionCategorias.php" method="post">
            <p>Categoría a eliminar: <br><input type="text" name="catEliminar"placeholder="Categoría a eliminar"></p>
            <p>Contraseña del administrador <br><input type="password" name="contrasenaELM" placeholder="Contraseña del administrador"></p>
            <p class="guardar"><input type="submit" name="boton" value="Eliminar"></p>
        </form>
    </article>
</section>
<?php
pie();
?>
</body>
</html>
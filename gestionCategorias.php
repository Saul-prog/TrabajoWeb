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
$usuario=(string)(isset($_SESSION['tipo_usuario'])?$_SESSION['tipo_usuario']:2);
if($usuario==2){
    header('refresh:0;url=index.php');
}
$con=conectar();
encabezado($usuario,$con);

$nombreUsuario=(isset($_SESSION['usuario'])?$_SESSION['usuario']:null);

?>

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
                $valido=comprobarContrasena($con,$contrasena,$nombreUsuario);
                if($valido==true){
                    $check=(isset($_POST['essub'])?$_POST['essub']:null);
                        if($check=='si'){
                            $padre=(isset($_POST['categoria'])?$_POST['categoria']:null);
                            if($padre!=null){
                            crearSubCategoria($con,$nombre,$padre);
                            header('refresh:0;url=gestionCategorias.php');
                            }else{
                                echo 'Error al crear la categoría';
                            }
                        }else{
                            crearCategoria($con,$nombre);
                            header('refresh:0;url=gestionCategorias.php');
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
                if($nombreElm==null){
                    echo '<p>Seleccione la Categoría a eliminar</p>';
                }else{
                    $contrasena=(isset($_POST['contrasenaELM'])?$_POST['contrasenaELM']:null);
                    if(comprobarContrasena($con,$contrasena,$nombreUsuario)){
                        eliminarCategoria($con,$nombreElm);
                        header('refresh:0;url=gestionCategorias.php');
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
pie("peque");
?>
</body>
</html>
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
$con=conectar();?>

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
                $check=(isset($_POST['essub'])?$_POST['essub']:null);
                if($check==null){
                    crearCategoria($con,$nombre);
                }else{
                    $padre=$_POST['categoria'];
                    crearSubCategoria($con,$nombre,$padre);
                }
            }
        }

        ?>
        <h3 class="comentario">&nbsp;</h3>
        <form action="gestionCategorias.php" method="post">
            <p>Categoría nueva: <br><input type="text" name="nombreCat"placeholder="Nueva categoría"></p>
            
            <input type="checkbox" id="essub" name="essub" value="si"> <label for="essub">Marcar si es Subcategoría</label><br>
            <p>Si es subcategoría, indique la que corresponde<br><?php desplegableCat($con);?><p>
            <p>Contraseña del administrador <br><input type="password" placeholder="Contraseña del administrador"></p>
            
            <p class="guardar"><input type="submit" name="boton" value="Crear"></p>
        </form> 
   
    </article>
</section>


<section class="comentario">
<h2 class="comentario">Eliminar categoría</h2>
    <article class="comentario">
        <h3 class="comentario">&nbsp;</h3>
        <p>Categoría a eliminar: <br><input type="text" placeholder="Categoría a eliminar"></p>
        <p>Contraseña del administrador <br><input type="password" placeholder="Contraseña del administrador"></p>
        <p class="guardar"><input type="submit" value="Eliminar"></p>
        <!--La fecha se coge de cuando se haya enviado-->
    </article>
</section>
<?php
pie();
?>
</body>
</html>
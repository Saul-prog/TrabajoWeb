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
if($usuario==2||$usuario==0){
    header('refresh:0;url=index.php');
}
$con=conectar();
encabezado($usuario,$con);

$nombreUsuario=(isset($_SESSION['usuario'])?$_SESSION['usuario']:null);
if($nombreUsuario==null){
    echo '<p>Usuario no válido</p>';
    header('refresh:1;url=index.php');
}
?>
<section class="comentario">
  		<h2 class="comentario">Eliminar usuario</h2>
        <article class="comentario">
            <h3 class="comentario">&nbsp;</h3>
            <form action="gestionUsuarios.php" method="post">
            <p>Nombre de usuario: <br><input type="text" name="nombreusuario" placeholder="Nombre del usuario"></p>
            <p>Contraseña del administrador <br><input type="password" name="contrasena" placeholder="Contraseña del administrador"></p>
            <p class="guardar"><input type="submit" value="Eliminar usuario"></p>
        </form>
            <?php $contrasena=(isset($_POST['contrasena'])?$_POST['contrasena']:null);
                $buena=comprobarContrasena($con,$contrasena,$nombreUsuario);
                if($buena==true){
                    $nom=(isset($_POST['nombreusuario'])?$_POST['nombreusuario']:null);
                    eliminarUsuario($con,$nom);
                }else{
                    echo '<p>Introduzca contraseña válida.</p>';
                }
            ?>
		</article>
	</section>
<?php pie("peque");?>
</body>

</html>
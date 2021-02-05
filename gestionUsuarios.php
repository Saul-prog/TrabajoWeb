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
$tipo_usuario=(string)(isset($_SESSION['tipo_usuario'])?$_SESSION['tipo_usuario']:2);
if($tipo_usuario==2||$tipo_usuario!=0){
    header('refresh:0;url=index.php');
}
$con=conectar();
$nombreUsuario=(isset($_SESSION['usuario'])?$_SESSION['usuario']:null);
if($nombreUsuario==null){
    echo '<p>Usuario no válido</p>';
    header('refresh:1;url=index.php');
}
encabezado($usuario,$con);?>
<section class="comentario">
  		<h2 class="comentario">Eliminar usuario</h2>
        <article class="comentario">
            <h3 class="comentario">&nbsp;</h3>
            <form action="gestionUsuarios.php" method="post">
            <p>Correo del usuario: <br><input type="email" name="correo" placeholder="Correo electrónico del usuario"></p>
            <p>Contraseña del administrador <br><input type="password" name="contrasena" placeholder="Contraseña del administrador"></p>
            <p class="guardar"><input type="submit" value="Eliminar usuario"></p>
        </form>
            <?php $contrasena=(isset($_POST['contrasena'])?$_POST['contrasena']:null);
                $buena=comprobarContrasena($con,$contrasena,$nombreUsuario);
                if($buena==true){
                    $correo=(isset($_POST['correo'])?$_POST['correo']:null);
                    eliminarUsuario($con,$correo);
                }else{
                    echo '<p>Contraseña no válida.</p>';
                }
            ?>
		</article>
	</section>
<?php pie();?>
</body>

</html>
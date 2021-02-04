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
        include 'funciones.php';
        $tipo_user= (isset($_SESSION['tipo_usuario'])?$_SESSION['tipo_usuario']:2);
        $con=conectar();
        encabezado($tipo_user,$con);

        $nombreUsuario=(isset($_SESSION['nombreUsuario'])?$_SESSION['nombreUsuario']:null);
    ?>
    <Section class="formulario">
    <?php
    if($nombreUsuario!=null)
    {                             
        $retorno= perfil($con,$nombreUsuario);
        
        if($retorno != null)
        {
            $contraseña= $retorno[2];
            $nombre= $retorno[3];
            $ap1= $retorno[4];
            $ap2= $retorno[5];
            $correo= $retorno[6];
            $fechanac= $retorno[7];
            $promo= $retorno[9];
        }

        $con->close();

        echo '<form action="registro.php" method="post">
		<h2>Información personal</h2>
		<p>Nombre: <br><input type="text" name="nombre" value="'.$nombre.'"></p>
        <p>Primer apellido: <br><input type="text" name="apellido1" value="'.$ap1.'" >
        <br>Segundo apellido<br><input type="text" name="apellido2" value="'.$ap2.'"></p>
		<p>Nombre de usuario: <br><input type="text" name="nombreUsuario" value="'.$nombreUsuario.'"></p>
		<p>Contraseña: <br><input type="password" name="contrasena1" value="'.$contraseña.'"></p>
		<p>Repetir contraseña: <br><input type="password" name="contrasena2" value="'.$contraseña.'"></p>
		<p>Correo electrónico: <br><input type="email" name="email1" value="'.$correo.'"></p>
		<p>Repetir correo electrónico: <br><input type="email" name="email2" value="'.$correo.'"></p>
		<p>Fecha de nacimiento: <br><input type="date" name="fechanac" value="'.$fechanac.'"></p>';
		if($promo==0){
            echo '<p><input type="checkbox" name= "promo" value="1">Quiero recibir correos electrónicos publicitarios de Fm-cia.</p>';
        }else{
            echo '<p><input type="checkbox" name= "promo" value="1" checked>Quiero recibir correos electrónicos publicitarios de Fm-cia.</p>';
        }

	    echo '<p class="guardar"><input type="submit" value="Guardar cambios"></p>
        </form>
        
        <details class="vacio2">
			<summary>Eliminar cuenta</summary>
			<h3 class="comentario">¿Está seguro de eliminar esta cuenta?</h3>
			<input type="submit" value="Eliminar">
		</details>
		<p>Si tiene una cuenta en esta página está aceptando nuestros <a href="terminos_condiciones.html" target="_blank">Términos y Condiciones Fm-cia</a>.</p>
	</Section>';
    }else
    {
        echo '<p>Error al buscar el usuario, vuelva a iniciar sesión.</p>';
    }

    ?>
    </Section>
    <?php pie();?>
    
</body>

</html>
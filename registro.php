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

      ?>
      <Section class="formulario">
      <?php
        $nombre=(isset($_GET['nombre'])?$_GET['nombre']:'Nombre');
        $apellido1=(isset($_GET['apellido1'])?$_GET['apellido1']:'Primer Apellido');
        $apellido2=(isset($_GET['apellido2'])?$_GET['apellido2']:'Segundo Apellido');
        $nombreUsuario=(isset($_GET['nombreUsuario'])?$_GET['nombreUsuario']:'usuario');
        $contrasena1=(isset($_GET['contrasena1'])?$_GET['contrasena1']:'Contraseña');
        $contrasena2=(isset($_GET['contrasena2'])?$_GET['contrasena2']:'Contraseña');
        $email1=(isset($_GET['email1'])?$_GET['email1']:'correo@dominio.es');
        $email2=(isset($_GET['email2'])?$_GET['email2']:'correo@dominio.es');
        $fechanac=(isset($_GET['fechanac'])?$_GET['fechanac']: null);
        $boton= (isset($_GET['boton'])? $_GET['boton'] : 'no');
        $promo= (isset($_GET['promo'])? $_GET['promo'] : 0);

        
   echo   '<form action="registro.php" method="get">
		<h2>Introduzca sus datos</h2>
		<p>Nombre: <br><input type="text" name="nombre" value="'.$nombre.'"></p>
		<p>Primer apellido: <br><input type="text" name="apellido1" value="'.$apellido1.'" ><br>Segundo apellido<br><input type="text" name="apellido2" value="'.$apellido2.'"></p>
		<p>Nombre de usuario: <br><input type="text" name="nombreUsuario" value="'.$nombreUsuario.'"></p>
		<p>Contraseña: <br><input type="password" name="contrasena1" value="'.$contrasena1.'"></p>
		<p>Repetir contraseña: <br><input type="password" name="contrasena2" value="'.$contrasena2.'"></p>
		<p>Correo electrónico: <br><input type="email" name="email1" value="'.$email1.'"></p>
		<p>Repetir correo electrónico: <br><input type="email" name="email2" value="'.$email2.'"></p>
        <p>Fecha de nacimiento: <br><input type="date" name="fechanac" value="'.$fechanac.'"></p>';
        if($boton !="check"){
            echo '<p class="check"><input type="checkbox" name= "boton" value="check">He leído y acepto los <a href="terminos_condiciones.html" target="_blank">Términos y Condiciones de Fm-cia</a>.</p>';
        }else{
            echo '<p class="check"><input type="checkbox" name= "boton" value="check" checked >He leído y acepto los <a href="terminos_condiciones.html" target="_blank">Términos y Condiciones de Fm-cia</a>.</p>';
        }
        if($promo==0){
            echo '<p><input type="checkbox" name= "promo" value="1">Quiero recibir correos electrónicos publicitarios de Fm-cia.</p>';
        }else{
            echo '<p><input type="checkbox" name= "promo" value="1" checked>Quiero recibir correos electrónicos publicitarios de Fm-cia.</p>';
        }
        echo '<p class="guardar"><input type="submit" value="Crear cuenta"></p>
        </form>';

if(($nombre!='Nombre') || ($apellido1!='Primer Apellido') || ($apellido2!='Segundo Apellido') || 
   ($nombreUsuario!='usuario') || ($fechanac!=null))
{
    if(($nombre!='Nombre') && ($nombre!=null)){
        if(($apellido1!='Primer Apellido') && ($apellido1!=null)){
            if(($apellido2!='Segundo Apellido') && ($apellido2!=null)){
                if(($nombreUsuario!='Nombre de usuario') && ($nombreUsuario!=null)){
                    if(($contrasena1!=null) && ($contrasena1!='Contraseña')){
                        if($contrasena1==$contrasena2){
                            if(($email1!=null) && ($email1!='correo@dominio.es')){
                                if($email1==$email2){
                                    if($fechanac!=null){
                                        if($boton =="check"){
                                        
                                            $con=conectar();
                                            nuevoUsuario($con,$nombre,$apellido1,$apellido2,$nombreUsuario,$contrasena1,$email1,$fechanac,$promo);

                                            $con->close();
                                        }else{
                                            echo '<p>Debe aceptar los Términos y Condiciones de uso</p>';
                                        }
                                    }else{
                                        echo '<p>Seleccione fecha de nacimiento</p>';
                                    }
                                }else{
                                    echo '<p>Correos diferentes</p>';
                                } 
                            }else{
                                echo '<p>Introduzca un correo válido</p>';
                            }
                        }else{
                            echo '<p>Contraseñas diferentes</p>';
                        }
                    }else{
                        echo '<p>Introduzca una contraseña no válida</p>';
                    }
                }else{
                    echo '<p>Escriba su nombre de usuario</p>';
                }
            }else{
                echo '<p>Escriba su segundo apellido</p>';
            }
        }else{
            echo '<p>Escriba su primer apellido</p>';
        }
    }else{
        echo '<p>Escriba su nombre</p>';
    }  
}
else{
    echo '<p>Introduzca sus datos para registrarse</p>';
}
    ?>
    </Section>
    <?php pie("peque");?>
</body>

</html>
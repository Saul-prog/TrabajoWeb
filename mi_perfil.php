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
        include 'funciones.php';
        $tipo_user= (isset($_SESSION['tipo_usuario'])?$_SESSION['tipo_usuario']:2);
        encabezado($tipo_user);
      ?>
      <Section class="formulario">
      <?php
        $nombre=(isset($_POST['nombre'])?$_POST['nombre']:'Nombre');
        $apellido1=(isset($_POST['apellido1'])?$_POST['apellido1']:'Primer Apellido');
        $apellido2=(isset($_POST['apellido2'])?$_POST['apellido2']:'Segundo Apellido');
        $nombreUsuario=(isset($_POST['nombreUsuario'])?$_POST['nombreUsuario']:'usuario');
        $contrasena1=(isset($_POST['contrasena1'])?$_POST['contrasena1']:'Contraseña');
        $contrasena2=(isset($_POST['contrasena2'])?$_POST['contrasena2']:'Contraseña');
        $email1=(isset($_POST['email1'])?$_POST['email1']:'correo@dominio.es');
        $email2=(isset($_POST['email2'])?$_POST['email2']:'correo@dominio.es');
        $fechanac=(isset($_POST['fechanac'])?$_POST['fechanac']: null);
        
   echo   '<form action="registro.php" method="post">
		<h2>Información personal</h2>
		<p>Nombre: <br><input type="text" name="nombre" value="'.$nombre.'"></p>
        <p>Primer apellido: <br><input type="text" name="apellido1" value="'.$apellido1.'" >
        <br>Segundo apellido<br><input type="text" name="apellido2" value="'.$apellido2.'"></p>
		<p>Nombre de usuario: <br><input type="text" name="nombreUsuario" value="'.$nombreUsuario.'"></p>
		<p>Contraseña: <br><input type="password" name="contrasena1" value="'.$contrasena1.'"></p>
		<p>Repetir contraseña: <br><input type="password" name="contrasena2" value="'.$contrasena2.'"></p>
		<p>Correo electrónico: <br><input type="email" name="email1" value="'.$email1.'"></p>
		<p>Repetir correo electrónico: <br><input type="email" name="email2" value="'.$email2.'"></p>
		<p>Fecha de nacimiento: <br><input type="date" name="fechanac" value="'.$fechanac.'"></p>
		
		<p><input type="checkbox">Quiero recibir correos electrónicos publicitarios de Fm-cia.</p>
        <p class="guardar"><input type="submit" value="Crear cuenta"></p>
        </form>';

    if($nombre!='Nombre'){
        if($apellido1!='Primer Apellido'){
            if($apellido2!='Segundo Apellido'){
                if($nombreUsuario!='Nombre de usuario'){
                    if($contrasena1==$contrasena2){
                        if($email1==$email2){
                            if($fechanac!=null){
                                
                                $con=conectar();
                                nuevoUsuario($con,$nombre,$apellido1,$apellido2,$nombreUsuario,$contrasena1,$email1,$fechanac);

                                $con->close();
                            }else{
                                echo '<p>Seleccione fecha de nacimiento</p>';
                            }
                        }else{
                            echo '<p>Email diferente o no válido';
                        }
                    }else{
                        echo '<p>Contraseña diferente o no válida</p>';
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
    ?>
    </Section>
    <?php pie();?>
    
</body>

</html>
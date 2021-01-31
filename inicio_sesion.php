<!DOCTYPE html>
<html lang="es">
    <head>
        <meta name="author" content= "Saúl Otero García" />
        <meta name="author" content= "Celia Torres Montero" />
        <meta name="description" content="" />
        <meta charset="utf-8">
        <title>Fm-cia</title>
        <link rel="stylesheet" href="inicializador.css">
        <link rel="stylesheet" href="index.css">

        <link rel="icon" type="image/jpeg" href="imagenes/Iconos/FermioP.jpeg">
    </head>
<body>

<?php
    session_start();
    error_reporting(0);
        include 'funciones.php';
    $tipo_user= (isset($_SESSION['tipo_usuario'])?$_SESSION['tipo_usuario']:2);
      encabezado($tipo_user);

      if(($tipo_user != 0) && ($tipo_user != 1))
    {
      ?>
      
      <Section class="formulario">
        <h2>Iniciar sesión</h2>
      <?php
        $contrasena=(isset($_POST['contrasena'])?$_POST['contrasena']:'Contraseña');
        $email=(isset($_POST['email'])?$_POST['email']:'correo@dominio.es');
        
   echo   '<form action="inicioSesion.php" method="post">
        <p>Correo electrónico: <br><input type="email" name="email" value="'.$email.'"></p>
		<p>Contraseña: <br><input type="password" name="contrasena" value="'.$contrasena.'"></p>

        <p class="guardar"><input type="submit" value="Iniciar sesión"></p>
        </form>';

        if($email!='correo@dominio.es'){
            if($contrasena!='Contraseña'){                              
                $con=conectar();
                iniciarSesion($con,$contrasena,$email);

                $con->close();

            }else{
                echo '<p>Email no válido';
            }
        }else{
            echo '<p>Contraseña no válida</p>';
        }
    }
    else
    {
        header('refresh:2;url=miperfil.php');
    }
    ?>
    </Section>
    <?php pie();?>
</body>

</html>
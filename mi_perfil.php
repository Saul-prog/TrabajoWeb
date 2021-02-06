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

        $nombreUsuario=(isset($_SESSION['usuario'])?$_SESSION['usuario']:null);
    ?>
    <Section class="formulario">
    <?php
if($nombreUsuario!=null)
{                             
    $retorno= perfil($con,$nombreUsuario);
        
    if($retorno != null)
    {
        $id= $retorno['ID_USUARIO'];
        $contraseña= $retorno['contrasena'];
        $nombre= $retorno['Nombre'];
        $ap1= $retorno['Apellido1'];
        $ap2= $retorno['Apellido2'];
        $correo= $retorno['CorreoElectronico'];
        $fechanac= $retorno['Fechanac'];
        $promo= $retorno['promo'];
        

        echo '<form action="mi_perfil.php" method="get">
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

	    echo '<p class="guardar"><input type="submit" name="boton" value="Guardar cambios"></p>
        
        
            <details class="vacio2">
                <summary>Eliminar cuenta</summary>
                <h3 class="comentario">¿Está seguro de eliminar esta cuenta?</h3>
                <p>Escriba CONFIRMAR:<input type="text" name="confirm"></p>
                <input type="submit" name="elim" value="Eliminar">
            </details>
        </form>
		<p>Si tiene una cuenta en esta página está aceptando nuestros <a href="terminos_condiciones.html" target="_blank">Términos y Condiciones Fm-cia</a>.</p>';

        $nombre=(isset($_GET['nombre'])?$_GET['nombre']:$retorno['Nombre']);
        $apellido1=(isset($_GET['apellido1'])?$_GET['apellido1']:$retorno['Apellido1']);
        $apellido2=(isset($_GET['apellido2'])?$_GET['apellido2']:$retorno['Apellido2']);
        $nombreUsuario=(isset($_GET['nombreUsuario'])?$_GET['nombreUsuario']:$_SESSION['usuario']);
        $contrasena1=(isset($_GET['contrasena1'])?$_GET['contrasena1']:$retorno['contrasena']);
        $contrasena2=(isset($_GET['contrasena2'])?$_GET['contrasena2']:$retorno['contrasena']);
        $email1=(isset($_GET['email1'])?$_GET['email1']:$retorno['CorreoElectronico']);
        $email2=(isset($_GET['email2'])?$_GET['email2']:$retorno['CorreoElectronico']);
        $fechanac=(isset($_GET['fechanac'])?$_GET['fechanac']: $retorno['Fechanac']);
        $promo= (isset($_GET['promo'])? $_GET['promo'] : $retorno['promo']);
        $boton=(isset($_GET['boton'])? $_GET['boton'] : 'no');

        $confirmar=(isset($_GET['confirm'])?$_GET['confirm']:'no');
        $elim= (isset($_GET['elim'])? $_GET['elim'] : 'no');

        
        if($elim=="Eliminar"){
            if(($confirmar=="CONFIRMAR") ||($confirmar=="confirmar")){ 
                if($correo!=null){
                    eliminarUsuario($con,$correo);

                    $tipo_user=2;
                    $_SESSION['tipo_usuario']= $tipo_user;

                    header('refresh:2;url=index.php');
                }
                else{echo'Error al encontrar el usuario a borrar.';}    
            }
            else{echo 'Debe confirmar que desea eliminar esta cuenta.';}
        }
        
        if($boton=='Guardar cambios'){  
            if(($nombre!='Nombre') && ($nombre!=null)){
                if(($apellido1!='Primer Apellido') && ($apellido1!=null)){
                    if(($apellido2!='Segundo Apellido') && ($apellido2!=null)){
                        if(($nombreUsuario!='Nombre de usuario') && ($nombreUsuario!=null)){
                            if(($contrasena1!=null) && ($contrasena1!='Contraseña')){
                                if($contrasena1==$contrasena2){
                                    if(($email1!=null) && ($email1!='correo@dominio.es')){
                                        if($email1==$email2){
                                            if($fechanac!=null){              
                                                
                                                modificar_perfil($con,$id,$nombre,$apellido1,$apellido2,$nombreUsuario,$contrasena1,$email1,$fechanac,$promo);

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
    }
}else
{
    echo '<p>Error al buscar el usuario, vuelva a iniciar sesión.</p>';
}
$con->close();
    ?>
</Section>
    <?php pie();?>
    
</body>

</html>
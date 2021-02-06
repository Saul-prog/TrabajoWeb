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
$tipo_user=(isset($_SESSION['tipo_usuario'])?$_SESSION['tipo_usuario']:2);
$user=(isset($_SESSION['usuario'])?$_SESSION['usuario']:2);
$con=conectar();
encabezado($tipo_user,$con);
$idarticulo=(isset($_GET['articulo'])?$_GET['articulo']:null);
if($idarticulo==null){
    echo '<article class="articulo">';
    echo   '<h2 class="articulo"No se ha encontrado el artículo buscado</h2>';
    echo '</article>';    
}
$peticion22=$con->prepare("SELECT * FROM articulopublicado WHERE ID_articulo LIKE ? ");
$peticion22->bind_param("i",$idarticulo);
$peticion22->execute();
$rs=$peticion22->get_result();

    if ($rs) {
        $fila= $rs->fetch_assoc();
        
        if($rs->num_rows<1){
        echo '<p>No hay artículos que coincidan con el identificador=', $idarticulo, '</p>';
        exit;
        }
        while (($fila !== false) && ($fila !== null)) {
            echo '<article class="articulo">';
            echo '<h2 class="articulo">'.$fila['Titulo'].'</h2>';
            echo '<p class="autor">Autor: '.$fila['autor'].'</p>';
            echo '<embed src="articulos/'.$fila['PDF'].'" type="application/pdf"/>';
            echo '</article> ';
            $fila= $rs->fetch_assoc();
        }
        $rs->free();
        
    }

    
	echo '<section class="comentario">';
    echo    '<h2 class="comentario">Comentarios</h2>';
    echo		'<article class="comentario">';
    ?>
    <form name="comentario" method="post">
         <label for="textarea"></label>
         
         <p><textarea name="comentario"cols="80" rows="5" id="textarea" required></textarea></p>
         
         <p><input type="submit" <?php if(isset($_GET['id_comentario'])){?> name="respuesta" <?php} else{?> name="comentar" <?php}?> value="Comentar"></p>
     </form>

 <?php
 
     if(isset($_POST['comentar'])){
         $peticion_com=$con->prepare("INSERT INTO comentarios (comentario,usuario,fecha,id_articulo) value (?,?,NOW(),?) ");
         $peticion_com->bind_param("ssi",$_POST['comentario'],$user,$idarticulo);
         if($peticion_com->execute()){
             header('refresh:0;url=articulo.php?articulo='.$idarticulo);
         }else{
             echo '<p>ERROR: '.$con->error.'</p>';
         }
     }
 
    
     if(isset($_POST['responder'])){
         $peticion_com=$con->prepare("INSERT INTO comentarios (comentario,usuario,fecha,id_articulo,respuesta) value (?,?,NOW(),?,?) ");
         $peticion_com->bind_param("ssi",$_POST['comentario'],$user,$idarticulo,$_GET['id_comentario']);
         if($peticion_com->execute()){
             header('refresh:0;url=articulo.php?articulo='.$idarticulo);
         }else{
             echo '<p>ERROR: '.$con->error.'</p>';
         }
     }
 echo '</article>';
 
 echo		'<article class="comentario">';

$comentarios=$con->query("SELECT * FROM comentarios WHERE respuesta LIKE '0' ORDER BY DESC");
        while($row=mysqli_fetch_array($comentarios){
            
            $usuario= $con->prepare("SELECT * FROM usuario WHERE NombreUsuario LIKE ?");
            $usuario->bind_param("s",$row['usuario']);


            if($peticion_com->execute()){
            $user_=mysqli_fetch_array($usuario);
            }else{
                echo '<p>ERROR: '.$con->error.'</p>';
            }
        }
 echo '</article>';

 echo '</section>';


     
     
    



pie()
?>
</body>
</html>
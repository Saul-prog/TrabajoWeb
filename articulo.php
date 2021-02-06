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
$user=(isset($_SESSION['usuario'])?$_SESSION['usuario']:null);
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

//SECCION DE COMENTARIOS
    echo '<section class="comentario">';
	echo	'<h2 class="comentario">Comentarios</h2>';
if($tipo_user!=2){
    echo '<article class="comentario">
            <form action="articulo.php?articulo='.$idarticulo.'" method="post">
                <textarea name="comentario" rows="5" cols="70" required></textarea><br>
                <input type="submit" name="comentar" value="Comentar">
            </form>
        </article>';
    $boton=(isset($_POST['comentar'])?$_POST['comentar']:null);
    if($boton=='Comentar'){
        
        if($user!=null){
            $inserta=$con->prepare("INSERT INTO comentarios (usuario,comentario,fecha,id_articulo) VALUES (?,?,NOW(),?)");
            $inserta->bind_param("sss",$user,$_POST['comentario'],$idarticulo);
            if($inserta->execute()){
               
            }else{
                echo '<p>ERROR: '.$con->error.'</p>';
            }
        }else{
            echo '<p>Usuario no reconocido, por favor reinicie sesión</p>';
        }
    }
}

$boton_eliminar=(isset($_POST['boton_eliminar'])?$_POST['boton_eliminar']:null);
if($boton_eliminar=='Eliminar'){
    $id_eliminar=(isset($_POST['commentario_eliminar'])?$_POST['commentario_eliminar']:NULL);
    if($id_eliminar!=NULL){
        $eliminar=$con->prepare("DELETE FROM comentarios WHERE id_comentario LIKE ? OR id_referencia LIKE ?");
        $eliminar->bind_param("ii",$id_eliminar,$id_eliminar);
        if($eliminar->execute()){
            echo 'Comentario Eliminado';
            
        }else{
            echo '<p>ERROR: '.$con->error.'</p>';
        }
    }
}
    $peticion=$con ->query("SELECT * FROM comentarios");
    echo '<article class="comentario">';
    while($fila=mysqli_fetch_array($peticion)){
        if($idarticulo==$fila['id_articulo']){
            
            if($fila['id_referencia']==NULL){
                echo '<h3 class="comentario">'.$fila['usuario'].'</h3><p>'.$fila['fecha'].'</p>';
                echo '<p class="comentario">'.$fila['comentario'].'</p>';
                if($tipo_user==1){
                echo '<details class="vacio2">
                <summary>Eliminar</summary>
				<h3 class="comentario">¿Está seguro de la eliminación?</h3>
                <form action="articulo.php?articulo='.$idarticulo.'" method="post">
                <input type="hidden" name="commentario_eliminar" value="'.$fila['id_comentario'].'">
				<input type="submit" name="boton_eliminar" value="Eliminar">
                </form>
			    </details>';
                }
                if($tipo_user==1||$tipo_user==0){
                    echo '<details class="vacio">
                <summary>Responder</summary>
                <h3 class="comentario">&nbsp;</h3>
                <form action="articulo.php?articulo='.$idarticulo.'" method="post">
                <textarea name="respuesta" rows="5" cols="70" required></textarea><br>
                <input type="submit" value="Enviar">
                </form>
                </details>';
                }

                $peticion_=$con->query("SELECT * FROM comentarios");
                while($fila_=mysqli_fetch_array($peticion_)){
                    if($fila['id_comentario']==$fila_['id_referencia']){
                        echo '<article class="respuesta">';
                        echo '<h3 class="respuesta">'.$fila_['usuario'].'</h3><p>'.$fila_['fecha'].'</p>';
                        echo '<p class="comentario">'.$fila_['comentario'].'</p>';
                        echo '<details class="vacio2">
                                <summary>Eliminar</summary>
                                <h3 class="comentario">¿Está seguro de la eliminación?</h3>
                                <form action="articulo.php?articulo='.$idarticulo.'" method="post">
                                <input type="hidden" name="commentario_eliminar" value="'.$fila_['id_comentario'].'">
                                <input type="submit" name="boton_eliminar" value="Eliminar">
                                </form>
                                </details>';
                        echo '</article>';

                    }
                }
                mysqli_data_seek($peticion_, 0);
            }
            
        }
    }
    echo '</article>';
    
    
     
    
    echo '</section>';


pie()
?>
</body>
</html>
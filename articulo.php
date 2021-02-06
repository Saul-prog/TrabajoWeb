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
echo '<article class="articulo">';
    if ($rs) {
        $fila= $rs->fetch_assoc();
        
        if($rs->num_rows<1){
        echo '<p>No hay artículos que coincidan con el identificador=', $idarticulo, '</p>';
        exit;
        }
        while (($fila !== false) && ($fila !== null)) {
            echo '<article class="articulo">';
            echo '<h2 class="articulo">'.$fila['Titulo'].'  ';
            if($tipo_user!=2){
                $fav=$con->prepare("SELECT * FROM favorito WHERE usuario LIKE ? AND id_articulo LIKE ?");
                $fav->bind_param("ss",$user,$idarticulo);
                
                
                if($fav->execute()){
                    
                    $resultado=$fav->get_result();
                    
                    $fila2=$resultado->fetch_assoc();
                    if($fila2['usuario']==$user){
                        if($fila2['id_articulo']==$idarticulo){
                            echo '<a href="articulo.php?articulo='.$idarticulo.'&favorito=pulsado"><img src="imagenes/Iconos/estrella-encendida.png" width="30" height="25"></a>';
                        }
                    }else{
                            echo '<a href="articulo.php?articulo='.$idarticulo.'&favorito=pulsado"><img src="imagenes/Iconos/Estrella-apagada.png" width="30" height="25"></a>';
                    }
                }
                
            }
            echo '</h2>';
            echo '<details class="articulo">';
            echo '<summary class="autor">Autor: '.$fila['autor'].'</summary>';
            echo '<p>'.$fila['biografia'].'</p></details>';
            echo '<embed src="articulos/'.$fila['PDF'].'" type="application/pdf"/>';

            
            $fila= $rs->fetch_assoc();
        }
        $rs->free();
        
    }
$favorito=(isset($_GET['favorito'])?$_GET['favorito']:null);
if($tipo_user!=2){
    if($favorito=='pulsado'){
        $fav2=$con->prepare("SELECT * FROM favorito WHERE usuario LIKE ? AND id_articulo LIKE ?");
        $fav2->bind_param("ss",$user,$idarticulo);   
        if($fav2->execute()){
            $resultado2=$fav2->get_result();
            $fila3=$resultado2->fetch_assoc();
            if($fila3['usuario']==$user){
                if($fila3['id_articulo']==$idarticulo){
                    $eliminarfav=$con->prepare("DELETE FROM favorito WHERE usuario LIKE ? AND id_articulo LIKE ?");
                    $eliminarfav->bind_param("ss",$user,$idarticulo);
                    if($eliminarfav->execute()){
                    }else{
                        echo '<p>ERROR: '.$con->error.'</p>';
                    }
                }
            }else{
                $agregarfav=$con->prepare("INSERT INTO favorito (usuario,id_articulo) VALUES (?,?)");
                $agregarfav->bind_param("si",$user,$idarticulo);
                if($agregarfav->execute()){

                }else{
                    echo '<p>ERROR: '.$con->error.'</p>';
                }
            }
        }
        header('refresh:0;url=articulo.php?articulo='.$idarticulo.'');
    }
}
    echo '</article> ';
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
$boton_responder=(isset($_POST['boton_responder'])?$_POST['boton_responder']:null);
if($boton_responder=='Responder'){
    $id_responder=(isset($_POST['commentario_responder'])?$_POST['commentario_responder']:NULL);
    $respuesta=(isset($_POST['respuesta'])?$_POST['respuesta']:NULL);
    if($id_responder!=NULL){
        $responder=$con->prepare("INSERT INTO comentarios (usuario,comentario,fecha,id_articulo,id_referencia) VALUES (?,?,NOW(),?,?)");
        $responder->bind_param("ssii",$user,$respuesta,$idarticulo,$id_responder);
        if($responder->execute()){
            
            
        }else{
            echo '<p>ERROR: '.$con->error.'</p>';
        }
    }
}
    $peticion=$con ->query("SELECT * FROM comentarios ORDER BY id_comentario DESC");
    $cantidad=$peticion->num_rows;
    
    echo '<article class="comentario">';
    if($cantidad>1){
        echo '<h2>Se el primero en comentar</h2>';
    }
    while($fila=mysqli_fetch_array($peticion)){
        if($idarticulo==$fila['id_articulo']){ 
            
            if($fila['id_referencia']==NULL){
                echo '<h3 class="comentario">'.$fila['usuario'].'</h3><p>'.$fila['fecha'].'</p>';
                echo '<p class="comentario">'.$fila['comentario'].'</p>';
                if($tipo_user==1||$tipo_user==0){
                    echo '<details class="vacio">
                <summary>Responder</summary>
                <h3 class="comentario">&nbsp;</h3>
                <form action="articulo.php?articulo='.$idarticulo.'" method="post">
                <input type="hidden" name="commentario_responder" value="'.$fila['id_comentario'].'">
                <textarea name="respuesta" rows="5" cols="70" required></textarea><br>
                <input type="submit" name="boton_responder" value="Responder">
                </form>
                </details>';
                }
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
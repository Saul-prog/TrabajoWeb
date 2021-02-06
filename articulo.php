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
	echo	'<h2 class="comentario">Comentarios</h2>';?>
    <form action="articulo.php" method="post">
    <textarea name="comentario" rows="5" cols="70" required></textarea>
    </form>





    <?php
    $peticion = $con -> query ("SELECT * FROM categorias");
    $peticion2 = $con -> query ("SELECT * FROM categorias");?>
    <nav class="navegacion">
            <ul class="menu"><?php
    while ($fila = mysqli_fetch_array($peticion)) {
        if($fila['subcategoria']==0){
            $cat=$fila['categoria'];
        echo '<li>|</li>
        <li><a href="tablon.php?buscar='.$cat.'">'.$cat.'</a>';?>
                    <ul class="submenu"><?php
                    while ($fila2 = mysqli_fetch_array($peticion2)) {
                        if($fila2['claveCategoria']==$cat){
                            $subcategoria=$fila2['categoria'];
                            echo '<li><a href="tablon.php?buscar='.$subcategoria.'">'.$subcategoria.'</a></li>';
                        }
                    }
                    mysqli_data_seek($peticion2, 0)?>
                    </ul></li>	
        <?php
        }
    }
    



 



     
     
    
    echo '</section>';


pie()
?>
</body>
</html>
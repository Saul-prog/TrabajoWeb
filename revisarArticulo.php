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

if($tipo_user!=1 || $user==null){
    header('refresh:0;url=index.php');
}
$con=conectar();
encabezado($tipo_user,$con);
$determinado=(isset($_POST['determinado'])?$_POST['determinado']:null);
$peque="";

if($determinado==null){
    $peticion=$con ->query("SELECT * FROM articulorevision ORDER BY ID_art_rev DESC LIMIT 1");
    $cantidad=$peticion->num_rows;
    if($cantidad<1){
    echo '<article class="articulo">';
    echo   '<h2 class="articulo">No hay artículos para su revisión</h2>';
    echo '</article>';    
    }else{
        while($fila=mysqli_fetch_array($peticion)){
            echo '<article class="articulo">';
            echo '<h2 class="articulo">'.$fila['Titulo'].'<br>  Identificador:' .$fila['ID_art_rev'].'</h2> ';
            echo '<details class="articulo">';
            echo '<summary class="autor">Autor: '.$fila['autor'].'</summary>';
            echo '<p>'.$fila['biografia'].'</p>';
            echo '<p>'.$fila['Observaciones'].'</p></details>';
            echo '<embed src="articulos/'.$fila['PDF'].'" type="application/pdf"/>';
            echo '</article>';
        }
    }
}else{
    $peticion=$con ->prepare("SELECT * FROM articulorevision WHERE ID_art_rev LIKE ? ");
    $peticion->bind_param("i",$determinado);
    if($peticion->execute()){
        $rs= $peticion->get_result();
        $fila=$rs->fetch_assoc();
        if($rs->num_rows!=1){
            echo '<article class="articulo">';
            echo '<h2 class="articulo">No se han encontrado resultados para esa búsqueda<h2>';
            echo '</article>';
            $peque="peque";
        }else {
       
                
                    echo '<article class="articulo">';
                    echo '<h2 class="articulo">'.$fila['Titulo'].'<br>  Identificador:' .$fila['ID_art_rev'].'</h2> ';
                    echo '<details class="articulo">';
                    echo '<summary class="autor">Autor: '.$fila['autor'].'</summary>';
                    echo '<p>'.$fila['Observaciones'].'</p></details>';
                    echo '<embed src="articulos/'.$fila['PDF'].'" type="application/pdf"/>';
                    echo '</article>';
                
            }
    }else{
        echo '<p>ERROR: '.$con->error.'</p>';
    }
    
}
?>
<article class="articulo">
<form action="revisarArticulo.php" method="post">
    <h3>Si desea buscar un artículo en concreto, inserte el identificador</h3>
    <input type="text" name="determinado">
    <input type="submit" value="Buscar">
</form>
</article>

<?php 
if($peque=="peque"){
    pie("peque");
}else{
    pie(); 
}
?>
</body>
</html>


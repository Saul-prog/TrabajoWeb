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
$buscar=(isset($_GET['buscar'])?$_GET['buscar']:null);
echo'<section class="margen">
    <h1>'.$buscar.'</h1>';

$por_pagina=4;

$pagina=(isset($_GET['pagina'])?$_GET['pagina']:1);
$empezar=($pagina-1)*$por_pagina;
//Se trae toda la base de datos
$peticion=$con->prepare("SELECT * FROM articulopublicado INNER JOIN favorito ON articulopublicado.ID_articulo = favorito.id_articulo WHERE favorito.usuario LIKE ?;");
$peticion->bind_param("s",$user);
$peticion->execute();
$rs=$peticion->get_result();
$total_reg=$rs->num_rows;
//Se cuentan todas las filas


if($total_reg<4){
    $por_pagina=$total_reg;
    
}
if($total_reg<1){
    echo '<article><h2>No hay articulos definidos en su lista de Favoritos</h2>
    <p>Añada algún artículo a su lista de favoritos</p></article>';
    exit;
}
//Se calcula el total de páginas que existen(ceil redondea al alza)
$total_pag=ceil($total_reg/$por_pagina);

//Se crea la consulta
$peticion2=$con->prepare("SELECT * FROM articulopublicado INNER JOIN favorito ON articulopublicado.ID_articulo = favorito.id_articulo WHERE favorito.usuario LIKE ? ORDER BY favorito.id_articulo DESC LIMIT ?,? ");
$peticion2->bind_param("sii",$user,$empezar,$por_pagina);
$peticion2->execute();
$rs=$peticion2->get_result();

if ($rs) {
    $fila= $rs->fetch_assoc();
    
    if($rs->num_rows<1){
      echo '<p>No hay artículos que coincidan con la Categoria=</p>';
      exit;
    }
      while (($fila !== false) && ($fila !== null)) {
        echo '<article><a href="articulo.php?articulo='.$fila['ID_articulo'].'">';
        echo '<h2>'.$fila['Titulo'].'</h2>';
        echo '<p>'.$fila['Resumen'].'</p>';
        echo '</article></a>';
       
        $fila= $rs->fetch_assoc();
      }
      $rs->free();
     
}

    echo '<center>| ';
    for ($i=1; $i<=$total_pag; $i++) {
        //En el bucle, muestra la paginación
        echo "<a href='tablon.php?pagina=".$i."&buscar=".$buscar."'>".$i."</a> | </center>";
    }; 

echo '</section>';
pie();
?>
</body>
</html>
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
$con=conectar();
encabezado($tipo_user,$con);
$buscar=(isset($_GET['buscar'])?$_GET['buscar']:null);
echo'<section class="margen">
    <h1>'.$buscar.'</h1>';

$por_pagina=4;

$pagina=(isset($_GET['pagina'])?$_GET['pagina']:1);
$empezar=($pagina-1)*$por_pagina;
//Se trae toda la base de datos
$peticion=$con->prepare("SELECT * FROM articulopublicado WHERE (Categoria LIKE ?) OR (subCategoria LIKE ?)");
$peticion->bind_param("ss",$buscar,$buscar);
$peticion->execute();
$rs=$peticion->get_result();
$total_reg=$rs->num_rows;
//Se cuentan todas las filas


if($total_reg<4){
    $por_pagina=$total_reg;
    
}
if($total_reg<1){
    echo '<article><h2>No hay articulos definidos en esta categoría</h2>
    <p>Por favor, pruebe con otra categoría</p></article>';
    exit;
}
//Se calcula el total de páginas que existen(ceil redondea al alza)
$total_pag=ceil($total_reg/$por_pagina);

//Se crea la consulta
$peticion2=$con->prepare("SELECT * FROM articulopublicado WHERE (Categoria LIKE ?) OR (subCategoria LIKE ?) ORDER BY ID_articulo DESC LIMIT ?,? ");
$peticion2->bind_param("ssii",$buscar,$buscar,$empezar,$por_pagina);
$peticion2->execute();
$rs=$peticion2->get_result();

if ($rs) {
    $fila= $rs->fetch_assoc();
    
    if($rs->num_rows<1){
      echo '<p>No hay artículos que coincidan con la Categoria=', $buscar, '</p>';
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
for ($i=1; $i<=$total_pag; $i++) {
	//En el bucle, muestra la paginación
	echo "<a href='tablon.php?pagina=".$i."&buscar=".$buscar."'>".$i."</a> | ";
}; 





echo '</section>';
pie();
?>
</body>
</html>
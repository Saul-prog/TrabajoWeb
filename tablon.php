<!DOCTYPE html>
<html lang="es">
    <head>
        <meta name="author" content= "Saúl Otero García" />
        <meta name="author" content= "Celia Torres Montero" />
        <meta name="description" content="" />
        <meta charset="utf-8">
        <title>Iniciación Saúl</title>
        <link rel="stylesheet" href="inicializador.css">
        <link rel="stylesheet" href="index.css">
    </head>
<body>
<?php
session_start();
include "funciones.php";
$tipo_user=(isset($_SESSION['tipo_usuario'])?$_SESSION['tipo_usuario']:2);¡
$con=conectar();
encabezado($tipo_user,$con);
$buscar=(isset($_GET['buscar'])?$_GET['buscar']:null);
echo'<section class="margen">
    <h1>Química</h1>';
echo $buscar;
$por_pagina=4;

$pagina=(isset($_GET['pagina'])?$_GET['pagina']:1);
$empezar=($pagina-1)*$por_pagina;
//Se trae toda la base de datos
$todo="SELECT * FROM articulopublicado";
//Se cuentan todas las filas
$total_reg=mysqli_num_rows($todo);
//Se calcula el total de páginas que existen(ceil redondea al alza)
$total_pag=ceil($total_reg/$por_pagina);
//Se crea la consulta
$peticion=mysqli_query("SELECT * FROM articulopublicado WHERE Categoria LIKE $buscar ORDER BY ID_articulo LIMIT $empezar,$por_pagina");
//Se muestra la consulta
while($fila= mysqli_fetch_array($peticion)){

}




echo '</section>'
pie();
?>
</body>
</html>
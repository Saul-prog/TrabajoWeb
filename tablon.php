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
    echo '<a href=""><article>';
    <h2>Where does it come from?</h2>
    <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

        The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>
    </article></a>
}




echo '</section>'
pie();
?>
</body>
</html>
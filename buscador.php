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
$por_pagina=4;
$tipo_user=(isset($_SESSION['tipo_usuario'])?$_SESSION['tipo_usuario']:2);
$con=conectar();
encabezado($tipo_user,$con);
$buscar=(isset($_GET['buscar'])?$_GET['buscar']:null);
$tipo_busqueda=(isset($_GET['tipo'])?$_GET['tipo']:null);
echo'<section class="margen">
    <h1>'.$buscar.'</h1>';

$buscar='%'.$buscar.'%';
if($tipo_busqueda=="Título"){
    $pagina=(isset($_GET['pagina'])?$_GET['pagina']:1);
    $empezar=($pagina-1)*$por_pagina;
    //Se trae toda la base de datos
    $peticion=$con->prepare("SELECT * FROM articulopublicado WHERE Titulo LIKE ?");
    $peticion->bind_param("s",$buscar);
    $peticion->execute();
    $rs=$peticion->get_result();
    $total_reg=$rs->num_rows;
    //Se cuentan todas las filas


    if($total_reg<4){
        $por_pagina=$total_reg;
        
    }
    if($total_reg<1){
        echo '<article><h2>No hay articulos definidos para esta búsqueda</h2>
        <p>Por favor, pruebe con otra BÚSQUEDA</p></article>';
        exit;
    }
    //Se calcula el total de páginas que existen(ceil redondea al alza)
    $total_pag=ceil($total_reg/$por_pagina);

    //Se crea la consulta
    $peticion22=$con->prepare("SELECT * FROM articulopublicado WHERE Titulo LIKE ? ORDER BY ID_articulo DESC LIMIT ?,? ");
    $peticion22->bind_param("sii",$buscar,$empezar,$por_pagina);
    $peticion22->execute();
    $rs=$peticion22->get_result();

        if ($rs) {
            $fila= $rs->fetch_assoc();
            
            if($rs->num_rows<1){
            echo '<p>No hay artículos que coincidan con el título=', $buscar, '</p>';
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
}

if($tipo_busqueda=="Contenido"){
    $pagina=(isset($_GET['pagina2'])?$_GET['pagina2']:1);
    $empezar=($pagina-1)*$por_pagina;
    //Se trae toda la base de datos
    
    $peticion1=$con->prepare("SELECT * FROM articulopublicado WHERE Resumen LIKE ?");
    $peticion1->bind_param("s",$buscar);
    $peticion1->execute();
    $rs1=$peticion1->get_result();
    $total_reg1=$rs1->num_rows;
    //Se cuentan todas las filas


    if($total_reg1<4){
        $por_pagina=$total_reg1;
        
    }
    if($total_reg1<1){
        echo '<article><h2>No hay articulos definidos en esta categoría</h2>
        <p>Por favor, pruebe con otra categoría</p></article>';
        exit;
    }
    //Se calcula el total de páginas que existen(ceil redondea al alza)
    $total_pag2=ceil($total_reg1/$por_pagina);

    //Se crea la consulta
    $peticion2=$con->prepare("SELECT * FROM articulopublicado WHERE Resumen LIKE ? ORDER BY ID_articulo DESC LIMIT ?,? ");
    $peticion2->bind_param("sii",$buscar,$empezar2,$por_pagina);
    $peticion2->execute();
    $rs2=$peticion2->get_result();

    if ($rs2) {
        $fila2= $rs2->fetch_assoc();
        
        if($rs2->num_rows<1){
        echo '<p>No hay artículos que coincidan con la Categoria=', $buscar, '</p>';
        exit;
        }
        while (($fila2 !== false) && ($fila2 !== null)) {
            echo '<article><a href="articulo.php?articulo='.$fila2['ID_articulo'].'">';
            echo '<h2>'.$fila2['Titulo'].'</h2>';
            echo '<p>'.$fila2['Resumen'].'</p>';
            echo '</article></a>';
        
            $fila2= $rs2->fetch_assoc();
        }
        $rs2->free();
        
    }
    for ($i=1; $i<=$total_pag2; $i++) {
        //En el bucle, muestra la paginación
        echo "<a href='tablon.php?pagina2=".$i."&buscar=".$buscar."'>".$i."</a> | ";
    }; 
}


if($tipo_busqueda=="Autor"){
    $pagina=(isset($_GET['pagina'])?$_GET['pagina']:1);
    $empezar=($pagina-1)*$por_pagina;
    //Se trae toda la base de datos
    $peticion=$con->prepare("SELECT * FROM articulopublicado WHERE autor LIKE ?");
    $peticion->bind_param("s",$buscar);
    $peticion->execute();
    $rs=$peticion->get_result();
    $total_reg=$rs->num_rows;
    //Se cuentan todas las filas


    if($total_reg<4){
        $por_pagina=$total_reg;
        
    }
    if($total_reg<1){
        echo '<article><h2>No hay articulos definidos para esta búsqueda</h2>
        <p>Por favor, pruebe con otra BÚSQUEDA</p></article>';
        exit;
    }
    //Se calcula el total de páginas que existen(ceil redondea al alza)
    $total_pag=ceil($total_reg/$por_pagina);

    //Se crea la consulta
    $peticion22=$con->prepare("SELECT * FROM articulopublicado WHERE autor LIKE ? ORDER BY ID_articulo DESC LIMIT ?,? ");
    $peticion22->bind_param("sii",$buscar,$empezar,$por_pagina);
    $peticion22->execute();
    $rs=$peticion22->get_result();

        if ($rs) {
            $fila= $rs->fetch_assoc();
            
            if($rs->num_rows<1){
            echo '<p>No hay artículos que coincidan con el autor=', $buscar, '</p>';
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
}



echo '</section>';
pie();
?>
</body>
</html>
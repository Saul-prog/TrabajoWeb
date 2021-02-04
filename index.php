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
$con=conectar();
$usuario=(isset($_SESSION['usuario'])?$_SESSION['usuario']:2);
encabezado($usuario,$con);

slider($con);
?>
<Section class="entero">
	<h2 class="no">&nbsp;</h2>
	<!--Lo que se va a mostrar-->
	<div class="slider">
	 <ul>
		<li><a href="articulo_ascii.html"><img src="imagenes/Fondos/codigo_difuminado.jpg" alt="Imagen de codigo"></a><p class="pie_foto">Una herramienta para verificar programas ANSI-C</p></li>
		</ul>
	</div>
	<!---->

</Section>




<?php
pie();
?>
</body>
</html>
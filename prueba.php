<?php
include "funciones.php";
$con=conectar();
encabezado(2,$con);
$contenedor='articulopublicado';
$peticion=$con->prepare("SELECT COUNT(*) FROM ?");
$peticion->bind_param("s",$contenedor);
$peticion->execute();
$resultado=$peticion->get_result();
echo $resultado;
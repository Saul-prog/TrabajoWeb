<?php
$busqueda='hola';
$busqueda.="%";
echo $busqueda;
echo '<p></p>';
$busqueda= "%".$busqueda."%";
echo $busqueda;
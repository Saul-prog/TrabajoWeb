<?php

function conectar(){
	$con =  mysqli_connect('localhost', 'root', '', 'FMCIA');
	
	if ($con) $con->set_charset( 'UTF8');
	if ($con->connect_error) {
	  printf("Falló la conexión: %s\n", $mysqli->connect_error);
	  exit();
	}
	  return $con;
	
}










function encabezado($administrador){
	if($administrador==2){
        ?>
        	<header>
		<a href="index.html">
			<img class="icono" src="imagenes/Iconos/fm_arriba.png" alt="Fm-cia"/>
		</a>

		<nav class="navegacion">
			<ul class="menu">
				<li><a href="biologia.html">Biología</a></li>

				<?php
				/*foreach categoria(acceso a table)
					if sub ==0  (acceso a tabla)
						escribir la categoria

					foreach (acceso a tabla)
						if sub ==1 (acceso a tabla)
							if clave==categoria (acceso a tabla)


				

				foreach categoria (acceso a tabla) x4*/
				?>
				<li>|</li>
				<li><a href="fisica.html">Física</a></li>
				<li>|</li>
				<li><a href="quimica.html">Química</a></li>
				<li>|</li>
				<li><a href="tecnologia.html">Tecnología</a>
					<ul class="submenu">
						<li><a href="informatica.html">Informática</a></li>
						<li><a href="robotica.html">Robótica</a></li>
						<li><a href="biotecnologia.html">Biotecnología</a></li>
					</ul>
			</ul>
		</nav>

		<!--Registro y Crear cuenta con los enlaces-->
		<article class="p1">
			<h2 class="no"><a href="registro.html">Crear cuenta</a>  |  <a href="inicio_sesion.html">Iniciar sesión</a></h2>		</article>
    </header>
        <?php
    }
    if($administrador==0){
        ?>
        <header>
		<a href="index_registrado.html">
			<img class="icono" src="imagenes/Iconos/fm_arriba.png" alt="Fm-cia"/>
		</a>

		<nav class="navegacion">
			<ul class="menu">
				<li><a href="biologia_registrado.html">Biología</a></li>
				<li>|</li>
				<li><a href="fisica_registrado.html">Física</a></li>
				<li>|</li>
				<li><a href="quimica_registrado.html">Química</a></li>
				<li>|</li>
				<li><a href="tecnologia_registrado.html">Tecnología</a>
					<ul class="submenu">
						<li><a href="informatica_registrado.html">Informática</a></li>
						<li><a href="robotica_registrado.html">Robótica</a></li>
						<li><a href="biotecnologia_registrado.html">Biotecnología</a></li>
                    </ul>
                <li>|</li>
				<li><a href="enviar_articulo.html">Enviar artículo</a></li>
			</ul>
		</nav>

		<!--Mi perfil y cerrar sesion lleva a la pagina inicial en vista no registrado-->
		<article class="p1">
			<h2 class="no"><a href="mi_perfil.html">Mi perfil</a>  |  <a href="../index.html">Cerrar sesión</a></h2>
        </article>
    </header>
    <?php
    }
    if($administrador==1){
        ?>
        <header>
		<a href="index_administrador.html">
			<img class="icono" src="imagenes/Iconos/fm_arriba.png" alt="Fm-cia"/>
		</a>

        <nav class="navegacion">

			<ul class="menu">
				<li><a href="biologia_administrador.html">Biología</a></li>
				<li>|</li>
				<li><a href="fisica_administrador.html">Física</a></li>
				<li>|</li>
				<li><a href="quimica_administrador.html">Química</a></li>
				<li>|</li>
				<li><a href="tecnologia_administrador.html">Tecnología</a>
					<ul class="submenu">
						<li><a href="informatica_administrador.html">Informática</a></li>
						<li><a href="robotica_administrador.html">Robótica</a></li>
						<li><a href="biotecnologia_administrador.html">Biotecnología</a></li>
                    </ul>
                <li>|</li>
				<li><a href="publicar_articulo.html">Publicar artículo</a></li>
				<li>|</li>
                <li><a href="eliminar_usuario.html">Eliminar usuario</a></li>
                <li>|</li>
				<li><a href="modificar_categorias.html">Modificar Categorías</a></li>
			</ul>
		</nav>

		<!--Mi perfil y cerrar sesion lleva a la pagina inicial en vista no registrado-->
		<article class="p1">
			<h2 class="no"><a href="mi_perfil.html">Mi perfil</a>  |  <a href="../index.html">Cerrar sesión</a></h2>
        </article>
    </header>
    <?php
    }
}




function nuevoUsuario($con,$nombre,$apellido1,$apellido2,$nombreUsuario,$contrasena1,$email1,$fechanac){
	$peticion=$con->prepare("INSERT INTO usuario (NombreUsuario,contrasena,Nombre,Apellido1,Apellido2,CorreoElectronico,Fechanac) VALUES (?,?,?,?,?,?,?)");
	
	$peticion->bind_param("sssssss",$nombreUsuario,$contrasena1,$nombre,$apellido1,$apellido2,$email1,$fechanac);

	if($peticion->execute()){
		echo '<p>Datos Creados</p>';
		$_SESSION['usuario']=1;
		header('refresh:1;url=index.php');
	}else{
		echo '<p>ERROR: '.$con->error.'</p>';
	}

}
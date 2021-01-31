<?php

function conectar(){
	$con =  mysqli_connect('localhost', 'root', '', 'fmcia');
	
	if ($con) $con->set_charset( 'UTF8');
	if ($con->connect_error) {
	  printf("Falló la conexión: %s\n", $mysqli->connect_error);
	  exit();
	}
	  return $con;
	
}

function pie(){
	?>
	<footer>
		<img src="imagenes/Iconos/fm_grande.png" alt="icono de la página"/>
		<p class="fot">SOBRE NOSOTROS</p>
		<p>Somos un portal de noticias científicas y tecnológicas. 
		Fm-cia fue fundada en el año <strong>2020</strong> con el objetivo de informar y entretener a las mentes más curiosas.</p>
		<p><strong class="fot">CURIOSIDAD:</strong> nuestro nombre viene del elemento químico número 100, el Fermio; por lo que vendría a significar: <strong>100-cia</strong>, o lo que es lo mismo, ciencia.</p>
	</footer>
	<?php
}

function encabezado($administrador){
	if($administrador==2){
        ?>
        	<header>
		<a href="index.php">
			<img class="icono" src="imagenes/Iconos/fm_arriba.png" alt="Fm-cia"/>
		</a>

		<nav class="navegacion">
			<ul class="menu">
				<li><a href="biologia.php">Biología</a></li>

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
				<li><a href="fisica.php">Física</a></li>
				<li>|</li>
				<li><a href="quimica.php">Química</a></li>
				<li>|</li>
				<li><a href="tecnologia.php">Tecnología</a>
					<ul class="submenu">
						<li><a href="informatica.php">Informática</a></li>
						<li><a href="robotica.php">Robótica</a></li>
						<li><a href="biotecnologia.php">Biotecnología</a></li>
					</ul>
			</ul>
		</nav>

		<!--Registro y Crear cuenta con los enlaces-->
		<article class="p1">
			<h2 class="no"><a href="registro.php">Crear cuenta</a>  |  <a href="inicio_sesion.php">Iniciar sesión</a></h2>		</article>
    </header>
        <?php
    }
    if($administrador==0){
        ?>
        <header>
		<a href="index_registrado.php">
			<img class="icono" src="imagenes/Iconos/fm_arriba.png" alt="Fm-cia"/>
		</a>

		<nav class="navegacion">
			<ul class="menu">
				<li><a href="biologia_registrado.php">Biología</a></li>
				<li>|</li>
				<li><a href="fisica_registrado.php">Física</a></li>
				<li>|</li>
				<li><a href="quimica_registrado.php">Química</a></li>
				<li>|</li>
				<li><a href="tecnologia_registrado.php">Tecnología</a>
					<ul class="submenu">
						<li><a href="informatica_registrado.php">Informática</a></li>
						<li><a href="robotica_registrado.php">Robótica</a></li>
						<li><a href="biotecnologia_registrado.php">Biotecnología</a></li>
                    </ul>
                <li>|</li>
				<li><a href="enviarArticulo.php">Enviar artículo</a></li>
			</ul>
		</nav>

		<!--Mi perfil y cerrar sesion lleva a la pagina inicial en vista no registrado-->
		<article class="p1">
			<h2 class="no"><a href="mi_perfil.php">Mi perfil</a>  |  <a href="../index.php">Cerrar sesión</a></h2>
        </article>
    </header>
    <?php
    }
    if($administrador==1){
        ?>
        <header>
		<a href="index_administrador.php">
			<img class="icono" src="imagenes/Iconos/fm_arriba.png" alt="Fm-cia"/>
		</a>

        <nav class="navegacion">

			<ul class="menu">
				<li><a href="biologia_administrador.php">Biología</a></li>
				<li>|</li>
				<li><a href="fisica_administrador.php">Física</a></li>
				<li>|</li>
				<li><a href="quimica_administrador.php">Química</a></li>
				<li>|</li>
				<li><a href="tecnologia_administrador.php">Tecnología</a>
					<ul class="submenu">
						<li><a href="informatica_administrador.php">Informática</a></li>
						<li><a href="robotica_administrador.php">Robótica</a></li>
						<li><a href="biotecnologia_administrador.php">Biotecnología</a></li>
                    </ul>
                <li>|</li>
				<li><a href="publicar_articulo.php">Publicar artículo</a></li>
				<li>|</li>
                <li><a href="eliminar_usuario.php">Eliminar usuario</a></li>
                <li>|</li>
				<li><a href="modificar_categorias.php">Modificar Categorías</a></li>
			</ul>
		</nav>

		<!--Mi perfil y cerrar sesion lleva a la pagina inicial en vista no registrado-->
		<article class="p1">
			<h2 class="no"><a href="mi_perfil.php">Mi perfil</a>  |  <a href="../index.php">Cerrar sesión</a></h2>
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


function formularioEnviarAr($error){
	?>
	<section class="comentario">
  		<h2 class="comentario">Enviar artículo</h2>
        <article class="comentario">
            <form action="subido.php" method="post" enctype="multipart/form-data">
                <h3 class="comentario">&nbsp;</h3>
                <p>Título: <input type="text" name="titulo" placeholder="Titulo"></p>
                <p>Artículo u observaciones: <input class="comentario" type="text" name="observaciones" placeholder="Artículo a enviar">
                <p>Resumen: <input class="comentario" type="text" name="resumen" placeholder="Resumen">
				
				<p class="guardar"><input type="file" name="archivo"></p>
				<p class="guardar"><input type="submit" name="enviarAr" value="Enviar"></p>
				<p><?php echo $error;?></p>
            </form>
		</article>
	</section>
	<?php
}
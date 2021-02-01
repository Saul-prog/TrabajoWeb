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
	if($administrador==2){ //no registrado
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
    if($administrador==0){ //registrado
        ?>
        <header>
		<a href="index.php">
			<img class="icono" src="imagenes/Iconos/fm_arriba.png" alt="Fm-cia"/>
		</a>

		<nav class="navegacion">
			<ul class="menu">
				<li><a href="biologia.php">Biología</a></li>
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
    if($administrador==1){ //administrador
        ?>
        <header>
		<a href="index.php">
			<img class="icono" src="imagenes/Iconos/fm_arriba.png" alt="Fm-cia"/>
		</a>

        <nav class="navegacion">

			<ul class="menu">
				<li><a href="biologia.php">Biología</a></li>
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
                <li>|</li>
				<li><a href="publicar.php">Publicar artículo</a></li>
				<li>|</li>
                <li><a href="eliminar.php">Eliminar usuario</a></li>
                <li>|</li>
				<li><a href="modificar.php">Modificar Categorías</a></li>
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

function iniciarSesion($con,$contrasena,$email){
	$peticion=$con->prepare("SELECT * FROM usuario WHERE CorreoElectronico LIKE ?");

	$peticion->bind_param("s",$email);

	if($peticion->execute()){
		$rs= $peticion->get_result();
		if($rs)
		{
			$fila= $rs->fetch_assoc();
	
			if($fila['contrasena']==$contrasena)
			{
				$autor= $fila['Nombre'].' '.$fila['Apellido1'].' '.$fila['Apellido2'];

				$_SESSION['autor']= $autor;

				echo 'Bienvenido de nuevo, '.$_SESSION['autor'];

				$tipo_user= $fila['administrador'];
				
				$_SESSION['tipo_usuario']=$tipo_user;

				$user= $fila['NombreUsuario'];
				
				$_SESSION['usuario']=$user;
			}
		}
	}else{
		echo '<p>ERROR: '.$con->error.'</p>';
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
function nuevoArtRevision($con,$autor,$titulo,$resumen,$observaciones,$PDF){
	$peticion=$con->prepare("INSERT INTO articulorevision (autor,Titulo,Observaciones,Resumen,PDF) VALUES (?,?,?,?,?)");
	
	$peticion->bind_param("sssss",$autor,$titulo,$observaciones,$resumen,$PDF);
	
	if($peticion->execute()){
		echo '<p>Datos Creados</p>';
		
	}else{
		echo '<p>ERROR: '.$con->error.'</p>';
	}
}

function formularioEnviarAr($error){
	?>
	
            <form action="enviarArticulo.php" method="post" enctype="multipart/form-data">
                <h3 class="comentario">&nbsp;</h3>
                <p>Título: <input type="text"  name="titulo" placeholder="Titulo"></p>
				<p>Artículo u observaciones: <br><textarea name="observaciones" rows="5" cols="60">Observaciones sobre el artículo.</textarea></p>
                <p>Resumen:<br><textarea name="resumen" rows="5" cols="60">Resumen o abstract.</textarea>	</p>			
				<p class="guardar"><input type="file" name="archivo"></p>
				<p class="guardar"><input type="submit" name="enviarAr" value="Enviar"></p>
				<p><?php echo $error;?></p>
            </form>
	
	<?php
}
function desplegableCat($con){
	?>
	<select>
        
        <?php
          $peticion = $con -> query ("SELECT * FROM categorias");
         	while ($fila = mysqli_fetch_array($peticion)) {
			  	if($fila['subcategoria']==0){
            		echo '<option name="categoria" value="'.$fila['categoria'].'">'.$fila['categoria'].'</option>';
			  	}
			}
        ?>
	  </select>
<?php	
}
function desplegableSubCat($con){
	?>
	<select>
        <option name="categoria" value="">Ninguna</option>
        <?php
          $peticion = $con -> query ("SELECT * FROM categorias");
         	while ($fila = mysqli_fetch_array($peticion)) {
			  	if($fila['subcategoria']==1){
            		echo '<option name="subcategoria" value="'.$fila['categoria'].'">'.$fila['categoria'].'</option>';
			  	}
			}
        ?>
	  </select>
<?php	
}

function existeArt($con,$id_art){
	$peticion = $con -> query ("SELECT * FROM articulorevision");
	while ($fila = mysqli_fetch_array($peticion)) {
		if($fila['ID_art_rev']==$id_art){
			return $fila;
		}
	  }
	
		echo '<p>Articulo no encontrado</p>';
		return false;
	
	
}
function subirImagen($nombre,$guardar){
 
	if(!file_exists('imagenes')){
		mkdir('imagenes',0777,true);
		if(file_exists('imagenes')){
			if(move_uploaded_file($guardar,'imagenes/'.$nombre)){
				echo "La imagen se ha guardado correctamente";
				
				
			}else{
				echo "La imagen no se ha guardado correctamente";
				
			}
		}
	}else{
		if(move_uploaded_file($guardar,'imagenes/'.$nombre)){
			echo"La imagen guardado correctamente";

			
		}else{
			echo "La imagen no se ha guardado correctamente";
			
		}
	}
}
function publicar($con,$fila){
	
}
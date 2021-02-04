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
	<footer class="peque">
		<img src="imagenes/Iconos/fm_grande.png" alt="icono de la página"/>
		<p class="fot">SOBRE NOSOTROS</p>
		<p>Somos un portal de noticias científicas y tecnológicas. 
		Fm-cia fue fundada en el año <strong>2020</strong> con el objetivo de informar y entretener a las mentes más curiosas.</p>
		<p><strong class="fot">CURIOSIDAD:</strong> nuestro nombre viene del elemento químico número 100, el Fermio; por lo que vendría a significar: <strong>100-cia</strong>, o lo que es lo mismo, ciencia.</p>
	</footer>
	<?php
}

function desplegables($con){
	$peticion = $con -> query ("SELECT * FROM categorias");
	$peticion2 = $con -> query ("SELECT * FROM categorias");?>
	<nav class="navegacion">
			<ul class="menu"><?php
	while ($fila = mysqli_fetch_array($peticion)) {
		if($fila['subcategoria']==0){
			$cat=$fila['categoria'];
		echo '<li><a href="tablon.php?buscar='.$cat.'">'.$cat.'</a>';?>
					<ul class="submenu"><?php
					while ($fila2 = mysqli_fetch_array($peticion2)) {
						if($fila2['claveCategoria']==$cat){
							$subcategoria=$fila2['categoria'];
							echo '<li><a href="tablon.php?buscar='.$subcategoria.'">'.$subcategoria.'</a></li>';
						}
					}
					mysqli_data_seek($peticion2, 0)?>
					</ul></li>
			<li>|</li>
			
		<?php
		}
	  }
	  ?>
	  	</ul>	
	</nav>
	<?php
}

function encabezado($administrador,$con){
        ?>
        	<header>
		<a href="index.php">
			<img class="icono" src="imagenes/Iconos/fm_arriba.png" alt="Fm-cia"/>
		</a>
		<?php 
		$peticion = $con -> query ("SELECT * FROM categorias");
		$peticion2 = $con -> query ("SELECT * FROM categorias");?>
		<nav class="navegacion">
				<ul class="menu"><?php
		while ($fila = mysqli_fetch_array($peticion)) {
			if($fila['subcategoria']==0){
				$cat=$fila['categoria'];
			echo '<li><a href="tablon.php?buscar='.$cat.'">'.$cat.'</a>';?>
						<ul class="submenu"><?php
						while ($fila2 = mysqli_fetch_array($peticion2)) {
							if($fila2['claveCategoria']==$cat){
								$subcategoria=$fila2['categoria'];
								echo '<li><a href="tablon.php?buscar='.$subcategoria.'">'.$subcategoria.'</a></li>';
							}
						}
						mysqli_data_seek($peticion2, 0)?>
						</ul></li>
						<li>|</li>
			<?php
			}
		}
		if($administrador==0){
			?>
				<li><a href="enviarArticulo.php">Enviar artículo</a></li>
		<?php
		}
		if($administrador==1){
			?>
				
				<li><a href="publicarArticulo.php">Publicar artículo</a></li>
				<li>|</li>
                <li><a href="eliminar.php">Eliminar usuario</a></li>
                <li>|</li>
				<li><a href="gestionCategorias.php">Modificar Categorías</a></li>
		<?php	
		}
		?>
			</ul>	
		</nav>
		<?php
	if($administrador==0 || $administrador==1){
		?>
		<article class="p1">
			<h2 class="no"><a href="mi_perfil.php">Mi perfil</a>  |  <a href="cerrar_sesion.php">Cerrar sesión</a></h2>
		</article>
		<?php
	}
	//Registro y Crear cuenta con los enlaces
	if($administrador==2){?>
		
		<article class="p1">
			<h2 class="no"><a href="registro.php">Crear cuenta</a>  |  <a href="inicio_sesion.php">Iniciar sesión</a></h2>
		</article><?php
	}?>
    </header>
        <?php
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
				header('refresh:2;url=mi_perfil.php');
			}
		}
	}else{
		echo '<p>ERROR: '.$con->error.'</p>';
	}
}

function nuevoUsuario($con,$nombre,$apellido1,$apellido2,$nombreUsuario,$contrasena1,$email1,$fechanac,$promo){
	$peticion=$con->prepare("INSERT INTO usuario (NombreUsuario,contrasena,Nombre,Apellido1,Apellido2,CorreoElectronico,Fechanac,promo) VALUES (?,?,?,?,?,?,?,?)");
	
	$peticion->bind_param("sssssssi",$nombreUsuario,$contrasena1,$nombre,$apellido1,$apellido2,$email1,$fechanac,$promo);

	if($peticion->execute()){
		echo '<p>Se ha creado su cuenta correctamente, '.$nombreUsuario.'</p>';

		$_SESSION['usuario']=1;
		header('refresh:2;url=inicio_sesion.php');
	}else{
		echo '<p>ERROR: '.$con->error.'</p>';
	}

}

function perfil($con,$nombreUsuario){
	$consulta= "SELECT * FROM articulos WHERE id_articulo =". $nombreUsuario .";";
        
        $resultado= mysqli_query($con, $consulta);
        $fila= mysqli_fetch_array($resultado);
        $num_filas= mysqli_num_rows($resultado);
        if(($num_filas != 0) && ($num_filas != null))
        {
            return $fila;
		}
		else
		{
			echo "<br><br>No se han encontrado datos.";
			return null;
		}
}
function modificar_perfil($conect, $nombreUsuario, $referencia, $descripcion, $precio, $iva, $notas)
{

	$consulta=$conect->prepare("UPDATE articulos SET referencia=?, texto=?,precio=?,iva=?,notas=? WHERE id_articulo=?;");
	$consulta->bind_param("ssiisi",$referencia,$descripcion,$precio,$iva,$notas,$id);
	if ($consulta->execute() ) 
	{
		echo "<br><br>Se ha modificado el artículo $referencia correctamente.";
	}
	else
	{
		echo "<br><br>ERROR: No se ha podido modificar correctamente el artículo. $conect->error.";
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
	<select name="categoria" value="">
        
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
	$peticion = $con -> prepare ("SELECT * FROM articulorevision WHERE ID_art_rev LIKE ? ");
	$peticion->bind_param("i",$id_art);
	
		if($peticion->execute()){
			$rs= $peticion->get_result();
			if ($rs) {
					$fila= $rs->fetch_assoc();
					$rs->free();
					return $fila;}
		}
	  
	
		echo '<p>Articulo no encontrado</p>';
		return false;
	
	
}

function subirImagen($nombre,$guardar){
 
	if(!file_exists('imagenes/fondos')){
		mkdir('imagenes',0777,true);
		mkdir('imagenes/fondos',0777,true);
		if(file_exists('imagenes/fondos/')){
			if(move_uploaded_file($guardar,'imagenes/fondos/'.$nombre)){
				
				$vale='ok';
				return $vale;
				
			}else{
				echo "La imagen no se ha guardado correctamente";
				$vale='nook';
				return $vale;
			}
		}
	}else{
		if(move_uploaded_file($guardar,'imagenes/fondos/'.$nombre)){
			
			$vale='ok';
			return $vale;
			
		}else{
			echo "La imagen no se ha guardado correctamente";
			$vale='nook';
			return $vale;
		}
	}
}

function publicar($con,$fila,$categoria,$subCategoria,$imagen){
	$peticion=$con->prepare("INSERT INTO articulopublicado (autor,Titulo,Observaciones,Resumen,PDF,Categoria,subCategoria,imagen) VALUES (?,?,?,?,?,?,?,?)");
	
	$peticion->bind_param("ssssssss",$fila['autor'],$fila['Titulo'],$fila['Observaciones'],$fila['Resumen'],$fila['PDF'],$categoria,$subCategoria,$imagen);
	
	if($peticion->execute()){
		echo '<p>Datos Creados</p>';
		
	}else{
		echo '<p>ERROR: '.$con->error.'</p>';
	}
}

/**********************************************
 * Al introducir la base de datos, la contraseña pedida por pantalla y el usuario que la pide
 * se comprueba que es su contraseña
 * 
 * @param
 * $con: 		Base de datos
 * $contrasena: La contraseña introducida por el usuario
 * $usuario:    El usuario que introduce la contraseña
 * 
 * @return
 * true:  si la contraseña es la correcta
 * false: si al contraseña no es la correcta
 * 
 */
function comprobarContrasena($con,$contrasena,$nombreUsuario){
	
	$peticion = $con -> prepare ("SELECT * FROM usuario WHERE NombreUsuario LIKE (?)");
	$peticion->bind_param("s",$nombreUsuario);
	if($peticion->execute()){
		$rs= $peticion->get_result();
  		if ($rs) {
				$fila= $rs->fetch_assoc();
				
				if($fila['contrasena']==$contrasena){
					$rs->free();
					return true;
				}
				$rs->free();
		  }
		 
	}
	return false;
		
	
}

function crearCategoria($con,$nombre){
	$peticion=$con->prepare("INSERT INTO categorias(categoria,subcategoria) VALUES  (?,0)");

	$peticion->bind_param("s", $nombre);

	if($peticion->execute()){
		echo '<p>Categoría Creada</p>';
		
	}else{
		echo '<p>ERROR: '.$con->error.'</p>';
	}
}

function crearSubCategoria($con,$nombre,$padre){
	$peticion=$con->prepare("INSERT INTO categorias(categoria,subcategoria,claveCategoria) VALUES  (?,1,?)");

	$peticion->bind_param("ss", $nombre,$padre);

	if($peticion->execute()){
		echo '<p>Subcategoría Creada</p>';
		
	}else{
		echo '<p>ERROR: '.$con->error.'</p>';
	}
}

function eliminarCategoria($con,$nombreElm){
	$peticion=$con->prepare("DELETE FROM categorias WHERE categoria LIKE ?");
	$peticion->bind_param("s",$nombreElm);
	if($peticion->execute()){
		echo '<p>Categoría Eliminada</p>';
		
	}else{
		echo '<p>ERROR: '.$con->error.'</p>';
	}
}

function slider($con){
	$peticion=$con->query("SELECT * FROM articulopublicado ORDER BY ID_articulo DESC LIMIT 0,4 ");
	echo '<Section class="entero">';
	echo '<h2 class="no">&nbsp;</h2>';
	echo '<div class="slider">';
			while ($fila = mysqli_fetch_array($peticion)){
				echo '<ul>';
				echo '<li><a href="articulo.php?articulo='.$fila['ID_articulo'].'"><img src="imagenes/fondos/'.$fila['imagen'].'" alt="Imagen demostrativa"></a><p class="pie_foto">'.$fila['Titulo'].'</p></li>';
				echo '</ul>';		
			}
			echo '</div>';
			echo '</Section>';
}



<html>
	<head>
		<title>Prueba Api</title>
		<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="Enrique Escudero">
		<link rel=StyleSheet href="estilos.css" type="text/css" media=screen>
	</head>
	<body>
		<?php		
			include_once 'funciones.php';
			session_start();
			if (!isset($_POST['Aceptar'])&&!isset($_POST['Consultando'])&&!isset($_POST['Modificando'])&&!isset($_POST['Salir'])&&!isset($_POST['Consultar1'])&&!isset($_POST['Marcadas'])&&!isset($_POST['Volver'])&&!isset($_POST['Crear'])&&!isset($_POST['Creando'])&&!isset($_POST['Consultar1'])&&!isset($_POST['Consultar'])&&!isset($_POST['Marcar'])&&!isset($_POST['SoloMarcadas'])){
		?> 								
		  <form id="formu" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
				<label for="nombre">Nombre</label>
					<input type="text" name="nombre">
					<br><br>
				<label for="clave">Clave</label>
					<input type="text" name="clave">
					<br><br>
				<input type="submit" value="Aceptar" name="Aceptar">
			</form>
		<?php
			}
			else{
				if (isset($_POST['Aceptar'])||isset($_POST['Volver'])){
					if(isset($_POST['nombre'])){
						$_SESSION["nombre"] = filtrado($_POST['nombre']);
						$_SESSION["clave"] = filtrado($_POST['clave']);
					}
					$acceso=new Conectar($_SESSION["nombre"], $_SESSION["clave"]);
					$acceso->opciones();
				}
				if (isset($_POST['Marcar'])){
					$acceso=new Conectar($_SESSION["nombre"], $_SESSION["clave"]);
					$datos=$acceso->marcar();
				}
				if(isset($_POST['Modificando'])){
					$id = $_POST['notaMarca'];
					$favorita = $_POST['favoritaMarca'];
					
					$acceso=new Conectar($_SESSION["nombre"], $_SESSION["clave"]);
					$acceso->dame_marcar($id, $favorita);
					echo "Nota marcada correctamente";
					$acceso->volver();
				}
				if (isset($_POST['Crear'])){
					$acceso=new Conectar($_SESSION["nombre"], $_SESSION["clave"]);
					$acceso->crear_nota();
				}
				if(isset($_POST['Creando'])){
					$nota = $_POST['nota'];
					$favorita = $_POST['favorita'];
					$acceso=new Conectar($_SESSION["nombre"], $_SESSION["clave"]);
					$acceso->dame_crear($nota, $favorita);
					$acceso->volver();	
				}
				if(isset($_POST['Consultar'])){
					$acceso=new Conectar($_SESSION["nombre"], $_SESSION["clave"]);
					$acceso->consultar();
					$acceso->volver();
				}
				if(isset($_POST['Consultar1'])){
					$acceso=new Conectar($_SESSION["nombre"], $_SESSION["clave"]);
					$acceso->consultando();
				}
				if(isset($_POST['Consultando'])){
					$id= $_POST['id'];
					$acceso=new Conectar($_SESSION["nombre"], $_SESSION["clave"]);
					$acceso->consultarUna($id);
					$acceso->volver();
				}
				if(isset($_POST['Marcadas'])){
					$acceso=new Conectar($_SESSION["nombre"], $_SESSION["clave"]);
					$acceso->consultarMarcadas();
					$acceso->volver();
				}
				if(isset($_POST['Salir'])){
					session_destroy();
					session_unset();
					echo "Hasta pronto";
					header("Refresh: 2; URL=trabajo.php");
				}
			}
		?>
	</body>
</html>
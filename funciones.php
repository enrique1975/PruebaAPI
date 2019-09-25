<?php
	function filtrado ($datos){
		$datos = trim($datos);
		$datos = stripslashes($datos);	
		$datos = htmlspecialchars($datos);
		return $datos;
	}
	class Conectar{
		private $conexion;
		private $notas = "notas";
			
		public function __construct($nombre, $clave){
			try {
				$red = "mysql:host=localhost;dbname=trabajo";
				$this->conexion = new PDO($red, $nombre, $clave);
				$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} 
			catch (PDOException $e){
				//echo $e->getMessage();
				echo "Usuario no registrado";
				header("Refresh: 2; URL=trabajo.php");
				exit();
			}
		}
		public function opciones(){
			echo "<form id='formu' action='trabajo.php' method='POST'>
					<input type='submit' class='botones' value='Crear nota' name='Crear'>
					<input type='submit' class='botones' value='Consultar notas' name='Consultar'>
					<input type='submit' class='botones' value='Consultar 1 nota' name='Consultar1'>
					<input type='submit' class='botones' value='Marcar 1 nota' name='Marcar'>
					<input type='submit' class='botones' value='Ver solo marcadas' name='Marcadas'>
					<input type='submit' class='botones' value='Salir' name='Salir'>
				</form>";
		}
		public function volver(){
			echo "<br><form id='vuelve' action='trabajo.php' method='POST'>
					<input id='volver' class='botones' type='submit' value='Volver' name='Volver'>
				</form>";
		
		}
		public function marcar(){
			echo "<form id='formu' action='trabajo.php' method='POST'>Numero de nota a modificar:<br>
					<input id='texto' type='text' name='notaMarca'><br>
					Favorita
					<input type='radio' name='favoritaMarca' value='1' checked> Si
					<input type='radio' name='favoritaMarca' value='0'> No<br>
					<input type='submit' class='botones' value='Modificar' name='Modificando'>
				</form>";
		}
		public function dame_marcar($id, $favorita){
			$consulta = $this->conexion->prepare("update notas SET favorita=? where id=$id");
			$consulta->bindParam(1, $favorita);
			$consulta->execute();
		}
		public function consultarUna($id){
			$consulta = $this->conexion->prepare("SELECT * FROM notas where id= ?");
			$consulta->bindParam(1, $id,PDO::PARAM_STR);
			$consulta->execute();
			$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
			$numero = count($resultado);
			if($numero!=0){
				echo "<table><tr><th>ID</th><th>NOTA</th><th>FAVORITA</th></tr>";
				foreach($resultado as $datos){
					echo "<tr><td>".$datos['id']."</td>";
					echo "<td>".$datos['nota']."</td>";
					
					if ($datos['favorita']==0){$datos['favorita']="No";}
					else{$datos['favorita']="Si";}
					echo "<td>".$datos['favorita'] . "</td></tr>";
				}
				echo "</table>";
			}
			else{
				echo"Sin registros";
			}
		}
		public function consultando(){
			echo "<form id='formu' action='trabajo.php' method='POST'>Numero de nota:<br>
					<input id='texto' type='text' name='id'><br><br>
					<input type='submit' class='botones' value='Consultar' name='Consultando'>
				</form>";
		}
		public function consultar(){
			$consulta = $this->conexion->prepare("SELECT * FROM notas");
			$consulta->execute();
			$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
			echo "<table><tr><th>ID</th><th>NOTA</th><th>FAVORITA</th></tr>";
			foreach($resultado as $datos){
				echo "<tr><td>".$datos['id']."</td>";
				echo "<td>".$datos['nota']."</td>";
				
				if ($datos['favorita']==0){$datos['favorita']="No";}
				else{$datos['favorita']="Si";}
				echo "<td>".$datos['favorita'] . "</td></tr>";
			}
			echo "</table>";
		}
		public function consultarMarcadas(){
			$consulta = $this->conexion->prepare("SELECT * FROM notas where favorita=1");
			$consulta->execute();
			$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
			echo "<table><tr><th>ID</th><th>NOTA</th><th>FAVORITA</th></tr>";
			foreach($resultado as $datos){
				echo "<tr><td>".$datos['id']."</td>";
				echo "<td>".$datos['nota']."</td>";
				
				if ($datos['favorita']==0){$datos['favorita']="No";}
				else{$datos['favorita']="Si";}
				echo "<td>".$datos['favorita'] . "</td></tr>";
			}
			echo "</table>";
		}
		public function crear_nota(){
			echo "<form id='formu' action='trabajo.php' method='POST'>Crear nota:<br>
					<input id='texto' type='text' name='nota'><br><br>Favorita
					<input type='radio' name='favorita' value='1' checked> Si
					<input type='radio' name='favorita' value='0'> No<br>
					<input type='submit' class='botones' value='Crear' name='Creando'>
				</form>";
		}
		public function dame_crear($nota, $favorita){
			$consulta = $this->conexion->prepare("SELECT max(ID) FROM notas");
			$consulta->execute();
			$mayor = $consulta->fetchColumn();
			$mayor = $mayor + 1;
			
			$consulta1 = $this->conexion->prepare("insert into notas (id, nota, favorita) VALUES (?, ?, ?)");
			
			
			$consulta1->bindParam(1, $mayor);
			$consulta1->bindParam(2, $nota);
			$consulta1->bindParam(3, $favorita);
			
			$consulta1->execute();
			echo "Nota creada correctamente";
		}
	}
	

?>
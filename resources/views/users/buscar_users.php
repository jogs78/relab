<?php 
	$servername = "127.0.0.1";
    $username = "usuariolab";
  	$password = "contralab";
  	$dbname = "labisc";

	$mysqli = mysqli_connect($servername, $username, $password, $dbname);

	if(mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

	$salida = "";
	$query = "SELECT * FROM users ORDER by id";

	if (isset($_POST['consulta'])) {
		$q = $mysqli->real_escape_string($_POST['consulta']);
		$query = "SELECT id, nombre, apellido, telefono, tipo_usuario from users where id Like '%".$q."%' OR  nombre LIKE '%".$q."%' OR apellido LIKE '%".$q."%' OR tipo_usuario LIKE '%".$q."%'";
	}

	if (!$resultado = mysqli_query($mysqli,$query)){

  		echo("Error description: " . mysqli_error($mysqli));

  	}else{

	  	if ($resultado->num_rows > 0) {

			$salida.= "<table border=1 class='tabla-datos'>
					<thead>
						<tr>
							<th>Id</th>
							<th>Nombre</th>
							<th>Precio</th>
							<th>Descripcion</th>
							<th>Stock</th>
						</tr>
					</thead>
					<tbody>";

			while ($fila = $resultado->fetch_assoc()) {

				$salida.= "<tr>
							<td>".$fila['id']."</td>
							<td>".$fila['nombre']."</td>
							<td>".$fila['apellido']."</td>
							<td>".$fila['telefono']."</td>
							<td>".$fila['tipo_usuario']."</td>
						</tr>";

			}

			$salida.="</tbody>
				</table>";
						
		}else{
			$salida.="No hay datos similares :(";
		}

  }

		
	echo $salida;
	mysqli_close($mysqli);

 ?>
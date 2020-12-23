<?php
include_once 'config.php';
$id_user = $_SESSION['id']; // id del usuario cuya sesion esta iniciada.
$id_apuesta = $cantidad = $resultado = $cod_apuesta = "";
$cantidad_err = "";


$qRes = "SELECT * FROM apuestas WHERE id_user = $id_user";
$qQuery = mysqli_query($link,$qRes);    

?>
<br>

	<table border="1" >
		<tr>
			<td>Asignatura</td>
			<td>Apostado a</td>
			<td>Predicción</td>
			<td>Cantidad</td>
			<td>Fecha</td>
			<td>Resultado</td>
			<td>Ganancia/Pérdida</td>	
		</tr>

		<?php 
		while($mostrar=mysqli_fetch_array($qQuery)){

			//Sacamos el nombre de la asignatura a partir de su id.
			$id_apuesta = $mostrar['id_apuesta'];
			$nombre_apuesta_sql = "SELECT nombre_resumido FROM apuestasdisponibles WHERE id_apuesta = $id_apuesta"; 
			$nombre_apuesta_result = mysqli_query($link,$nombre_apuesta_sql);
			$nombre_apuesta = $nombre_apuesta_result->fetch_array()['nombre_resumido'];
			//Sacamos el nombre de la persona a la que apuestas a partir de su id.
			//Si es a ti mismo, saltamos este paso
			if($mostrar['id_apostado'] == $id_user)
			{
				$nombre_apostado = $_SESSION['username'];

			}else{
				
				$id_apostado= $mostrar['id_apostado'];
				$nombre_apostado_sql = "SELECT username FROM users WHERE id = $id_apostado"; 
				$nombre_apostado_result = mysqli_query($link,$nombre_apostado_sql);
				$nombre_apostado = $nombre_apostado_result->fetch_array()['username'];
			}
			//Sacamos la prediccion de la apuesta Aprobado/Suspendo
			if($mostrar['resultado_user'] == 1)
			{
				$resultado_user = "Aprueba";
			} else $resultado_user = "Suspende";

			if($mostrar['resultado_final'] == 0)
			{
				$resultado = "Pendiente";
			}else if($mostrar['resultado_final'] == 1)
			{
				$resultado = "Ganada";
			}else $resultado = "Perdida";
			if($mostrar['cantidad_resultado'] == 0)
			{
				$cantidad_resultado = "Pendiente";
			}else $cantidad_resultado = $mostrar['cantidad_resultado'];
			
		 ?>

		<tr>
			<td><?php echo $nombre_apuesta ?></td>
			<td><?php echo $nombre_apostado ?></td>
			<td><?php echo $resultado_user ?></td>
			<td><?php echo $mostrar['cantidad_apostada']; echo " PinfCoins" ?></td>
			<td><?php echo $mostrar['fecha_apuesta'] ?></td>
			<td><?php echo $resultado ?></td>
			<td><?php echo $cantidad_resultado ?></td>
		</tr>
	<?php 
	}
	 ?>
	</table>
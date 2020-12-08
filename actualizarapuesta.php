<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false){
    header("location: login.php");
    exit;
}
include_once "config.php";

$query = mysqli_query($link,"SELECT id_apuesta,nombre FROM apuestasdisponibles");
$id_user = $_SESSION['id']; // id del usuario cuya sesion esta iniciada.
$apuestaid = $nombreapuesta = $cantidad = ""

?>

<table border="1" >
		<tr>
			<td>id</td>
			<td>nombre</td>
			<td>apellido</td>
			<td>email</td>
			<td>telefono</td>	
		</tr>

		<?php 
		$sql="SELECT * from t_persona";
		$result=mysqli_query($conexion,$sql);

		while($mostrar=mysqli_fetch_array($result)){
		 ?>

		<tr>
			<td><?php echo $mostrar['id'] ?></td>
			<td><?php echo $mostrar['nombre'] ?></td>
			<td><?php echo $mostrar['apellido'] ?></td>
			<td><?php echo $mostrar['email'] ?></td>
			<td><?php echo $mostrar['telefono'] ?></td>
		</tr>
	<?php 
	}
	 ?>
	</table>
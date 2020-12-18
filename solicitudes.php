<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

include_once 'config.php';
$id_user = $_SESSION['id']; // id del usuario cuya sesion esta iniciada.

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $busq = $_POST['busqueda'];
    $qRes = "SELECT username FROM users WHERE username LIKE '$busq%'";
    $qQuery = mysqli_query($link,$qRes);

    ?>

    <br>

    <table border="1" >
        <tr>
            <td>Usuario</td>
            <td>Solicitud</td>
        </tr>

        <?php 
            while($mostrar=mysqli_fetch_array($qQuery)){
        ?>

        <tr>
            <td><?php echo $mostrar['username'] ?></td>
        </tr>

<?php 
    }
    }
?>
</table>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitudes</title>
</head>
<body>

<form method ="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" target ="_self">
    <label for="busqueda">Buscar amigos: </label>
    <input type="text" name="busqueda"><br><br>
</form>

</body>
</html>
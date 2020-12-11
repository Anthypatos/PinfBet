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
$id_apuesta = $cantidad = $resultado = $cod_apuesta = "";
$cantidad_err = "";



if(isset($_POST['id_apuesta']))
{
   $id_apuesta = $_POST['id_apuesta'];
    
   $numero =$id_apuesta; //Con esto sabremos la longitud de la id de apuesta para general el codigo de apuesta.
    $id_apuesta_long = 1;
    do{
	    $numero = floor($numero / 10);
	    $id_apuesta_long = $id_apuesta_long*10;
    } while ($numero > 0);

    $cod_apuesta = ($id_user * 100 * $id_apuesta_long) + $id_apuesta; //Con esto, deberiamos tener siempre un código único, por ejemplo, usuario 154 y cod apuesta 3.
    // cod apuesta = (154 * 100 * 10)+3, por lo que tendriamos 15400003
   
}

// Validamos que la cantidad introducida sea real, un numero y este entre el 1 y el 50
if(empty ($_POST["cantidad"])){
    $cantidad_err = "Introduce una cantidad real";     
} elseif($_POST["cantidad"] >=1 && $_POST["cantidad"] <= 50 && is_numeric($_POST["cantidad"])){
    $cantidad = $_POST["cantidad"];
} else{
    $cantidad_err = "Introduce un valor numérico superior a 0 hasta un máximo de 50.";
    
}

if(isset($_POST['resultado']))
{
   $resultado = $_POST['resultado'];
   
}

if(empty($cantidad_err)){
    
    // Preparamos la consulta que vamos a introducir a la base de datos.
    $sql = "INSERT INTO apuestas (id_user, id_apuesta,cod_apuesta, cantidad_apostada, resultado_user) VALUES (?,?,?,?,?)";
     
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "iiiii",$param_iduser, $param_apuesta,$param_codapuesta, $param_cantidad, $param_resultado);
        
        // Ponemos los parametros con sus respectivos valores.
        $param_iduser = $id_user;
        $param_apuesta = $id_apuesta;
        $param_cantidad = $cantidad; 
        $param_resultado = $resultado;
        $param_codapuesta = $cod_apuesta;
        
        // Ejecuta la orden
        if(mysqli_stmt_execute($stmt)){
            // Redirige a la pagina princial
            echo "Tu Apuesta Ha sido realizada! Redirigiendo en 3s..";
            sleep('3');
            header("location: main.php");
        } else{
            echo "Error, Puede que ya hayas apostado en esta asignatura, solo puedes apostar 1 vez.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
}

// Close connection
mysqli_close($link);



?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Apuesta</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Apuesta</h2>
        <p>Rellena estos datos para poder apostar.</p>
        <form action="apuesta.php" method="post">
            <div class="form-group"> 
            <label>Asignatura</label>
                <select name="id_apuesta">
                <?php     
                    while($datos = mysqli_fetch_array($query))
                    {
                ?>
                    <option value="<?php echo $datos['id_apuesta']?>"> <?php echo $datos['nombre']?> </option>
                <?php    
                    }
                ?>
                </select>
            </div>
           
            <div class="form-group <?php echo (!empty($cantidad_err)) ? 'has-error' : ''; ?>">
                <label>Cantidad (PinfCoins)</label>
                <input type="text" name="cantidad" class="form-control" value="<?php echo $cantidad; ?>">
                <span class="help-block"><?php echo $cantidad_err; ?></span>
            </div>  
            <div class="form-group <?php echo (!empty($cantidad_err)) ? 'has-error' : ''; ?>">
            <label>Resultado</label>
            <select id="resultado" name="resultado">
                <option value=1>Aprobado</option>
                <option value=-1>Suspenso</option>
            </select>
            </div>  

                <input type="submit" class="btn btn-primary" value="Apostar">
                <a href="main.php" class="btn btn-primary">Cancelar</a>
            
        </form>
    </div>    
</body>
</html>
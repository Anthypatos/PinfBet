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
$apuestaid = $cantidad = $resultado = "";
$cantidad_err = "";

if(isset($_POST['apuestaid']))
{
   $apuestaid = $_POST['apuestaid'];
   
}

// Validate password
if(empty ($_POST["cantidad"])){
    $cantidad_err = "Introduce una cantidad";     
} elseif($_POST["cantidad"] > 0 && $_POST["cantidad"] <= 50 && is_numeric($_POST["cantidad"])){
    $cantidad = $_POST["cantidad"];
    
} else{
    $cantidad_err = "Introduce un valor numérico superior a 0 hasta un máximo de 50.";
    
}

if(isset($_POST['resultado']))
{
   $resultado = $_POST['resultado'];
   
}

if(empty($cantidad_err)){
        
    // Prepare an insert statement
    $sql = "INSERT INTO apuestas (id_user, id_apuesta, cantidad, resultado_user) VALUES (?, ?, ?,?)";
     
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "iiii",$param_iduser, $param_apuesta, $param_cantidad, $param_resultado);
        
        // Set parameters
        $param_iduser = $id_user;
        $param_apuesta = $apuestaid;
        $param_cantidad = $cantidad; 
        $param_resultado = $resultado;
        echo "yeyeyey";
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Redirect to login page
            header("location: index.php");
        } else{
            echo $id_user;
            echo $apuestaid;
            echo $cantidad;
            echo $resultado;
            echo "Error, Prueba de nuevo";
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
                <select name="apuestaid">
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
                <a href="index.php" class="btn btn-primary">Cancelar</a>
            
        </form>
    </div>    
</body>
</html>
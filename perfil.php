<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hola, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>, este es tu perfil.</h1>
    </div>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Cambiar contraseña.</a>
        <a href="logout.php" class="btn btn-danger">Cerrar sesión.</a>
        <a href="form.php" class="btn btn-danger">Cambiar Foto</a>
        <a href="main.php" class="btn btn-primary">Volver</a>
    </p>
</body>
</html>
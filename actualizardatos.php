<?php
include_once 'config.php';
$id_user = $_SESSION['id']; // id del usuario cuya sesion esta iniciada.
$qRes = "SELECT name,username,created_at,pinfcoins,profile_image,bio FROM users WHERE id = $id_user";
$qQuery = mysqli_query($link,$qRes);    

//Descargamos todos los datos de la base de datos.
        // Bind variables to the prepared statement as parameters
        $mostrar=mysqli_fetch_array($qQuery);
        // Ponemos los parametros con sus respectivos valores.
        $_SESSION["loggedin"] = true;
        $_SESSION["name"] = $mostrar["name"];
        $_SESSION["username"] =$mostrar["username"];                           
        $_SESSION["created_at"] =  $mostrar["created_at"];
        $_SESSION["pinfcoins"] = $mostrar["pinfcoins"];
        $_SESSION["profile_image"] = $mostrar["profile_image"];
        $_SESSION["bio"] = $mostrar["bio"];
        // Ejecuta la orden
    
// Close connection

?>
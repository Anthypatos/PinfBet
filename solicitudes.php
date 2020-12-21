<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

include_once 'config.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitudes</title>
</head>
<body>

<form method = "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" target = "_self">
    <label for= "busqueda">Buscar amigos: </label>
    <input type= "text" id = "busqueda" name = "busqueda" placeholder = "Busca un usuario..."><br><br>
</form>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {

        $busq = $_POST['busqueda'];
        $buscar = "SELECT username FROM users WHERE username like '%$busq%'";
        $buscar_consulta = mysqli_query($link,$buscar);
        $elem_busq=mysqli_fetch_array($buscar_consulta);
        ?>

        <br>

        <table border="1" >
            <tr>
                <td>Usuario</td>
                <td>Solicitud</td>
            </tr>

            <?php
                while($elem_busq)
                { 
            ?>

            <tr>
                <td><?php echo $elem_busq['username'] ?></td>
                <td>
                    <?php
                        $user_actual = $_SESSION['username'];
                        $user_buscado = $elem_busq['username'];

                        if ($user_actual == $user_buscado)
                        {
                            echo "Eres tú.";
                        }
                        else
                        {
                            $amistad = "SELECT solicitud, amigos FROM amistades WHERE ('$user_actual' = usuario1 and '$user_buscado' = usuario2)";
                            $amistad_consulta = mysqli_query($link,$amistad);

                            if (mysqli_num_rows($amistad_consulta) == 0)
                            {
                                mysqli_query($link, "INSERT INTO amistades (usuario1, usuario2, solicitud, amigos) VALUES ('$user_actual', '$user_buscado', 0, 0), ('$user_buscado', '$user_actual', 0, 0)");
                                $amistad_consulta = mysqli_query($link,$amistad);
                            }

                            $elem_amistad = mysqli_fetch_array($amistad_consulta);

                            if ($elem_amistad['solicitud'] == 0)
                            {
                                ?>

                                <form>
                                    <input type="button" value="Enviar solicitud" onclick="enviar()">
                                </form>

                                <script>
                                    function enviar() 
                                    {
                                        <?php
                                            $enviar_solicitud = "UPDATE amistades SET solicitud = '1' WHERE amistades.usuario1 = '$user_actual' AND amistades.usuario2 = '$user_buscado'";
                                            $consulta_enviar = mysqli_query($link, $enviar_solicitud);
                                        ?>
                                        alert("¡Solicitud de amistad enviada!");
                                        location.reload();
                                    }
                                </script>

                                <?php
                            }
                            else if ($elem_amistad['solicitud'] == 1 && $elem_amistad['amigos'] == 0)
                            {
                                echo "Ya le has enviado una solicitud.";
                            }
                            else echo "Ya sois amigos.";
                        }
                    ?>
                </td>
            </tr>

<?php 
                $elem_busq=mysqli_fetch_array($buscar_consulta);
                }
    }
?>
</table>

<table border="1" >
    <tr>
        <td>Solicitudes de amistad recibidas</td>
    </tr>
    <?php
        $user_actual = $_SESSION['username'];
        $comprobar_solicitudes = "SELECT usuario1, solicitud FROM amistades WHERE '$user_actual' = usuario2 and solicitud = 1 and amigos = 0";
        $comprobar_consulta = mysqli_query($link, $comprobar_solicitudes);

        if (mysqli_num_rows($comprobar_consulta) == 0)
        {
            ?>
            <td>No tienes solicitudes pendiendes.</td>
            <?php
        }
        else
        {
            while ($solicitante = mysqli_fetch_array($comprobar_consulta))
            {
                ?>
                    <tr>
                        <td> <?php echo $solicitante['usuario1']; ?> </td>
                        <td>
                            <form>
                                <input type="button" value="Aceptar solicitud" onclick="aceptar()">
                            </form>

                            <script>
                                function aceptar() 
                                {
                                    <?php
                                        $user_solicitante = $solicitante['usuario1'];
                                        $aceptar_solicitud = "UPDATE amistades SET amigos = '1' WHERE amistades.usuario1 = '$user_solicitante' AND amistades.usuario2 = '$user_actual'";
                                        $consulta_aceptar = mysqli_query($link, $aceptar_solicitud);
                                    ?>
                                    alert("¡Solicitud de amistad aceptada!");
                                    location.reload();
                                }
                            </script>
                        </td>
                    </tr>
                <?php
            }
        }
    ?>
</table>

</body>
</html>
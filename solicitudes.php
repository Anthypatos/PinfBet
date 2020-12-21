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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" />
</head>
<body>

<p>
    <form method = "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" target = "_self">
        <input type= "text" id = "busqueda" name = "busqueda" placeholder = "Busca un usuario...">
        <input type = "hidden" name = "tipo" value = "buscar_users">
        <input type = "submit" value = "Buscar">
    </form>
</p>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        switch($_POST['tipo'])
        {
            case 'aceptar':
                $user_cliente = $_POST['cliente'];
                $user_otro = $_POST['otro'];

                $aceptar_solicitud = "UPDATE amistades SET amigos = '1' WHERE amistades.usuario1 = '$user_otro' AND amistades.usuario2 = '$user_cliente'";
                $consulta_aceptar = mysqli_query($link, $aceptar_solicitud);

                $aceptar_solicitud = "UPDATE amistades SET solicitud = '1', amigos = '1' WHERE amistades.usuario1 = '$user_cliente' AND amistades.usuario2 = '$user_otro'";
                $consulta_aceptar = mysqli_query($link, $aceptar_solicitud);
                break;
            case 'rechazar':
                $user_cliente = $_POST['cliente'];
                $user_otro = $_POST['otro'];

                $rechazar_solicitud = "UPDATE amistades SET solicitud = '0' WHERE amistades.usuario1 = '$user_otro' AND amistades.usuario2 = '$user_cliente'";
                $consulta_rechazar = mysqli_query($link, $rechazar_solicitud);
                break;
            default:

                if ($_POST['tipo'] == 'enviar')
                {
                    $user_cliente = $_POST['cliente'];
                    $user_otro = $_POST['otro'];

                    $enviar_solicitud = "UPDATE amistades SET solicitud = '1' WHERE amistades.usuario1 = '$user_cliente' AND amistades.usuario2 = '$user_otro'";
                    $consulta_enviar = mysqli_query($link, $enviar_solicitud);
                }

                $busq = $_POST['busqueda'];
                $buscar = "SELECT username FROM users WHERE username like '%$busq%'";
                $buscar_consulta = mysqli_query($link,$buscar);
                $elem_busq=mysqli_fetch_array($buscar_consulta);
                ?>

                <p>
                <table class="table table-bordered">
                    <thead>
                        <th>Usuario</th>
                        <th>Solicitud</th>
                    </thead>

                    <tbody>
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

                                        <form method = "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" target = "_self" onsubmit="mensajito('¡Solicitud de amistad enviada!')">
                                            <input type = "hidden" name = "tipo" value = "enviar">
                                            <input type = "hidden" name = "cliente" value = "<?php echo htmlspecialchars($user_actual); ?>">
                                            <input type = "hidden" name = "otro" value = "<?php echo htmlspecialchars($user_buscado); ?>">
                                            <input type = "hidden" name = "busqueda" value = "<?php echo htmlspecialchars($_POST['busqueda']); ?>">
                                            <input type = "submit" value = "Enviar solicitud">
                                        </form>

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
            break;
        }
    }
    ?>
    </tbody>
    </table>
</p>

<p>
<table class="table table-bordered">
    <thead>
        <th>Solicitudes de amistad recibidas</th>
    </thead>
    <tbody>
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
                            <form method = "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" target = "_self" onsubmit="mensajito('¡Solicitud de amistad aceptada!')">
                                <input type = "hidden" name = "tipo" value = "aceptar">
                                <input type = "hidden" name = "cliente" value = "<?php echo htmlspecialchars($user_actual); ?>">
                                <input type = "hidden" name = "otro" value = "<?php echo htmlspecialchars($solicitante['usuario1']); ?>">
                                <input type = "submit" value = "Aceptar">
                            </form>
                            <form method = "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" target = "_self" onsubmit="mensajito('Solicitud de amistad rechazada.')">
                                <input type = "hidden" name = "tipo" value = "rechazar">
                                <input type = "hidden" name = "cliente" value = "<?php echo htmlspecialchars($user_actual); ?>">
                                <input type = "hidden" name = "otro" value = "<?php echo htmlspecialchars($solicitante['usuario1']); ?>">
                                <input type = "submit" value = "Rechazar">
                            </form>
                        </td>
                    </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>
</p>

<script>
    function mensajito($cadena)
    {
        alert($cadena);
    }
</script>
</body>
</html>
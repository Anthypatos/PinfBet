<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

include_once 'config.php';

$user_actual = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>5&Bet - Social</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" />
</head>
<body style="text-align:center">
<h2>Social</h2>

<!-- Hay distintos tipos de formularios en la página para realizar las distintas acciones -->

<!-- FORMULARIO DE BÚSQUEDA, siempre se muestra -->
<p>
    <form method = "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" target = "_self">
        <input type= "search" id = "busqueda" name = "busqueda" placeholder = "Busca un usuario..." minlength = "3" required>
        <input type = "hidden" name = "tipo" value = "buscar_users">    <!-- Tipo de formulario que se envía -->
        <input type = "submit" value = "Buscar">
    </form>
</p>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        switch($_POST['tipo'])
        {
            /* La estructura de una relación de amistad es una tupla (user_actual, user_otro, solicitud, amigos) en la que los 2 últimos son
            booleanos que se activan cuando el primer usuario manda una solicitud al segundo, y cuando se forma la amistad, respectivamente.
            La tupla debe estar repetida a la inversa para poder dar lugar a todos los posibles escenarios. */
            
            // Aceptar solicitud de amistad
            case 'aceptar':
                $user_otro = $_POST['otro'];    // Se recibe el usuario objetivo

                // Actualizar la tupla del usuario que manda la solicitud
                $aceptar_solicitud = "UPDATE amistades SET amigos = '1' WHERE usuario1 = '$user_otro' AND usuario2 = '$user_actual'";
                $consulta_aceptar = mysqli_query($link, $aceptar_solicitud);

                // Insertar la nueva tupla del usuario que acepta la solicitud
                $aceptar_solicitud = "INSERT INTO amistades (usuario1, usuario2, solicitud, amigos) VALUES ('$user_actual', '$user_otro', 1, 1)";
                $consulta_aceptar = mysqli_query($link, $aceptar_solicitud);
                break;

            // Rechazar solicitud de amistad y borrar usuarios de la lista de amigos
            case 'borrar':
                $user_otro = $_POST['otro'];    // Se recibe el usuario objetivo

                // Borrar la primera de las tuplas
                $borrar_amigo = "DELETE FROM amistades WHERE usuario1 = '$user_actual' AND usuario2 = '$user_otro'";
                $consulta_borrar = mysqli_query($link, $borrar_amigo);

                // Borrar la segunda de las tuplas
                $borrar_amigo = "DELETE FROM amistades WHERE usuario1 = '$user_otro' AND usuario2 = '$user_actual'";
                $consulta_borrar = mysqli_query($link, $borrar_amigo);

                // No hay problema si al rechazar sólo existe una de las tuplas
                break;

            // Para los casos de enviar solicitud y buscar usuarios queremos mostrar siempre la tabla de búsqueda así que 
            // tendrán un comportamiento compartido.
            default:

                // Sólo para el caso de enviar solicitud
                if ($_POST['tipo'] == 'enviar')
                {
                    $user_otro = $_POST['otro'];    // Se recibe el usuario objetivo

                    // Se inserta la tupla del usuario actual, que envía la solicitud
                    $enviar_solicitud = "INSERT INTO amistades (usuario1, usuario2, solicitud, amigos) VALUES ('$user_actual', '$user_otro', 1, 0)";
                    $consulta_enviar = mysqli_query($link, $enviar_solicitud);
                }

                // Se obtiene el término de búsqueda y se hace la consulta
                $busq = $_POST['busqueda'];
                $buscar = "SELECT username, profile_image FROM users WHERE username LIKE '%$busq%' ORDER BY username ASC";
                $buscar_sql = mysqli_query($link,$buscar);

                if (mysqli_num_rows($buscar_sql) == 0) echo "No se encontraron resultados.";    // Si la búsqueda no encuentra resultados
                else
                {
                ?>

                    <!-- Tabla con los resultados de búsqueda -->
                    <p>
                    <table class="table table-bordered">
                        <thead>
                            <th>Usuario</th>
                            <th>Solicitud</th>
                        </thead>

                        <tbody>
                        <?php
                            while($elem_busq = mysqli_fetch_array($buscar_sql)) // Por cada uno de los usuarios encontrados
                            { 
                        ?>

                        <tr>
                            <td> <img src="<?php echo 'imagenesperfil/' . $elem_busq['profile_image'] ?>" width="90" height="90" alt="Avatar de <?php echo $elem_busq['username'] ?>"> </td>
                            <td> <?php echo $elem_busq['username'] ?> </td>
                            <td>
                                <?php
                                    $user_encontrado = $elem_busq['username']; // Se obtiene cada nombre de usuario del resultado

                                    if ($user_actual == $user_encontrado)  // Si el cliente se encuentra a sí mismo
                                    {
                                        echo "Eres tú.";
                                    }
                                    else 
                                    {
                                        // Se consulta si el cliente y cada uno de los usuarios encontrados son ya amigos o no
                                        // La consulta devolverá 0 ó 1 tuplas
                                        $amistad = "SELECT solicitud, amigos FROM amistades WHERE ('$user_actual' = usuario1 and '$user_encontrado' = usuario2)";
                                        $amistad_sql = mysqli_query($link,$amistad);

                                        // Se comprueba si se ha recibido la tupla
                                        $existe_amigo = mysqli_num_rows($amistad_sql);

                                        if ($existe_amigo == 0) // Si no se ha recibido tupla es que los usuarios no son amigos
                                        {
                                            ?>

                                            <!-- FORMULARIO PARA ENVIAR SOLICITUD DE AMISTAD -->
                                            <form method = "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" target = "_self" onsubmit="mensajito('¡Solicitud de amistad enviada!')">
                                                <input type = "hidden" name = "tipo" value = "enviar"> <!-- Tipo de formulario que se envía -->
                                                <input type = "hidden" name = "otro" value = "<?php echo $user_encontrado; ?>"> <!-- Usuario objetivo -->
                                                <input type = "hidden" name = "busqueda" value = "<?php echo htmlspecialchars($_POST['busqueda']); ?>"> <!-- Se reenviará la búsqueda de usuarios anterior, para que vuelva a aparecer la tabla -->
                                                <input type = "submit" value = "Enviar solicitud">
                                            </form>

                                            <?php
                                        }
                                        else    // Si se ha recibido la tupla es que ya se ha enviado solicitud o los usuarios ya son amigos
                                        {
                                            $elem_amistad = mysqli_fetch_array($amistad_sql);

                                            if ($elem_amistad['solicitud'] == 1 && $elem_amistad['amigos'] == 0)
                                            {
                                                echo "Ya le has enviado una solicitud.";
                                            }
                                            else echo "Ya sois amigos.";
                                        }
                                    }
                                ?>
                            </td>
                        </tr>

                        <?php
                            }
                        ?>
                        </tbody>
                    </table>
                    </p>
                <?php
                }
            break;
        }
    }
                ?>

<!-- Tabla de solicitudes recibidas -->
<p>
<table class="table table-bordered">
    <thead>
        <th colspan = "4">Solicitudes de amistad recibidas</th>
    </thead>
    <tbody>
    <?php
        // Comprobación de la existencia de solicitudes por parte de algún usuario
        $comprobar_solicitudes = "SELECT usuario1, solicitud FROM amistades WHERE '$user_actual' = usuario2 and solicitud = 1 and amigos = 0";
        $comprobar_sql = mysqli_query($link, $comprobar_solicitudes);

        if (mysqli_num_rows($comprobar_sql) == 0)   // Si no se hallan solicitudes
        {
            ?>
            <td>No tienes solicitudes pendiendes.</td>
            <?php
        }
        else
        {
            while ($solicitante = mysqli_fetch_array($comprobar_sql))   // Para cada solicitud encontrada
            {
                ?>
                    <tr>
                        <td> <?php echo $solicitante['usuario1']; ?> </td>
                        <td>
                            <!-- FORMULARIO PARA ACEPTAR SOLICITUD DE AMISTAD -->
                            <form method = "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" target = "_self" onsubmit="mensajito('¡Solicitud de amistad aceptada!')">
                                <input type = "hidden" name = "tipo" value = "aceptar"> <!-- Tipo de formulario que se envía -->
                                <input type = "hidden" name = "otro" value = "<?php echo $solicitante['usuario1']; ?>">   <!-- Usuario objetivo -->
                                <input type = "submit" value = "Aceptar">
                            </form>
                            <!-- FORMULARIO PARA RECHAZAR SOLICITUD DE AMISTAD -->
                            <form method = "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" target = "_self" onsubmit="mensajito('Solicitud de amistad rechazada.')">
                                <input type = "hidden" name = "tipo" value = "borrar"> <!-- Tipo de formulario que se envía, rechazar es igual que borrar de la lista -->
                                <input type = "hidden" name = "otro" value = "<?php echo $solicitante['usuario1']; ?>">   <!-- Usuario objetivo -->
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

<!-- Tabla de lista de amigos -->
<p>
<table class="table table-bordered">
    <thead>
        <th colspan = "4">Tu lista de amigos</th>
    </thead>
    <tbody>
    <?php
        $lista_sql = "SELECT usuario2, profile_image FROM amistades, users WHERE '$user_actual' = usuario1 AND amigos = 1 AND usuario2 = username";
        $lista_amigos = mysqli_query($link, $lista_sql);

        if (mysqli_num_rows($lista_amigos) == 0)    // Si no se encuentran amigos
        {
            ?>
            <td>Tu lista de amigos está vacía.</td>
            <?php
        }
        else
        {
            while ($datos_amigo = mysqli_fetch_array($lista_amigos))    // Para cada amigo encontrado
            {
                ?>
                    <tr>
                        <td> <img src="<?php echo 'imagenesperfil/' . $datos_amigo['profile_image'] ?>" width="90" height="90" alt="Avatar de <?php echo $datos_amigo['usuario2'] ?>"> </td>
                        <td> <?php echo $datos_amigo['usuario2']; ?> </td>
                        <!-- En construcción -->
                        <td>No funciona de momento
                            <form method = "post" action="apuesta.php" target = "_self">
                                <input type = "hidden" name = "objetivo" value = "<?php echo htmlspecialchars($datos_amigo['usuario2']); ?>">
                                <input type = "submit" value = "Apostar">
                            </form>
                        </td>
                        <!-- FORMULARIO PARA BORRAR AMIGO DE LA LISTA -->
                        <td>
                            <form method = "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" target = "_self" onsubmit="mensajito('Amigo eliminado.')">
                                <input type = "hidden" name = "tipo" value = "borrar">  <!-- Tipo de formulario que se envía, borrar es igual que rechazar solicitud --> 
                                <input type = "hidden" name = "otro" value = "<?php echo htmlspecialchars($datos_amigo['usuario2']); ?>">   <!-- Usuario objetivo -->
                                <input type = "submit" value = "Borrar">
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
    // Función para mostrar mensaje al realizar una acción
    function mensajito($cadena)
    {
        alert($cadena);
    }

    // Para evitar el reenvío de formularios al actualizar o moverse por las páginas
    if (window.history.replaceState)
    {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</body>
</html>
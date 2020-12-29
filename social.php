<?php
    // Inicializa la sesión
    session_start();
    
    // Comprueba si el usuario esta logueado
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
    {
        header("location: login.php");
        exit;
    }

    $user_actual = $_SESSION['username'];
    $link = mysqli_connect("localhost", "root", "", "pinf");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>5&Bet - Social</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body style = "text-align:center">
<h1>Social</h1>

<!-- Hay distintos tipos de formularios en la página para realizar las distintas acciones -->

<!-- FORMULARIO DE BÚSQUEDA, siempre se muestra -->
<p>
    <form method = "get" action = "social.php" target = "_self">
        <input type= "search" id = "q" name = "q" placeholder = "Busca un usuario..." minlength = "3" autocomplete = "off" required>
        <input type = "submit" value = "Buscar">
    </form>
</p>

<hr>

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

                // Comprobación para el caso de las solicitudes cruzadas
                $comprobar_estado = "SELECT * FROM amistades WHERE usuario1 = '$user_otro' AND usuario2 = '$user_actual'";
                if (mysqli_num_rows(mysqli_query($link, $comprobar_estado)) > 0)
                {
                    // Actualizar la tupla del usuario que manda la solicitud
                    $aceptar_solicitud = "UPDATE amistades SET amigos = '1' WHERE usuario1 = '$user_otro' AND usuario2 = '$user_actual'";
                    $consulta_aceptar = mysqli_query($link, $aceptar_solicitud);

                    // Insertar la nueva tupla del usuario que acepta la solicitud
                    $aceptar_solicitud = "INSERT INTO amistades (usuario1, usuario2, solicitud, amigos) VALUES ('$user_actual', '$user_otro', 1, 1)";
                    $consulta_aceptar = mysqli_query($link, $aceptar_solicitud);
                }
?>
                <!-- Muestra mensaje de confirmación -->
                <div class = "alert alert-success" role = "alert" style = "text-align:center">Solicitud de amistad aceptada</div>
<?php
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

?>
                <!-- Muestra mensaje de confirmación tras rechazar o borrar -->
                <div class = "alert alert-warning" role = "alert" style = "text-align:center"><?php
                    if (isset($_POST['rechazar'])) echo "Solicitud de amistad rechazada";
                    else echo "Amigo borrado";
                ?></div>
<?php
                break;

            // Enviar solicitud de amistad
            case 'enviar':

                $user_otro = $_POST['otro'];    // Se recibe el usuario objetivo

                // Se inserta la tupla del usuario actual, que envía la solicitud
                $enviar_solicitud = "INSERT INTO amistades (usuario1, usuario2, solicitud, amigos) VALUES ('$user_actual', '$user_otro', 1, 0)";
                $consulta_enviar = mysqli_query($link, $enviar_solicitud);
?>
                <!-- Muestra mensaje de confirmación -->
                <div class = "alert alert-success" role = "alert" style = "text-align:center">Solicitud de amistad enviada</div>
<?php
                break;
        }
    }

    // Si se ha pasado el parámetro 'q' por URL (la búsqueda)
    if (isset($_GET['q']))
    {
        // Se obtiene el término de búsqueda y se hace la consulta
        $busq = $_GET['q'];
        $buscar = "SELECT id, username, profile_image FROM users WHERE username LIKE '%$busq%' ORDER BY username ASC";
        $buscar_sql = mysqli_query($link,$buscar);

        if (mysqli_num_rows($buscar_sql) == 0) echo "No se encontraron resultados.";    // Si la búsqueda no encuentra resultados
        else
        {
?>
            <h2>Resultados de búsqueda</h2>
            <!-- Tabla con los resultados de búsqueda -->
            <div class="container">
            <table class = "table table-bordered">
                <thead>
                    <th colspan = "2">Usuario</th>
                    <th>Solicitud</th>
                </thead>

                <tbody>
<?php
                    while($elem_busq = mysqli_fetch_array($buscar_sql)) // Por cada uno de los usuarios encontrados
                    { 
?>

                <tr>
                    <td> <a title = "Acceder a perfil" href = "<?php echo "main.php" . "?id=" . $elem_busq['id']; ?>"><img src = "<?php echo 'imagenesperfil/' . $elem_busq['profile_image'] ?>" width = "50" height = "50" alt = "Avatar de <?php echo $elem_busq['username'] ?>"></a> </td>
                    <td> <a title = "Acceder a perfil" href = "<?php echo "main.php" . "?id=" . $elem_busq['id']; ?>"><?php echo $elem_busq['username']; ?></a> </td>
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
                                    <form method = "post" action = "<?php echo "social.php?q=" . $busq; ?>" target = "_self">
                                        <input type = "hidden" name = "tipo" value = "enviar"> <!-- Tipo de formulario que se envía -->
                                        <input type = "hidden" name = "otro" value = "<?php echo $user_encontrado; ?>"> <!-- Usuario objetivo -->
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
            </div>
            <!-- Fin de tabla -->
<?php
        }
    }
?>

<!-- Tabla de solicitudes recibidas -->
<div class="container">
<table class = "table table-bordered">
    <thead>
        <th colspan = "3">Solicitudes de amistad recibidas</th>
    </thead>
    <tbody>
<?php
        // Comprobación de la existencia de solicitudes por parte de algún usuario
        $comprobar_solicitudes = "SELECT id, username, profile_image FROM amistades, users WHERE usuario2 = '$user_actual' AND solicitud = 1 AND amigos = 0 AND usuario1 = username ORDER BY username ASC";
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
                        <td> <a title = "Acceder a perfil" href = "<?php echo "main.php" . "?id=" . $solicitante['id']; ?>"><img src = "<?php echo 'imagenesperfil/' . $solicitante['profile_image'] ?>" width = "50" height = "50" alt = "Avatar de <?php echo $solicitante['username'] ?>"></a> </td>
                        <td> <a title = "Acceder a perfil" href = "<?php echo "main.php" . "?id=" . $solicitante['id']; ?>"><?php echo $solicitante['username']; ?></a> </td>
                        <td>
                            <!-- FORMULARIO PARA ACEPTAR SOLICITUD DE AMISTAD -->
                            <form method = "post" action = "social.php" target = "_self">
                                <input type = "hidden" name = "tipo" value = "aceptar"> <!-- Tipo de formulario que se envía -->
                                <input type = "hidden" name = "otro" value = "<?php echo $solicitante['username']; ?>">   <!-- Usuario objetivo -->
                                <input type = "submit" value = "Aceptar">
                            </form>
                            <!-- FORMULARIO PARA RECHAZAR SOLICITUD DE AMISTAD -->
                            <form method = "post" action = "social.php" target = "_self">
                                <input type = "hidden" name = "tipo" value = "borrar"> <!-- Tipo de formulario que se envía, rechazar es igual que borrar de la lista -->
                                <input type = "hidden" name = "otro" value = "<?php echo $solicitante['username']; ?>">   <!-- Usuario objetivo -->
                                <input type = "submit" name = "rechazar" value = "Rechazar">
                            </form>
                        </td>
                    </tr>
<?php
            }
        }
?>
    </tbody>
</table>
</div>
<!-- Fin de tabla -->


<!-- Tabla de lista de amigos -->
<div class="container">
<table class = "table table-bordered">
    <thead>
        <th colspan = "3">Tu lista de amigos</th>
    </thead>
    <tbody>
<?php
        $lista_sql = "SELECT id, username, profile_image FROM users, amistades WHERE usuario1 = '$user_actual' AND usuario2 = username AND amigos = 1 ORDER BY username ASC";
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
                        <td> <a title = "Acceder a perfil" href = "<?php echo "main.php" . "?id=" . $datos_amigo['id']; ?>"><img src = "<?php echo 'imagenesperfil/' . $datos_amigo['profile_image'] ?>" width = "50" height = "50" alt = "Avatar de <?php echo $datos_amigo['username'] ?>"></a> </td>
                        <td> <a title = "Acceder a perfil" href = "<?php echo "main.php" . "?id=" . $datos_amigo['id']; ?>"><?php echo $datos_amigo['username']; ?></a> </td>
                        <!-- FORMULARIO PARA BORRAR AMIGO DE LA LISTA -->
                        <td>
                            <form method = "post" action = "social.php" target = "_self">
                                <input type = "hidden" name = "tipo" value = "borrar">  <!-- Tipo de formulario que se envía, borrar es igual que rechazar solicitud --> 
                                <input type = "hidden" name = "otro" value = "<?php echo htmlspecialchars($datos_amigo['username']); ?>">   <!-- Usuario objetivo -->
                                <input type = "submit" name = "borrar" value = "Borrar">
                            </form>
                        </td>
                    </tr>
<?php
            }
        }

        // Cerrar conexión con la BD
        mysqli_close($link);
?>
    </tbody>
</table>
</div>
<!-- Fin de tabla -->

<script>
    // Para evitar el reenvío de formularios al actualizar o moverse por las páginas
    if (window.history.replaceState)
    {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

</body>
</html>
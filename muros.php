<?php
    include_once 'config.php';

    $user_actual = $_SESSION["username"];

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $msj = $_POST['muro'];
        $user_objetivo = $_POST['objetivo'];

        $insertar_sql = "INSERT INTO muros (usuario_env, usuario_rec, mensaje) VALUES ('$user_actual', '$user_objetivo', '$msj')";
        $insertar_consulta = mysqli_query($link, $insertar_sql);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muros</title>
</head>
<body>

<?php
    $amigos_sql = "SELECT * FROM amistades WHERE usuario1 = '$user_actual' AND usuario2 = '$username_user' AND amigos = 1";
    $amigos_consulta = mysqli_query($link, $amigos_sql);

    if (mysqli_num_rows($amigos_consulta) > 0)
    {
?>
    <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ;?>" method = "post">
        <label for = "muro">Escribir en el muro:</label>
        <textarea id = "muro" name = "muro" class="form-control" placeholder = "Escribe en el muro..." rows = "2" cols = "50" maxlength = "300" required></textarea>
        <input type = "hidden" name = "objetivo" value = "<?php echo $username_user; ?>">
        <input type = "submit" value = "Enviar">
    </form>
<?php
    }

    $mensajes_sql = "SELECT usuario_env, mensaje, fecha FROM muros WHERE usuario_rec = '$username_user' ORDER BY fecha DESC";
    $mensajes_consulta = mysqli_query($link, $mensajes_sql);

    if (mysqli_num_rows($mensajes_consulta) == 0)
    {
?>
    <div style = "text-align:center"> No hay mensajes en el muro </div>
<?php
    }
    else
    {
?>
    <table border = "1">

    <?php
    while ($publicacion = mysqli_fetch_array($mensajes_consulta))
    {
    ?>
        <tr>
            <td>
                <?php echo $publicacion['mensaje']; ?> <br>
                <?php echo "Escrito por " . $publicacion['usuario_env'] . " el " . $publicacion['fecha']; ?>
            </td>
        </tr>
    <?php
    }
    ?>

    </table>

    <?php
    }
    ?>

</body>
</html>
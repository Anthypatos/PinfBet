<?php
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $msj = $_POST['muro'];

        $insertar_sql = "INSERT INTO muros (usuario_env, usuario_rec, mensaje) VALUES ('$user_actual', '$id_user', '$msj')";
        $insertar_consulta = mysqli_query($link, $insertar_sql);
    }
?>

    <div class="w3-row-padding">
        <div class="w3-col m12">
            <div class="w3-card w3-round w3-white">
                <div class="w3-container w3-padding">
                <h4>Muro</h4>

<?php
    if ($amigos || $id_user == $_SESSION['id'])
    {
?>
        <form action = "<?php echo "main.php?id=" . $id_user;?>" method = "post" style = "text-align:center">
            <label for = "muro">Escribir en el muro:</label>
            <textarea id = "muro" name = "muro" class="form-control" placeholder = "Escribe en el muro..." rows = "2" cols = "50" maxlength = "300" required></textarea>
            <input type = "submit" value = "Enviar">
        </form>
        <hr>
<?php
    }

    $mensajes_sql = "SELECT usuario_env, mensaje, fecha FROM muros WHERE usuario_rec = '$id_user' ORDER BY fecha DESC";
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
    <table border = "1" style = "margin-left:auto; margin-right:auto;">
<?php
    while ($publicacion = mysqli_fetch_array($mensajes_consulta))
    {
        $id_env = $publicacion['usuario_env'];
        $nombre_env = mysqli_fetch_array(mysqli_query($link, "SELECT username FROM users WHERE id = '$id_env'"))['username'];
?>
        <tr>
            <td>
                <?php echo $publicacion['mensaje']; ?> <br>
                <div style = "font-size:11px;">
                    <i><?php echo "Escrito por "?><a title = "Acceder a perfil" href = "<?php echo "main.php?id=" . $id_env; ?>"><?php echo $nombre_env; ?></a><?php echo " el " . $publicacion['fecha']; ?></i>
                </div>
            </td>
        </tr>
<?php
    }
?>

    </table>
<?php
    }
?>
                </div>
            </div>
        </div>
    </div>

<script>
    // Para evitar el reenvío de formularios al actualizar o moverse por las páginas
    if (window.history.replaceState)
    {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
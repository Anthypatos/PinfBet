<div class="w3-card w3-round w3-white">
    <div class="w3-container w3-padding" style = "text-align:center">
    <h4><b>Amigos</b></h4>
    <hr>
<?php
        $lista_sql = "SELECT id, username, profile_image, email FROM users, amistades WHERE usuario1 = '$username_user' AND usuario2 = username AND amigos = 1 ORDER BY username ASC";
        $lista_amigos = mysqli_query($link, $lista_sql);

        if (mysqli_num_rows($lista_amigos) == 0)    // Si no se encuentran amigos
        {
            echo "¡Aún no hay amigos!";
        }
        else
        {
?>
        <table border = "1" style = "margin-left:auto; margin-right:auto;">
<?php
        while ($datos_amigo = mysqli_fetch_array($lista_amigos))    // Para cada amigo encontrado
        {
?>
                <tr>
                    <td style = "padding:5px;"> <a title = "Acceder a perfil" href = "<?php echo "main.php" . "?id=" . $datos_amigo['id']; ?>"><img src = "<?php echo 'imagenesperfil/' . $datos_amigo['profile_image'] ?>" width = "35" height = "35" alt = "Avatar de <?php echo $datos_amigo['username'] ?>"></a> </td>
                    <td style = "padding:5px;"> <a title = "Acceder a perfil" href = "<?php echo "main.php" . "?id=" . $datos_amigo['id']; ?>"><?php echo $datos_amigo['username']; ?></a> </td>
<?php
                    if ($id_user == $_SESSION['id']) // Si el usuario está viendo su perfil
                    {
?>
                        <td style = "padding:5px;"> <a title = "Enviar correo electrónico" href = "<?php echo "mailto:" . $datos_amigo['email']; ?>"><i class="far fa-envelope fa-2x"></i></a> </td>
<?php
                    }
?>
                </tr>
<?php
        }
        }
?>
        </table>
        <!-- Fin de tabla -->
    </div>
</div>
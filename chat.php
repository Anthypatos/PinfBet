<?php
    // Inicializa la sesión
    session_start();
    
    // Comprueba si el usuario esta logueado
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
    {
        header("location: login.php");
        exit;
    }

    $user_actual = $_SESSION['id'];
    $user_otro = $_GET['id'];

    $enlace = mysqli_connect("localhost", "root", "", "pinf");

    $comprobar_amistad = "SELECT * FROM amistades WHERE usuario1 = '$user_actual' AND usuario2 = '$user_otro' AND amigos = 1";

    if (mysqli_num_rows(mysqli_query($enlace, $comprobar_amistad)) == 0)
    {
        mysqli_close($enlace);
        header("location: main.php");
    }
    else
    {
        mysqli_close($enlace);
?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>5&Bet - Chat</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
            <script src = "js/jquery-3.5.1.js"></script>

            <script type = "text/javascript">

                setInterval (cargar_log, 500);

                function cargar_log()
                {
                    var datos = {user_actual:<?php echo $user_actual; ?>,
                                user_otro:<?php echo $user_otro; ?>}

                    $.get("procesarchat.php", datos, mostrar_chat);
                }

                function mostrar_chat(datos_rec)
                {
                    $("#caja_chat").html(datos_rec);
                }

                $(document).ready(function() {

                    $("#formulario").submit(function() {

                        var datos_env = $(this).serialize();

                        $.post("procesarchat.php", datos_env);

                        $("#mensaje").val("");

                        return false;
                    });
                })
            </script>

        </head>
        <body>
            <div class = "container" id = "caja_chat"></div>

            <form id = "formulario" method = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $user_otro; ?>">
                <input type = "text" id = "mensaje" name = "mensaje" placeholder = "Escribe un mensaje..." value = "">
                <input type = "hidden" id = "user_actual" name = "user_actual" value = "<?php echo $user_actual; ?>">
                <input type = "hidden" id = "user_otro" name = "user_otro" value = "<?php echo $user_otro; ?>">
                <input type = "submit" value = "Enviar">
            </form>
        </body>
        </html>

<?php
    }
?>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $user_actual = $_GET['user_actual'];
        $user_otro = $_GET['user_otro'];

        $enlace = mysqli_connect("localhost", "root", "", "pinf");

        $chat_consulta = mysqli_query($enlace, "SELECT id_chat FROM chats WHERE (usuario1 = '$user_actual' AND usuario2 = '$user_otro') OR (usuario1 = '$user_otro' AND usuario2 = '$user_actual')");

        if (mysqli_num_rows($chat_consulta) > 0)
        {
            $id_chat = mysqli_fetch_array($chat_consulta)['id_chat'];

            $chat = fopen($id_chat . ".txt", "r");
            $log = "";

            while (!feof($chat))
            {
                $log = $log . fgets($chat) . "<br>";
            }

            fclose($chat);

            echo $log;
        }
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $user_actual = $_POST['user_actual'];
        $user_otro = $_POST['user_otro'];
        $msj = $_POST['mensaje'];

        $enlace = mysqli_connect("localhost", "root", "", "pinf");

        $chat_consulta = mysqli_query($enlace, "SELECT id_chat FROM chats WHERE (usuario1 = '$user_actual' AND usuario2 = '$user_otro') OR (usuario1 = '$user_otro' AND usuario2 = '$user_actual')");

        if (mysqli_num_rows($chat_consulta) == 0)
        {
            mysqli_query($enlace, "INSERT INTO chats (usuario1, usuario2) VALUES ('$user_actual', '$user_otro')");
            $chat_consulta = mysqli_query($enlace, "SELECT id_chat FROM chats WHERE usuario1 = '$user_actual' AND usuario2 = '$user_otro'");
        }

        $id_chat = mysqli_fetch_array($chat_consulta)['id_chat'];

        $nombre_user_actual = mysqli_fetch_array(mysqli_query($enlace, "SELECT username FROM users WHERE id = '$user_actual'"))['username'];

        mysqli_close($enlace);

        $chat = fopen($id_chat . ".txt", "a");
        fwrite($chat, $nombre_user_actual . " dice: " . $msj . "\n");
        fclose($chat);
    }
?>
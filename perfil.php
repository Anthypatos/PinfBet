<?php
    // Initialize the session
    session_start();
    
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

    if (isset($_GET['p']) && ($_GET['p'] == 0 || $_GET['p'] == 1))
    {
        $_SESSION['privacidad'] = $privacidad = $_GET['p'];
        $id = $_SESSION['id'];
        $link = mysqli_connect("localhost", "root", "", "pinf");

        mysqli_query($link, "UPDATE users SET privacidad = '$privacidad' WHERE id = $id");
    }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
    <link rel="stylesheet" href="css/all.css" > <!-- Iconos de FontAwesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hola, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>, este es tu perfil.</h1>
        <div class="w3-card w3-round w3-white">
      
        <div class="w3-container">
            <div style = "color:royalblue;"><b>Privacidad:</b></div>
            <?php if ($_SESSION['privacidad']) { ?><div style = "color:crimson"><i class="fas fa-lock" style = "color:black;"></i> privado</div><?php }
                else { ?><div style = "color:lime"><i class="fas fa-lock-open" style = "color:black;"></i> público</div><?php } ?>
            <p class="w3-center"><img src="<?php echo 'imagenesperfil/' . $_SESSION["profile_image"] ?>" width="90" height="90" alt=""></p>
            <hr>

            <p><i class="fas fa-user-circle fa-fw w3-margin-right w3-text-theme"></i> <?php echo $_SESSION["name"];?></p>
            <p><i class="fas fa-money-bill fa-fw w3-margin-right w3-text-theme"></i> <?php echo $_SESSION["pinfcoins"];?> PinfCoins</p>
            <p><i class="fas fa-comment-dots fa-fw w3-margin-right w3-text-theme"></i> "<?php echo $_SESSION["bio"];?>"</p>
        </div>
    </div>
    
    <p>
        <a href = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?p=" . (($_SESSION['privacidad']) ? "0" : "1"); ?>" class = "btn btn-warning">Cambiar privacidad</a>
        <a href="reset-password.php" class="btn btn-warning">Cambiar contraseña</a>
        <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
        <a href="form.php" class="btn btn-danger">Editar perfil</a>
        <a href="main.php" class="btn btn-primary">Volver</a>
    </p>
</body>
</html>
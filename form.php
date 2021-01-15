<?php
include_once('processForm.php');
header('Content-Type: text/html; charset=ISO-8859-1');
$id = $_SESSION["id"];
$link = mysqli_connect("localhost", "root", "", "pinf");

// Cargar valores existentes del perfil para colocarlos por defecto
$perfil_sql = "SELECT `name`, bio FROM users WHERE id = $id";
$perfil = mysqli_fetch_array(mysqli_query($link, $perfil_sql));

include_once "actualizardatos.php"; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" type="image/x-icon" href="images/MonedaFinal-ConvertImage.ico" />
    <title>5&Bet - Editar Perfil</title>
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″ />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/registro.css">
    <link rel="stylesheet" href="css/custom.css">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="main.css">
</head>

<body>
  <div class = "register-box">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <a href="index.php"><img src="images/logo.png" class="avatar" alt="Imagen Avatar"></a>
            <h1>Editar perfil</h1>

            <!-- Mensaje de éxito o error al modificar el perfil -->
            <?php if (!empty($msg)) : ?>
                <div class="alert <?php echo $msg_class ?>" role="alert" style="text-align:center">
                    <?php echo $msg; ?>
                </div>
            <?php endif; ?>

            <!-- Cambiar imagen -->
            <div class="form-group text-center" style="position: relative;">
                <span class="img-div">
                    <div class="text-center img-placeholder" onClick="triggerClick()">
                        <h4>Cambiar imagen</h4>
                    </div>
                    <img src="<?php echo 'imagenesperfil/' . $_SESSION["profile_image"] ?>" onClick="triggerClick()" width="" id="profileDisplay">
                </span>
                    <input type="file" name="profileImage" onChange="displayImage(this)" id="profileImage" class="form-control" style="display: none;" accept="image/*">
                    <h2>Imagen de perfil</h2>
            </div>

            <!-- Cambiar nombre -->
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Escribe tu nombre..." value="<?php echo $perfil['name']; ?>">
            </div>

            <!-- Cambiar bio -->
            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea type="bio" id="bio" name="bio" class="form-control" placeholder="Escribe tu biografia..."><?php echo $perfil['bio']; ?></textarea>
            </div>

            <!-- Botones -->
            <div style="margin-left: 20px;">
                <input type="submit" class="btn btn-primary" value="Aceptar">
                <a href="perfil.php" id="boton" class="btn btn-primary">Cancelar</a>
            </div>
        </form>
    </div>
</body>

</html>
<script src="scripts.js"></script>
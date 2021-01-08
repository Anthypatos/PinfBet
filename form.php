<?php
include_once('processForm.php');

$id = $_SESSION["id"];
$link = mysqli_connect("localhost", "root", "", "pinf");

// Cargar valores existentes del perfil para colocarlos por defecto
$perfil_sql = "SELECT `name`, bio FROM users WHERE id = $id";
$perfil = mysqli_fetch_array(mysqli_query($link, $perfil_sql));
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" type="image/x-icon" href="images/MonedaFinal-ConvertImage.ico" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Site Icons -->
    <link rel="shortcut icon" href="" type="image/x-icon" />
    <link rel="apple-touch-icon" href="">
    <!--Login CSS -->
    <link rel="stylesheet" href="css/registro.css">
    <!-- ALL VERSION CSS -->
    <link rel="stylesheet" href="css/versions.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/custom.css">
    <!-- font family -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Perfil</title>
    <!-- Bootstrap CSS -->
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
                    <img src="<?php echo 'imagenesperfil/' . $_SESSION["profile_image"] ?>" onClick="triggerClick()" id="profileDisplay">
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
            <div class="form-group">
                <input type="submit" name="save_profile" value="Guardar">
                <p><a href="perfil.php" class="boton">Volver</a></p>
            </div>
        </form>
    </div>
</body>

</html>
<script src="scripts.js"></script>
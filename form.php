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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Image Preview and Upload PHP</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" />
  <link rel="stylesheet" href="main.css">
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-4 offset-md-4 form-div" style = "margin-top:20px;">
        <a href="profiles.php">Ver todos los perfiles</a>
        <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "post" enctype = "multipart/form-data">
          <h2 class="text-center mb-3 mt-3">Editar perfil</h2>

          <!-- Mensaje de éxito o error al modificar el perfil -->
          <?php if (!empty($msg)): ?>
            <div class="alert <?php echo $msg_class ?>" role="alert" style="text-align:center">
              <?php echo $msg; ?>
            </div>
          <?php endif; ?>

          <!-- Cambiar imagen -->
          <div class="form-group text-center" style="position: relative;" >
            <span class="img-div">
              <div class="text-center img-placeholder"  onClick="triggerClick()">
                <h4>Cambiar imagen</h4>
              </div>
              <img src="<?php echo 'imagenesperfil/' . $_SESSION["profile_image"] ?>" onClick="triggerClick()" id="profileDisplay">
            </span>
            <input type="file" name="profileImage" onChange="displayImage(this)" id="profileImage" class="form-control" style="display: none;" accept = "image/*">
            <label>Imagen de perfil</label>
          </div>

          <!-- Cambiar nombre -->
          <div class="form-group">
            <label for = "nombre">Nombre</label>
            <input type= "text" id = "nombre" name= "nombre" class= "form-control" placeholder = "Escribe tu nombre..." value = "<?php echo $perfil['name']; ?>">
          </div>

          <!-- Cambiar bio -->
          <div class="form-group">
            <label for = "bio">Bio</label>
            <textarea id = "bio" name="bio" class="form-control" placeholder = "Escribe tu bio..."><?php echo $perfil['bio']; ?></textarea>
          </div>

          <!-- Botones -->
          <div class="form-group">
            <button type="submit" name="save_profile" class="btn btn-primary btn-block">Guardar</button>
            <a href="main.php" class="btn btn-primary btn-block">Volver</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
<script src="scripts.js"></script>

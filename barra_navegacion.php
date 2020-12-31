<?php
    $user_actual = $_SESSION['id']; // Usuario cliente

    /* Bloque comprobar notificaciones */
    $contador_notis = 0;
    $bandera_solicitudes = false; // Bandera solicitudes de amistad

    $enlace = mysqli_connect("localhost", "root", "", "pinf");
  
    // Comprobar solicitudes de amistad pendientes
    $comprobar_solicitudes = "SELECT * FROM amistades WHERE usuario2 = '$user_actual' and solicitud = 1 and amigos = 0";
    $comprobar_consulta = mysqli_query($enlace, $comprobar_solicitudes);
  
    if (($numero_solicitudes = mysqli_num_rows($comprobar_consulta)) > 0) // Si hay solicitudes
    {
      $bandera_solicitudes = true;
      $contador_notis += $numero_solicitudes;
    }
    /* Fin bloque notificaciones */

    mysqli_close($enlace);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/all.css" > <!-- Iconos de FontAwesome -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
    <style>
    html, body, h1, h2, h3, h4, h5 {font-family: "Open Sans", sans-serif}
    img 
    {
      border-radius: 50%;
    }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="w3-top">
 <div class="w3-bar w3-theme-d2 w3-left-align w3-large">
  <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
  <a href="index.php" class="w3-bar-item w3-button w3-padding-large w3-theme-d4"><i class="fa fa-home w3-margin-right"></i>Logo</a>
  <a href="perfil.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Mi perfil"><i class="fas fa-user"></i></a>
  <a href="apuesta.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Apostar"><i class="fas fa-coins"></i></a>
  <a href="rankingmain.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Ranking"><i class="fas fa-list-ol"></i></a>
  <a href="social.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Social"><i class="fas fa-grin-wink"></i></a>

<!-- Bloque notificaciones -->
<?php
  if ($contador_notis > 0)
  {
?>
    <div class="w3-dropdown-hover w3-hide-small">
      <button class="w3-button w3-padding-large" title="Notificaciones">
        <i class="fas fa-envelope"></i>
        <span class="w3-badge w3-right w3-small w3-green">
          <?php echo $contador_notis; ?>
        </span>
      </button>
      <div class="w3-dropdown-content w3-card-4 w3-bar-block" style="width:300px">
<?php
          if ($bandera_solicitudes)
          {
?>
              <a href="social.php" class="w3-bar-item w3-button">
<?php
                if ($numero_solicitudes == 1) echo "Nueva solicitud de amistad";
                else echo "$numero_solicitudes nuevas solicitudes de amistad";
?>
              </a>
<?php
          }
?>
      </div>
    </div>
<?php
  }
  else
  {
    ?>
    <div class="w3-dropdown-hover w3-hide-small">
      <button class="w3-button w3-padding-large" title="No hay notificaciones nuevas">
        <i class="far fa-envelope-open"></i>
        <span class="w3-badge w3-right w3-small w3-green">
        </span>
      </button>
    </div>
  <?php
  }
?>
<!-- Fin bloque notificaciones -->

  <a href="main.php" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white" title="Mi cuenta">
    <img src="<?php echo 'imagenesperfil/' . $_SESSION["profile_image"] ?>" class="w3-circle" style="height:23px;width:23px" alt="Mi avatar">
  </a>
 </div>
</div>

<!-- Navbar on small screens -->
<div id="navDemo" class="w3-bar-block w3-theme-d2 w3-hide w3-hide-large w3-hide-medium w3-large">
  <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 1</a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 2</a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 3</a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large"><b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></a>
</div>

</body>
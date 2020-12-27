<?php
  // Initialize the session
  session_start();
  
  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
      header("location: login.php");
      exit;
  }

  include_once "actualizardatos.php"; 

  $contador_notis = 0;
  $bandera_solicitudes = false;

  $user_actual = $_SESSION['username']; // Usuario cliente

  $comprobar_solicitudes = "SELECT * FROM amistades WHERE usuario2 = '$user_actual' and solicitud = 1 and amigos = 0";
  $comprobar_consulta = mysqli_query($link, $comprobar_solicitudes);

  if (($numero_solicitudes = mysqli_num_rows($comprobar_consulta)) != 0)
  {
    $bandera_solicitudes = true;
    $contador_notis += $numero_solicitudes;
  }
?>


<!DOCTYPE html>
<html>
<head>
  <title>5&Bet</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
<body class="w3-theme-l5">

<!-- Navbar -->
<div class="w3-top">
 <div class="w3-bar w3-theme-d2 w3-left-align w3-large">
  <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
  <a href="main.php" class="w3-bar-item w3-button w3-padding-large w3-theme-d4"><i class="fa fa-home w3-margin-right"></i>Logo</a>
  <a href="perfil.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Mi perfil"><i class="fas fa-user"></i></a>
  <a href="apuesta.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Apostar"><i class="fas fa-coins"></i></a>
  <a href="rankingmain.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Ranking"><i class="fas fa-list-ol"></i></a>
  <a href="social.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Social"><i class="fas fa-grin-wink"></i></a>
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
  <a href="perfil.php" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white" title="Mi cuenta">
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

<!-- Page Container -->
<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">    
  <!-- The Grid -->
  <div class="w3-row">
    <!-- Left Column -->
    <div class="w3-col m3">
      <!-- Profile -->
      <div class="w3-card w3-round w3-white">
      
        <div class="w3-container">
         <h4 class="w3-center"><b><?php echo htmlspecialchars($username_user); ?></b></h4>
         <p class="w3-center"><img src="<?php echo 'imagenesperfil/' . $profile_image_user ?>" width="90" height="90" alt=""></p>
         <hr>
         <p><i class="fas fa-user-circle fa-fw w3-margin-right w3-text-theme"></i><?php echo $name_user;?></p>
         <p><i class="fas fa-money-bill fa-fw w3-margin-right w3-text-theme"></i><?php echo $pinfcoins_user;?> PinfCoins</p>
         <p><i class="fas fa-comment-dots fa-fw w3-margin-right w3-text-theme"></i><?php echo $bio_user;?></p>
        </div>
      </div>
      <br>
      
      <!-- Accordion -->
    
      
      
      <!-- Interests --> 
     
     
      
      <!-- Alert Box -->
   
    
    <!-- End Left Column -->
    </div>
    
    <div class="w3-col m8">
      <div class="w3-row-padding">
        <div class="w3-col m12">
          <div class="w3-card w3-round w3-white">
            <div class="w3-container w3-padding">
              <h4>Últimas Apuestas</h4>
              <?php require __DIR__ . '/actualizarapuesta.php'; ?>
              
            </div>
          </div>
        </div>
      </div>
    </div>
    
  <!-- End Middle Column -->
  
    <!--<div class="w3-col m8">
      <div class="w3-row-padding">
        <div class="w3-col m12">
          <div class="w3-card w3-round w3-white">
            <div class="w3-container w3-padding">
              <h4>Muro</h4>
                <?php //require "muros.php"; ?>
            </div>
          </div>
        </div>
      </div>
    </div>-->
    
    <!-- Right Column -->
   
  
<!-- End Page Container -->


<!-- Footer -->



 
<script>
// Accordion
function myFunction(id) {
  var x = document.getElementById(id);
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
    x.previousElementSibling.className += " w3-theme-d1";
  } else { 
    x.className = x.className.replace("w3-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace(" w3-theme-d1", "");
  }
}

// Used to toggle the menu on smaller screens when clicking on the menu button
function openNav() {
  var x = document.getElementById("navDemo");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}
</script>

</body>
</html> 

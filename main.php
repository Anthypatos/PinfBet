<?php
  // Initialize the session
  session_start();
  
  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
      header("location: login.php");
      exit;
  }

  include_once "actualizardatos.php"; 

  $user_actual = $_SESSION['id']; // Usuario cliente

  /* Consultar si el usuario que hay en pantalla es amigo del cliente */
  $amigos_sql = "SELECT * FROM amistades WHERE usuario1 = '$user_actual' AND usuario2 = '$id_user' AND amigos = 1";
  $amigos_consulta = mysqli_query($link, $amigos_sql);

  if (mysqli_num_rows($amigos_consulta) > 0) $amigos = true;
  else $amigos = false;
?>


<!DOCTYPE html>
<html>
<head>
  <link rel="icon" type="image/x-icon" href="images/MonedaFinal-ConvertImage.ico" />  
  <title>5&Bet - Menu Principal</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/all.css" > <!-- Iconos de FontAwesome -->
  <link rel="stylesheet" href="css/principal.css">

  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
</head>
<body>

<?php include "barra_navegacion.php"; ?>

<!-- Page Container -->
<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">    
  <!-- The Grid -->
  <div class="w3-row">
    <!-- Left Column -->
    <div class="w3-col m3">
      <!-- Profile -->
      <div class="w3-card w3-round w3-white">
        
        <div class="w3-container">
         <h4 class="w3-center"><b><?php echo htmlspecialchars($username_user); ?></b> <?php if ($privacidad_user) { ?><i class="fas fa-lock" title = "Este perfil es privado"></i><?php } ?></h4>
         <p class="w3-center"><img src="<?php echo 'imagenesperfil/' . $profile_image_user ?>" width="90" height="90" alt=""></p>
         <hr>
         <p><i class="fas fa-user-circle fa-fw w3-margin-right w3-text-theme"></i><?php echo $name_user;?></p>
         <p><i class="fas fa-coins fa-fw w3-margin-right w3-text-theme"></i><?php echo $pinfcoins_user;?> PinfCoins</p>
         <p><i class="fas fa-comment-dots fa-fw w3-margin-right w3-text-theme"></i><?php echo $bio_user;?></p>
        </div>
      </div>
      <br>
    
    <!-- Lista de amigos -->
    <?php if ($privacidad_user && !($amigos) && $id_user != $_SESSION['id'])
          {
    ?>
            </div>
            <div style = "text-align:center; margin-top:150px;"><i class="fas fa-user-lock"></i> Este perfil es privado</div>
    <?php
          }
          else
          {
            include "lista_amigos.php";
    ?>
    
<!-- End Left Column -->
  </div>
    
    <div class="w3-col m9">

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
            
      <!-- Muros de perfil -->
      <hr>
      <?php include "muros.php"; ?>

    </div>
    
      <!-- End Middle Column -->
    <!-- Right Column -->
<!-- End Page Container -->
</div>

<!-- Footer -->

<?php } ?>

 
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

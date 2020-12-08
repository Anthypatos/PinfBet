<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
?>

<!DOCTYPE html>
<html lang="es">
   <!-- Basic -->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- Mobile Metas -->
   <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
   <!-- Site Metas -->
   <title>Casa de Apuestas</title>
   <meta name="keywords" content="">
   <meta name="description" content="">
   <meta name="author" content="">
   
   <link rel="stylesheet" href="css/master.css?n=1">
   <!-- Site Icons -->
   <link rel="shortcut icon" href="" type="image/x-icon" />
   <link rel="apple-touch-icon" href="">
   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <!-- Site CSS -->
   <link rel="stylesheet" href="style.css">
   <!-- Colors CSS -->
   <link rel="stylesheet" href="css/colors.css">
   <!-- ALL VERSION CSS -->	
   <link rel="stylesheet" href="css/versions.css">
   <!-- Responsive CSS -->
   <link rel="stylesheet" href="css/responsive.css">
   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/custom.css">
   <!-- font family -->
   <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
   <!-- end font family -->
   <link rel="stylesheet" href="css/3dslider.css" />
   <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
   <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
   <script src="js/3dslider.js"></script>
   </head>
   <body class="CasaDeApuestas" data-spy="scroll" data-target=".header">
      <!-- LOADER -->
      <div id="preloader">
         <img class="preloader" src="images/loading-img.gif" alt="">
      </div>
      <!-- END LOADER -->
      <section id="top">
         <header>
            <div class="container">
               <div class="header-top">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="full">
                           <div class="logo">
                              <a href="index.php"><img src="images/logo.png"  height="80"/></a>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="right_top_section">
                           <!-- button section -->
                           <ul class="login">
                              <li class="login-modal">
                                 <a href="login.php" class="login"><i class="fa fa-user"></i>Iniciar Sesión</a>
                              </li>
                              <li>
                                 <div class="cart-option">
                                    <a href="register.php"><i class ="fa fa-user"></i>Registrarse</a>
                                 </div>
                              </li>
                           </ul>
                           <!-- end button section -->
                        </div>
                     </div>
                  </div>
               </div>
               <div class="header-bottom">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="full">
                           <div class="main-menu-section">
                              <div class="menu">
                                 <nav class="navbar navbar-inverse">
                                    <div class ="container-fluid">
                                       <div class="navbar-header">
                                          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
                                          <span class="sr-only">Barra Navegacion</span>
                                          <span class="icon-bar"></span> <!-- Para crear el logo de botón en versión móvil -->
                                          <span class="icon-bar"></span>
                                          <span class="icon-bar"></span>
                                          </button>
                                          <a class="navbar-brand" href="#"> ACCEDER</a>
                                       </div>
                                    </div>
                                    <div class="collapse navbar-collapse js-navbar-collapse">
                                       <ul class="nav navbar-nav">
                                          <li><a class ="login" href="login.php"><i class = "fa fa-user"></i>  INICIAR SESION</a></li>
                                          <li><a href="register.php"><i class = "fa fa-user"></i>  REGISTRARSE</a></li>
                                       </ul>
                                    </div>
                                    <!-- /.nav-collapse -->
                                 </nav>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </header>
         <div class="full-slider">
            <div id="carousel-example-generic" class="carousel">
               <!-- Wrapper for slides -->
               <div class="carousel-inner" role="listbox">
                  <!-- First slide -->
                  <div class="item active primerafoto" data-ride="carousel">
                     <div class="carousel-caption">
                        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12"></div>
                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                           <div class="slider-contant" data-animation="animated fadeInRight">
                              <h3>Donde <span style="color: #ec8464;">apuestan</span><br>los que <span style="color: #ec8464">aprueban</span></h3>
                              <button class="btn btn-primary btn-lg"><a href="login.php">Apuesta ya</a></button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="news">
               <div class="container">
                  <div class="heading-slider">
                     <p class="headline"><i class="fa fa-star" aria-hidden="true"></i> Noticias Estrellas :</p>
                     <h1>
                     <a href="" class="typewrite" data-period="2000" data-type='[ "EDNL se mantiene con cuotas altas despues de otro año de suspensos.", "Se comenta que SSI este año esta en buena racha de aprobados.", "El COVID-19 mantiene la incertidumbre entre los grupos universitarios"]'>
                     <span class="wrap"></span>
                     </a>
                     </h1>
                     <span class="wrap"></span>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <footer id="footer" class="footer">
         <div class="container">
            <div class="row">
               <div class="col-md-4">
                  <div class="full">
                     <div class="footer-widget">
                        <div class="footer-logo">
                           <a href="#"><img src="images/footer-logo.png" alt="#" /></a>
                        </div>
                        <p>Juega con responsabilidad.<br>+18<br><br>"La suerte, mala o buena, siempre está<br> con nosotros. Pero tiene una manera de favorecer a los inteligentes y darle la espalda a la estupidez."</p>
                        <ul class="social-icons style-4 pull-left">
                           <!--<li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                           <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                           <li><a class="youtube" href="#"><i class="fa fa-youtube-play"></i></a></li>
                           <li><a class="pinterest" href="#"><i class="fa fa-pinterest-p"></i></a></li>-->
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="col-md-2">
                  <div class="full">
                     <div class="footer-widget">
                        <h3>Menu</h3>
                        <ul class="footer-menu">
                           <li><a href="index.html">Inicio</a></li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="full">
                     <div class="footer-widget">
                        <h3>Contacta con nosotros</h3>
                        <ul class="address-list">
                           <li><i class="fa fa-map-marker"></i>Av. Universidad de Cádiz, 10, 11519 Puerto Real, Cádiz</li>
                           <li><i class="fa fa-phone"></i> 956 48 32 00</li>
                           <li><i style="font-size:20px;top:5px;" class="fa fa-envelope"></i> 5&bet@gmail.com</li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="full">
                     <div class="contact-footer">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3205.6634342794637!2d-6.204227585228313!3d36.53811339010932!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x152f79854b8f0de1%3A0x8d075bd9e5895558!2sEscuela%20Superior%20de%20Ingenier%C3%ADa!5e0!3m2!1ses!2ses!4v1607443397000!5m2!1ses!2ses" width="600" height="350" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="footer-bottom">
            <div class="container">
               <p>Copyright © 2020 5&Bet.com Derechos Reservados.</p>
            </div>
         </div>
      </footer>
      <a href="#home" data-scroll class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>
      <!-- ALL JS FILES -->
      <script src="js/all.js"></script>
      <!-- ALL PLUGINS -->
      <script src="js/custom.js"></script>
   </body>
</html>
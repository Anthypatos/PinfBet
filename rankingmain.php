<?php
//Chama os arquivos necessario
include_once __DIR__ . '/includesranking/config/config.php';
include_once __DIR__ . '/includesranking/config/init.php';

$img_src = "assetsranking/images/bg-card3.png";
$imgbinary = fread(fopen($img_src, "r"), filesize($img_src));
$img_str = base64_encode($imgbinary);
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>5&Bet Ranking</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" href="favicon.ico" type="image/x-icon" />
      <link rel="stylesheet" href="assetsranking/css/bootstrap.min.css">
      <link rel="stylesheet" href="assetsranking/css/font-awesome.css">
      <link rel="stylesheet" href="assetsranking/css/style.css?v=<?php echo time(); ?>">
   </head>
   <body>
      <div class="container" style="margin: 30px auto;">
         <div class="row justify-content-center align-items-center">
            <div class="col-md-12">
               <div class="card">
                  <img class="card-img-top" src="data:image/jpg;base64,<?php echo $img_str; ?>">
                  <div class="card-body">
                     <h5 class="card-title"></h5>
                     <p class="card-text"></p>
                  </div>
                  <?php require __DIR__ . '/includesranking/components/getRanking/loader.php'; ?>
                  <div class="card-body text-center">
                  <a href="index.php" class="btn btn">Volver</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script type="text/javascript" src="assetsranking/js/jquery.min.js"></script>
      <script type="text/javascript" src="assetsranking/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="assetsranking/js/pace.min.js"></script>
   </body>
</html>
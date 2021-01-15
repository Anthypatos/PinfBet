<?php
   include_once 'config.php';
   session_start();
   
   if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
   $cantidad = $cantidad_err = "";
   $target_file = 
   $id_user =  $_SESSION['id'];
   if(isset($_FILES['image'])){
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $tmp = explode('.',$_FILES['image']['name']);
      $file_ext = end($tmp);  
      
      $extensions= array("pdf");
      
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="Solo se pueden subir pdf, prueba de nuevo";
      }
      
      if($file_size > 2097152){
         $errors[]='File size must be excately 2 MB';
      }
      
      // Check if file already exists
      
      if (file_exists("expedientes/".$id_user.".pdf")) {
        $errors[]='Ya existe tu expediente en la base.';
      }

       if(empty ($_POST["cantidad"])){
        $errors[] = "Introduce tus creditos aprobados";     
    } elseif($_POST["cantidad"] >=1 && is_numeric($_POST["cantidad"])){
        $cantidad = $_POST["cantidad"];
    } else{
        $errors = "Introduce un valor numérico superior a 0"; 
    }

      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"expedientes/".$id_user.".pdf");
         echo "Success";
         $sql2 = "UPDATE users SET pinfcoins = $cantidad WHERE id = $id_user";
         mysqli_query($link,$sql2);
         header("location: main.php");

      }else{
         $i = 0;
         while(!empty($errors[$i]))
         {
            echo $errors[$i];
            $i++;

         }
      }
   }

?>
<html>
   <body>
   <form action="expediente.php" method="POST" enctype="multipart/form-data">
    <div class="form-group <?php echo (!empty($cantidad_err)) ? 'has-error' : ''; ?>">       
        <h3>Cantidad (PinfCoins)</h3>
        <p>AVISO: La cantidad introducida debe corresponder con los créditos aprobados.</p>
        <p>Un moderador revisará que la cantidad introducida corresponde con el expediente, en el caso de que no coincidan será excluido del uso de esta plataforma y perderá todas las ganancias obtenidas con ese credito.</p>
        <input type="text" name="cantidad" class="form-control" placeholder= "Introduce tus creditos" value=""> 
        <h4><span class="help-block"><?php echo $cantidad_err; ?></span></h4>
     
      
         <input type="file" name="image" />
         <input type="submit"/>
      </form>
      <a href="main.php" id="boton" class="btn btn-primary">Volver</a>
   </body>
</html>

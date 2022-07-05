<?php 
  include "db.php";

  $imagenes = ["./images/email.png", "./images/red.png", "./images/tel.png"];
  $images = (array_rand($imagenes));
//  $i = rand(0, count($imagenes));

  echo '<img src="'.$imagenes[$images].'">';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Enviar Datos a un BD</title>
</head>
<body>
    <div id="contenedor">
        <form method="POST" action="index.php" >
            <input type="text" id="mensaje" name="mensaje" placeholder="Ingresa un mensaje">
            <input type="submit" name="enviar" id="enviar" value="Enviar">
        </form>
        
        <?php
        if(isset($_POST['enviar'])){
            $mensaje = $_POST['mensaje'];
            
            $consulta = "insert into Mensaje (mensaje) values ('$mensaje')";
            $consultaResult = sqlsrv_query($cnx, $consulta);
             if(!$consultaResult)die( print_r(sqlsrv_errors(), true));
            
    
            if($consultaResult){
                echo "Hola";
              
                echo "<script> alert('".$mensaje."'); </script>";
            }
            
            $datos[]= [$mensaje];
            echo json_encode($datos);
        }
        ?>
        
    </div>
    <div id="salida"></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
    <script type="text/javascript" src="funcion.js"></script>
</body>
</html>
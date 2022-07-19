<?php 
include "db.php";

        if(isset($_POST['enviar'])){
            $mensaje = $_POST['mensaje'];
            //echo $mensaje;
            
            $consulta = "insert into Mensaje (mensaje) values ('$mensaje')";
            $consultaResult = sqlsrv_query($cnx, $consulta);
            //print_r($consultaResult);
            if(!$consultaResult) die( print_r(sqlsrv_errors(), true));
            
    
            if($consultaResult){
                echo "<script> alert('".$mensaje."'); </script>";
        
            }
            
            $datos[]= [$mensaje];
            echo json_encode($datos);
        }
?>
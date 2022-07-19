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
    <?php
        use Firebase\JWT\JWT;
        require_once './php-jwt-master/src/JWT.php';        
        $time = time(); //Fecha y hora actual en segundos
        $key = "example_key";
        $token = array(
            'iat' => $time, // Tiempo que inició el token
            'exp' => $time + (60 * 60), // Tiempo que expirará el token (+1 hora)                                                                
            'idUsuario' =>'1',//Informacion de usuario
        );
        $jwt = JWT::encode($token, $key);//Codificamos el Token
        $decoded = JWT::decode($jwt, $key, array('HS256'));//Decodificamos el Token
//        print_r($jwt);//Mostramos el Tocken Codificado
//        echo '<br><br>';
//        print_r($decoded);//Mostramos el Tocken Decodificado
    echo "<script>console.log('Token: " . $jwt . "' );</script>";
         
        ?>
    <div id="contenedor">
        <form method="POST" action="index.php" >
            <input type="text" id="mensaje" name="mensaje" placeholder="Ingresa un mensaje">
            <input type="submit" name="enviar" id="enviar" value="Enviar">
        </form>
        
        <?php
        if(isset($_POST['enviar'])){
            $mensaje = $_POST['mensaje'];
            //echo $mensaje;
            
            $consulta = "insert into Mensaje (mensaje) values ('$mensaje')";
            $consultaResult = sqlsrv_query($cnx, $consulta);
            //print_r($consultaResult);
            if(!$consultaResult) die( print_r(sqlsrv_errors(), true));
            
    
            if($consultaResult){
                //echo "<script> alert('".$mensaje."'); </script>";
                //echo "SUCCESS";
            }
            
            $datos[]= [$mensaje];
            echo json_encode($datos);
        }
        ?>
        
    </div>
    <div id="salida"></div>
    <script>
      // Variables
      const miWebSocket = new WebSocket('ws://localhost:8080');
      const miNuevoMensaje = document.querySelector('#mensaje');
      const misRespuestas = document.querySelector('#salida');
      const button = document.querySelector('#enviar');
        

      // Funciones
      function open () {
          // Abre conexión
          console.log("WebSocket abierto.");
      }

      async function message (evento) {
          // Se recibe un mensaje
          console.log("WebSocket ha recibido un mensaje");
          // Mostrar mensaje en HTML
          const mensajeRecibido = await evento.data.text(); // Arreglo para Node ya que devuelve Blob. Solo con 'evento.data' debería ser suficiente
          misRespuestas.innerHTML = misRespuestas.innerHTML.concat(mensajeRecibido, '<br>');
      }

      function error (evento) {
          // Ha ocurrido un error
          console.error("WebSocket ha observado un error: ", evento);
      }

      function close () {
          // Cierra la conexión
          console.log("WebSocket cerrado.");
      }
        
//      $('#enviar').click(function(){
//		enviarNuevoMensaje();
//	    });
	
      function enviarNuevoMensaje (evento) {
          // Evento tecla Enter
          if(evento.code === 'Enter') {
              // Envia mensaje por WebSockets
              miWebSocket.send(miNuevoMensaje.value);
              // Borra texto en el input
              miNuevoMensaje.value = '';
          }
      }

      // Eventos de WebSocket
      miWebSocket.addEventListener('open', open);
      miWebSocket.addEventListener('message', message);
      miWebSocket.addEventListener('error', error);
      miWebSocket.addEventListener('close', close);

      // Evento para envia nuevo mensaje
      //miNuevoMensaje.addEventListener('keypress', enviarNuevoMensaje);
      button.addEventListener("click", function(evt){
          miWebSocket.send(miNuevoMensaje.value);
          miNuevoMensaje.value = '';
      });

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
    <script type="text/javascript" src="funcion.js"></script>
</body>
</html>
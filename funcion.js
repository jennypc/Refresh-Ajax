var enviar = document.getElementById("enviar");

enviar.addEventListener('click',function(){
    regresar();
}); 

function regresar(){
    $.ajax({
        url:'index.php',
        type: 'post',
        dataType: 'json',
        data:{
            mensaje:$('#mensaje').val()
            
        }
    }).done(
      function(data){
          $('#salida').append(data);
          $('#mensaje').val('');
          
      });
}
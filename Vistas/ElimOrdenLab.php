<script>
    $( "#btnelimorden" ).button({icons: {primary: "ui-icon-trash"}});
      var optionselimorden = {

        success:       showResponseElimOrden
  };
  function showResponseElimOrden(responseText, statusText, xhr, $form)  {
   resp = JSON.parse(responseText);
   if (resp.estado == 1){
     alert('Orden Eliminada del Portal');
   }
     else{
     alert(resp.error);
     
   }

   }
  

  $('#formelimorden').ajaxForm(optionselimorden);
  </script>
<center><h2>Eliminacion de Orden de Trabajo Enviada al Portal Clinico</h2></center>
<center>
<form name='formelimorden' id='formelimorden' method='post' action='Servicios/setEliminaOrden.php'>
    Numero de Orden<input type="text" name="nro_orden"><br>
    <button type='submit' id="btnelimorden">Eliminar Orden</button>
</form>
</center>
function log_portal(id_accion,app,run_paciente,id) {
    $.ajax({
  type: "POST",
  async:false,
  url: "Servicios/setLog.php",
  data: {id_accion:id_accion,app:app,run_paciente:run_paciente,id:id},
  dataType: "json"
});
}
function custom_alert( message, title ) {
    if ( !title )
        title = 'Alert';

    if ( !message )
        message = 'No Message to Display.';

    $('<div></div>').html( message ).dialog({
        title: title,
        resizable: false,
        modal: true,
		open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
        buttons: {
            'Ok': function()  {
                log_portal('I','portal','','');
        
                $( this ).dialog( 'close' );
				window.location="index.php";
            }
        }
    });
}


function onInit() {

	if($('#conectado').attr("value") =="S"){

	}else{
          function showResponseLogin(responseText, statusText, xhr, $form)  { 
                resp = JSON.parse(responseText);
                if (resp.estado==1){
                  if (resp.popup=='S') {
                  
				  custom_alert(resp.datos_popup.mensaje,resp.datos_popup.titulo);
                  }
                  else{
                   log_portal('I','portal','',''); 
                   window.location="index.php";
                  }
				}  
                else{ 
                  alert(resp.mensaje);
                } 
            }  
	    var optionslogin = { 
                success:       showResponseLogin
            };   
                  
            $('#form_login').ajaxForm(optionslogin);
	    

	

        }
}




$(document).ready(onInit);

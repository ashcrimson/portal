<?php
include("../funciones.global.inc.php");
include("../funciones.inc.php");
verifica_sesion(false);
?>


         


 



<script type="text/javascript">
		function getEspecialidades(){
				var res="";
				$.ajax({
  dataType: "json",
  url: "Servicios/getEspecialidades.php",
  async: false,
  success:
      function(data) {
            if (data != null) {
				
                 res = data;
            }
        }});
				return res;
        }
        $( "#insu" ).button({icons: {primary: "ui-icon-plus"}});
        $( "#updu" ).button({icons: {primary: "ui-icon-pencil"}});
        $( "#delu" ).button({icons: {primary: "ui-icon-trash"}});
		$( "#peru" ).button({icons: {primary: "ui-icon-document"}});
		 $("#btn-buscar").button({icons: {primary: "ui-icon-search"}}); 
$("#btn-limpiar").button({icons: {primary: "ui-icon-trash"}}); 
	  var auths ="1:Autenticacion LDAP;2:Autenticacion Propia";
          var admin ="N:No;S:Si";
$(function(){ 
    $("#list-usuarios").jqGrid({
      url:'Servicios/getUsuarios.php',
	  editurl:'Servicios/setUsuarios.php',
	  width:1200,
	  datatype: 'json', loadonce: false,height: 300,
	  colNames:["Email","Nombres","Apellido Paterno","Apellido Materno",'Clave','Tipo Autenticacion','SN Administrador','SN Enfermero Anest','SN Pabellonero/Arsenalero','SN Enfermera Univ','SN Estadistico','Especialidad','Subespecialidad 1','Subespecialidad 2','Rut','SN Subdirector Clinico','SN Enfermera Epidemiologia','SN Residente','SN Elimina Orden Lab'
		    ],
	  colModel :[
		     {name:'email', index:'email', width:50, align:'center',editable:true},
		     {name:'nombres', index:'nombres', width:50, align:'center',editable:true},
		     {name:'apellido_paterno', index:'apellido_paterno', width:50, align:'center',editable:true},
		     {name:'apellido_materno', index:'apellido_materno', width:50, align:'center',editable:true},
		     {name:'clave', index:'clave', width:95, align:'center',editable:true,hidden:true,edittype:"password",editrules:{ edithidden:true, required:true}},
		     {name:'ind_auth', index:'ind_auth', width:50, align:'center',editable:true,edittype: "select",editoptions: { value: auths},editrules:{}},
             {name:'sn_admin', index:'sn_admin', width:50, align:'center',editable:true,edittype: "select",editoptions: { value: admin},editrules:{}},
             {name:'sn_enf_anest', index:'sn_enf_anest', width:50, align:'center',editable:true,edittype: "select",editoptions: { value: admin},editrules:{}},
             {name:'sn_arsen_pabellonero', index:'sn_arsen_pabellonero', width:50, align:'center',editable:true,edittype: "select",editoptions: { value: admin},editrules:{}},
             {name:'sn_enfermera_univ', index:'sn_enfermera_univ', width:50, align:'center',editable:true,edittype: "select",editoptions: { value: admin},editrules:{}},
             {name:'sn_estadistico', index:'sn_estadistico', width:50, align:'center',editable:true,edittype: "select",editoptions: { value: admin},editrules:{}},
             {name:'especialidad', index:'especialidad', width:50, align:'center',editable:true,edittype:"select",formatter: 'select',editoptions:{ value:getEspecialidades()}},
             {name:'subespecialidad1', index:'subespecialidad1', width:50, align:'center',editable:true,edittype:"select",formatter: 'select',editoptions:{ value:getEspecialidades()}},
             {name:'subespecialidad2', index:'subespecialidad2', width:50, align:'center',editable:true,edittype:"select",formatter: 'select',editoptions:{ value:getEspecialidades()}},
             
			 {name:'rut', index:'rut', width:50, align:'center',editable:true,editoptions: {size:10,maxlength:10}},
             {name:'sn_subdirector_clinico', index:'sn_subdirector_clinico', width:50, align:'center',editable:true,edittype: "select",editoptions: { value: admin},editrules:{}},
             {name:'sn_enfermera_epidemiologia', index:'sn_enfermera_epidemiologia', width:50, align:'center',editable:true,edittype: "select",editoptions: { value: admin},editrules:{}},
             {name:'sn_residente', index:'sn_residente', width:50, align:'center',editable:true,edittype: "select",editoptions: { value: admin},editrules:{}},
             {name:'sn_elimordenlab', index:'sn_elimordenlab', width:50, align:'center',editable:true,edittype: "select",editoptions: { value: admin},editrules:{}}
                     

		     ],jsonReader: { repeatitems : false, id: "0" },
	  rowNum:1000, rowList:[100,200,300], sortname: 'fecha', viewrecords: true, sortorder: "desc", caption:"Mantencion de Usuarios",

          });
}); 
function addUsuario() {

  $("#list-usuarios").jqGrid('editGridRow',"new",{
    reloadAfterSubmit:true,
				 closeAfterAdd:true,
				 jqModal:false,
				 width: 600,
				 afterSubmit: function (response) {
				 resp = JSON.parse(response.responseText);
				 if (resp.estado ==0){

				   return [false, resp.error, response.responseText];

				 }
				 else{
				   return [true, '', response.responseText];
				 }
			       }
    });

}
function editUsuario() {

  var selected = jQuery("#list-usuarios").jqGrid('getGridParam','selrow');
  if (selected == null) alert('Debe seleccionar una fila.');
  if (selected != null){
    $("#list-usuarios").jqGrid('editGridRow', selected,{viewPagerButtons: false,
				   reloadAfterSubmit:true,
				   closeAfterEdit:true,
				   jqModal:false,
				   width: 600,
				   afterSubmit: function (response) {
				   resp = JSON.parse(response.responseText);
				   if (resp.estado ==0){

				     return [false, resp.error, response.responseText];

				   }
				   else{
				     return [true, '', response.responseText];
				   }
				 }
			       });
  }
}
function delUsuario() {

  var selected = jQuery("#list-usuarios").jqGrid('getGridParam','selrow');
  if (selected == null) alert('Debe seleccionar una fila.');
  if (selected != null){
    $("#list-usuarios").jqGrid('delGridRow', selected,{viewPagerButtons: false,
				   reloadAfterSubmit:true,
				   closeAfterEdit:true,
				   jqModal:false,
				   width: 600,
				   afterSubmit: function (response) {
				   resp = JSON.parse(response.responseText);
				   if (resp.estado ==0){

				     return [false, resp.error, response.responseText];

				   }
				   else{
				     return [true, '', response.responseText];
				   }
				 }
			       });
  }
}
function verPerfil(){
 
var   titulo="Mantencion de Perfiles";
    var selected = jQuery("#list-usuarios").jqGrid('getGridParam','selrow');
  if (selected == null) alert('Debe seleccionar una fila.');
  if (selected != null){
var email = jQuery("#list-usuarios").jqGrid('getCell',selected,'email');
  $("#vwperfilu").remove();
  var tag = $("<div id='vwperfilu'></div>"); //This tag will the hold the dialog content.                                                                                           
  $.ajax({
    url: 'Vistas/Perfil.php?email='+email,
    type: 'GET',
    async:false,
    success: function(data, textStatus, jqXHR) {
      if(typeof data == "object" && data.html) { //response is assumed to be JSON                                                                                                    
        tag.html(data.html).dialog({modal: true,position:[300,0], title: titulo,width:'100%',height:'550',resizable:false,close: function(event, ui) {  $("#vwperfilu").remove(); }}).dialog('open');
      } else { //response is assumed to be HTML                                                                                                                                      
        tag.html(data).dialog({modal: true,position:[300,0], title: titulo,width:'100%',height:'550',resizable:false,close: function(event, ui) {  $("#vwperfilu").remove(); }}).dialog('open');
      }
    }
  });
  }
}
</script>
 
</head>
<body>
<span style="font-family: Tahoma, Ubuntu;font-size:12px;"> Busqueda : </span><input type="text" id="busq" name="busq" size="20" maxlength="40" onkeyup="$('#list-usuarios').setGridParam({url:'Servicios/getUsuarios.php?busq='+$('#busq').val()});$('#list-usuarios').trigger( 'reloadGrid' );"><button id="btn-limpiar" class="boton" onclick="$('#busq').val('');$('#list-usuarios').setGridParam({url:'Servicios/getUsuarios.php'});$('#list-usuarios').trigger( 'reloadGrid' );">Limpiar Filtros</button>
		
<table id="list-usuarios"><tr><td/></tr></table> 
<div id="pager-u"></div> 
<button id="insu" class="boton" onclick="addUsuario();">Ingresar Usuario</button>
<button id="updu" class="boton" onclick="editUsuario();">Modificar Usuario</button>
<button id="delu" class="boton" onclick="delUsuario();">Eliminar Usuario</button>
<button id="peru" class="boton" onclick="verPerfil();">Mantener Perfiles de Usuario</button>

</body>
</html>

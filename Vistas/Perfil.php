<script>
    $( "#insp" ).button({icons: {primary: "ui-icon-document"}});
      var optionsperfil = {

        success:       showResponsePerfil
  };
  function showResponsePerfil(responseText, statusText, xhr, $form)  {
   resp = JSON.parse(responseText);
   if (resp.estado == 1){
     alert('Perfiles Actualizados');
     $('#vwperfilu').dialog('close');
   }
     else{
     alert(resp.error);
     $("#guardaraeu").button( "option", "disabled", false );
     $("#spin").hide();
   }

   }
  

  $('#perfiles').ajaxForm(optionsperfil);
    function habilita_perfil(obj){
        
        var res = obj.name.split("_"); 
        if (obj.checked) {
          
          $("#f_"+res[1]).children().attr('disabled', false);
          $("#f_"+res[1]).children().val("");
          $("#jefe_servicio_"+res[1]).attr('checked', false);
          
        }
        else{
           $("#f_"+res[1]).children().attr('disabled', true);
           $("#f_"+res[1]).children().val( "");
           $("#jefe_servicio_"+res[1]).attr('checked', false);
        }
        
    }
</script>
<?php

  include("../funciones.global.inc.php");
  verifica_sesion(false);
  $db=genera_adodb();
  $recordset = $db->Execute("select * from usuario where email=?",array($_REQUEST["email"]));
  if (!$recordset) die($db->ErrorMsg());
  
  while ($arr = $recordset->FetchRow()) {
   print("<h3> Mantencion de Perfiles del Usuario : ".$arr["nombres"]." ".$arr["apellido_paterno"]." ".$arr["apellido_materno"]."</h3>");
   }
  print("<form name='perfiles' id='perfiles' method='post' action='Servicios/setPerfil.php'>");
  print("<input type='hidden' name='email' value='".$_REQUEST["email"]."'>");
  $recordset = $db->Execute("select * from apps");
  if (!$recordset) die($db->ErrorMsg());
  
  while ($arr = $recordset->FetchRow()) {
   $sql_perfil="select * from parametros_".$arr["app"] ." where email=?";
    $recordset_p = $db->Execute($sql_perfil,array($_REQUEST["email"]));
  if (!$recordset_p) die($db->ErrorMsg());
   $perfil=array();
   while ($arr_p= $recordset_p->FetchRow()) {
      $perfil=$arr_p;
   }
   if(count($perfil) > 0){
    $checked="checked";
    $disabled="";
   }
   else{
    $checked="";
    $disabled="disabled";
   }
   print("<fieldset name='f_".$arr["app"]."' id='f_".$arr["app"]."'><label><input type='checkbox' name='c_".$arr["app"]."' id='c_".$arr["app"]."' $checked value='S' onclick='habilita_perfil(this);'>".strtoupper($arr["app"])."</label><br>");
   if($arr["app"] =="ram"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");
    if($perfil["jefe_servicio"]==1){
        $chk_jefe="checked";
        
    }
    else{
        $chk_jefe="";
        
    }
    print("<b>Es Jefe de Servicio</b> <input type='checkbox' id='jefe_servicio_".$arr["app"]."' name='jefe_servicio_".$arr["app"]."' $chk_jefe value='S'><br>");
    $sql_t="select * from servicio_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Servicio :</b> <select id='cod_servicio_".$arr["app"]."' name='cod_servicio_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)
    $arr_t[$k]=utf8_encode($v);
      if($arr_t["cod_servicio"] == $perfil["cod_servicio"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["cod_servicio"]."' $selected >".$arr_t["desc_servicio"]."</option>");
    }
    print("</select><br>");    
   }
    elseif($arr["app"] =="urgencias"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");
    for($ii=1;$ii<=4;$ii++){
        $sql_t="select * from servicio_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Servicio $ii :</b> <select id='cod_tipo_serv".$ii."_".$arr["app"]."' name='cod_tipo_serv".$ii."_".$arr["app"]."' $disabled>");
    
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["cod_tipo_serv"] == $perfil["cod_tipo_serv".$ii]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["cod_tipo_serv"]."' $selected >".$arr_t["desc_tipo_serv"]."</option>");
    }
    print("</select><br>");
      
    }
    if($perfil["sn_jefe_serv"]=='S'){
        $chk_jefe="checked";
        
    }
    else{
        $chk_jefe="";
        
    }
     print("<b>Es Jefe de Servicio</b> <input type='checkbox' id='sn_jefe_serv_".$arr["app"]."' name='sn_jefe_serv_".$arr["app"]."' $chk_jefe value='S'><br>");    
   }
   elseif($arr["app"] =="licencias"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");
    for($ii=1;$ii<=5;$ii++){
        $sql_t="select * from origen_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Reparticion $ii :</b> <select id='cod_repart".$ii."_".$arr["app"]."' name='cod_repart".$ii."_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["cod_repart"] == $perfil["cod_repart".$ii]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["cod_repart"]."' $selected >".$arr_t["desc_repart"]."</option>");
    }
    print("</select><br>");    
        
    }
   }
    elseif($arr["app"] =="registrominsal"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");    
   }
     elseif($arr["app"] =="inmunizaciones"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");    
   }
    elseif($arr["app"] =="rayos"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");    
   }
   elseif($arr["app"] =="referencia"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die( $db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");    
   }
     elseif($arr["app"] =="afisan"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");    
   }
   elseif($arr["app"] =="epicrisis"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");    
   }
   elseif($arr["app"] =="indicadores"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");    
   }
//nuevo--------------------------------------------------------------------
elseif($arr["app"] =="horas"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");    
   }

elseif($arr["app"] =="centro"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");    
}
elseif($arr["app"] =="docclinico"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");
    $sql_t="select * from servicio_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Servicio :</b> <select id='cod_servicio_".$arr["app"]."' name='cod_servicio_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)
    $arr_t[$k]=utf8_encode($v);
      if($arr_t["cod_servicio"] == $perfil["cod_servicio"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["cod_servicio"]."' $selected >".$arr_t["desc_servicio"]."</option>");
    }
    print("</select><br>"); 
   }
   elseif($arr["app"] =="gespac"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");
    $sql_t="select * from procedencia_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Procedencia :</b> <select id='cod_procedencia".$arr["app"]."' name='cod_procedencia_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)
    $arr_t[$k]=utf8_encode($v);
      if($arr_t["cod_procedencia"] == $perfil["cod_procedencia"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["cod_procedencia"]."' $selected >".$arr_t["desc_procedencia"]."</option>");
    }
    print("</select><br>"); 
   }
  elseif($arr["app"] =="fichaupc"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");    
   }
   elseif($arr["app"] =="examrayos"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");    
   }
     elseif($arr["app"] =="fichaiaas"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");    
   }
   elseif($arr["app"] =="fichatmq"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");    
   }
   elseif($arr["app"] =="ges"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");    
   }
   elseif($arr["app"] =="cinf"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");    
   }
   
   elseif($arr["app"] =="fichageriatria"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");    
   }
   elseif($arr["app"] =="fichaoncohemato"){
    $sql_t="select * from tipo_usuario_".$arr["app"];
    $recordset_t = $db->Execute($sql_t);
    if (!$recordset_t) die($db->ErrorMsg());
    print("<b>Tipo Usuario :</b> <select id='tipo_usuario_".$arr["app"]."' name='tipo_usuario_".$arr["app"]."' $disabled>");
    print("<option value=''>No aplica</option>");
   while ($arr_t = $recordset_t->FetchRow()) {
    foreach($arr_t as $k =>$v)      $arr_t[$k]=utf8_encode($v);
      if($arr_t["tipo_usuario"] == $perfil["tipo_usuario"]){
       $selected="selected";
      }
      else{
        $selected="";
      }
      print("<option value='".$arr_t["tipo_usuario"]."' $selected >".$arr_t["desc_tipo_usuario"]."</option>");
    }
    print("</select><br>");    
   }
   //agasta aki------------------------------------------------------------------

   print("</fieldset>");
  }



   
   $db->disconnect();
   print("<br><center><button typoe=\"submit\" id=\"insp\" >Actualizar Perfil</button></center>");
  print("</form>");
?>
<?php
$salida=array();
require_once 'funciones.global.inc.php';

verifica_sesion(false);
session_destroy();
unset($_SESSION);
verifica_sesion(false);
if($_REQUEST["condiciones"] !="S"){
   $_SESSION = array();
  $salida['estado'] = 0;
  $salida['mensaje'] = "Debe Aceptar Condiciones.";
  echo json_encode($salida);
  exit(0);
}
$cod_u = null;
$clave = '';
$correcta = -1;
if (isset($_REQUEST['email'])) {
  $cod_u   = $_REQUEST['email'];
  $clave = $_REQUEST['clave'];
}
if (isset($cod_u)) {
  $db = genera_adodb();
  datos_usuario($db, $_SESSION["portal"], $cod_u,$clave);
if($_SESSION["portal"]["ind_auth"] == 1){
  if(isset($clave)){
   require_once('libs/nusoap/lib/nusoap.php');
   $usuario=split('@',$_SESSION["portal"]["email"]);
   $client = new soapclient('http://172.25.16.18/bus/webservice/ws.php?wsdl');
   $result = $client->call('autentifica_ldap', array('id' =>$usuario[0],'clave'=>$clave));
   //   print_r($result);
   //         $result["resp"]= 1;
   if($result["resp"]== 1){
     $correcta=1;
   }
   else{
    $correcta=0;
   }
  }
}
else{
   $correcta=1;
}
//print("--->$correcta");
   unset($_SESSION["portal"]['clave']);
  $db->disconnect();
}
//print_r($_SESSION["licencias"]);
//exit(0);
//$correcta=1;
if ( isset( $_SESSION["portal"]['email'] ) && $correcta == 1 ) {  
  
  $salida['estado'] = 1;
  $db = genera_adodb();
  $popup=popup($db);
  if(count($popup) >0){
   $salida['popup'] = "S";
   $salida['datos_popup'] = $popup;
   
    
  }
  else{
    $salida['popup'] = "N";
  }
  $_SESSION["portal"]["menu"]["Mi Escritorio"]="Vistas/Escritorio.php";
  if($_SESSION["portal"]["sn_admin"] =="S")
  $_SESSION["portal"]["menu"]["Mantencion de Usuarios"]="Vistas/Usuarios.php";

  apps_usuario($db, $_SESSION, $_SESSION["portal"]['email']);
  $db->disconnect();
  
}
else {
  $_SESSION = array();
  $salida['estado'] = 0;
  $salida['mensaje'] = "Usuario sin acceso al Portal de Registros Clinicos";

}

echo json_encode($salida);

?>

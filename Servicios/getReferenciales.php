<?php
require_once('../libs/nusoap/lib/nusoap.php');
  include("../funciones.global.inc.php");
  include("../funciones.inc.php");
  $db=genera_adodb();
  verifica_sesion(false);

$client = new soapclient('http://172.25.16.18/bus/webservice/ws.php?wsdl');
$result = $client->call('buscarDetallePersona', array('run' =>$_REQUEST["run"]));

if((count($result) > 0)&&(isset($result["run"]))){
  foreach($result as $k => $v){
    $result[$k]=utf8_encode($v);
  }
$result["resbusq"]="Paciente encontrado en referencial";
$result["estado"]="1";
$result["edad"]="";

$clientdatos = new soapclient('http://172.25.16.18/bus/webservice/ws.php?wsdl');
$datospers = $clientdatos->call('retorna_DatosPersonaAS400', array('run' =>$_REQUEST["run"]));
$npi_aux=str_pad(trim($datospers["npiarm"]),7,"0",STR_PAD_LEFT);
$result["npi"]=substr($npi_aux,0,6)."-".substr($npi_aux,6,1);
$result["sigla_unid_rep_dot"]=trim($datospers["desrep"]);


$result["espec"] = 0;
$clientdir = new soapclient('http://172.25.16.18/bus/webservice/ws.php?wsdl');
$result["espec"] = $clientdir->call('retorna_EspecDP', array('run' =>$_REQUEST["run"]));
$datosdir = $clientdir->call('retorna_DireccionDP', array('run' =>$_REQUEST["run"]));
if($datosdir != "")
if(count($datosdir) >0){
  foreach($datosdir as $k => $v){
    $datosdir[$k]=utf8_encode($v);
  }
  }

// $datosdir["rnum"]=0;
if($datosdir["rnum"]!=0){
  $result["direccion"]=$datosdir["calle"]." ".$datosdir["nr_depto"]."\n".$datosdir["poblacion"]."\n".$datosdir["ciudad"]."\n".$datosdir["region"];
  $result["telefono"]=$datosdir["codigo_area"]." - ".$datosdir["telefono_publico"];
}
else{
  $result["direccion"]=" ";
  $result["telefono"]=" ";
}

if($result["fecha_nac"] != ""){
$dias = mktime(0,0,0,substr($result["fecha_nac"],5,2),substr($result["fecha_nac"],8,2),substr($result["fecha_nac"],0,4));
$result["edad"] = (int)((time()-$dias)/31556926 );
//$result["fecha_nac"]=substr($result["fecha_nac"],0,4).substr($result["fecha_nac"],5,2).substr($result["fecha_nac"],8,2);
 $result["fecha_nac"]=substr($result["fecha_nac"],8,2)."/".substr($result["fecha_nac"],5,2)."/".substr($result["fecha_nac"],0,4);

}
 $result["lic_vig"]=retorna_cuenta_licencias($db,$_REQUEST["run"]);
 $db->disconnect();
}
else{
$result["resbusq"]="Paciente no encontrado en referencial";
$result["estado"]="0";
}

echo json_encode($result);

?>

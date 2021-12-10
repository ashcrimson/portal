<?php

include("../funciones.global.inc.php");

verifica_sesion(false);
$db=genera_adodb();
$valores=array();
$valores[]=$_SESSION["portal"]["email"];
$valores[]=$_REQUEST["id_accion"];
$valores[]=$_REQUEST["app"];
$valores[]=$_REQUEST["run_paciente"];
$valores[]=$_REQUEST["id"];


$sql="insert into log_portal values (?,sysdate,?,?,?,?)";
$recordset = $db->Execute($sql,$valores);
if($db->Affected_Rows() == 1){
if (!$recordset) {
  $results["estado"] = "0";
  $results["mensaje"] =$db->ErrorMsg();
 }
 else{
  $results["estado"] = "1";
 }
}

$db->disconnect();
echo json_encode($results);

?>
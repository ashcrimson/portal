<?php
include("../funciones.global.inc.php");
include("../funciones.inc.php");
$results=array();
$db=genera_adodb();
verifica_sesion(false);
$results=array();
$valores=array();

$sql="select cod_repart ||':'||desc_repart as val from origen ";
$recordset = $db->Execute($sql,$valores);
if (!$recordset) die("hhh".$db->ErrorMsg());
$resp=array();
while ($arr = $recordset->FetchRow()) {
    $resp[]=utf8_encode($arr["val"]);

  
 }

if(count($resp))
  $final=":SIN SELECCIONAR;".implode(";",$resp);

$db->disconnect();

echo $final;
?>
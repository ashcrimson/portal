<?php
$datos = array();
	include("../funciones.global.inc.php");
	include("../funciones.inc.php");
	$db=genera_adodb();
	$valores=array();
        $valores[]=$_REQUEST["fec_ini_reposo"];
        $valores[]=$_REQUEST["dias_reposo"] - 1;
        $sql= "select to_char(to_date(?||' 00:00:00','DD/MM/YYYY HH24:mi:SS') +?,'DD/MM/YYYY') as fec_termino_reposo from dual";
        $recordset = $db->Execute($sql,$valores);
  if (!$recordset) die("hhh".$db->ErrorMsg());  
 
while ($arr = $recordset->FetchRow()) {
     $datos=$arr;
  } 
$db->disconnect();  


echo json_encode($datos);
?>

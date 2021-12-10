<?php

include_once '../libs/core.php';
$filter = getParameter('term');
if ($useDB) {
$diagnostico = array();
	include("../funciones.global.inc.php");
	include("../funciones.inc.php");
	$db=genera_adodb();
	$valores=array();
        $valores[]=$_REQUEST["cod_repart"];
        $valores[]=$_REQUEST["cod_repart"];
        $valores[]=$_REQUEST["cod_repart"];
        $valores[]=$filter;
        $valores[]=$filter;
        $valores[]=$filter;
        $sql= "select email  as value,nombres||' '||apellido_paterno||' '||apellido_materno as label,u.nombres,u.apellido_paterno,u.apellido_materno,u.email,(select x.direccion from origen x where x.cod_repart=?) as direccion,u.tipo_usuario,(select x.fono from origen x where x.cod_repart=?) as fono,(select x.fax from origen x where x.cod_repart=?) as fax from usuario u where tipo_usuario in(1,2,3) and ((upper(nombres) like '%'||upper(?)||'%')or(upper(apellido_paterno) like '%'||upper(?)||'%')or(upper(apellido_materno) like '%'||upper(?)||'%'))";
        $recordset = $db->Execute($sql,$valores);
  if (!$recordset) die("hhh".$db->ErrorMsg());  
  $diagnostico=array();
while ($arr = $recordset->FetchRow()) {
  $tipo_prof=array();
  $tipo_prof["1"]="MEDICO";
  $tipo_prof["2"]="DENTISTA";
  $tipo_prof["3"]="MATRONA";
  $arr["tipo_usuario"]=$tipo_prof[$arr["tipo_usuario"]];
  
     $diagnostico[]=$arr;
  } 
	
       
        $db->disconnect();  
} else {
	
	$diagnostico = array();
	
	$valores = array();
	$valores['id'] = '0';
	$valores['value'] = "Diagnóstico que contiene $filter";
	
	$diagnostico[] = $valores;

	$valores = array();
	$valores['id'] = '1';
	$valores['value'] = "Otro Diagnóstico que contiene $filter";
	
	$diagnostico[] = $valores;

	$valores = array();
	$valores['id'] = '2';
	$valores['value'] = "Demo de Diagnóstico que contiene $filter";
	
	$diagnostico[] = $valores;
	
}

echo json_encode($diagnostico);

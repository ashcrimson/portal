<?php

include_once '../libs/core.php';
$filter = getParameter('term');
if ($useDB) {
$diagnostico = array();
	include("../funciones.global.inc.php");
	include("../funciones.inc.php");
	$db=genera_adodb();
	$valores=array();
        $vWhere=array();
        $sql= "select cod_diag||' - ' || desc_diag  as value,desc_diag as label from diagnostico where ";
        $filter=mb_strtoupper($filter,'utf-8');
        $conds=explode(" ",$filter);
        foreach($conds as $idx => $cond){
          $valores[]=trim($cond);
          $valores[]=trim($cond);
          $vWhere[] = " ((desc_diag like '%'||?||'%')or(cod_diag like '%'||?||'%')) ";
        }

        $sql.= implode(" and ",$vWhere);
        foreach($valores as $k => $v){
          $valores[$k]=utf8_decode($v);
        }

        $recordset = $db->Execute($sql,$valores);
  if (!$recordset) die("hhh".$db->ErrorMsg());  
  $diagnostico=array();
while ($arr = $recordset->FetchRow()) {
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

<?php

include_once '../libs/core.php';

if ($useDB) {
$medicamento = array();
	include("../funciones.global.inc.php");
	include("../funciones.inc.php");
	$db=genera_adodb();
	$valores=array();

         verifica_sesion(false);
        
         $sql= "select 
a.cod_repart||lpad(a.nro_licencia,6,'0')as nro_licencia,
a.run,
a.dv_run,
a.nombres as nombre,
a.apellido_paterno || ' ' ||a.apellido_materno as apellido,
to_char(a.fec_emision,'DD/MM/YYYY HH24:mi')  as fec_emision,
decode(a.estado,'A','Anulada','D','En Edicion','F','Firmada') as estado,a.categoria_pal,
a.estado as cod_estado,a.id_firma_doc,a.cod_tipo_categoria,a.cod_set_dp
from licencia a 
 ";
	 if(($_SESSION["licencias"]["tipo_usuario"]==1)||($_SESSION["licencias"]["tipo_usuario"]==2)||($_SESSION["licencias"]["tipo_usuario"]==3)){
	   $sql.=" where a.medico=? ";
           $valores[]=$_SESSION["licencias"]["email"];         
         }
         elseif($_SESSION["licencias"]["tipo_usuario"]==4){
           $sql.=" where a.usuario=? ";
           $valores[]=$_SESSION["licencias"]["email"];         
         } 
         elseif($_SESSION["licencias"]["tipo_usuario"]==6){
           $sql.=" where a.usuario=? ";
           $valores[]=$_SESSION["licencias"]["email"];         
         } 
	 if($_REQUEST["fec_aten"] !=""){
           $vwhere[]=" to_char(a.fec_emision,'dd/mm/yyyy')=? ";
           $valores[]=$_REQUEST["fec_aten"];
         }
         if($_REQUEST["busq"] !=""){
           $vwhere[]="((to_char(a.run)||'-'||upper(a.dv_run) like '%'||upper(?)||'%') or (upper(a.nombres) like '%'||upper(?)||'%')or(upper(a.apellido_paterno) like '%'||upper(?)||'%')or(upper(a.apellido_materno) like '%'||upper(?)||'%')) ";
           $valores[]=trim($_REQUEST["busq"]);
           $valores[]=trim($_REQUEST["busq"]);
           $valores[]=trim($_REQUEST["busq"]);
           $valores[]=trim($_REQUEST["busq"]);
         }
         if(count($vwhere) >0){
           $sql.= " and ". implode(" and " ,$vwhere);
         }

	 $sql.=" order by 6 desc ,1,2";
	 
        $recordset = $db->Execute($sql,$valores);
  if (!$recordset) die("hhh".$db->ErrorMsg());  
  $licencias=array();
while ($arr = $recordset->FetchRow()) {
     

     $licencias[]=$arr;
  } 
	
       
        $db->disconnect();  
} else {
	
	$medicamento = array();
	
	$valores = array();
	$valores['medicamento'] = 'Sed ut perspiciatis unde omnis iste natus error';
	$valores['dosis'] = '200mg';
	$valores['cuandoEjecutar'] = 'ASAP';
	$valores['ejecutado'] = 'Sí';
	
	$medicamento[] = $valores;
	
	$valores = array();
	$valores['medicamento'] = 'Lorem ipsum dolor sit amet, consectetur';
	$valores['dosis'] = '100mg';
	$valores['cuandoEjecutar'] = '10/03/2013 08:00';
	$valores['ejecutado'] = 'No';
		
	$medicamento[] = $valores;
	
}

$result = array();
$result["records"] = count($licencias);
$result["rows"] = $licencias;

echo json_encode($result);
?>

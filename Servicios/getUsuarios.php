<?php


$datos = array();
	include("../funciones.global.inc.php");
	include("../funciones.inc.php");
	$db=genera_adodb();
	$valores=array();
    $bs=explode(" ",$_REQUEST["busq"]);  
        $sql= " select
                  u.email,u.nombres,u.apellido_paterno,u.apellido_materno,
toolkit.decrypt(clave) as clave,decode(u.ind_auth,'1','Autenticacion LDAP','2','Autenticacion Propia') as ind_auth,decode(u.sn_admin,'N','No','S','Si') as sn_admin,
SN_ENF_ANEST,
	SN_ARSEN_PABELLONERO,
	SN_ENFERMERA_UNIV,
	RUT,sn_estadistico,especialidad,
	subespecialidad1,
	subespecialidad2,sn_subdirector_clinico,sn_enfermera_epidemiologia,sn_residente,sn_elimordenlab
                 from usuario u
                 ";
   
         if($_REQUEST["busq"] !=""){
		   foreach($bs as $kk => $vv){	
           $vwhere[]="((to_char(upper(u.email)) like '%'||upper(?)||'%') or (upper(u.nombres) like '%'||upper(?)||'%')or(upper(u.apellido_paterno) like '%'||upper(?)||'%')or(upper(u.apellido_materno) like '%'||upper(?)||'%')) ";
           $valores[]=trim(strtoupper($vv));
           $valores[]=trim(strtoupper($vv));
           $valores[]=trim(strtoupper($vv));
           $valores[]=trim(strtoupper($vv));
		   		   
		   }
         }
		 if(count($vwhere) >0){
           $sql.= " where ". implode(" and " ,$vwhere);
         }
        $sql.=" order by 1 asc ";
        $recordset = $db->Execute($sql,$valores);
  if (!$recordset) die("hhh".$db->ErrorMsg());  
 
while ($arr = $recordset->FetchRow()) {
    foreach($arr as $k =>$v)
      $arr[$k]=utf8_decode($v);


     $datos[]=$arr;
  } 
$db->disconnect();  

$result = array();
$result["records"] = count($datos);
$result["rows"] = $datos;

echo json_encode($result);
?>

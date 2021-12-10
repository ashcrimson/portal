<?php
/*
   Funcion Script : Inicio del Sistema 
   Ultima Modificacion: 12/09/2011  
*/
   include_once("../libs/core.php");
   include("../funciones.global.inc.php");
   include("../funciones.inc.php");
   verifica_sesion(false);
   $db=genera_adodb();
   

       $valores=array();
     $valores[]=$_REQUEST["par"];
//     $sql="update tipo_lic set desc_tipo_lic=? where cod_tipo_lic=4";
     $sql="update tipo_REPOSO_PARCIAL set desc_tipo_REPOSO_PARCIAL=? where cod_tipo_REPOSO_PARCIAL='A'";
     $recordset = $db->Execute($sql,$valores);
$db->disconnect();

?>

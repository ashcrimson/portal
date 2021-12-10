<?php
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
/*
   Funcion Script : Libreria de Funciones Globales del Sistema 
   Ultima Modificacion: 05/01/2013  
*/
define('ADODB_ASSOC_CASE',0);
require_once 'libs/Smarty/libs/Smarty.class.php';
include "libs/adodb5/adodb.inc.php";

function genera_adodb(){

  $db=NewADOConnection("oci8po://portal:portal@172.25.23.84:1521/orcl");
  //$db=NewADOConnection("oci8://portal:portal@172.25.23.84:1521/orcl");
  if(!$db){
    $db->ErrorMsg();
  }
  $db->SetFetchMode(ADODB_FETCH_ASSOC);
  
  return $db;
}

function verifica_sesion($redir = true) {
 
  if (!isset($_SESSION["portal"]) || count($_SESSION["portal"]) < 1) {
    //    session_name($_SERVER['HTTP_HOST']);
        ini_set("session.cookie_domain", ".hospitalnaval.cl");
    session_start();
  }
  
  if (!isset($_SESSION["portal"]['email']) && $redir) {
    header('Location: index.php');
    exit(0);
  }
}

function datos_usuario($db, &$arreglo, $cod_u,$clave) {
  $res=array();
  $valores=array();
  if(count(split('@',$cod_u))>1)
    $email   = $cod_u;
  else
    $email   = $cod_u."@sanidadnaval.cl";
  $valores[]=$email;
  $valores[]=$cod_u;
  if($clave =="")
    $clave=" ";
  $valores[]=$clave;
  $recordset = $db->Execute("select * from usuario where ((email=? and ind_auth=1) or (email=? and clave=toolkit.encrypt(?) and ind_auth=2))",$valores);
  if (!$recordset) die("Err : " . $db->ErrorMsg());
  $encontrado=0;
  while ($arr = $recordset->FetchRow()) {
    /*        $reparts=array();
    for($i=1;$i<=5;$i++){
      if(isset($reparts[$arr["cod_repart".$i]])){
      }
      elseif($arr["cod_repart".$i]!="")
	$reparts[$arr["cod_repart".$i]]=1;
    }
    if(count($reparts) ==1){
      foreach($reparts as $c => $v){
        $arreglo["cod_repart"]=$c;
      }
    }
    elseif(count($reparts) >1){
      foreach($reparts as $c => $v){
        $arreglo["reparts"][$c]=1;
      }
    }
    */
    foreach($arr as $c => $v)
      $arreglo[$c]=utf8_encode($v);
    $encontrado=1;
  }
  if ($encontrado==0){
    return;
  }
  return;
}
function apps_usuario($db, &$arreglo, $cod_u) {
  $recordset = $db->Execute("select * from apps order by nro_orden");
  if (!$recordset) die($db->ErrorMsg());
  
  while ($arr = $recordset->FetchRow()) {
    $arreglo[$arr["app"]]["nombre"]=$arr["nombre"];
    $arreglo[$arr["app"]]["link"]=$arr["link"];
    $arreglo[$arr["app"]]["acceso"]="N";
  }
  $apps=array();
  $apps["licencias"]="select * from parametros_licencias a,apps b where b.app=? and email=?";
  $apps["epicrisis"]="select * from parametros_epicrisis a,apps b where b.app=? and email=?"; 
  $apps["ram"]="select * from parametros_ram a,apps b where b.app=? and email=?"; 
  $apps["protocolo"]="select * from parametros_protocolo a,apps b where b.app=? and email=?";
  $apps["indicadores"]="select * from parametros_indicadores a,apps b where b.app=? and email=?";
  $apps["horas"]="select * from parametros_horas a,apps b where b.app=? and email=?";
  $apps["centro"]="select * from parametros_centro a,apps b where b.app=? and email=?";
  $apps["urgencia"]="select * from parametros_urgencia a,apps b where b.app=? and email=?";
  foreach($apps as $app => $sql){
   $valores=array();
   $valores[]=$app;
   $valores[]=$cod_u;
  $recordset = $db->Execute($sql,$valores);
  if (!$recordset) die($db->ErrorMsg());
  
  while ($arr = $recordset->FetchRow()) {
    foreach($arreglo["portal"] as $c => $v)
      $arreglo[$app][$c]=utf8_encode($v);
     foreach($arr as $c => $v)
      $arreglo[$app][$c]=utf8_encode($v);
    if($app =="ram"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      if($arreglo[$app]["tipo_usuario"]==1){
	$arreglo[$app]["menu"]["Interconsultas"]="Vistas/Interconsultas.php";
	$arreglo[$app]["menu"]["Procedimientos"]="Vistas/Procedimientos.php";

      }
      elseif($arreglo[$app]["tipo_usuario"]==2){
	$arreglo[$app]["menu"]["Interconsultas"]="Vistas/Interconsultas.php";


      }
      elseif($arreglo[$app]["tipo_usuario"]==3){
	$arreglo[$app]["menu"]["Procedimientos"]="Vistas/Procedimientos.php";

      }
      elseif($arreglo[$app]["tipo_usuario"]==4){
	$arreglo[$app]["menu"]["Usuarios"]="Vistas/Usuarios.php";

      }

    }
	elseif($app =="indicadores"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }
    //nuevo codigo-------------------------------------------------
elseif($app =="horas"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }

    elseif($app =="centro"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }
  elseif($app =="urgencia"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }
    //----------------------------------------------------------------
    elseif($app =="protocolo"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }
    elseif($app =="licencias"){
            $reparts=array();
    for($i=1;$i<=5;$i++){
      if(isset($reparts[$arr["cod_repart".$i]])){
      }
      elseif($arr["cod_repart".$i]!="")
	$reparts[$arr["cod_repart".$i]]=1;
    }
    if(count($reparts) ==1){
      foreach($reparts as $c => $v){
        $arreglo[$app]["cod_repart"]=$c;
      }
    }
    elseif(count($reparts) >1){
      foreach($reparts as $c => $v){
        $arreglo[$app]["reparts"][$c]=1;
      }
    }
    
    }
   
  $arreglo[$app]["acceso"]="S";
  }
  
  }
  
  foreach($arreglo["portal"] as $c => $v)
      $arreglo["reportes"][$c]=utf8_encode($v);
  $arreglo["reportes"]["nombre"]="Lectura/ Impresi&oacute;n Reportes Cl&iacute;nicos";
  $arreglo["reportes"]["link"]="reporteshnv.hospitalnaval.cl";
  $arreglo["reportes"]["acceso"]="S";
  
  $arreglo["informado"][$c]=utf8_encode($v);
  $arreglo["informado"]["nombre"]="Consentimiento Informado";
  $arreglo["informado"]["link"]="acreditacion.hospitalnaval.cl/index.php?option=com_content&view=article&id=50&Itemid=72&dir=JSROOT%2FConsentimientos/Consentimientos";
  $arreglo["informado"]["acceso"]="S";

  $arreglo["cie1"][$c]=utf8_encode($v);
  $arreglo["cie1"]["nombre"]="Ayuda CIE 10";
  $arreglo["cie1"]["link"]="intranet.sanidadnaval.cl/app/pdf/AyudaCie10.pdf";
  $arreglo["cie1"]["acceso"]="S";
  
  return;


}
?>

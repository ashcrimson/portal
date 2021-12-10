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

function genera_adodb($tipo=null){
  if($tipo =="lab")
    $db=NewADOConnection("oci8po://labcore:labcore.56@172.25.16.24:1521/lawen.hnv.sanidadnaval.cl");
  else
   $db=NewADOConnection("oci8po://portal:portal@172.25.23.84:1521/orcl");
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
      $arreglo[$c]=utf8_decode($v);
    $encontrado=1;
  }
  if ($encontrado==0){
    return;
  }
  return;
}
function popup($db) {
  $popup=array();
  $recordset = $db->Execute("select * from  popup where sn_vig='S'");
  if (!$recordset) die($db->ErrorMsg());
  
  while ($arr = $recordset->FetchRow()) {
	$arr["mensaje"]=utf8_encode($arr["mensaje"]);
	$popup=$arr;
	
  }
 return $popup;
}
function apps_usuario($db, &$arreglo, $cod_u) {
  $recordset = $db->Execute("select * from apps order by nro_orden");
  if (!$recordset) die($db->ErrorMsg());
  
  while ($arr = $recordset->FetchRow()) {
    $arreglo[$arr["app"]]["nombre"]=$arr["nombre"];
    $arreglo[$arr["app"]]["link"]=$arr["link"];
    $arreglo[$arr["app"]]["acceso"]="N";
	$arreglo[$arr["app"]]["sn_vista"]=$arr["sn_vista"];
	
  }
  $apps=array();
  $apps["licencias"]="select * from parametros_licencias a,apps b where b.app=? and email=?";
  $apps["registrominsal"]="select * from parametros_registrominsal a,apps b where b.app=? and email=?";
  $apps["inmunizaciones"]="select * from parametros_inmunizaciones a,apps b where b.app=? and email=?";
  
  $apps["referencia"]="select * from parametros_referencia a,apps b where b.app=? and email=?";
  $apps["afisan"]="select * from parametros_afisan a,apps b where b.app=? and email=?";
  $apps["examrayos"]="select * from parametros_examrayos a,apps b where b.app=? and email=?";
  $apps["rayos"]="select * from parametros_rayos a,apps b where b.app=? and email=?";
  $apps["gespac"]="select * from parametros_gespac a,apps b where b.app=? and email=?";
  
  $apps["epicrisis"]="select * from parametros_epicrisis a,apps b where b.app=? and email=?"; 
  $apps["ram"]="select * from parametros_ram a,apps b where b.app=? and email=?"; 
  $apps["protocolo"]="select * from parametros_protocolo a,apps b where b.app=? and email=?";
  $apps["indicadores"]="select * from parametros_indicadores a,apps b where b.app=? and email=?";
  $apps["horas"]="select * from parametros_horas a,apps b where b.app=? and email=?";
  $apps["centro"]="select * from parametros_centro a,apps b where b.app=? and email=?";
  $apps["urgencia"]="select * from parametros_urgencia a,apps b where b.app=? and email=?";
  $apps["docclinico"]="select * from parametros_docclinico a,apps b where b.app=? and email=?";
  $apps["fichaupc"]="select * from parametros_fichaupc a,apps b where b.app=? and email=?";
   $apps["fichaiaas"]="select * from parametros_fichaiaas a,apps b where b.app=? and email=?";
 
  $apps["fichageriatria"]="select * from parametros_fichageriatria a,apps b where b.app=? and email=?";
  $apps["fichaoncohemato"]="select * from parametros_fichaoncohemato a,apps b where b.app=? and email=?";
  $apps["fichatmq"]="select * from parametros_fichatmq a,apps b where b.app=? and email=?";
  
  $apps["ges"]="select * from parametros_ges a,apps b where b.app=? and email=?";
  $apps["cinf"]="select * from parametros_cinf a,apps b where b.app=? and email=?";
  $apps["reportes"]="select * from parametros_reportes a,apps b where b.app=? and email=?";
  $apps["censocovid"]="select * from parametros_censocovid a,apps b where b.app=? and email=?";
  $apps["controlpyxis"]="select * from parametros_controlpyxis a,apps b where b.app=? and email=?";
  
  $apps["interconsultas"]="select * from parametros_interconsultas a,apps b where b.app=? and email=?";
  $apps["medicollamada"]="select * from parametros_medicollamada a,apps b where b.app=? and email=?";
  $apps["urgencias"]="select * from parametros_urgencias a,apps b where b.app=? and email=?";
  
  foreach($apps as $app => $sql){
   $valores=array();
   $valores[]=$app;
   $valores[]=$cod_u;
  $recordset = $db->Execute($sql,$valores);
  if (!$recordset) die($db->ErrorMsg());
  
  while ($arr = $recordset->FetchRow()) {
    foreach($arreglo["portal"] as $c => $v)
      $arreglo[$app][$c]=$v;
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
		elseif($app =="interconsultas"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }
		elseif($app =="medicollamada"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }
		elseif($app =="registrominsal"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }
		elseif($app =="inmunizaciones"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }
	elseif($app =="referencia"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }
	elseif($app =="afisan"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }
	elseif($app =="examrayos"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }
	elseif($app =="rayos"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }
	elseif($app =="gespac"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }
	elseif($app =="reportes"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }
	elseif($app =="censocovid"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }
	elseif($app =="controlpyxis"){
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
      elseif($app =="docclinico"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }
	  elseif($app =="fichaupc"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }
	elseif($app =="fichaiaas"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    } 
	elseif($app =="fichatmq"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }
	  elseif($app =="fichageriatria"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }
	elseif($app =="fichaoncohemato"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }
	elseif($app =="ges"){
      $arreglo[$app]["usuario"]=$arreglo[$app]["email"];
      $arreglo[$app]["nombre_usuario"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
    }
	elseif($app =="cinf"){
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
	   elseif($app =="urgencias"){
            $servicios=array();
    for($i=1;$i<=4;$i++){
      if(isset($servicios[$arr["cod_tipo_serv".$i]])){
      }
      elseif($arr["cod_tipo_serv".$i]!="0")
	$servicios[$arr["cod_tipo_serv".$i]]=1;
    }
    if(count($servicios) ==1){
      foreach($servicios as $c => $v){
        $arreglo[$app]["cod_tipo_serv"]=$c;
      }
    }
    elseif(count($servicios) >1){
	  $arreglo[$app]["cod_tipo_serv"]=$arr["cod_tipo_serv1"];
      foreach($servicios as $c => $v){
        $arreglo[$app]["servicios"][$c]=1;
      }
    }
    $arreglo[$app]["cod_u"]=$arreglo[$app]["rut"];
	$arreglo[$app]["nombre_u"]=$arreglo["portal"]["nombres"]." ".$arreglo["portal"]["apellido_paterno"]." ".$arreglo["portal"]["apellido_materno"];
	$arreglo[$app]["cod_perfil_u"]=$arreglo[$app]["tipo_usuario"];
	unset($arreglo[$app]["menu"]);
	  if($arreglo[$app]['cod_perfil_u']==1){
    $arreglo[$app]["Rol"]="";
    $arreglo[$app]["menu"]["Tablero"]="Vistas/Tablero.php";
  }
  elseif($arreglo[$app]['cod_perfil_u']==2){
    $arreglo[$app]["Rol"]="";
    $arreglo[$app]["menu"]["Tablero"]="Vistas/Tablero.php";
    //$arreglo[$app]["menu"]["Cuentas de Usuarios"]="Vistas/Usuarios.php";
    $arreglo[$app]["menu"]["Recursos F&iacute;sicos"]="Vistas/Recursos_Fisicos.php";
    
  }
  elseif($arreglo[$app]['cod_perfil_u']==3){
    $arreglo[$app]["Rol"]="";
    $arreglo[$app]["menu"]["Tablero"]="Vistas/Tablero.php";
    
  }
  elseif($arreglo[$app]['cod_perfil_u']==4){
    $arreglo[$app]["menu"]["Admisi&oacute;n y Egreso"]="Vistas/A_E.php";
  }
  elseif($arreglo[$app]['cod_perfil_u']==5){
    $arreglo[$app]["menu"]["Administraci&oacute;n"]="Vistas/Admin.php"; 
  }
  elseif($arreglo[$app]['cod_perfil_u']==6){
    $arreglo[$app]["menu"]["Tablero"]="Vistas/VistaTablero.php"; 
  }
  elseif($arreglo[$app]['cod_perfil_u']==7){
    $arreglo[$app]["Rol"]="";
    $arreglo[$app]["menu"]["Tablero"]="Vistas/Tablero.php";
  }
	}
   
  $arreglo[$app]["acceso"]="S";
  }
  
  }
  /*
  foreach($arreglo["portal"] as $c => $v)
      $arreglo["reportes"][$c]=utf8_encode($v);
  $arreglo["reportes"]["nombre"]="Lectura / Impresi&oacute;n de  Reportes Cl&iacute;nicos";
  $arreglo["reportes"]["link"]="reporteshnv.hospitalnaval.cl";
  $arreglo["reportes"]["acceso"]="S";
  */
   foreach($arreglo["portal"] as $c => $v)
  $arreglo["hojaevolucion"][$c]=utf8_encode($v);
  $arreglo["hojaevolucion"]["nombre"]="Impresi&oacute;n de Hoja de Evoluci&oacute;n";
  $arreglo["hojaevolucion"]["link"]="hojaevolucion.hospitalnaval.cl";
  $arreglo["hojaevolucion"]["acceso"]="S";
  $arreglo["hojaevolucion"]["nro_orden"]="7";
  $arreglo["hojaevolucion"]["cod_categ"]="2";
  foreach($arreglo["portal"] as $c => $v)
      $arreglo["laboratorio"][$c]=utf8_encode($v);
  $arreglo["laboratorio"]["nombre"]="Acceso a Laboratorio";
  //$arreglo["laboratorio"]["link"]="weblab.hospitalnaval.cl:8080/Home/Login?ReturnUrl=%2fClinicos";
  $arreglo["laboratorio"]["link"]="laboratorio.hospitalnaval.cl:8080/Clinicos";
  //$arreglo["laboratorio"]["link"]="172.25.23.104/weblab/Centros/login_centros.aspx";
  $arreglo["laboratorio"]["acceso"]="S";
  $arreglo["laboratorio"]["nro_orden"]="6";
  $arreglo["laboratorio"]["cod_categ"]="2";
  foreach($arreglo["portal"] as $c => $v)
      $arreglo["sollaboratorio"][$c]=utf8_encode($v);
  $arreglo["sollaboratorio"]["nombre"]="Solicitudes de Laboratorio";
  //$arreglo["sollaboratorio"]["link"]="172.25.23.104/Ordenweb/";
  $arreglo["sollaboratorio"]["link"]="172.25.26.39/Ordenweb/";
  $arreglo["sollaboratorio"]["acceso"]="S";
  $arreglo["sollaboratorio"]["nro_orden"]="1";
  $arreglo["sollaboratorio"]["cod_categ"]="4";
  /*$arreglo["imagenes"][$c]=utf8_encode($v);
  $arreglo["imagenes"]["nombre"]="Acceso a Imagenes";
  $arreglo["imagenes"]["link"]="172.25.23.150/ami/html/";
  $arreglo["imagenes"]["acceso"]="S";
  */
  
  $arreglo["informado"][$c]=utf8_encode($v);
  $arreglo["informado"]["nombre"]="Consentimiento Informado";
  $arreglo["informado"]["link"]="acreditacion.hospitalnaval.cl/index.php?option=com_content&view=article&id=50&Itemid=72&dir=JSROOT%2FConsentimientos/Consentimientos";
  $arreglo["informado"]["acceso"]="S";
  $arreglo["informado"]["nro_orden"]="12";
  $arreglo["informado"]["cod_categ"]="1";

  $arreglo["cie1"][$c]=utf8_encode($v);
  $arreglo["cie1"]["nombre"]="Ayuda CIE 10";
  $arreglo["cie1"]["link"]="intranet.sanidadnaval.cl/app/pdf/AyudaCie10.pdf";
  $arreglo["cie1"]["acceso"]="S";
  $arreglo["cie1"]["nro_orden"]="5";
  $arreglo["cie1"]["cod_categ"]="2";
  foreach($arreglo["portal"] as $c => $v)
  $arreglo["pacs"][$c]=utf8_encode($v);
  $arreglo["pacs"]["nombre"]="Acceso a Rayos";
  $arreglo["pacs"]["link"]="registrosclinicos.hospitalnaval.cl/Servicios/Pacs.php";
  $arreglo["pacs"]["acceso"]="S";
  $arreglo["pacs"]["nro_orden"]="2";
  $arreglo["pacs"]["cod_categ"]="2";
  
   foreach($arreglo["portal"] as $c => $v)
  $arreglo["siapss"][$c]=utf8_encode($v);
  $arreglo["siapss"]["nombre"]="Ficha Ambulatoria SIAPSS";
  $arreglo["siapss"]["link"]="siapss.sanidadnaval.cl";
  $arreglo["siapss"]["acceso"]="S";
    $arreglo["siapss"]["nro_orden"]="10";
  $arreglo["siapss"]["cod_categ"]="1";
  return;


}
?>

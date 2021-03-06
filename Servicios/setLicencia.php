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
   
   if($_REQUEST["trans"] =="add"){
     if(($_REQUEST["cod_tipo_categoria"]!="E6")|| (($_REQUEST["cod_tipo_categoria"]=="E6")&&($_SESSION["licencias"]["tipo_usuario"] !=6)&&($_REQUEST["cod_repart"] != "0113")&&(busca_E6_AS400($_REQUEST["run"],$_REQUEST["fec_inicio_reposo"])=="S") )||(($_REQUEST["cod_tipo_categoria"]=="E6")&&($_REQUEST["cod_repart"] =="0113"))||(($_REQUEST["cod_tipo_categoria"]=="E6")&&($_REQUEST["cod_repart"] !="0113")&&($_SESSION["licencias"]["tipo_usuario"] ==6))){
     if(revisa_traslape($db,$_REQUEST["run"],$_REQUEST["fec_inicio_reposo"])==0){
       $valores=array();
     $valores[]=$_REQUEST["cod_repart"] ;
     $sql="select (nvl(max(nro_licencia),0)+1) as nro_licencia from licencia where cod_repart=?";
     $recordset = $db->Execute($sql,$valores);
  if (!$recordset) die("hhhsss".$db->ErrorMsg());  
  $nro_licencia="";
while ($arr = $recordset->FetchRow()) {
     $nro_licencia=$arr["nro_licencia"];
  }  
   $valores=array();
   $sql="insert into licencia
 values(?,?,?,?,?,?,?,?,?,?,?,
        ?,?,sysdate,to_date(?,'DD/MM/YYYY'),to_date(?,'DD/MM/YYYY'),?,?,to_date(?,'DD/MM/YYYY'),?,?,
        ?,?,?,?,?,to_date(?,'DD/MM/YYYY'),?,?,?,to_date(?,'DD/MM/YYYY'),
        ?,?,?,?,?,?,?,?,?,?,
        ?,?,sysdate,null,?,null,null,null,?,null,?,?,?)";
   $valores[]=$nro_licencia;
   $valores[]=$_REQUEST["run"] ;
   $valores[]=$_REQUEST["dv_run"] ;
   $valores[]=$_REQUEST["nombres"] ;
   $valores[]=$_REQUEST["apellido_paterno"] ;
   $valores[]=$_REQUEST["apellido_materno"] ;
   $valores[]=$_REQUEST["npi"] ;
   $valores[]=$_REQUEST["grado"] ;
   $valores[]=$_REQUEST["edad"] ;
   $valores[]=$_REQUEST["ind_sexo"] ;
   $valores[]=$_REQUEST["cod_repart"] ;
   $valores[]=$_REQUEST["reparticion"] ;
   $valores[]=$_REQUEST["sn_iden"] ;
   $valores[]=$_REQUEST["fec_inicio_reposo"] ;
   $valores[]=$_REQUEST["fec_termino_reposo"] ;
   $valores[]=$_REQUEST["dias_reposo"] ;
   $valores[]=$_REQUEST["dias_reposo_pal"] ;
   $valores[]=$_REQUEST["fec_nac_hijo"] ;
   $valores[]=$_REQUEST["run_hijo"] ;
   $valores[]=$_REQUEST["nombres_hijo"] ;
   $valores[]=$_REQUEST["apellido_paterno_hijo"] ;
   $valores[]=$_REQUEST["apellido_materno_hijo"] ; 
   $valores[]=$_REQUEST["cod_tipo_lic"] ;
   $valores[]=$_REQUEST["sn_rec_laboral"] ;
   $valores[]=$_REQUEST["sn_inicia_tram_inval"] ;
   $valores[]=$_REQUEST["fec_accidente_trab_tray"] ;
   $valores[]=$_REQUEST["hora_accidente_trab_tray"] ;
   $valores[]=$_REQUEST["minuto_accidente_trab_tray"] ;    
   $valores[]=$_REQUEST["sn_trayecto"] ;
   $valores[]=$_REQUEST["fec_concepcion"] ;
   $valores[]=$_REQUEST["cod_tipo_reposo"] ;
   $valores[]=$_REQUEST["cod_tipo_reposo_parcial"] ;
   $valores[]=$_REQUEST["cod_lugar_reposo"] ;
   $valores[]=$_REQUEST["otro_lugar_reposo"] ;
   $valores[]=$_REQUEST["direccion"] ;
   $valores[]=$_REQUEST["telefono"] ;
   $valores[]=$_REQUEST["cod_tipo_categoria"] ;
   $valores[]=$_REQUEST["categoria_pal"] ;
   $valores[]=$_REQUEST["antecedentes_clinicos"] ;
   $valores[]=$_REQUEST["examenes_apoyo"] ;
   $valores[]="D";
   $valores[]=$_REQUEST["medico"] ;
   $valores[]=$_SESSION["licencias"]["email"] ;
   $valores[]=$_REQUEST["cod_repartdot"] ;
   $valores[]=$_REQUEST["indicaciones"] ;
   $valores[]=$_REQUEST["cod_subcategoria"] ;
   $valores[]=$_REQUEST["espec"] ;
   $recordset = $db->Execute($sql,$valores);
  if (!$recordset) {
   $results["estado"] = "0";
   $results["error"] =$db->ErrorMsg();
  }  
  else{
   if((isset($_REQUEST["diag_pri"])) &&($_REQUEST["diag_pri"] != "")){
    $datos=array();
    $datos=split(",",$_REQUEST["diag_pri"]);
    if(count($datos) >0){
      $valores = array();
      $sql="delete from diagnostico_pri where nro_licencia=? and cod_repart=?";
      $valores[]=$nro_licencia;
      $valores[]=$_REQUEST["cod_repart"] ;
      $recordset = $db->Execute($sql,$valores);
      if (!$recordset) die("hhh".$db->ErrorMsg());   
      foreach($datos as $k => $v){
        $valores = array();
      $sql="insert into diagnostico_pri values (?,?,?)";
      $valores[]=$nro_licencia;
      $valores[]=$_REQUEST["cod_repart"] ;
      $valores[]=$v; 
      $recordset = $db->Execute($sql,$valores);
      if (!$recordset) die("hhh".$db->ErrorMsg());   
      
      }     
    }
   }
   if((isset($_REQUEST["diag_sec"])) &&($_REQUEST["diag_sec"] != "")){
    $datos=array();
    $datos=split(",",$_REQUEST["diag_sec"]);
    if(count($datos) >0){
      $valores = array();
      $sql="delete from diagnostico_sec where nro_licencia=? and cod_repart=?";
      $valores[]=$nro_licencia;
      $valores[]=$_REQUEST["cod_repart"] ;
      $recordset = $db->Execute($sql,$valores);
      if (!$recordset) die("hhh".$db->ErrorMsg());   
      foreach($datos as $k => $v){
        $valores = array();
      $sql="insert into diagnostico_sec values (?,?,?)";
      $valores[]=$nro_licencia;
      $valores[]=$_REQUEST["cod_repart"] ;
      $valores[]=$v;  
      $recordset = $db->Execute($sql,$valores);
      if (!$recordset) die("hhh".$db->ErrorMsg());   
      
      }     
    }
   }


   $results["estado"] = "1";
   $results["nro_licencia"] = $_REQUEST["cod_repart"].str_pad($nro_licencia,6,"0",STR_PAD_LEFT);
  }
     }
  else{
      $results["estado"] = "0";
      $results["error"] ="Ya existe una licencia para el periodo de reposo escogido";
  }
     }
  else{
      $results["estado"] = "0";
      $results["error"] ="No existe un ingreso de hospitalizacion para la fecha y run ingresado";
  }
}
 else{
   if(revisa_traslape($db,$_REQUEST["run"],$_REQUEST["fec_inicio_reposo"],$_REQUEST["nro_licencia"],$_REQUEST["cod_repart"] )==0){
   $valores=array();
   $campos=array();
   $sql="update licencia set 
RUN =?,
DV_RUN =?,
NOMBRES =?,
APELLIDO_PATERNO =?,
APELLIDO_MATERNO =?,
NPI =?,
GRADO =?,
EDAD =?,
IND_SEXO =?,
REPARTICION =?,
SN_IDEN =?,
FEC_INICIO_REPOSO=to_date(?,'DD/MM/YYYY') ,
FEC_TERMINO_REPOSO=to_date(?,'DD/MM/YYYY') ,
DIAS_REPOSO =?,
DIAS_REPOSO_PAL =?,
FEC_NAC_HIJO=to_date(?,'DD/MM/YYYY') ,
RUN_HIJO =?,
NOMBRES_HIJO =?,
APELLIDO_PATERNO_HIJO =?,
APELLIDO_MATERNO_HIJO =?,
COD_TIPO_LIC =?,
SN_REC_LABORAL =?,
SN_INICIA_TRAM_INVAL =?,
FEC_ACCIDENTE_TRAB_TRAY=to_date(?,'DD/MM/YYYY') ,
HORA_ACCIDENTE_TRAB_TRAY =?,
MINUTO_ACCIDENTE_TRAB_TRAY=?,
SN_TRAYECTO =?,
FEC_CONCEPCION =to_date(?,'DD/MM/YYYY') ,
COD_TIPO_REPOSO =?,
COD_TIPO_REPOSO_PARCIAL =?,
COD_LUGAR_REPOSO =?,
OTRO_LUGAR_REPOSO =?,
DIRECCION =?,
TELEFONO=?,
COD_TIPO_CATEGORIA =?,
CATEGORIA_PAL =?,
ANTECEDENTES_CLINICOS =?,
EXAMENES_APOYO =?,
INDICACIONES=?,
cod_subcategoria=?,
ESTADO=?,
fecha_modif=sysdate,medico=?,espec=? ";
$sql.= " where nro_licencia=? and COD_REPART =? and cod_set_dp is null";
   
   $valores[]=$_REQUEST["run"] ;
   $valores[]=$_REQUEST["dv_run"] ;
   $valores[]=$_REQUEST["nombres"] ;
   $valores[]=$_REQUEST["apellido_paterno"] ;
   $valores[]=$_REQUEST["apellido_materno"] ;
   $valores[]=$_REQUEST["npi"] ;
   $valores[]=$_REQUEST["grado"] ;
   $valores[]=$_REQUEST["edad"] ;
   $valores[]=$_REQUEST["ind_sexo"] ;

   $valores[]=$_REQUEST["reparticion"] ;
   $valores[]=$_REQUEST["sn_iden"] ;
   $valores[]=$_REQUEST["fec_inicio_reposo"] ;
   $valores[]=$_REQUEST["fec_termino_reposo"] ;
   $valores[]=$_REQUEST["dias_reposo"] ;
   $valores[]=$_REQUEST["dias_reposo_pal"] ;
   $valores[]=$_REQUEST["fec_nac_hijo"] ;
   $valores[]=$_REQUEST["run_hijo"] ;
   $valores[]=$_REQUEST["nombres_hijo"] ;
   $valores[]=$_REQUEST["apellido_paterno_hijo"] ;
   $valores[]=$_REQUEST["apellido_materno_hijo"] ; 
   $valores[]=$_REQUEST["cod_tipo_lic"] ;
   $valores[]=$_REQUEST["sn_rec_laboral"] ;
   $valores[]=$_REQUEST["sn_inicia_tram_inval"] ;
   $valores[]=$_REQUEST["fec_accidente_trab_tray"] ;
   $valores[]=$_REQUEST["hora_accidente_trab_tray"] ;
   $valores[]=$_REQUEST["minuto_accidente_trab_tray"] ;    
   $valores[]=$_REQUEST["sn_trayecto"] ;
   $valores[]=$_REQUEST["fec_concepcion"] ;
   $valores[]=$_REQUEST["cod_tipo_reposo"] ;
   $valores[]=$_REQUEST["cod_tipo_reposo_parcial"] ;
   $valores[]=$_REQUEST["cod_lugar_reposo"] ;
   $valores[]=$_REQUEST["otro_lugar_reposo"] ;
   $valores[]=$_REQUEST["direccion"] ;
   $valores[]=$_REQUEST["telefono"] ;
   $valores[]=$_REQUEST["cod_tipo_categoria"] ;
   $valores[]=$_REQUEST["categoria_pal"] ;
   $valores[]=$_REQUEST["antecedentes_clinicos"] ;
   $valores[]=$_REQUEST["examenes_apoyo"] ;
   $valores[]=$_REQUEST["indicaciones"] ;
   $valores[]=$_REQUEST["cod_subcategoria"] ; 
   $valores[]=$_REQUEST["estado"] ;
   $valores[]=$_REQUEST["medico"] ; 
   $valores[]=$_REQUEST["espec"] ;
   $valores[]=$_REQUEST["nro_licencia"]; 
   $valores[]=$_REQUEST["cod_repart"] ;
   $recordset = $db->Execute($sql,$valores);
   if($db->Affected_Rows() == 1){
  if (!$recordset) {
   $results["estado"] = "0";
   $results["error"] =count($campos)." ".$sql." ".$db->ErrorMsg();
  }  
  else{
      if((isset($_REQUEST["diag_pri"])) &&($_REQUEST["diag_pri"] != "")){
    $datos=array();
    $datos=split(",",$_REQUEST["diag_pri"]);
    if(count($datos) >0){
      $valores = array();
      $sql="delete from diagnostico_pri where nro_licencia=? and cod_repart=?";
      $valores[]=$_REQUEST["nro_licencia"];
      $valores[]=$_REQUEST["cod_repart"] ;
      $recordset = $db->Execute($sql,$valores);
      if (!$recordset) die("hhh".$db->ErrorMsg());   
      foreach($datos as $k => $v){
        $valores = array();
      $sql="insert into diagnostico_pri values (?,?,?)";
      $valores[]=$_REQUEST["nro_licencia"];
      $valores[]=$_REQUEST["cod_repart"] ;
      $valores[]=$v; 
      $recordset = $db->Execute($sql,$valores);
      if (!$recordset) die("hhh".$db->ErrorMsg());   
      
      }     
    }
   }
   if((isset($_REQUEST["diag_sec"])) &&($_REQUEST["diag_sec"] != "")){
    $datos=array();
    $datos=split(",",$_REQUEST["diag_sec"]);
    if(count($datos) >0){
      $valores = array();
      $sql="delete from diagnostico_sec where nro_licencia=? and cod_repart=?";
      $valores[]=$_REQUEST["nro_licencia"];
      $valores[]=$_REQUEST["cod_repart"] ;
      $recordset = $db->Execute($sql,$valores);
      if (!$recordset) die("hhh".$db->ErrorMsg());   
      foreach($datos as $k => $v){
        $valores = array();
      $sql="insert into diagnostico_sec values (?,?,?)";
      $valores[]=$_REQUEST["nro_licencia"];
      $valores[]=$_REQUEST["cod_repart"] ;
      $valores[]=$v;  
      $recordset = $db->Execute($sql,$valores);
      if (!$recordset) die("hhh".$db->ErrorMsg());   
      
      }     
    }
   }

   if($_REQUEST["estado"] =="F")
   $results["estado"] = "3";
   else
   $results["estado"] = "2";
  }
   }
   else{
     $results["estado"] = "0";
     $results["error"] ="No puede modificar esta licencia. Ya fue informada a la DIRECPERS.";
   }
   }
   else{
      $results["estado"] = "0";
      $results["error"] ="Ya existe una licencia para el periodo de reposo escogido";
  }
} 
  
  $db->disconnect();
    echo json_encode($results);
?>

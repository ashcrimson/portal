<?php
include("../funciones.global.inc.php");
include("../funciones.inc.php");
include("../funciones.inc.firma.php");
include("../funciones.inc.reporte.php");
require_once('../libs/nusoap/lib/nusoap.php');
$db=genera_adodb();
include ('../libs/phppdf/class.ezpdf.php');
verifica_sesion(false);

$nro_licencia=substr($_REQUEST["nro_licencia"],4,6);
$cod_repart=substr($_REQUEST["nro_licencia"],0,4);
$id_us=$_SESSION["licencias"]["email"];
$pin=$_REQUEST["pin"];
$retorno=retorna_id_documento($id_us,$pin);
if(isset($retorno["error"])){
  $results["estado"]=0;
  $results["error"]="Error al firmar : ".$retorno["error"];
 }
 else{
   $id_doc=$retorno["id"];
   $doc=getpdfLicencia($db,$_REQUEST["nro_licencia"],$id_doc,$retorno);
   $ok=firmar_documento($id_doc,$id_us,$pin,$doc);
   if ($ok == "OK"){
     $valores=array();
     $sql="update licencia set id_firma_doc=?,estado='F' where nro_licencia=? and cod_repart=?";
     $valores[]=$id_doc;
     $valores[]=$nro_licencia;
     $valores[]=$cod_repart;
     $recordset = $db->Execute($sql,$valores);
     //Inicio DP
     /*
     $lic_dp=retorna_licencia_dp($db,$nro_licencia,$cod_repart);
     $clientdp = new soapclient('http://172.25.16.18/bus/webservice/ws.php?wsdl');
     $entrada=array();
     $entrada['runPaciente']=$lic_dp["runpaciente"];
     $entrada['fecIniLic']=$lic_dp["fecinilic"];
     $entrada['fecTerLic']=$lic_dp["fecterlic"];
     $entrada['codCateMed']=$lic_dp["codcatemed"];
     $entrada['codUurrPac']=$lic_dp["coduurrpac"];
     $entrada['codUurrEmiteLic']=$lic_dp["coduurremitelic"];
     $entrada['numLic']=$lic_dp["numlic"];
     $entrada['fecEmiLicMed']=$lic_dp["fecemilicmed"];
     $entrada['totDiaLicMed']=$lic_dp["totdialicmed"];
     $entrada['codTpoLic']=$lic_dp["codtpolic"];
     $entrada['codTpoRep']=$lic_dp["codtporep"];
     $entrada['codLugRep']=$lic_dp["codlugrep"];
     $entrada['codRecLab']=$lic_dp["codreclab"];
     $entrada['codIniTramInv']=$lic_dp["codinitraminv"];
     $respdp = $clientdp->call('setLicenciaDP', $entrada);
     if(count($respdp)>0){
              $valores=array();
              $sql="delete from  licencia_set_err_dp where nro_licencia=? and cod_repart=?";
              $valores[]=$nro_licencia;
              $valores[]=$cod_repart;
              $recordset = $db->Execute($sql,$valores);
              $valores=array();
              $sql="delete from  licencia_act_err_dp where nro_licencia=? and cod_repart=?";
              $valores[]=$nro_licencia;
              $valores[]=$cod_repart;
              $recordset = $db->Execute($sql,$valores);
       if($respdp[0]["cod"]==1){
              $valores=array();
              $sql="update licencia set cod_set_dp=1 where nro_licencia=? and cod_repart=?";
              $valores[]=$nro_licencia;
              $valores[]=$cod_repart;
              $recordset = $db->Execute($sql,$valores);
       }
       else{
              $valores=array();
              $sql="update licencia set cod_set_dp=2 where nro_licencia=? and cod_repart=?";
              $valores[]=$nro_licencia;
              $valores[]=$cod_repart;
              $recordset = $db->Execute($sql,$valores);
              $i=1;
              foreach($respdp as $kdp => $vdp){
                   $valores=array();
                   $sql="insert into licencia_set_err_dp values (?,?,?,?)";
                   $valores[]=$nro_licencia;
                   $valores[]=$cod_repart;
                   $valores[]=$i;
                   $valores[]=$vdp["desc"];
                   $recordset = $db->Execute($sql,$valores);
                   $i++; 
              }
       }
     }
     */
     //Termino DP     
     $results["estado"] = "1";
   }
   else{
     $results["estado"]=0;
     $results["mensaje"]="Error al firmar";
   }
 }
$db->disconnect();
echo json_encode($results);
?>

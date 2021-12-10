 <?php
 $results=array();
 $wsdl = "https://apps.sanidadnaval.cl/portal/ws/Examen?wsdl";
 include("../funciones.global.inc.php");
   include("../funciones.inc.php");
   include("../libs/nusoap/lib/nusoap.php");
   
   $db=genera_adodb("lab");
   $recordset = $db->Execute("select * from control_envio where trim(nro_orden)=trim(?) and estado='R'",array($_REQUEST["nro_orden"]));
   if (!$recordset) die($db->ErrorMsg());
   $datos=array(); 
   while ($arr = $recordset->FetchRow()) {
      $datos=$arr;
   }
   if(count($datos) ==0){
    $results["estado"] = "2";
    $results["error"] = "La orden no ha sido enviada al Portal de Sanidad";
   }
   else{
     $client = new soapclient($wsdl, true);
     $client->soap_defencoding = 'UTF-8';
     // Error check
     $err = $client->getError();
     if ($err) {
       // Show error
       echo '<h2>Error with soapclient creation: </h2><pre>' . $err . '</pre>';
      // call won't work
      exit();
     }
    $params = array('usuario' => 'hospviña', 'password' => 'ws-HOSPVIÑA.2016');
    $proxy = $client->getProxy();
    $result = $proxy->login("hospviña","ws-HOSPVIÑA.2016");
      if($datos["estado_act"] =="R") 
      $result = $proxy->elimina(trim($datos["id"]),trim($datos["obs_act"]));
      else
      $result = $proxy->elimina(trim($datos["id"]),trim($datos["obs"]));
      
    if($client->fault) {
      $obs=$proxy->faultcode ." " .$proxy->faultstring;
      $results["estado"] = "2";
     $results["error"] = $obs;
    }
    else{
        // print_r($result);
         if(is_array($result)){
          $obs=$result["faultstring"];
          $results["estado"] = "2";
          $results["error"] = $obs;
         }
         else{
          $recordset = $db->Execute("delete from control_envio where trim(nro_orden)=trim(?)",array($_REQUEST["nro_orden"]));
          $results["estado"] = "1";
         }
    }
   }
  $db->disconnect();
  echo json_encode($results);
?>
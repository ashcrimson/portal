<?php
   include("../funciones.global.inc.php");
   include("../funciones.inc.php");
   $db=genera_adodb();
   
   if($_REQUEST["oper"] =="add"){ 
     
   $valores=array();
   $sql="insert into usuario values(lower(?),upper(?),upper(?),upper(?),toolkit.encrypt(?),?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";

   $valores[]=$_REQUEST["email"] ;
   $valores[]=utf8_encode($_REQUEST["nombres"]) ;
   $valores[]=utf8_encode($_REQUEST["apellido_paterno"]);
   $valores[]=utf8_encode($_REQUEST["apellido_materno"] ); 
   
   $valores[]=$_REQUEST["clave"] ;
   $valores[]=$_REQUEST["ind_auth"] ;
   $valores[]=$_REQUEST["sn_admin"] ;
   $valores[]=$_REQUEST["sn_enf_anest"] ;
   $valores[]=$_REQUEST["sn_arsen_pabellonero"] ;
   $valores[]=$_REQUEST["sn_enfermera_univ"] ;
   
   
   $valores[]=$_REQUEST["rut"] ;
   $valores[]=$_REQUEST["sn_estadistico"] ;
   $valores[]=$_REQUEST["especialidad"] ;
   $valores[]=$_REQUEST["subespecialidad1"] ;
   $valores[]=$_REQUEST["subespecialidad2"] ;
   $valores[]=$_REQUEST["sn_subdirector_clinico"] ;
   $valores[]=$_REQUEST["sn_enfermera_epidemiologia"] ;
   $valores[]=$_REQUEST["sn_residente"] ;
   $valores[]=$_REQUEST["sn_elimordenlab"] ;
   
   
   
   $recordset = $db->Execute($sql,$valores);
  if (!$recordset) {
   $results["estado"] = "0";
   $results["error"] =$db->ErrorMsg();
  }  
  else{
   $results["estado"] = "1";
  }
    
}
elseif($_REQUEST["oper"] =="edit"){
  
   $valores=array();
   $campos=array();
   $sql="update usuario set email=?,nombres=upper(?),apellido_paterno=upper(?),apellido_materno=upper(?),clave=toolkit.encrypt(?),ind_auth=?,sn_admin=?,
   sn_enf_anest=?,
	sn_arsen_pabellonero=?,
	sn_enfermera_univ=?,
	rut=?,
	sn_estadistico=?,
	especialidad=?,
	subespecialidad1=?,
	subespecialidad2=?,
	sn_subdirector_clinico=?,
    sn_enfermera_epidemiologia=?,
	sn_residente=?,
	sn_elimordenlab=?

	
	
	";
$sql.= " where email=? ";
   $valores[]=$_REQUEST["email"] ;
   $valores[]=utf8_encode($_REQUEST["nombres"] );
   $valores[]=utf8_encode($_REQUEST["apellido_paterno"]) ;
   $valores[]=utf8_encode($_REQUEST["apellido_materno"] ); 
   $valores[]=$_REQUEST["clave"] ;
   $valores[]=$_REQUEST["ind_auth"] ;
   $valores[]=$_REQUEST["sn_admin"] ;
   $valores[]=$_REQUEST["sn_enf_anest"] ;
   $valores[]=$_REQUEST["sn_arsen_pabellonero"] ;
   $valores[]=$_REQUEST["sn_enfermera_univ"] ;
   $valores[]=$_REQUEST["rut"] ;
   $valores[]=$_REQUEST["sn_estadistico"] ;
   $valores[]=$_REQUEST["especialidad"] ;
   $valores[]=$_REQUEST["subespecialidad1"] ;
   $valores[]=$_REQUEST["subespecialidad2"] ;
   $valores[]=$_REQUEST["sn_subdirector_clinico"] ;
   $valores[]=$_REQUEST["sn_enfermera_epidemiologia"] ;
   $valores[]=$_REQUEST["sn_residente"] ;
   $valores[]=$_REQUEST["sn_elimordenlab"] ;
   $valores[]=$_REQUEST["id"] ;
   
   $recordset = $db->Execute($sql,$valores);
  if (!$recordset) {
   $results["estado"] = "0";
   $results["error"] =count($campos)." ".$sql." ".$db->ErrorMsg();
  }  
  else{
   $results["estado"] = "1";
  }
  
} 
elseif($_REQUEST["oper"] =="del"){

   $valores=array();
   $campos=array();
   $sql="delete from usuario";
$sql.= " where email=? ";
   $valores[]=$_REQUEST["id"] ;
   $recordset = $db->Execute($sql,$valores);
  if (!$recordset) {
   $results["estado"] = "0";
   $results["error"] =count($campos)." ".$sql." ".$db->ErrorMsg();
  }  
  else{
   $recordset = $db->Execute("select * from apps");
   if (!$recordset) die($db->ErrorMsg());
   $apps=array(); 
   while ($arr = $recordset->FetchRow()) {
      $apps[]=$arr;
   }
   if(count($apps)>0){
      foreach($apps as $idx =>$app){
          $valores=array();
          $sql="delete from  parametros_".$app["app"]." where email=? ";
          $valores[]=$_REQUEST["id"] ;
          $recordset = $db->Execute($sql,$valores);
      }
   }   
   $results["estado"] = "1";
  }
} 
  
  $db->disconnect();
    echo json_encode($results);
?>

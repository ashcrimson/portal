<?php
   include("../funciones.global.inc.php");
   include("../funciones.inc.php");
   $db=genera_adodb();
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
          $valores[]=$_REQUEST["email"] ;
          $recordset = $db->Execute($sql,$valores);
      }
      foreach($apps as $idx =>$app){
         if($_REQUEST["c_".$app["app"]] =="S"){
            if($app["app"] =="protocolo"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?) ";
               $valores[]=$_REQUEST["email"] ;
               $recordset = $db->Execute($sql,$valores);
            }
            elseif($app["app"] =="indicadores"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ;
               $recordset = $db->Execute($sql,$valores);
            }
              elseif($app["app"] =="reportes"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?) ";
               $valores[]=$_REQUEST["email"] ;
               $recordset = $db->Execute($sql,$valores);
            }
              elseif($app["app"] =="censocovid"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?) ";
               $valores[]=$_REQUEST["email"] ;
               $recordset = $db->Execute($sql,$valores);
            }
                elseif($app["app"] =="controlpyxis"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?) ";
               $valores[]=$_REQUEST["email"] ;
               $recordset = $db->Execute($sql,$valores);
            }
              elseif($app["app"] =="interconsultas"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?) ";
               $valores[]=$_REQUEST["email"] ;
               $recordset = $db->Execute($sql,$valores);
            }
               elseif($app["app"] =="medicollamada"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?) ";
               $valores[]=$_REQUEST["email"] ;
               $recordset = $db->Execute($sql,$valores);
            }
            
            elseif($app["app"] =="licencias"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?,?,?,?,?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ;
               $valores[]=$_REQUEST["cod_repart1_".$app["app"]] ;
               $valores[]=$_REQUEST["cod_repart2_".$app["app"]] ;
               $valores[]=$_REQUEST["cod_repart3_".$app["app"]] ;
               $valores[]=$_REQUEST["cod_repart4_".$app["app"]] ;
               $valores[]=$_REQUEST["cod_repart5_".$app["app"]] ;
               $recordset = $db->Execute($sql,$valores);
            }
              elseif($app["app"] =="urgencias"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?,?,?,?,?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ;
               $valores[]=$_REQUEST["cod_tipo_serv1_".$app["app"]] ;
               $valores[]=$_REQUEST["cod_tipo_serv2_".$app["app"]] ;
               $valores[]=$_REQUEST["cod_tipo_serv3_".$app["app"]] ;
               $valores[]=$_REQUEST["cod_tipo_serv4_".$app["app"]] ;
               $valores[]=($_REQUEST["sn_jefe_serv_".$app["app"]] =='S' )? 'S' : 'N';
               $recordset = $db->Execute($sql,$valores);
            }
            elseif($app["app"] =="ram"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?,?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ;
               $valores[]=($_REQUEST["jefe_servicio_".$app["app"]] =='S' )? 1 : 0;
               $valores[]=$_REQUEST["cod_servicio_".$app["app"]] ;
               $recordset = $db->Execute($sql,$valores);
            }
            elseif($app["app"] =="gespac"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ;
               $valores[]=$_REQUEST["cod_procedencia_".$app["app"]] ;
               $recordset = $db->Execute($sql,$valores);
            }
            elseif($app["app"] =="epicrisis"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ;
               $recordset = $db->Execute($sql,$valores);
            }
              elseif($app["app"] =="registrominsal"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ;
               $recordset = $db->Execute($sql,$valores);
            }
              elseif($app["app"] =="inmunizaciones"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ;
               $recordset = $db->Execute($sql,$valores);
            }
               elseif($app["app"] =="referencia"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ;
               $recordset = $db->Execute($sql,$valores);
            }
            elseif($app["app"] =="afisan"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ;
               $recordset = $db->Execute($sql,$valores);
            }
            elseif($app["app"] =="rayos"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ;
               $recordset = $db->Execute($sql,$valores);
            }
            elseif($app["app"] =="examrayos"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ; 
               $recordset = $db->Execute($sql,$valores);
            }
//nuevo codigo------------------------------------------------------
            elseif($app["app"] =="horas"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ;
               $recordset = $db->Execute($sql,$valores);
            }

            elseif($app["app"] =="centro"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ;
               $recordset = $db->Execute($sql,$valores);
            }
            elseif($app["app"] =="docclinico"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ;
               $valores[]=$_REQUEST["cod_servicio_".$app["app"]] ;
               $recordset = $db->Execute($sql,$valores);
             }
            elseif($app["app"] =="fichaupc"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ;
               $recordset = $db->Execute($sql,$valores);
             }
               elseif($app["app"] =="fichaiaas"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ;
               $recordset = $db->Execute($sql,$valores);
             }
               elseif($app["app"] =="fichatmq"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ;
               $recordset = $db->Execute($sql,$valores);
             }
            elseif($app["app"] =="fichageriatria"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ;
               $recordset = $db->Execute($sql,$valores);
             }
            elseif($app["app"] =="fichaoncohemato"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ;
               $recordset = $db->Execute($sql,$valores);
             }
             elseif($app["app"] =="cinf"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ;
               $recordset = $db->Execute($sql,$valores);
             } elseif($app["app"] =="ges"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?,?) ";
               $valores[]=$_REQUEST["email"] ;
               $valores[]=$_REQUEST["tipo_usuario_".$app["app"]] ;
               $recordset = $db->Execute($sql,$valores);
             } 
            elseif($app["app"] =="urgencia"){
               $valores=array();
               $sql="insert into  parametros_".$app["app"]." values (?) ";
               $valores[]=$_REQUEST["email"] ;
               $recordset = $db->Execute($sql,$valores);
            }

           //-------------------------------------------------- 
         }
      }
   }
  
  $results["estado"] = "1"; 
  $db->disconnect();
  echo json_encode($results);
?>

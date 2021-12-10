<?php

	include("../funciones.global.inc.php");
	include("../funciones.inc.php");
	$db=genera_adodb();
        $sql= "select * from especialidad order by 2";
        $recordset = $db->Execute($sql);
  if (!$recordset) die("hhh".$db->ErrorMsg());  
  $res=array();
  $res[]=":No Aplica";
while ($arr = $recordset->FetchRow()) {
     $res[]=$arr["cod_especialidad"].":".$arr["desc_especialidad"];
  } 

echo json_encode(implode(";",$res));
 
        $db->disconnect();
		?>
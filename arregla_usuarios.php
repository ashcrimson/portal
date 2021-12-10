<?php
include("funciones.global.inc.php");
$db=genera_adodb();
verifica_sesion(false);

include 'libs/excel_reader/simplexlsx.class.php';
include 'libs/excel_reader/reader.php';
$final=array();

  $excel = new SimpleXLSX("Users_Portal.xlsx");
  $x=1;
  if(count($excel->rows()) >0){
    foreach($excel->rows() as $i => $fila){
      $y=1;
      if(count($fila) >0){
	foreach($fila as $j => $column){
	 
	  $final[$x][$y] = $column;
	  $y++;
	}
      }
      $x++;
    }
  }




   $sql="update usuario set nombres=upper(?),apellido_paterno=upper(?),apellido_materno=upper(?) where email=? ";
foreach($final as $k => $v){
  print($k.".\n");
$valores=array();
$valores[]=utf8_encode($v[2] );
$valores[]=utf8_encode($v[3] );
$valores[]=utf8_encode($v[4] );
$valores[]=$v[1] ;
print_r($valores);

$recordset = $db->Execute($sql,$valores);
//if (!$recordset) {
//}
}
$db->disconnect();
?>
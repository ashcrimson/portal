<?php
include("../funciones.global.inc.php");
verifica_sesion(false);
$db = genera_adodb();
		  $recordset = $db->Execute("select * from categoria where cod_categ=? ",array($_REQUEST["cod_categ"]));
  if (!$recordset) die("Err : " . $db->ErrorMsg());
  $titulo="";
  while ($arr = $recordset->FetchRow()) {
  $titulo=$arr["desc_categ"];
    
  }
		  $db->disconnect();
?>
 <div class="row title-bar">
              <div class="col-md-12">
                <h1 class="wow fadeInUp"><?php echo strtoupper(utf8_encode($titulo));?></h1><br>
                <div class="heading-border"></div>
               
              </div>
            </div>
            


<?php
$apps=array();
foreach($_SESSION as $idapp => $app ){
   if($_REQUEST["cod_categ"]==$app["cod_categ"]){			 
     $apps[$app["nro_orden"]][$idapp]=$app;
   }
}
ksort($apps);
//print("<table >");
//$max=5;
//$fila=1;
foreach($apps as $n => $appk )
foreach($appk as $idapp => $app ){
  if($_REQUEST["cod_categ"]==$app["cod_categ"]){
  if(isset($app["link"])&&($app["acceso"] == "S")){
 //if($fila==1)
 //   print("<tr>");
//	print("<td width='10000px'>");
     print('<div style="overflow: hidden; " class="col-md-3 col-sm-6 service-padding marg">');
                   print('<div class="service-item">');
                       print('<a onclick="log_portal(\'I\',\''.$idapp.'\',\'\');" href="http://'.$app["link"].'" target="'.$idapp.'"><div class="service-item-icon"><img src="img/'.$idapp.'.png" title="'.$app["nombre"].'" >');
                       print('</div>');
                       print('<div class="service-item-title">');
                           print('<h2>'.$app["nombre"].'</h2>');
                       print('</div></a>');
                       print('<div class="service-item-desc">');
                          
                           print('<div class="content-title-underline-light"></div>');
                       print('</div>');
                   print('</div>');
               print('</div>');
//  print("<td width=\"300px\"><center><a href=\"http://".$app["link"]."\" target=\"".$idapp."\"><img src=\"images/".$idapp.".gif\" title=\"".$app["nombre"]."\" width=\"50px\" height=\"50px\"><br><h3>".$app["nombre"]."</h3></a></center> </td>");
 // print("</td>");
    
 //$fila++;
 // if($fila==$max){
  //  $fila=1;
  //  print("</tr>");
 // }
  }
  elseif(isset($app["link"])&&($app["acceso"] == "N")&&($app["sn_vista"] == "S")){
			//  if($fila==1)
    //print("<tr>");
	//print("<td width='700px'>");
 print('<div style="overflow: hidden; " class="col-md-3 col-sm-6 service-padding marg">');
                   print('<div class="service-item">');
                       print('<div class="service-item-icon"><img src="img/'.$idapp.'.png" title="'.$app["nombre"].'" >');
                       print('</div>');
                       print('<div class="service-item-title">');
                           print('<h2><a href="#" onclick="alert(\'Usted No Tiene Acceso a esta aplicacion\');">'.$app["nombre"].'</a></h2>');
                       print('</div>');
                       print('<div class="service-item-desc">');
                          
                           print('<div class="content-title-underline-light"></div>');
                       print('</div>');
                   print('</div>');
               print('</div>');
   //  print("</td>");
    
	// $fila++;
 // if($fila==$max){
  //  $fila=1;
   // print("</tr>");
// }
 // print("<td width=\"300px\"><center><a href=\"#\" onclick=\"alert('Usted No Tiene Acceso a esta aplicacion');\"><img src=\"images/".$idapp.".gif\" title=\"".$app["nombre"]."\" width=\"50px\" height=\"50px\"><br><h3>".$app["nombre"]."</h3></a></center> </td>");

  }
  }
}
//if(($fila > 1)&&($fila < $max)){
// for($i=$fila;$i<$max;$i++)			 
 // print("<td>&nbsp;</td>");
 // print("</tr>");
//
//print("</table>");


?>


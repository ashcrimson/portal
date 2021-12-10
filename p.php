<?php

require_once 'funciones.global.inc.2.php';
echo "antes de genera_adodb \n";
$db = genera_adodb();
echo "despues de genera_adodb \n";
$sesion = array();
$cod_u = "mmejiasa";
$clave = "2257";

echo "antes de datos_usuario \n";

datos_usuario($db, $sesion, $cod_u,$clave);

echo "antes de soap \n";

$client = new soapclient('http://172.25.16.18/bus/webservice/ws.php?wsdl');
$result = $client->call('autentifica_ldap', array('id' =>$usuario[0],'clave'=>$clave));

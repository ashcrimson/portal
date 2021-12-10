<?php

include_once '../libs/core.php';

if ($useDB) {
        $protocolo = array();
	include("../funciones.global.inc.php");
	include("../funciones.inc.php");
	$db=genera_adodb();
	$licencia=retorna_licencia($db,$_REQUEST["nro_licencia"],$_REQUEST["cod_repart"]);
        $db->disconnect();  
} else {
	
	$medicamento = array();
	
	$valores = array();
	$valores['medicamento'] = 'Sed ut perspiciatis unde omnis iste natus error';
	$valores['dosis'] = '200mg';
	$valores['cuandoEjecutar'] = 'ASAP';
	$valores['ejecutado'] = 'Sí';
	
	$medicamento[] = $valores;
	
	$valores = array();
	$valores['medicamento'] = 'Lorem ipsum dolor sit amet, consectetur';
	$valores['dosis'] = '100mg';
	$valores['cuandoEjecutar'] = '10/03/2013 08:00';
	$valores['ejecutado'] = 'No';
		
	$medicamento[] = $valores;
	
}



echo json_encode( $licencia);
?>

<?php

require_once '../funciones.global.inc.php';
require_once '../funciones.inc.php';
verifica_sesion(false);
unset($_SESSION["licencias"]["reparts"]);
$_SESSION["licencias"]["cod_repart"]=$_REQUEST["cod_lugar"];
$results=array();
$results["estado"] = "1";
echo json_encode($results);
?>
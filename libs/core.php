<?php 

$useDB = true;

function getParameter($key) {
	global $_GET;
	return isset($_GET[$key])?$_GET[$key]:null;
}

function getPostParameter($key) {
	global $_POST;
	return isset($_POST[$key])?$_POST[$key]:null;
}

function isEmptyString($s) {
	return $s==null || strlen(trim($s))==0;
}

function _returnOk() {
	$okResponse = array('success' => true);
	echo json_encode($okResponse);
}

?>

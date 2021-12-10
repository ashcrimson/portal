<?php
date_default_timezone_set("America/Santiago"); 
$secret = 'default';
$timestamp = date('Ymd\THis.\0\Z', strtotime("$date + 4 hours"));
$url="/webview/NAVAL/DEFAULTSITE/search.html";
//$url.="?disableSearch=true";
$url.="?loginName=view";
//$url.="&studyInstanceUid=".$_REQUEST["uid"];
$url.="&timestamp=".$timestamp;
$signature = hash_hmac('sha1', $url, $secret);
$url="https://sharewebview.hospitalnaval.cl".$url;


$url.="&signature=".$signature;
/*
$url1="https://sharewebview.hospitalnaval.cl/webview/NAVAL/show.html?studyInstanceUid=1.2.826.0.1.3802357.101.441000000005&loginName=view&timestamp=20180510T175010.0Z";
$signature = hash_hmac('sha1', $url1, $secret);
$url2="https://sharewebview.hospitalnaval.cl/webview/NAVAL/show.html?studyInstanceUid=1.2.826.0.1.3802357.101.441000000005&timestamp=20180510T175010.0Z";

$url2.="&signature=".$signature;
*/
header("Location: ".$url);
die();
?>
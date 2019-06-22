<?php
include 'func.php';
sec_session_start(['expire_in'=>'AII','mode'=>'ARK']);
$login=false;
if(!isset($_SESSION['id'])) {
	$_SESSION['msg']='red|Please Login to get access.';
	if($_SESS_PARAMS['fresh']) {
		$_SESSION['msg']='info|Session Expired. Please Login Again to get access.';
	}
	if(!isset($ajax)){
		header('Location: index.php');
		exit;
	}
}
else {
	$login=true;
}
?>
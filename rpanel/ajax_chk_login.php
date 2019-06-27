<?php
$ajax=1;
include 'check_login.php';
if($login){
	echo '1';
}
else{
	echo '0';
}
?>
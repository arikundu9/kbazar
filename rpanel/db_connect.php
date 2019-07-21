<?php
include 'db.php';
// $con=new mysqli($dbserver,$dbuser,$dbpass,$dbname);
//$con=new mysqli($dbserver,$dbuser,$dbpass);
// if($con->connect_error)
	// {
	// echo $con->connect_error;
	// }
$dsn='mysql:host='.$dbserver.';dbname='.$dbname;
try{
	$con=new PDO($dsn,$dbuser,$dbpass);
	$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
	echo 'DB::Connection_Failed: '.$e->getMessage();
}

?>
<?php
$ajax=true;
include '../check_login.php';
$response['header']=['login'=>$login];
if($login){
	if(!empty($_GET))
	switch($_GET['cmd']){
		case 'GetInfo': 
						$Qw="SELECT SUM(price*stock) as total_stock_amount FROM product_tab WHERE rid=?";
						$stmt=$con->prepare($Qw);
						$stmt->bindParam(1,$_SESSION['id'],PDO::PARAM_INT);
						$stmt->execute();
						$data = $stmt->fetch();
						$stmt=null;
						$response['body']['total_stock_amount']=$data['total_stock_amount'];
						
						$Qw="SELECT COUNT(pid) as nop FROM product_tab WHERE rid=?";
						$stmt=$con->prepare($Qw);
						$stmt->bindParam(1,$_SESSION['id'],PDO::PARAM_INT);
						$stmt->execute();
						$data = $stmt->fetch();
						$stmt=null;
						$response['body']['total_stock']=$data['nop'];
						
						$Qw="SELECT COUNT(pid) as stock_out FROM product_tab WHERE rid=? AND stock<1";
						$stmt=$con->prepare($Qw);
						$stmt->bindParam(1,$_SESSION['id'],PDO::PARAM_INT);
						$stmt->execute();
						$data = $stmt->fetch();
						$stmt=null;
						$response['body']['stock_out']=$data['stock_out'];
		break;
		default: $response['body']=$_GET;
	}
	if(!empty($_POST))
	switch($_POST['cmd']){
		case 'CmD': 
		break;
		default: $response['body']=$_POST;
	}
}

echo json_encode($response);
?>
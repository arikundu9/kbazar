<?php
$ajax=true;
include '../check_login.php';
$response['header']=['login'=>$login];
if($login){
	if(!empty($_GET))
	switch($_GET['cmd']){
		case 'GetOrders': 
						//$Qw="SELECT * FROM order_tab WHERE pid IN (SELECT pid FROM product_tab WHERE rid=?)";
						//$Qw="SELECT order_tab.oid,pid,cid,order_data,oid_status.status,order_tab.datetime AS order_datetime,oid_status.datetime AS status_datetime FROM order_tab,oid_status WHERE order_tab.oid=oid_status.oid AND order_tab.pid IN (SELECT pid FROM product_tab WHERE rid=?) ORDER BY oid_status.datetime DESC LIMIT 1";
						$Qw="SELECT oid,order_tab.pid,cid,order_tab.status,order_data,datetime,name FROM order_tab,product_tab WHERE product_tab.pid=order_tab.pid AND order_tab.pid IN (SELECT pid FROM product_tab WHERE rid=?)";
						$stmt=$con->prepare($Qw);
						$stmt->bindParam(1,$_SESSION['id'],PDO::PARAM_INT);
						$stmt->execute();
						$data = $stmt->fetchAll();
						$stmt=null;
						$response['body']=$data;
						$Qw='SELECT suid, name FROM stock_units;';
						$stmt=$con->prepare($Qw);
						$stmt->execute();
						$data = $stmt->fetchAll();
						$stmt=null;
						foreach($data as $k=>$v){
							$response['units'][$v['suid']]=$v['name'];
						}
		break;
		case 'SaveChange': 
						if(!empty($_GET['password'])){
							$phash=password_hash($_GET['password'],PASSWORD_BCRYPT,['cost'=>8]);
							$Qw="UPDATE retailer_utab SET store_name=?,password=?,phone=? WHERE rid=?";
							$stmt=$con->prepare($Qw);
							$stmt->bindParam(1,$_GET['sname'],PDO::PARAM_STR);
							$stmt->bindParam(2,$phash,PDO::PARAM_STR);
							$stmt->bindParam(3,$_GET['phone'],PDO::PARAM_INT);
							$stmt->bindParam(4,$_SESSION['id'],PDO::PARAM_INT);
						}
						else{
							$Qw="UPDATE retailer_utab SET store_name=?,phone=? WHERE rid=?";
							$stmt=$con->prepare($Qw);
							$stmt->bindParam(1,$_GET['sname'],PDO::PARAM_STR);
							$stmt->bindParam(2,$_GET['phone'],PDO::PARAM_INT);
							$stmt->bindParam(3,$_SESSION['id'],PDO::PARAM_INT);
						}
						$stmt->execute();
						//$data = $stmt->fetch();
						$stmt=null;
						$response['msg']=['degree'=>'success','body'=>'Changes Saved Successfully.'];
		break;
		default: $response['body']=$_GET;
	}
	if(!empty($_POST))
	switch($_POST['cmd']){
		case 'EditOrder':
						if($_POST['action']=="Accepted"){
							switch($_POST['status']){
								case 'New':
									$status='Accepted';
									$Qw="UPDATE order_tab SET status=? WHERE oid=?";
									$stmt=$con->prepare($Qw);
									$stmt->bindParam(1,$status,PDO::PARAM_STR);
									$stmt->bindParam(2,$_POST['oid'],PDO::PARAM_INT);
									$stmt->execute();
									//$data = $stmt->fetch();
									$stmt=null;
									
									$who='Shop Owner';
									$time=time();
									$Qw="INSERT INTO oid_status(oid,status,who,datetime) VALUES (?,?,?,?)";
									$stmt=$con->prepare($Qw);
									$stmt->bindParam(1,$_POST['oid'],PDO::PARAM_INT);
									$stmt->bindParam(2,$status,PDO::PARAM_STR);
									$stmt->bindParam(3,$who,PDO::PARAM_STR);
									$stmt->bindParam(4,$time,PDO::PARAM_STR);
									$stmt->execute();
									$stmt=null;
									$response['msg']=['degree'=>'success','body'=>'Order <strong>(OID : '.$_POST['oid'].')</strong> is Accepted.'];
								break;
							}
						}
		break;
		case 'CmD': 
		break;
		default: $response['body']=$_POST;
	}
}
echo json_encode($response);
?>
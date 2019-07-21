<?php
$ajax=true;
include '../check_login.php';
$response['header']=['login'=>$login];
if($login){
	if(!empty($_GET))
	switch($_GET['cmd']){
		case 'GetList': if($_GET['filter']=='nos')
							$Qw="SELECT pid id,name,price,stock,stock_uid stock_unit,status,min_sale,return_replace,description FROM product_tab WHERE rid=? ORDER BY stock";
							elseif($_GET['filter']=='price')
								$Qw="SELECT pid id,name,price,stock,stock_uid stock_unit,status,min_sale,return_replace,description FROM product_tab WHERE rid=? ORDER BY price";
								elseif($_GET['filter']=='id')
									$Qw="SELECT pid id,name,price,stock,stock_uid stock_unit,status,min_sale,return_replace,description FROM product_tab WHERE rid=? ORDER BY pid";
									elseif($_GET['filter']=='name')
										$Qw="SELECT pid id,name,price,stock,stock_uid stock_unit,status,min_sale,return_replace,description FROM product_tab WHERE rid=? ORDER BY name";
										else
											$Qw="SELECT pid id,name,price,stock,stock_uid stock_unit,status,min_sale,return_replace,description FROM product_tab WHERE rid=?";

						$stmt=$con->prepare($Qw);
						$stmt->bindParam(1,$_SESSION['id'],PDO::PARAM_INT);
						$stmt->execute();
						$cf=$stmt->rowCount();
						$data = $stmt->fetchAll();
						$stmt=null;
						$stock_unit=[];
						$ite=0;
						foreach($data as $d){
							//$response['body'][$ite]=['id'=>$d['pid'], 'name'=>$d['name'], 'price'=>$d['price'], 'stock'=>$d['stock'], 'stock_unit'=>$d['stock_uid'], 'status'=>$d['status'], 'thumb'=>'m.jpg'];
							$response['body'][$ite]=$d;
							//if(!in_array($d['stock_uid'],$stock_unit)) all sent at a time
								//$stock_unit[]=$d['stock_uid']; +++++++++++
								$response['body'][$ite]['thumb1']=file_exists('../../thumbs/'.$d['id'].'_thumb1.jpg') ? $d['id'].'_thumb1.jpg' : 'default.jpg' ;
								$response['body'][$ite]['thumb2']=file_exists('../../thumbs/'.$d['id'].'_thumb2.jpg') ? $d['id'].'_thumb2.jpg' : 'default.jpg' ;
								$response['body'][$ite]['thumb3']=file_exists('../../thumbs/'.$d['id'].'_thumb3.jpg') ? $d['id'].'_thumb3.jpg' : 'default.jpg' ;
							$ite++;
						}
						//$Qw='SELECT suid, name FROM stock_units WHERE suid IN ('.implode(',',$stock_unit).');'; send all units at a time
						$Qw='SELECT suid, name FROM stock_units;';
						$stmt=$con->prepare($Qw);
						$stmt->execute();
						$data = $stmt->fetchAll();
						$stmt=null;
						foreach($data as $k=>$v){
							$response['units'][$v['suid']]=$v['name'];
						}
		break;
		case 'AddProduct': 
						$Qw="INSERT INTO product_tab(rid,name,price,min_sale,stock,stock_uid,status,return_replace,description) VALUES (?,?,?,?,?,(SELECT suid FROM stock_units WHERE symbol=?),?,?,?)";
						$stmt=$con->prepare($Qw);
						$stmt->bindParam(1,$_SESSION['id'],PDO::PARAM_INT);
						$stmt->bindParam(2,$_GET['name'],PDO::PARAM_STR);
						$stmt->bindParam(3,$_GET['price'],PDO::PARAM_INT);
						$stmt->bindParam(4,$_GET['minsale'],PDO::PARAM_INT);
						$stmt->bindParam(5,$_GET['stock'],PDO::PARAM_INT);
						$stmt->bindParam(6,$_GET['munit'],PDO::PARAM_STR);
						$stmt->bindParam(7,$_GET['salebility'],PDO::PARAM_BOOL);
						$rr='none';
						if($_GET['refund'] and $_GET['replace'])
							$rr='both';
						if(!$_GET['refund'] and $_GET['replace'])
							$rr='only_replaceable';
						if($_GET['refund'] and !$_GET['replace'])
							$rr='only_returnable';
							
						$stmt->bindParam(8,$rr,PDO::PARAM_STR);
						$stmt->bindParam(9,$_GET['description'],PDO::PARAM_STR);
						if($stmt->execute()){
							$q='SELECT MAX(pid) FROM product_tab';
							$stmt=$con->prepare($q);
							$stmt->execute();
							$data = $stmt->fetch();
							$stmt=null;
							$response['body']['pid']=$data[0];
						}
		break;
		default: $response['body']=$_GET;
	}
	if(!empty($_POST))
	switch($_POST['cmd']){
		case 'AddProduct': 
						$Qw="INSERT INTO product_tab(rid,name,price,min_sale,stock,stock_uid,status,return_replace,description) VALUES (?,?,?,?,?,(SELECT suid FROM stock_units WHERE symbol=?),?,?,?)";
						$stmt=$con->prepare($Qw);
						$stmt->bindParam(1,$_SESSION['id'],PDO::PARAM_INT);
						$stmt->bindParam(2,$_POST['name'],PDO::PARAM_STR);
						$stmt->bindParam(3,$_POST['price'],PDO::PARAM_INT);
						$stmt->bindParam(4,$_POST['minsale'],PDO::PARAM_INT);
						$stmt->bindParam(5,$_POST['stock'],PDO::PARAM_INT);
						$stmt->bindParam(6,$_POST['munit'],PDO::PARAM_STR);
						$stmt->bindParam(7,$_POST['salebility'],PDO::PARAM_STR);
						$rr='none';
						if($_POST['refund']=='true' and $_POST['replace']=='true')
							$rr='both';
						if($_POST['refund']=='false' and $_POST['replace']=='true')
							$rr='only_replaceable';
						if($_POST['refund']=='true' and $_POST['replace']=='false')
							$rr='only_returnable';
							
						$stmt->bindParam(8,$rr,PDO::PARAM_STR);
						$stmt->bindParam(9,$_POST['description'],PDO::PARAM_STR);
						if($stmt->execute()){
							$q='SELECT MAX(pid) FROM product_tab';
							$stmt=$con->prepare($q);
							$stmt->execute();
							$data = $stmt->fetch();
							$stmt=null;
							$response['body']['pid']=$data[0];
						}
						if(isset($_FILES['thumb1']) and $_FILES['thumb1']['size']>0 and $_FILES['thumb1']['error']==0){
							move_uploaded_file($_FILES['thumb1']['tmp_name'],'../../thumbs/'.$data[0].'_thumb1.jpg'/*.strtolower(ext($_FILES['thumb1']['name']))*/);
						}
						if(isset($_FILES['thumb2']) and $_FILES['thumb2']['size']>0 and $_FILES['thumb2']['error']==0){
							move_uploaded_file($_FILES['thumb2']['tmp_name'],'../../thumbs/'.$data[0].'_thumb2.jpg'/*.strtolower(ext($_FILES['thumb2']['name']))*/);
						}
						if(isset($_FILES['thumb3']) and $_FILES['thumb3']['size']>0 and $_FILES['thumb3']['error']==0){
							move_uploaded_file($_FILES['thumb3']['tmp_name'],'../../thumbs/'.$data[0].'_thumb3.jpg'/*.strtolower(ext($_FILES['thumb3']['name']))*/);
						}
		break;
		case 'EditProduct': 
						$Qw="UPDATE product_tab SET name=?,price=?,min_sale=?,stock=?,stock_uid=?,status=?,return_replace=?,description=? WHERE pid=?";
						$stmt=$con->prepare($Qw);
						$stmt->bindParam(1,$_POST['name'],PDO::PARAM_STR);
						$stmt->bindParam(2,$_POST['price'],PDO::PARAM_INT);
						$stmt->bindParam(3,$_POST['minsale'],PDO::PARAM_INT);
						$stmt->bindParam(4,$_POST['stock'],PDO::PARAM_INT);
						$stmt->bindParam(5,$_POST['munit'],PDO::PARAM_INT);
						$stmt->bindParam(6,$_POST['salebility'],PDO::PARAM_STR);
						$rr='none';
						if($_POST['refund']=='true' and $_POST['replace']=='true')
							$rr='both';
						if($_POST['refund']=='false' and $_POST['replace']=='true')
							$rr='only_replaceable';
						if($_POST['refund']=='true' and $_POST['replace']=='false')
							$rr='only_returnable';
						$stmt->bindParam(7,$rr,PDO::PARAM_STR);
						$stmt->bindParam(8,$_POST['description'],PDO::PARAM_STR);
						$stmt->bindParam(9,$_POST['pid'],PDO::PARAM_INT);
						$stmt->execute();
						$stmt=null;
						
						if(isset($_FILES['thumb1']) and $_FILES['thumb1']['size']>0 and $_FILES['thumb1']['error']==0){
							move_uploaded_file($_FILES['thumb1']['tmp_name'],'../../thumbs/'.$_POST['pid'].'_thumb1.jpg'/*.strtolower(ext($_FILES['thumb1']['name']))*/);
						}
						if(isset($_FILES['thumb2']) and $_FILES['thumb2']['size']>0 and $_FILES['thumb2']['error']==0){
							move_uploaded_file($_FILES['thumb2']['tmp_name'],'../../thumbs/'.$_POST['pid'].'_thumb2.jpg'/*.strtolower(ext($_FILES['thumb2']['name']))*/);
						}
						if(isset($_FILES['thumb3']) and $_FILES['thumb3']['size']>0 and $_FILES['thumb3']['error']==0){
							move_uploaded_file($_FILES['thumb3']['tmp_name'],'../../thumbs/'.$_POST['pid'].'_thumb3.jpg'/*.strtolower(ext($_FILES['thumb3']['name']))*/);
						}
						$response['msg']=['degree'=>'success','body'=>'Changes Saved Successfully.'];
						$response['body']='success';

		break;
		default: $response['body']=$_POST;
	}
}

echo json_encode($response);
?>
<?php
include 'func.php';
sec_session_start(['expire_in'=>0,'mode'=>'ARK']);
$ajax=0;
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) and $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
	$ajax=1;
if(isset($_SESSION['id'])) {
	try{
		$Qw="SELECT name,password FROM retailer_utab WHERE rid=?";
		$stmt=$con->prepare($Qw);
		$stmt->bindParam(1,$_SESSION['id'],PDO::PARAM_INT);
		$stmt->execute();
		if(($row = $stmt->fetch())) {  // no of fatched row=1 should be checked here
			$name = $row['name'];
			$pass = $row['password'];
		}
		else {
			$_SESSION['msg']='info|Unable To Identify A/C';
			unset($_SESSION['id']);
			header('location: ' . basename(__FILE__),true,303);
			exit;
		}
		$_SESSION['msg']='info|Welcome back Mr.'.$name;
		if(isset($_GET['goto']))
			header('Location: '.$_GET['goto'],true,303);
		else
			header("location:  dashboard.php",true,303);
		exit;
	} catch(PDOException $e){
		echo 'DB::ERROR: '.$e->getMessage().' ON Line: '.$e->getLine();
	}
}
elseif(isset($_POST['login'])) {
	$id=@$_POST['id'];
	$pass=@$_POST['pass'];
	$remember_me=@$_POST['remember_me'];
	if($id=="" or $pass=="") {
		if(!$ajax){
			$_SESSION['msg']='red|Admin ID or Password can\'t be blank.';
			header('location: ' . basename(__FILE__),true,303);
		}
		else
			//echo 'SORI00';
			echo 'SORI05';
		exit;
	}
	
	try{
		$Qw="SELECT rid,name,password,failed_attempt,flbt FROM retailer_utab WHERE uname=?";
		$stmt=$con->prepare($Qw);
		$stmt->bindParam(1,$id,PDO::PARAM_STR);
		$stmt->execute();
		if(($row = $stmt->fetch()) and $stmt->rowCount()==1) {
			$uid=$row['rid'];
			$name=$row['name'];
			$pap=$row['password'];
			$failed_attempt=$row['failed_attempt'];
			$flbt=$row['flbt'];
			$stmt=null;
		}
		else {
			if(!$ajax){
				$_SESSION['msg']='info|Unable To Identify ID';
				header('location: ' . basename(__FILE__),true,303);
			}
			else
				//echo 'SORI09';
				echo 'SORI05';
			exit;
		}
		
		$Qw="SELECT ii,time,method FROM retailer_failed_log WHERE rid=?";
		$stmt=$con->prepare($Qw);
		$stmt->bindParam(1,$uid,PDO::PARAM_STR);
		$stmt->execute();
		$cf=$stmt->rowCount();
		$failed = $stmt->fetchAll();
		$stmt=null;
		file_put_contents('debug.txt',var_export($failed,true));
		if($cf > $failed_attempt){
			//add  big lenght failure detect
			
			
			if((time()-$failed[$cf-$failed_attempt+1]['time']) > $flbt){
				if((time()-$failed[$cf-1]['time']) < $flbt){
					if(!$ajax){
						$_SESSION['msg']='red|A/C is Locked For '.date('i:s',$flbt).' minutes.';
						header('location: ' . basename(__FILE__),true,303);
					}
					else
						//echo 'SORI07';
						echo 'SORI05';
					exit;
				}
			}
		}
		if(!password_verify($pass,$pap)) {//!password_verify($pass,$pap)  password_hash($pass,PASSWORD_BCRYPT,['cost'=>8])
			$Qw="INSERT INTO `retailer_failed_log` (`rid`, `time`, `method`) VALUES (?,?,?)";  // must use ` not '
			$stmt=$con->prepare($Qw);
			$tm=time();
			$method=0;
			$stmt->bindParam(1,$uid,PDO::PARAM_INT);
			$stmt->bindParam(2,$tm,PDO::PARAM_INT);
			$stmt->bindParam(3,$method,PDO::PARAM_INT);
			$stmt->execute();
			$stmt=null;
			if(!$ajax){
				$_SESSION['msg']='red|Wrong Password.';
				header('location: ' . basename(__FILE__),true,303);
			}
			else
				echo 'SORI05';
			exit;
		}
		else {
			$_SESSION['id']=$uid;
			$_SESSION['pass']=$pass;
			if($remember_me){
				$_SESS_PARAMS['expire_in']=$remember_me;
				session_reset_params();
			}
			$_SESSION['msg']='green|Welcome Mr. '.$name;
			if(!$ajax){
				if(isset($_GET['goto']))
					header('Location: '.$_GET['goto'],true,303);
				else
					header("location:  dashboard.php",true,303);
			}else
				echo 'SORI03';
			exit;

		}
	} catch(PDOException $e){
		echo 'DB::ERROR: '.$e->getMessage().' ON Line: '.$e->getLine();
	}
}
elseif(isset($_POST['log_pin'])){
	
}
else {
	include 'login.php';
}
?>
<?php
$func=1;
include "db_connect.php";
function ext($a)
	{
	$s1=explode(".",$a);
	//var_dump($cookieParams);
	
	switch($_SESS_PARAMS['mode']) {
		case 'ARK':{
			if($_SESS_PARAMS['expire_in']=='AII'){
				if(isset($_SESSION['ses_exp'])){
					if((time()>=$_SESSION['ses_exp']) and ($_SESSION['ses_exp']!=0)){
						session_destroy();
						session_start();
						$_SESSION['ses_exp']=0;
						$_SESS_PARAMS['fresh']=1;
					}
					else{
						//$_SESS_PARAMS['expire_in']=time()-$_SESSION['ses_exp'];
					}
				}
				else{
					$_SESSION['ses_exp']=0;
					$_SESS_PARAMS['fresh']=1;
				}
			}
			elseif($_SESS_PARAMS['expire_in']==0){
				if(isset($_SESSION['ses_exp'])){
					if((time()>=$_SESSION['ses_exp']) and ($_SESSION['ses_exp']!=0)){
						session_destroy();
						session_start();
						$_SESSION['ses_exp']=0;
						$_SESS_PARAMS['fresh']=1;
					}
					else{
						$_SESSION['ses_exp']=0;
					}
				}
				else{
					$_SESSION['ses_exp']=0;
					$_SESS_PARAMS['fresh']=1;
				}
			}
			else{ exit();// this else block may be never exe ed.
				if(isset($_SESSION['ses_exp'])){
					if(time()>=$_SESSION['ses_exp']){
						session_destroy();
						session_start();
						$_SESSION['ses_exp']=0;
						$_SESSION['ses_exp']=time()+$_SESS_PARAMS['expire_in'];
						$_SESS_PARAMS['fresh']=1;
					}
					else{
						//$_SESS_PARAMS['expire_in']=time()-$_SESSION['ses_exp'];
						$_SESSION['ses_exp']=time()+$_SESS_PARAMS['expire_in'];
					}
				}
				else{
					$_SESSION['ses_exp']=time()+$_SESS_PARAMS['expire_in'];
				}
			}
		}break;
		case 'DEFAULT':{
			$_SESS_PARAMS['expire_in']=$_SESSION['ses_exp']=0;
			
		}break;
	}
	
	setcookie($_SESS_PARAMS['session_name'], session_id(), $_SESSION['ses_exp'],$_SESS_PARAMS["path"], $_SESS_PARAMS["domain"], $_SESS_PARAMS['secure'], $_SESS_PARAMS['httponly']);

		elseif(isset($_SESSION['ses_exp']) and $_SESSION['ses_exp']==0){
			
		}
	elseif($_SESS_PARAMS['expire_in']==0) {
		if(!isset($_SESSION['ses_exp']))
			$_SESSION['ses_exp']=0;
	}*/
	elseif(isset($_COOKIE[session_name()]) and $_SESS_PARAMS['expire_in']==0){
		$_SESSION['ses_exp']=$_SESS_PARAMS['expire_in'];//(0)
		setcookie($_SESS_PARAMS['session_name'], session_id(), $_SESSION['ses_exp'],$_SESS_PARAMS["path"], $_SESS_PARAMS["domain"], $_SESS_PARAMS['secure'], $_SESS_PARAMS['httponly']);
	}
	elseif(isset($_COOKIE[session_name()]) and $_SESS_PARAMS['expire_in']==0){
		$_SESSION['ses_exp']=$_SESS_PARAMS['expire_in'];
		setcookie($_SESS_PARAMS['session_name'], session_id(), $_SESSION['ses_exp'],$_SESS_PARAMS["path"], $_SESS_PARAMS["domain"], $_SESS_PARAMS['secure'], $_SESS_PARAMS['httponly']);
	}
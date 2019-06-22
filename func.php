<?php
$func=1;
include "db_connect.php";
function ext($a)
	{
	$s1=explode(".",$a);	$s=end($s1);	return $s;	}function rext($a)	{	$s1=explode(".",$a);	$s=count($s1)-1;	unset($s1[$s]);	return implode(".",$s1);	}function file_size($file)	{	$filesize=filesize($file);	if($filesize < 1024) $filesize = ''.$filesize.'B';	if($filesize < 1048576 and $filesize >= 1024) $filesize = ''.round($filesize/1024, 2).'KB';	if($filesize > 1048576) $filesize = ''.round($filesize/1024/1024, 2).'MB';	return($filesize);	}function enplay($str,$key="ARIKundu")	{	$str=base64_encode($str);	$return=$str;	return $return;	}function deplay($str,$key="ARIKundu")	{	$str=base64_decode($str);	$return=$str;	return $return;	}function valid_url($url)	{	if(strtolower(substr($url,0,7))!="http://" AND strtolower(substr($url,0,8))!="https://")		{		$hs=get_headers("https://".$url);		$prs=explode(" ",$hs[0]);		if(substr($prs[1],0,1)=="2")			return "https://".$url;		else{			return "http://".$url;			}		}	else		return $url;	}	$_SESS_PARAMS=array();function sec_session_start($param=array()) {	global $_SESS_PARAMS;	$_OPT=['mode'=>'DEFAULT','expire_in'=>0,'fresh'=>0,'session_name'=>'SECURELOGIN','secure'=>false,'httponly'=>true];	    // Forces sessions to only use cookies.    if (ini_set('session.use_only_cookies', 1) === FALSE) {        //header("Location: index.php?msg=".enplay("red|Could not initiate a safe session (ini_set)"));        exit();    }    // Gets current cookies params.    $cookieParams = session_get_cookie_params();
	//var_dump($cookieParams);	$_SESS_PARAMS = array_merge($cookieParams, $_OPT, $param);	session_set_cookie_params(/*$cookieParams["lifetime"]*/0, $_SESS_PARAMS["path"], $_SESS_PARAMS["domain"], $_SESS_PARAMS['secure'], $_SESS_PARAMS['httponly']);    // Sets the session name to the one set above.    session_name($_SESS_PARAMS['session_name']);    session_start();            // Start the PHP session     session_regenerate_id(true);    // regenerated the session, delete the old one.
	
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
	/*if($_SESS_PARAMS['expire_in'] and $_SESS_PARAMS['mode']=='ARK'){		if(isset($_SESSION['ses_exp']) and $_SESSION['ses_exp']!=0){			if(time()>=$_SESSION['ses_exp']){				session_destroy();				session_start();				$_SESSION['ses_exp']=time()+$_SESS_PARAMS['expire_in'];				$_SESS_PARAMS['fresh']=1;				}			else{				session_regenerate_id(true);			}		}
		elseif(isset($_SESSION['ses_exp']) and $_SESSION['ses_exp']==0){
			
		}		else{			///session_regenerate_id(true);			$_SESSION['ses_exp']=time()+$_SESS_PARAMS['expire_in'];		}	setcookie($_SESS_PARAMS['session_name'], session_id(), $_SESSION['ses_exp'],$_SESS_PARAMS["path"], $_SESS_PARAMS["domain"], $_SESS_PARAMS['secure'], $_SESS_PARAMS['httponly']);	}
	elseif($_SESS_PARAMS['expire_in']==0) {
		if(!isset($_SESSION['ses_exp']))
			$_SESSION['ses_exp']=0;
	}*/}function session_reset_params(){	global $_SESS_PARAMS;	if(isset($_COOKIE[session_name()]) and $_SESS_PARAMS['expire_in']){		$_SESSION['ses_exp']=time()+$_SESS_PARAMS['expire_in'];		setcookie($_SESS_PARAMS['session_name'], session_id(), $_SESSION['ses_exp'],$_SESS_PARAMS["path"], $_SESS_PARAMS["domain"], $_SESS_PARAMS['secure'], $_SESS_PARAMS['httponly']);	}
	elseif(isset($_COOKIE[session_name()]) and $_SESS_PARAMS['expire_in']==0){
		$_SESSION['ses_exp']=$_SESS_PARAMS['expire_in'];//(0)
		setcookie($_SESS_PARAMS['session_name'], session_id(), $_SESSION['ses_exp'],$_SESS_PARAMS["path"], $_SESS_PARAMS["domain"], $_SESS_PARAMS['secure'], $_SESS_PARAMS['httponly']);
	}}/*function session_reset_params(){	global $_SESS_PARAMS;	if(isset($_COOKIE[session_name()]) and $_SESS_PARAMS['expire_in']){		$_SESSION['ses_exp']=time()+$_SESS_PARAMS['expire_in'];		setcookie($_SESS_PARAMS['session_name'], session_id(), $_SESSION['ses_exp'],$_SESS_PARAMS["path"], $_SESS_PARAMS["domain"], $_SESS_PARAMS['secure'], $_SESS_PARAMS['httponly']);	}
	elseif(isset($_COOKIE[session_name()]) and $_SESS_PARAMS['expire_in']==0){
		$_SESSION['ses_exp']=$_SESS_PARAMS['expire_in'];
		setcookie($_SESS_PARAMS['session_name'], session_id(), $_SESSION['ses_exp'],$_SESS_PARAMS["path"], $_SESS_PARAMS["domain"], $_SESS_PARAMS['secure'], $_SESS_PARAMS['httponly']);
	}}*/?>
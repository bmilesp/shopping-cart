<?php 
require_once('connections.php');

class Auth extends Connections{
	
	var $loginErrorMsg = null;
	
	//$allow set this to false if you need to be logged in 
	function Auth(){
		session_name("CAKEPHP");
		if(empty($_SESSION)){
			@session_start();
		}
	}

	private function sameUserLoggedIn($id = null){
		if($id){
			$isLoggedin = false;
			if(isset($_SESSION['User'])){
				if($id != $_SESSION['User']['id']){
					$isLoggedin = false;
					unset($_SESSION['User']);
				}else{
					$isLoggedin =true;
				}
			}else{
				$isLoggedin = false;
			}	
			return $isLoggedin;
		}
	}
	
	
	function login($login, $password){
		$password = hash('md5',stripslashes($_POST['loginPassword']).$this->security_salt);
		$q ="SELECT * FROM admin.users WHERE `retail_password`='$password' AND `email`='".stripslashes($_POST['loginEmail'])."' Limit 1";
	    $r = mysql_query($q);
	    $row = mysql_fetch_assoc($r);
		if(isset($row['id'])){
			if(!$this->sameUserLoggedIn($row['id'])){
				$_SESSION['User'] = $row;
			}
			return true;
		}else{
			return false;
		}
	}
	
	///old  - should not be used
	function loginById($id = null){
		if($id){
			if(!$this->sameUserLoggedIn($id)){
				$q ="SELECT * FROM admin.users WHERE `id`='$id' Limit 1";
			    $r = mysql_query($q);
			    $row = mysql_fetch_assoc($r);

				if(isset($row['id'])){
					$_SESSION['User'] = $row;
					return true;
				}else{
					return false;
				}
			}else{
				return true;
			}			
		}else{
			return false;
		}
	}
	//old - should not be used
	function logout($redirect_url = "/"){
		unset($_SESSION['User']);
		return true;
	}	
	
	function checkIfUserLoggedIn(){
		if(isset($_SESSION['User']['id'])){
			return $_SESSION['User'];
		}else{
			return false;
		}
	}
	
	function getUser(){
		if(isset($_SESSION['User'])){
			return $_SESSION['User'];
		}else{
			return false;
		}
	}
	
	function checkPublicAccess($allow = false){
		if(!isset($_SESSION['User']) && $allow == false){
			return false;
		}else{
			return true;
		}
	}
	
	function setDirectBackPage($p='checkout'){
		$_SESSION['direct_back'] = $p;
	}
	
	function checkDirectBackPage($defaultHttp = "/"){
		$directBack = $defaultHttp;
		if(isset($_SESSION['direct_back'])){
			$directBack = $defaultHttp."?p=".$_SESSION['direct_back'];
			unset($_SESSION['direct_back']);
		}
		return $directBack;
	}
	
	function checkUserId($user_id = null){
		$user = $this->getUser();
		if($user['id'] == $user_id){
			return true;
		}else{
			return false;
		}
	}
	
	function sanitizeInput($input){
		//return trim(ereg_replace("[^a-zA-Z0-9/#/&/+/$/@/!/-/_/./</>/=/*/^/%/~/(/) ]",'',$input));
		if(is_array($input)){
			$returnArray = array();
			foreach ($input as $key=>$arVal){
				$input[$key] = $this->sanitizeInput($arVal);
			}
			return $input;
		}else{
			return trim(mysql_real_escape_string($input));
		}
	}
	
	function hash($password){
		return hash('md5',$password.$this->security_alt);
	}
	
	/*
	function rememberRequestVars(){
		$_SESSION['direct_back_request_vars'] = $_REQUEST;
	}
	
	function forgetRequestVars(){
		unset($_SESSION['direct_back_request_vars']);
		return true;
	}
	
	function getDirectBackRequestVars(){
		$vars = array();
		if(isset($_SESSION['direct_back_request_vars'])){
			$vars = $_SESSION['direct_back_request_vars'];
			unset($_SESSION['direct_back_request_vars']);
		}else if(isset($_REQUEST)){
			$vars = $_REQUEST;
		}else{
			//redirect to cart
		}
		return $vars;
	}
	*/
}

?>
<?php

class Messaging {

	function Messaging(){
		if(!isset($_SESSION)){
			session_start();
		}
	}
	
	function setFlash($msg = ''){
			$_SESSION['Message'] = array('flash' => array('message'=> $msg,'layout' => 'default'));
	}
	
	function flash($key = 'flash',$class ="flashMsg" , $wrapper = 'div'){
		if(isset($_SESSION['Message']['flash']['message'])){
			$msg = $_SESSION['Message']['flash']['message'];
			$_SESSION['Message']['flash'] = null;
			return "<$wrapper class='$class'>$msg</$wrapper>";
		}else{
			return null;
		}
	}
	
}
?>
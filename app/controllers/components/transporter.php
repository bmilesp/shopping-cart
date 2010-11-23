<?php

class TransporterComponent extends Object {
    
		var $controller;
	
        function startup(&$controller) {
                $this->controller =& $controller;
        }
	
	function setTransporter($name = 'default',$url = null){
		//retrieve transported validationErrors and form data for forms
		if(isset($_SESSION['Transport']['validationErrors'])){
			$this->controller->{$_SESSION['Transport']['validationErrors']['modelClass']}->validationErrors = $_SESSION['Transport']['validationErrors']['errors'];
			$this->controller->data = $_SESSION['Transport']['data'];
			unset($_SESSION['Transport']);
		}
		
		//if specific url is null, get current url:
		$http = (isset($_SERVER['HTTPS']))? 'https' : 'http';
		if(!$url){
			$url = "{$http}://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		}
		if(isset($_SESSION['Transport'])){
			$_SESSION['Transport'][$name] = $url;		
		}else{
			$_SESSION['Transport'] = array($name => $url);
		}
	}
	
	function transportBack($name = 'default'){
		if($this->checkForTransport($name)){
			$base = $_SESSION['Transport'][$name];
			unset($_SESSION['Transport'][$name]);
			//set model validationErrors and form data (if any) to a session for after redirect 
			if(isset($this->controller->{$this->controller->modelClass})){
				$_SESSION['Transport'] = array('validationErrors'=>array('errors' => $this->controller->{$this->controller->modelClass}->validationErrors,
																     'modelClass'=> $this->controller->modelClass),
										   'data' => $this->controller->{$this->controller->modelClass}->data );
			}
			return (isset($base))? $base : false; 
		}else{
			return false;
		}
	}
	
	function checkForTransport($name = 'default'){
		if(isset($_SESSION['Transport'][$name])){
			return $_SESSION['Transport'][$name];
		}else{
			return false;
		}
	}
	
	
	function removeTransporter($name = 'default'){
		//retrieve transported validationErrors and form data for forms
		if(isset($_SESSION['Transport'][$name])){
			unset($_SESSION['Transport'][$name]);
		}
	}
	
	function eraseAll(){
		unset($_SESSION['Transport']);
	}
	
}

?>
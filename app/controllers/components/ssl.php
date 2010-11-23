<?php 
class SslComponent extends Object {

	var $components = array('RequestHandler');
	
	var $Controller = null;
	
	/**
	 * list of actions to force ssl 
	 * @var unknown_type
	 */
	var $forcedActions = array();
	
	/**
	 * if you do not want your local dev server to use https, set this to true
	 * @var unknown_type
	 */
	var $useLocalhostNoSsl = true;
	
	/**
	 * this will be set to true in init if you set $this->useLocalhostNoSsl to true
	 * 
	 * @var unknown_type
	 */
	var $localhostNoSsl = false;
	
	
	function initialize(&$Controller) {
		if($this->useLocalhostNoSsl){
			$this->localhostNoSsl = ($_SERVER['HTTP_HOST'] == 'localhost')? true : false;
		}
		$this->Controller = $Controller;
	}
	
	
	/**
	 * use just like Auth->allow(). eg: $Ssl->force('add, edit') 
	 * 
	 * @param mixed $action Controller action name or array of actions
 	 * @param string $action Controller action name
 	 * @param string ... etc.
	 */
	function force() {
		$args = func_get_args();
		if (empty($args) || $args == array('*')) {
			$this->forcedActions = $this->_methods;
		} else {
			if (isset($args[0]) && is_array($args[0])) {
				$args = $args[0];
			}
			$this->forcedActions = array_merge($this->forcedActions, array_map('strtolower', $args));
		}

		if( in_array( $this->Controller->params['action'] , $this->forcedActions ) ){
			if(!$this->RequestHandler->isSSL()) {
				if(!$this->localhostNoSsl){
					$this->Controller->redirect('https://'.$this->__url());
				}
			}	
		}
	}
	
	function unforce() {
		$args = func_get_args();
		if (empty($args) || $args == array('*')) {
			$this->forcedActions = $this->_methods;
		} else {
			if (isset($args[0]) && is_array($args[0])) {
				$args = $args[0];
			}
			$this->allowedActions = array_merge($this->allowedActions, array_map('strtolower', $args));
		}
		if($this->RequestHandler->isSSL()) {
			$this->Controller->redirect('http://'.$this->__urll());
		}
	}
	
	function __url() {
		$port = env('SERVER_PORT') == 80 ? '' : ':'.env('SERVER_PORT');
	
		return env('SERVER_NAME').$port.env('REQUEST_URI');
	}
	
	function __urll() {
		$port = env('SERVER_PORT') == 443 ? '' : ':'.env('SERVER_PORT');
	
		return env('SERVER_NAME').$port.env('REQUEST_URI');
	}

}
?>
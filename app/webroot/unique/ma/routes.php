<?php 

	$prefixes = Configure::read('Routing.prefixes');
	$possibleUrlPrefixes = split("/",$_SERVER['REQUEST_URI']);
	$foundPrefix= null;
	foreach ($possibleUrlPrefixes as $possiblePrefix){
		foreach ($prefixes as $prefix){
			if ($prefix == $possiblePrefix){
				$foundPrefix = $prefix;
				break;
			}
		}
		
	}
	if($foundPrefix){
		Router::connect("/{$foundPrefix}", array('controller' => 'pages', 'action' => 'display', 'home'));
		Router::connect("/{$foundPrefix}/", array('controller' => 'pages', 'action' => 'display', 'home'));
		Router::connect("/{$foundPrefix}/:controller", array('action' => 'index','controller' => ':controller'));
		Router::connect("/{$foundPrefix}/:controller/", array('action' => 'index','controller' => ':controller'));
		Router::connect("/{$foundPrefix}/:controller/:action/*", array('controller' => ':controller', 'action' => ':action'));
		Router::connect("/{$foundPrefix}/:plugin/:controller", array('action' => 'index', 'plugin' => ':plugin', 'controller' => ':controller'));
		Router::connect("/{$foundPrefix}/:plugin/:controller/", array('action' => 'index', 'plugin' => ':plugin', 'controller' => ':controller'));
		Router::connect("/{$foundPrefix}/:plugin/:controller/:action/*", array('plugin' => ':plugin', 'controller' => ':controller', 'action' => ':action'));
		Router::connect("/{$foundPrefix}/pages/*", array('controller' => 'pages', 'action' => 'display'));
	}else{		
		Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
		Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));	
	}
?>
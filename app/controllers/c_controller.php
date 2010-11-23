<?php 

	class CController extends AppController 
{
	var $name = 'C';
	var $helpers = array('Html', 'Form');
	var $components = array('Auth');
	var $uses = array();
	
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('groupon');
	}
	
	function groupon(){
		$this->redirect(array('controller'=>'groupon'));
	}
}
	
?>
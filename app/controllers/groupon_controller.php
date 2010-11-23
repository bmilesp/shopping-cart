<?php
class GrouponController extends AppController {

	var $name = 'Groupon';
	var $helpers = array('Html', 'Form');
	var $components = array();
	var $uses =array();

	function beforeFilter()
	{			
		parent::beforeFilter();
		$this->Auth->allow('index');
	}

	function index() {}
}
?>
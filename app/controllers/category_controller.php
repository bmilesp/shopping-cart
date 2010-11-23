<?php
class CategoryController extends AppController 
{
	var $name = 'Category';
	var $helpers = array('Html', 'Form');
	var $components = array('Auth');
	var $uses = array();

	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('tshirts');
	}

	function index() {}

	function tshirts()
	{
		$this->autoRender = false;
		$this->redirect(array('controller'=>'products','action'=>'tags','102'));
	}
}
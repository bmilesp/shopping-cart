<?php
class SitesController extends AppController {

	var $name = 'Sites';
	var $helpers = array('Html', 'Form');
	var $uses = array('Sites');

	function beforeFilter(){
		parent::beforeFilter();
		if($this->Auth->user('user_level_id') != 2){
			$this->Auth->deny('*');
		}
	}
	
	function index() {
		$this->Sites->recursive = 0;
		$this->set('sites', $this->paginate());
	}

}
?>
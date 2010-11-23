<?php
class RemapController extends AppController {

	var $name = 'Remap';
	var $helpers = array('Html', 'Form');
	var $uses = array();
	
	function beforeFilter(){
		
		$this->layout = false;
		$this->autoRender = false;
		//parent::beforeFilter();
		//$this->Auth->allow('tags','index');
	}
	
	function index() {
		$this->autoRender = false;
		//if($this->data['remap']){
			
			//remap customers
			//$this->Coupon->useDbConfig = 'cartExport';
			//debug($this->Coupon->find('all'));
		//}
	}
	
	function tags($key = null){

			//$tags = $this->Product->Query('SELECT * FROM tags');
			//foreach ($tags as $tag){
			//	$this->Product->Query("INSERT INTO groups set tag_id = {$tag['tags']['tag_id']}, main_menu = 1");
			//	//debug($tag['tags']);
			//}
			
	}


}
?>
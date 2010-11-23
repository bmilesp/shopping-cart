<?php
class NewslettersController extends AppController {

	var $name = 'Newsletters';
	var $helpers = array('Html', 'Form');
	var $uses = array('Newsletter');

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('add');
	}

	function add() {
		if (!empty($this->data)) {
			$this->Newsletter->create();
			$this->data['Newsletter']['site_id'] = $this->siteConfig->site_id;
			if ($this->Newsletter->save($this->data['Newsletter'])) {
				$this->Session->setFlash(__('Thank you for subscribing to our newsletter.', true));
			} else {
				if(!empty($this->Newsletter->validationErrors)){
					$this->Session->setFlash(__( implode(', ',$this->Newsletter->validationErrors) , true));
				}else{
					$this->Session->setFlash(__('The Newsletter could not be saved. Please, try again.', true));
				}
			}
		}
		$this->redirect($this->referer());
	}

}
?>
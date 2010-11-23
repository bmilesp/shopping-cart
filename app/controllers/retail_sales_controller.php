<?php
class RetailSalesController extends AppController {

	var $name = 'RetailSales';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->RetailSale->recursive = 0;
		$this->set('retailSales', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid RetailSale.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('retailSale', $this->RetailSale->read(null, $id));
	}

	/*
	function add() {
		if (!empty($this->data)) {
			$this->RetailSale->create();
			if ($this->RetailSale->save($this->data)) {
				$this->Session->setFlash(__('The RetailSale has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The RetailSale could not be saved. Please, try again.', true));
			}
		}
		$users = $this->RetailSale->User->find('list');
		$this->set(compact('users'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid RetailSale', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->RetailSale->save($this->data)) {
				$this->Session->setFlash(__('The RetailSale has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The RetailSale could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->RetailSale->read(null, $id);
		}
		$users = $this->RetailSale->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for RetailSale', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->RetailSale->del($id)) {
			$this->Session->setFlash(__('RetailSale deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
*/
}
?>
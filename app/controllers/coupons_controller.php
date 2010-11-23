<?php
class CouponsController extends AppController {

	var $name = 'Coupons';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Coupon->recursive = 0;
		$this->set('coupons', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Coupon.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('coupon', $this->Coupon->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Coupon->create();
			if ($this->Coupon->save($this->data)) {
				$this->Session->setFlash(__('The Coupon has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Coupon could not be saved. Please, try again.', true));
			}
		}
		$products = $this->Coupon->Product->find('list');
		$this->set(compact('products'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Coupon', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Coupon->save($this->data)) {
				$this->Session->setFlash(__('The Coupon has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Coupon could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Coupon->read(null, $id);
		}
		$products = $this->Coupon->Product->find('list');
		$this->set(compact('products'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Coupon', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Coupon->del($id)) {
			$this->Session->setFlash(__('Coupon deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
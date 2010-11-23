<?php
class BillingAddressesController extends AppController {

	var $name = 'BillingAddresses';
	var $helpers = array('Html', 'Form');
	var $components = array( 'Transporter' );
	var $uses = array('BillingAddress', 'State', 'ShippingAddress');
	
	function index() {
		$this->BillingAddress->recursive = 0;
		$this->set('billingAddresses', $this->paginate());
	}

	function isAuthorized(){
		return $this->authGuestDeny('view','add','delete','set_default');		
	}
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid BillingAddress.', true));
			$this->redirect(array('controller'=>'users' , 'action'=>"view/{$this->authUser['id']}"));
		}
		$this->set('billingAddress', $this->BillingAddress->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->BillingAddress->create();
			if ($this->BillingAddress->save($this->data)) {
				$this->Session->setFlash(__('The BillingAddress has been saved', true));
				if($base = $this->Transporter->transportBack('billing')){
					//instead of redirecting to $base here, let's redirect to pre-checkout shipping using the newly saved id:
					// we can't simply set the redirect from the initial setTransporter call since
					// we use it for redirection when data doesn't validate (see below):
					//$newBase = $this->rootDir."users/billing_addresses_select/".$this->BillingAddress->id;
					$this->redirect(array('controller'=>'users','action'=>'billing_addresses_select',$this->BillingAddress->id));
				}else{
					$this->redirect(array('controller'=>'users', 'action'=>"view/{$this->authUser['id']}"));
				}
			} else {
				$this->Session->setFlash(__('The BillingAddress could not be saved. Please, try again.', true));
				if($base = $this->Transporter->transportBack('billing')){
					$this->redirect($base);
				}
			}
		}
		$states = $this->State->find('list');
		$this->set(compact('states'));
	}
	
	function guest_add(){
		if (!empty($this->data)) {
			$this->BillingAddress->create();
			$this->ShippingAddress->create();
			$this->data['BillingAddress']['user_id'] = $_SESSION['User']['id'];
			$this->data['ShippingAddress']['user_id'] = $_SESSION['User']['id'];
			if ($this->BillingAddress->save($this->data['BillingAddress'])) {
				$this->sessionSelected('bill_id',$this->BillingAddress->getLastInsertID());
				if($this->ShippingAddress->save($this->data['ShippingAddress'])){
					$this->sessionSelected('ship_id',$this->ShippingAddress->getLastInsertID());
					$this->redirect(array('controller'=>'orders', 'action'=>'checkout'));
				}
			}
		}
		$this->data['BillingAddress'] = array('firstname'=>$_SESSION['User']['first_name'],
											  'lastname'=>$_SESSION['User']['last_name']);
		$this->data['ShippingAddress'] = array('firstname'=>$_SESSION['User']['first_name'],
											   'lastname'=>$_SESSION['User']['last_name']);
		
		
		$billingAddress = $this->BillingAddress->getSelectedAddress($_SESSION['User']['id']);
		$shippingAddress = $this->ShippingAddress->getSelectedAddress($_SESSION['User']['id']);
		if(!empty($billingAddress)){
			$this->data['BillingAddress'] = $billingAddress['BillingAddress'];
		}
		if(!empty($shippingAddress)){
			$this->data['ShippingAddress'] = $shippingAddress['ShippingAddress'];
		}
		$states = $this->State->find('list');
		$this->set(compact('states'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Billing Address', true));
		}
		$this->BillingAddress->recursive = -1;
		$address = $this->BillingAddress->findByBillId($id);
		if( !$this->BillingAddress->authenticateUserAndData($address['BillingAddress']['user_id']) ){
			$this->Session->setFlash(__("Invalid Operation.", true));
			$this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
		}
		if ($this->BillingAddress->softDelete($id)) {
			$this->Session->setFlash(__('Billing Address deleted', true));
		}else{
			$this->Session->setFlash(__('Address could not be deleted.', true));
		}
		$this->redirect(array('controller'=>'users' , 'action'=>"view/{$this->authUser['id']}"));
	}
	
	function set_default($id){
		Configure::write('debug', 0);
		$this->layout = null;
		$this->BillingAddress->read(null,$id);
		$this->BillingAddress->set('default',1);
		$address = $this->BillingAddress->data['BillingAddress'];
		$this->BillingAddress->save();
		$this->set(compact('address'));
		$this->Session->setFlash(__('The default Billing Address has been updated.', true));
		$this->redirect(array('controller'=>'users' , 'action'=>"view/{$this->authUser['id']}"));
	}	

}
?>
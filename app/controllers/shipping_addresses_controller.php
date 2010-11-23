<?php
class ShippingAddressesController extends AppController {

	var $name = 'ShippingAddresses';
	var $helpers = array('Html', 'Form');
	var $components = array( 'Transporter' );
	var $uses = array('ShippingAddress','State');

	function index() {
		$this->ShippingAddress->recursive = 0;
		$this->set('shippingAddresses', $this->paginate());
	}

	function isAuthorized(){
		return $this->authGuestDeny('view','add','delete','set_default');		
	}
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Shipping Address.', true));
			$this->redirect(array('controller'=>'users' , 'action'=>"view/{$this->authUser['id']}"));
		}
		$this->set('shippingAddress', $this->ShippingAddress->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			
			//check is user selected 'use billing address as shipping address':
			if(isset($this->data['ShippingAddressCopy'])){
				$this->data['ShippingAddress'] = $this->data['ShippingAddressCopy'];
				unset($this->data['ShippingAddressCopy']);
			}
			$this->ShippingAddress->create();
			if ($this->ShippingAddress->save($this->data)) {
				$this->Session->setFlash(__('The Shipping Address has been saved', true));
				if($base = $this->Transporter->transportBack('shipping')){
					//instead of redirecting to $base here, let's redirect to pre-checkout shipping using the newly saved id:
					// we can't simply set the redirect from the initial setTransporter call since
					// we use it for redirection when data doesn't validate (see below):
					$this->redirect(array('controller'=>'users', 'action'=>'shipping_addresses_select',$this->ShippingAddress->id));
				}else{
					$this->redirect(array('controller'=>'users', 'action'=>"view/{$this->authUser['id']}"));
				}
			} else {
				$this->Session->setFlash(__('The Shipping Address could not be saved. Please, try again.', true));
				if($base = $this->Transporter->transportBack('shipping')){
					$this->redirect($base);
				}
			}
		}
		$states = $this->State->find('list');
		$this->set(compact('states'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Shipping Address', true));
		}
		$address = $this->ShippingAddress->findByShipId($id);
		if( !$this->ShippingAddress->authenticateUserAndData($address['ShippingAddress']['user_id']) ){
			$this->Session->setFlash(__("Invalid Operation.", true));
			$this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
		}
		if ($this->ShippingAddress->softDelete($id)) {
			$this->Session->setFlash(__('Shipping Address deleted', true));
		}else{
			$this->Session->setFlash(__('Address could not be deleted.', true));
		}
		$this->redirect(array('controller'=>'users' , 'action'=>"view/{$this->authUser['id']}"));
	}
	
	function set_default($id){
		Configure::write('debug', 0);
		$this->layout = null;
		$this->ShippingAddress->read(null,$id);
		$this->ShippingAddress->set('default',1);
		$address = $this->ShippingAddress->data['ShippingAddress'];
		$this->ShippingAddress->save();
		$this->set(compact('address'));
		$this->Session->setFlash(__('The default Shipping Address has been updated.', true));
		$this->redirect(array('controller'=>'users' , 'action'=>"view/{$this->authUser['id']}"));
	}
}
?>
<?php
class OrdersController extends AppController {

	var $name = 'Orders';
	var $helpers = array('Html', 'Form');
	var $components = array('Transporter', 'Auth','Shipping','Ssl');
	var $uses = array('Order','ShippingCode','Coupon','ShippingAddress','BillingAddress','User');

	function beforeFilter(){
		parent::beforeFilter();
		$this->Ssl->force('checkout');
		$this->Auth->allow('get_totals','applygiftwrap','removegiftwrap','cart_add','cart_item_edit','cart_item_remove','cart','cart_clear');
	}
	
	//function index() {
		//$this->Order->recursive = 0;
		//$this->set('orders', $this->paginate());
	//}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Order.', true));
			$this->redirect(array('action'=>'index'));
		}
		$order = $this->Order->read(null, $id);
		if( !$this->Order->authenticateUserAndData($order['Order']['user_id']) ){
			$this->Session->setFlash(__("Invalid Operation.", true));
			$this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
		}
		$this->set('order', $order);
	}
	
	function checkout(){
		if($this->Auth->user()){
			if(!isset($_SESSION['Selected']['bill_id']) && !isset($_SESSION['Selected']['ship_id'])){
				$this->Session->setFlash(__("Please enter Billing/Shipping information.", true));
				$this->redirect($this->https(array('controller'=>'users','action'=>'pre_checkout')));
			}
			$this->Transporter->setTransporter('checkout');
			$gift = $this->Cart->hasGiftwrapping;
			$giftPrice = $this->Cart->totals['giftWrapTotal'];
			$this -> Cart -> removeUnavailableItems(); 
			$cartItems = $this->Cart->items;
			$user = $this->User->find('first',array('conditions'=>array('id'=>$this->authUser['id'])));
			$billingAddress = $this->BillingAddress->getSelectedAddress($this->authUser['id']);
			$shippingAddress = $this->ShippingAddress->getSelectedAddress($this->authUser['id']);
			$taxRate = $this->Cart->Tax->getTaxRateByZip($shippingAddress['ShippingAddress']['zip']);
			$coupons = $this->Coupon->getCoupons($this->Cart->items, ($this->Cart->totals['noTaxNoShipping']));
			// old: $shippingTypes = $this->ShippingCode->find('list', array('conditions'=>array('in_carts'=>1)));
			$shippingTypes = $this->Shipping->findPossibleShippingMethods($shippingAddress['ShippingAddress']['ship_id'], $this->Cart->items);
			
			$shippingType = (isset($_SESSION['Selected']['shippingType']))? $_SESSION['Selected']['shippingType'] : 1;
			$cartItemImageUrl = $this->Cart->itemImageUrl;
			$this->set(compact('cartItemImageUrl','cartItems','user','shippingTypes', 'taxRate',
							   'shippingAddress','billingAddress','coupons','gift','giftPrice','totals'));
			
		}else{
			$this->Session->setFlash(__("You must create an account or login to purchase items.", true));
		$this->redirect($this->https(array('controller'=>'users','action'=>'add')));
		}
	}
	
	function payment(){
				
		if($user = $this->Auth->user()){
			if(!empty($this->Cart->items)){
				$shipInfo = $this->Shipping->getShipDates($this->data['ship_type'], $this->data['Order']['ship_id'], $this->Cart->items);
				$inHandsDate = rearrangeDate($shipInfo['inHandsDate']);
				$dbInHandsDate = $shipInfo['inHandsDate'];
				$shipType = $this->ShippingCode->findById($this->data['ship_type']);
				$shipType = $shipType['ShippingCode']['title'];
				$cartItems = $this->Cart->items;
				$totalVals = $_SESSION['cart']['totals']; //from get_totals action
				$coupons = $this->Coupon->getCoupons($this->Cart->items, ($totalVals['noTaxNoShipping']));
				$this->set(compact('user','cartItems','giftPrice','coupons','totalVals','inHandsDate','shipType','dbInHandsDate'));
			}else{
				$this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
			}
		}else{
			$this->Session->setFlash(__("You must create an account or login to purchase items.", true));
			$this->redirect($this->https(array('controller'=>'users','action'=>'add')));
		}
	}
	
	function cart_add(){
		$this->autoRender = false;
		if(!empty($this->data)){
			if(isset($this->data['Product'])){
				$this->Cart->addProduct($this->data['Product']);			
			}
			if(isset($this->data['Coupon']) && !empty($this->data['Coupon'])){
				$this->Cart->addCoupon($this->data['Coupon']);
			}
		}
		$this->redirect($this->https(array('controller'=>'orders','action'=>'cart')));
	}
	
	function cart_item_edit(){
		$this->Cart->updateItem($this->params['url']['data']['OrdersProduct']);
		$this->Session->setFlash(__("Quantity Updated.", true));
		$this->redirect($this->https(array('controller'=>'orders','action'=>'cart')));
	}
	
	function cart_item_remove(){
		$this->Cart->removeItem($this->params['url']['data']['OrdersProduct']);
		$this->Session->setFlash(__("Item Removed From Cart.", true));
		$this->redirect($this->https(array('controller'=>'orders','action'=>'cart')));	
	}
	
	function cart_clear(){
		$this->Cart->clear();
		$this->Session->setFlash(__("Cart Emptied.", true));
		$this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
	}
	
	function cart(){
		/* view vars defined in app_controller*/
	}
	
	function get_totals($shippingAddressId = null, $shippingType = null){
		$this->layout = '';
		//Configure::write('debug', 0);
		$totals = $this->Cart->getTotals($shippingType, $shippingAddressId);
		$shippingCode = $this->Cart->Shipping->shippingCodes[$shippingType];
		$_SESSION['Selected']['shippingType'] = $shippingType;
		$_SESSION['cart']['totals'] = $totals;
		$_SESSION['cart']['shipping_code'] = $shippingCode;
		$this->set(compact('totals','shippingCode'));
	}
	
	function applygiftwrap(){
		$this->autoRender = false;
		$_SESSION['cart']['gift'] = 1;
		$this->redirect($this->https(array('controller'=>'orders','action'=>'checkout')));
	}
	
	function removegiftwrap(){
		$this->autoRender = false;
		$_SESSION['cart']['gift'] = 0;
		$this->redirect($this->https(array('controller'=>'orders','action'=>'checkout')));
	}
	
}
?>
<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Html', 'Form');
	var $components = array( 'RequestHandler','Transporter' );
	var $uses =array('User','BillingAddress','ShippingAddress','State','Coupon');

	function beforeFilter(){
		
		//hack to convert data from user/add login form to login friendly form, required for AutoLogin component
		if(isset($this->data['Login'])){
			$this->data['User'] = $this->data['Login'];
			unset($this->data['Login']);
		}		
		parent::beforeFilter();
		$this->Auth->allow('create_new_account','login','add','logout','pre_checkout','forgot_password');
	}
	
	function isAuthorized(){
		return $this->authGuestDeny('view','forgot_password','change_password','edit');		
	}
	
	function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function view($id = null) {
		$this->Transporter->removeTransporter('shipping');
		$this->Transporter->removeTransporter('billing');
		if (!$id) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('action'=>'login'));
		}
		$this->User->recursive = 2;
		$this->User->Contain(array('BillingAddress','ShippingAddress','Order'=>array('CouponsUsed'),'Order'=>array('Product'=>array('OrdersProduct'))));
		$user = $this->User->find('first', aa('conditions',aa('User.id',$id)));
		if( !$this->User->authenticateUserAndData($user['User']['id']) ){
			$this->Session->setFlash(__("Invalid Operation.", true));
			$this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
		}
		$this->set(compact('user'));
	}

	function login(){
		if($user = $this->Auth->user()){
			//this pre_login_cart transporter is set from root/cart.php:
			if($base = $this->Transporter->transportBack('pre_login_cart')){
				$this->Session->setFlash(__("Welcome Back {$user['User']['email']}!", true));
				$this->redirect($base);
			}
			$this->Session->setFlash(__("Welcome Back {$user['User']['email']}!", true));
			$this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
		}	
	}
	
	function logout() {
		$this->Auth->logout();
		$this->Transporter->eraseAll();
		unset($_SESSION['cart']);
		unset($_SESSION['Selected']);
		$this->Session->setFlash(__("You have successfully logged out.", true));
		$this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
	}
	
	
	//the SWITCHBOARD, or INTERCHANGE; redirections happen here with transporting
	function pre_checkout(){
		//add coupon code from cart.php to session 
		if(!empty($_REQUEST['code'])){
			$couponCode = strtolower($_REQUEST['code']);
			$this->Coupon->recursive = -1;
			$foundCoupon = $this->Coupon->find('first',array('conditions'=>array(
																'AND'=>array('code LIKE'=>$couponCode,
																			 'site_id'=>$this->siteConfig->site_id)
																)
												));
			if($foundCoupon){
				$_SESSION['cart']['code'][$couponCode] = 1;
				$totalVals = $_SESSION['cart']['totals']; 
				$coupons = $this->Coupon->getCoupons($this->Cart->items, ($totalVals['noTaxNoShipping']));
				$this->checkCouponErrors();
			}else{
				$this->Session->setFlash(__("Invalid Coupon Code.", true));
			}
				//redirect back to cart
			$this->redirect($this->https(array('controller'=>'orders','action'=>'cart')));
		}
		if($user = $this->Auth->user()){
			$billingAddress = $this->BillingAddress->getSelectedAddress($this->authUser['id']);
			if(!empty($billingAddress)){
				if(!isset($_SESSION['Selected']['bill_id'])){
					$this->sessionSelected('bill_id',$billingAddress['BillingAddress']['bill_id']);
				}
				$shippingAddress = $this->ShippingAddress->getSelectedAddress($this->authUser['id']);
				if(!empty($shippingAddress)){
					if(!isset($_SESSION['Selected']['ship_id'])){
						$this->sessionSelected('ship_id',$shippingAddress['ShippingAddress']['ship_id']);
					}
					$this->redirect($this->https(array('controller'=>'orders','action'=>'checkout')));
				}else{
					if($user['User']['cart_guest'] == 1){
						$this->redirect($this->https(array('controller'=>'billing_addresses','action'=>'guest_add')));
					}
					$this->redirect($this->https(array('controller'=>'users','action'=>'pre_checkout_shipping')));
				}
			}else{
				if($user['User']['cart_guest'] == 1){
					$this->redirect($this->https(array('controller'=>'billing_addresses','action'=>'guest_add')));
				}
				$this->redirect($this->https(array('controller'=>'users','action'=>'pre_checkout_billing')));
			}
		}else{
			$this->Transporter->setTransporter('pre_login_cart');
			$this->redirect($this->https(array('controller'=>'users','action'=>'add')));
		}
	}
	
	function pre_checkout_billing(){
		$this->Transporter->setTransporter('billing');
		$this->User->Contain(array('BillingAddress'));
		$user = $this->User->find('first',array('conditions'=>array('id'=>$this->authUser['id'])));
		$billingAddresses = $user['BillingAddress'];
		$states = $this->State->find('list');
		$this->set(compact('billingAddresses','states'));
	}
	
	function pre_checkout_shipping(){
		$this->BillingAddress->recursive = -1;
		$billingAddress = $this->BillingAddress->find('first',array('conditions'=>array('user_id'=>$this->authUser['id'])));
		$this->User->Contain(array('ShippingAddress'));
		$user = $this->User->find('first',array('conditions'=>array('id'=>$this->authUser['id'])));
		$shippingAddresses = $user['ShippingAddress'];
		$this->Transporter->setTransporter('shipping');
		$states = $this->State->find('list');
		$this->set(compact('shippingAddresses','states','billingAddress'));
	}
	
	function billing_addresses_select($id=null){
		if($id){
			 $billingAddress = $this->BillingAddress->findByBillId($id);	 
			if($this->BillingAddress->authenticateUserAndData($billingAddress['BillingAddress']['user_id'])){
				$this->sessionSelected('bill_id',$billingAddress['BillingAddress']['bill_id']);
			}
		}
		$this->redirect(array('action'=>'pre_checkout'));		
	}
	
	function shipping_addresses_select($id=null){
		$this->autoRender = false;
		
		if($id){
			 $shippingAddress = $this->ShippingAddress->findByShipId($id);
			if($this->ShippingAddress->authenticateUserAndData($shippingAddress['ShippingAddress']['user_id'])){
				$this->sessionSelected('ship_id',$shippingAddress['ShippingAddress']['ship_id']);
			}
		}
		$this->redirect(array('action'=>'pre_checkout'));	
	}
	
	
	function add() {
		if (isset($this->data['User']['add'])) {
				unset($this->data['User']['add']);
			if (!empty($this->data)) {
				if($this->data['User']['new_account'] == 'Yes' &&
				   ($this->data['User']['retail_password'] != $this->Auth->password($this->data['User']['password_confirm'])))
				{
					$this->Session->setFlash(__('The passwords do not match. Please try again.', true));
				}else{
					
					//We need to check if email not only exists, but if no password/guest password is assigned to accommodate existing users:
					$this->data = $this->User->findExistingRecordAndMerge($this->data);
					if(!empty($this->data['User']['id'])){
						$this->User->removeValidationRule($fieldname = 'email',$rulename = 'unique');
					}else{
						$this->User->create();
					}
					
					
					//if user does not want to create an account:
					if($this->data['User']['new_account'] == 'No'){
						$this->data['User']['cart_guest'] = 1;
						$this->data['User']['retail_password'] = 'guest';
						unset($this->data['User']['password_confirm']);
						$this->User->removeValidationRule($fieldname = 'retail_password',$rulename = 'notempty');
						$this->User->removeValidationRule($fieldname = 'password_confirm',$rulename = 'length');
						$this->User->removeValidationRule($fieldname = 'password_confirm',$rulename = 'notempty');
					}else{
						$this->data['User']['cart_guest'] = 0;
					}
					unset($this->data['User']['new_account']);
					$this->data['User']['cart_site_name'] = $this->siteConfig->site;
					if ($user = $this->User->save($this->data)) {
						$this->Auth->login($user);
						
						//check if guest:
						if($user['User']['cart_guest'] == 1){
							$this->redirect($this->https(array('controller'=>'billing_addresses','action'=>'guest_add')));
						}else{
							$_SESSION['User']['cart_guest']= 0;
							$this->Session->setFlash(__("Thank you for registering {$user['User']['email']}!", true));
						}
						
						//this pre_login_cart transporter is set from orders/cart:
						if($base = $this->Transporter->transportBack('pre_login_cart')){
							$this->redirect($base);
						}else{
							$this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
						}
					} else {
						$this->Session->setFlash(__('The Information could not be saved. Please, try again.', true));
					}
				}
				
			}
		//login
		}else if($this->data){
			$user = $this->User->find('first',array('conditions'=>array(
														'email'=>$this->data['Login']['email'],
														'retail_password'=>$this->Auth->password($this->data['Login']['retail_password']))));
			if($user){
				$this->Auth->login($user);

				$this->Session->setFlash(__("Welcome Back {$user['User']['email']}!", true));
				$this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
			}else{
				$this->Session->setFlash(__("User Name and/or Password is incorrect. Please log in again.", true));
			}
		}
	}

	function edit($id = null) {
		$this->Transporter->setTransporter('User.edit');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
		}
		if (!empty($this->data)) {
			if(!($this->User->authenticateUserAndData($this->data['User']['id']))){
				$this->Session->setFlash(__("Invalid Operation.", true));
				$this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
			}
			
			//check if session email matches this->data email. if it is, remove validation. 
			//if not, user is trying to change their email, so check if it's unique:
			if(isset($this->data['User']['email'])){//transporter sends data back to edit page from change_password action, so don't save that data (that data ain't got no email key)
				if($this->authUser['email']==$this->data['User']['email']){
					$this->User->removeValidationRule($fieldname = 'email',$rulename = 'unique');
				}
				
				if ($user = $this->User->save($this->data)) {
					//change session email address to saved email in case user changed it:
					if(!empty($user['User']['email'])){
						$_SESSION['User']['email'] = $user['User']['email'];
					}
					$this->Session->setFlash(__('Account Information has been saved', true));
					$this->redirect(array('action'=>"view/$id"));
				} else {
					$this->Session->setFlash(__('Account Information could not be saved. Please, try again.', true));
				}
			}
		}
		if (empty($this->data)) {
			$this->User->recursive = -1;
			$this->data = $this->User->read(null, $id);
		}
	}
	
	function create_new_account(){
		if($this->data){
			$this->data = $this->User->findExistingRecordAndMerge($this->data);
			$this->data['User']['cart_guest'] = 0;
			if($user = $this->User->Save($this->data)){
				$this->Auth->login($user);
				$this->Session->setFlash(__('Thank you for Registering! You can access your account by clicking the "Account" link at the top of the page', true));
				$this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
			}
		}
		if($user = $this->Auth->User()){
			$this->data = $user;
		}
	}
	
	function change_password($id = null){
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
		}
		if(!($this->User->authenticateUserAndData($this->data['User']['id']))){
			$this->Session->setFlash(__("Invalid Operation.", true));
			$this->redirect(array('controller'=>'pages', 'action'=>'display', 'home'));
		}
		
		if(!$this->User->oldPasswordMatch($this->data['User'], 'retail_password')){
			$this->Session->setFlash(__('The old password is incorrect. Please try again.', true));
			$this->redirect(array('action'=>"edit/$id"));
		}
		
		if(!$this->User->newPasswordConfirm($this->data['User'], 'retail_password')){
			$this->Session->setFlash(__('The new passwords do not match. Please try again.', true));
			$this->redirect(array('action'=>"edit/$id"));
		}
		$this->data['User']['retail_password'] = $this->Auth->password($this->data['User']['retail_password']);
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The New Password has been saved', true));
				$this->redirect(array('action'=>"view/$id"));
			} else {
				$this->Session->setFlash(__('The password could not be saved.', true));
				if($seed = $this->Transporter->transportBack('User.edit')){
					$this->redirect($seed);
				}else{
					$this->redirect(array('action'=>"edit/$id"));
				}
			}
		}
	}
	
	function forgot_password(){
		if($this->data){
			$this->User->recursive = -1;
			$user = $this->User->findByEmail($this->data['User']['email']);
			if($user && $user['User']['id'] != 1){
				$newPassword = $this->generatePassword(7,0);
				$user['User']['retail_password'] = $this->Auth->password($newPassword);
				$this->User->removeValidationRule('email','unique');
				if($this->User->save($user)){
					$siteName = $this->siteConfig->getCartDBField('site_url');
					$body = "<html><body>Your $siteName account password has been reset to:<br><br><B>$newPassword</B><br><br>Please login to <a href='".Router::url(array('controller'=>'users', 'action'=>'add'),true)."'>$siteName</a> using the above password. You can later reset your password in your Account settings page.<br><br></html></body>";
					$from = $this->siteConfig->getCartDBField('customer_contact_email');
					$headers  = "From: $from\r\n";
					$headers .= "Content-type: text/html\r\n";
					mail($user['User']['email'], "$siteName - Password Reset", $body, $headers);
					$this->Session->setFlash(__("A new Password has been created for your account and has been sent to {$user['User']['email']}. ", true));
				}else{
					$this->Session->setFlash(__("Critical Error, now password could not be created. Please contact customer support.", true));
				}
			}else{
				$this->Session->setFlash(__("Email address was not found in our system. please create a new account.", true));
			}
		}
	}
	
	private function generatePassword($length=9, $strength=0) {
		$vowels = 'aeuy';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength & 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%';
		}
	 
		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}
	
	private function checkCouponErrors(){
		if($msg = $this->Coupon->getCouponErrorMessages()){
			$this->Session->setFlash($msg);
		}
		return true;
	}
}
?>
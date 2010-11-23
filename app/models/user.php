<?php
class User extends AppModel {

	var $name = 'User';
	var $useDbConfig = 'admin';
	var $actsAs = array('Containable');
	var $validate = array(
		'email' => array( 'required' => array('rule'=>'email',
											 'message' => 'Must enter a valid email address.',
											 'last' => true),
						  'unique' => array('rule'=>array('checkAcctAvailable'),
										 	   'message'=> "This email address is already in our system. 
										 	   				If you have forgotten your password, click 'Forgot Your Password' in the left column."
									           )
					     ),
		'first_name' => array('notempty'),
		'last_name' => array('notempty'),
		'phone' => array('notempty'),
		'retail_password' => array('notempty'),
		'password_confirm' => array( 'notempty',
									 'length' => array('rule' => array('between', 6, 15),
													   'message' => 'Passwords must be between 6 and 15 characters long.'), 
									)
	);

	
	//validation methods
	function checkAcctAvailable($check){ 
		$existing_accts = $this->find('all', array('conditions'=>$check, 'recursive'=> -1) );
		foreach($existing_accts as $existing_acct){
			if(!empty($existing_acct)){
				$return = (empty($existing_acct['User']['retail_password']) || $existing_acct['User']['retail_password'] == 'guest')? true : false;
			}
			if($return == false){
				return false;
			}
		}
		return true;
	}
	
	function newPasswordConfirm($data, $password_field = 'password', $password_confirm_field = 'password_confirm'){
		if($data[$password_field] == $data[$password_confirm_field] ){
			return true;
		}else{
			return false;
		}
	}
	//end validation methods
	
	
	function oldPasswordMatch($data, $password_field = 'password', $old_password_field = 'old_password'){
		$this->recursive = -1;
		$user = $this->findById($data[$this->primaryKey],array('fields'=>$password_field));
		$old_password = Security::hash($data[$old_password_field], null, true);
		if($old_password == $user[$this->name][$password_field]){
			return true;
		}else{
			return false;
		}
	}
	
	function findExistingRecordAndMerge($data = array()){
		 $user =  $this->find('first', array('conditions'=>array('email'=>$data['User']['email'], 
																		 'first_name LIKE'=>$data['User']['first_name'], 
																		 'last_name LIKE'=>$data['User']['last_name'],
																		 'OR'=>array(array('retail_password'=>'guest'),
																					 array('retail_password'=>null)),
																		  ),
															 'recursive'=>-1));
		 if(!empty($user)){
			foreach($data['User'] as $key=>$input){
				$user['User'][$key] = $input;
			}
		 }else{
		 	$user = $data;
		 }
		 return $user;
	}
	
	
	# 'promotion_code' => array(
# 'rule' => array('limitDuplicates', 25),
# 'message' => 'This code has been used too many times.'
# )

	var $hasMany = array(
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ShippingAddress' => array(
			'className' => 'ShippingAddress',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => array('display' => '1'),
			'fields' => '',
			'order' => '`default` DESC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'BillingAddress' => array(
			'className' => 'BillingAddress',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => array('display' => '1'),
			'fields' => '',
			'order' => '`default` DESC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
}
?>
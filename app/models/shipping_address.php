<?php
class ShippingAddress extends AppModel {

	var $name = 'ShippingAddress';
	var $useTable = 'shipping';
	var $primaryKey ='ship_id';
	var $validate = array(
		'firstname' => array('notempty'),
		'lastname' => array('notempty'),
		'address_1' => array('notempty'),
		'city' => array('notempty'),
		'state' => array('notempty'),
		'zip' => array('notempty'),
		'user_id' => array('rule'=>'authenticateUserAndData',
						   'message' => 'Could Not Save. Please try again.')
	);
	var $order = 'default';
	
	var $belongsTo = array(
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'state',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function beforeSave(){	
		///toggle off all defaults:
		if($this->data[$this->name]['default'] == 1){
			$this->updateAll(
				    array('default' => 0),
				    array('user_id' => $this->data[$this->name]['user_id'])
			);
		}
		return true;
	}
	
	function getSelectedAddress($user_id){
		if(isset($_SESSION['Selected']['ship_id'])){
			return $this->findByShipId($_SESSION['Selected']['ship_id']);
		}else{
			if($user_id == 1){//if guest user
				return $this->find('first',array('conditions'=>array('user_id'=>$user_id,
				 													 'guest_email_key'=>$_SESSION['User']['email']),
				 								 'order'=>'created DESC'));
			}
			return $this->find('first',array('conditions'=>array('user_id'=>$user_id,'display'=>1,'default'=>1),
											 'order'=>'default DESC'));
		}
	}
	
}
?>
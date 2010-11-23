<?php
class BillingAddress extends AppModel {

	var $name = 'BillingAddress';
	var $useTable = 'billing';
	var $primaryKey ='bill_id';
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
	var $order = 'default DESC';
	
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
		if(isset($_SESSION['Selected']['bill_id'])){
			return $this->findByBillId($_SESSION['Selected']['bill_id']);
		}else{
			return $this->find('first',array('conditions'=>array('user_id'=>$user_id,'display'=>1,'default'=>1),
											 'order'=>'default DESC'));
		}
	}
}
?>
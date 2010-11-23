<?php
class Newsletter extends AppModel {

	var $name = 'Newsletter';
	var $useDbConfig = 'admin';
	var $useTable = 'newsletter';
	var $validate = array(
		'email' => array( 'required' => array('rule'=>'email',
											  'message' => 'Please enter a valid email address.',
											  'last' => true),
						  'unique' => array('rule'=>array('checkExists'),
										 	  'message'=> "You have already signed up to our newsletter with this email address."
									       )
					     ));
	
					     
	function checkExists($check){
		$existing_acct = $this->find('first', array('conditions'=>$check, 'recursive'=> -1) );
		if(!empty($existing_acct)){
			return false;
		}else{
			return true;
		} 
	}
}
?>
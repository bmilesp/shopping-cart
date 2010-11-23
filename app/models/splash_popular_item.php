<?php
class SplashPopularItem extends AppModel {

	var $name = 'SplashPopularItem';
	var $actsAs = array('Containable');
	var $order = 'order ASC';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>
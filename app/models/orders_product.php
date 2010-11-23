<?php
class OrdersProduct extends AppModel {

	var $name = 'OrdersProduct';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'order_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'prod_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>
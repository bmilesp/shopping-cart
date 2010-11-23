<?php
class Product extends AppModel {

	var $name = 'Product';
	var $actsAs = array('containable');//sluggable - need a field and insertion methods in admin

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'ColorsProduct' => array(
			'className' => 'ColorsProduct',
			'foreignKey' => 'prod_id',
			'conditions' => '',
			'dependent' => false,
			'fields' => '',
			'order' => 'is_base DESC'
		)
	);

	var $hasAndBelongsToMany = array(
		'Order' => array(
			'className' => 'Order',
			'joinTable' => 'orders_products',
			'foreignKey' => 'prod_id',
			'associationForeignKey' => 'order_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Image' => array(
			'className' => 'Image',
			'joinTable' => 'images_products',
			'foreignKey' => 'product_id',
			'associationForeignKey' => 'image_id',
			'unique' => true,
			'conditions' => '',
		)
	);
	
	
	var $belongsTo = array(
		'Site' => array(
			'className' => 'Site',
			'foreignKey' => 'site_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShippingGroup' => array(
			'className' => 'ShippingGroup',
			'foreignKey' => 'shipping_groups_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PogoCart' => array(
			'className' => 'PogoCart',
			'foreignKey' => 'pogo_id',
			'conditions' => '',
			'fields' => '',
			'order' => '')
	);
	
	function sortPicsInArray($product = array()){
		$keys = array('pic1'=>1,'pic1_l'=>1,'pic2'=>2,'pic2_l'=>2,'pic3'=>3,'pic3_l'=>3,'pic4'=>4,'pic4_l'=>4);
		$pics = array();
		foreach ($keys as $key=>$position){
					//debug($key);
			if($product['Product'][$key] == 1){
				$pics[$key] = $position; 
			}
		}
		return $pics;
	}
	
	function beforeFind($queryData){
		$prefixes = Configure::read('Routing.prefixes');
		$possibleUrlPrefixes = split("/",$_SERVER['REQUEST_URI']);
		$foundPrefix= null;
		foreach ($possibleUrlPrefixes as $possiblePrefix){
			foreach ($prefixes as $prefix){
				if ($prefix == $possiblePrefix){
					$foundPrefix = $prefix;
					break;
				}
			}
		}
		
		if($foundPrefix){
			
			//check and set a conditions obj:
			if(!isset($queryData['conditions'])){
				$queryData['conditions'] = array();
			}
			
			//add some or conditions too if any already are set:
			if(isset($queryData['conditions']['OR'])){
				foreach($queryData['conditions']['OR'] as &$or){
					$or["url_tags LIKE"] = "%{$foundPrefix}%";
				}
			}
			
			$queryData['conditions']["url_tags LIKE"] = "%{$foundPrefix}%";
		}
		
		return $queryData;
	}
	
}
?>
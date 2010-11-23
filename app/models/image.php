<?php
class Image extends AppModel {

	var $name = 'Image';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Upload' => array(
			'className' => 'Upload',
			'foreignKey' => 'upload_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	var $hasAndBelongsToMany = array(
		'Product' => array(
			'className' => 'Product',
			'joinTable' => 'images_products',
			'foreignKey' => 'image_id',
			'associationForeignKey' => 'product_id',
			'unique' => true,
			'conditions' => '',
		)
	);

}
?>
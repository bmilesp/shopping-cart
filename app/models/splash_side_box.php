<?php
class SplashSideBox extends AppModel {

	var $name = 'SplashSideBox';
	var $order = 'order ASC';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Upload' => array(
			'className' => 'Upload',
			'foreignKey' => 'upload_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Site' => array(
			'className' => 'Site',
			'foreignKey' => 'site_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	var $hasMany = array(
		'Url' => array(
			'className' => 'Url',
			'foreignKey' => 'foreign_id'	
		)
	);

}
?>
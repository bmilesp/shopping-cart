<?php
class Upload extends AppModel {

	var $name = 'Upload';
	/* var $actsAs = array(
        'FileUpload.FileUpload' => array(
          'uploadDir' => 'img',
          'required' => false, //default is false, if true a validation error would occur if a file wsan't uploaded.
          'maxFileSize' => '200000', //bytes OR false to turn off maxFileSize (default false)
          'unique' => true //filenames will overwrite existing files of the same name. (default true)
        )
      );*/
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'SplashHeadlineImage' => array(
			'className' => 'SplashHeadlineImage',
			'foreignKey' => 'upload_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'SplashSideBox' => array(
			'className' => 'SplashSideBox',
			'foreignKey' => 'upload_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
?>
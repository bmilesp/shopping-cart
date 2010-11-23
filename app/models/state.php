<?php 
class State extends AppModel {

	var $name = 'State';
	var $useTable = 'state';
	var $useDbConfig = 'admin';
	var $primaryKey = 'state_code';
	var $displayField = 'state_name';

}
?>
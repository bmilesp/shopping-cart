<?php
class Group extends AppModel {

	var $name = 'Group';
	var $primaryKey = 'group_id';
	var $order = 'order ASC';
	var $actsAs = 'Containable';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'GroupTagName' =>array(
			'className' => 'Tag',
			'foreignKey' => 'tag_id'	
		)
	);
	
	var $hasAndBelongsToMany = array(
		'Tag' => array(
			'className' => 'Tag',
			'joinTable' => 'tags_groups',
			'foreignKey' => 'group_id',
			'associationForeignKey' => 'tag_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

	function findMenuGroups($site_id, $menu = 'main_menu'){// main_menu, side_bar, site_map
		$tagIN = $this->Tag->find('list',array('conditions'=>array('site_id'=>$site_id),
									     'fields' => array('Tag.tag_id', 'Tag.tag_id')));
		return $this->find('all',array('conditions' => array('Group.tag_id'=>$tagIN, $menu=>1)));
	}
	
}
?>
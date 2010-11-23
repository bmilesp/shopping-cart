<?php
class Tag extends AppModel {

	var $name = 'Tag';
	var $actsAs = array('Containable');
	var $primaryKey = 'tag_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'tag_id',
			'dependent' => false,
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

	var $hasAndBelongsToMany = array(
		'Group' => array(
			'className' => 'Group',
			'joinTable' => 'tags_groups',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'group_id',
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
		'Product' => array(
			'className' => 'Product',
			'joinTable' => 'tags_products',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'prod_id',
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

	function findVerifiedTagList($unverifiedTags = array(), $site_id){
		$verifiedTags = $this->find('list', array('conditions'=>array('tag_id' => $unverifiedTags,
													   'site_id'=> $site_id),
													   'recursive'=>-1));
		//resort verified tags to match url for breadcrumb:
		$sortedTagsByUrl = array();
		foreach($unverifiedTags as $urlTag){
			foreach ($verifiedTags as $verifiedTagId=>$verifiedTag){
				if($urlTag == $verifiedTagId){
					$sortedTagsByUrl[$verifiedTagId] = $verifiedTag;
				}
			}
		}
		return $sortedTagsByUrl;
	}
	
	function findProductIdsByTags($verified_tag_id_list = array(),$site_id = null){
		$searchTags = array();
		foreach($verified_tag_id_list as $tag){
			$searchTags[] = array('TagsProduct.tag_id' => $tag);
		}
		//$verified_tag_id_list needs to be a list of tag_ids and pre-filtered by site.
		$total_tags = count($verified_tag_id_list);
		$tagsProducts = $this->TagsProduct->find('all', array('conditions'=>array('OR'=>$searchTags), 
													 'fields'=>array('prod_id','count(*) as total_matching_hits'), 
													 'group'=>array("prod_id HAVING COUNT( * ) = $total_tags")));
		return Set::extract($tagsProducts, '{n}.TagsProduct.prod_id');
		
	}
	
	function findFirstSelectedGroup($varifiedTags){
		foreach($varifiedTags as $tag_id=>$tag){
			$foundGroup = $this->Group->findByTagId($tag_id);
			if($foundGroup){
				return($foundGroup);
			}
		}
		return null;
	}
	
	function findRelatedTags($productIds = array()){
		//finds tags and sorts them groups first
		if(!empty($productIds)){
			$conditions = array('prod_id'=>$productIds);
		}else{
			//don't get related tags if no products are availabel
			$conditions = array('tag_id'=>0);
		}
		$allTags  = $this->TagsProduct->find('all', array('conditions'=>$conditions, 
													 			'fields'=>array('DISTINCT tag_id') 
													 ));

		$allTags = Set::extract($allTags, '{n}.TagsProduct.tag_id');
		$groupTags = $this->Group->find('all',array('conditions'=>array('Group.tag_id'=>$allTags)));
		$groupTags = Set::extract($groupTags, '{n}.Group.tag_id');
		foreach ($groupTags as $groupTag){
			foreach($allTags as $key=>$tag){
				if($groupTag == $tag){
					unset($allTags[$key]);
				}
			}
		}
		$tags = array_merge($groupTags, $allTags);
		return $this->find('list', array('conditions'=>array('Tag.tag_id'=>$tags)));
		 
	}
	
	function findAllNonGroupTags($site_id){
		$allTagsList = $this->find('list',array('conditions'=>array('site_id'=>$site_id)));
		$allTagIds = array_keys($allTagsList);
		$groupTags = $this->Group->find('all',array('conditions'=>array('Group.tag_id'=>$allTagIds),
													'contain'=>array('GroupTagName'),
													'fields'=>array('Group.tag_id','GroupTagName.name')));
		
		$groupTagsList = array_combine(
			Set::extract($groupTags, '{n}.Group.tag_id'),
			Set::extract($groupTags, '{n}.GroupTagName.name')
		);
		return array_diff_assoc($allTagsList, $groupTagsList);
	}
	
}
?>
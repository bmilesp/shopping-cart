<?php 
	$menuType = $siteConfig->getCartDBField('menu_type');
	if($menuType != 'none'){
		$menuType = ($menuType)? $menuType : "nav/top_menu_nav";
		echo $this->element($menuType, array('groups'=>$groups, 'selectedTagId'=>$selectedTagId));
	}
?>
<?php 
	$selectedTagId = (isset($selectedTagId))? $selectedTagId : null;
	$groups = (isset($groups))? $groups : array();
?>
<div id="style_menu">
	<?php 
	$selectedTag = (isset($selectedTagId))? null : 'selected_menu_item';
	echo $html->link("ALL",array('controller'=>'pages', 'action'=>'display', 'home'),array('class'=>$selectedTag));
	?>&nbsp;&nbsp;|&nbsp;&nbsp;
	<?php
		$tagLinks = array(); 
		foreach ($groups as $group){
			$selectedTag = ($group['Group']['tag_id'] == $selectedTagId)? 'selected_menu_item' : null;
			$tagLinks[] = $html->link($group['GroupTagName']['name'],array('controller'=>'products', 'action'=>'tags', $group['Group']['tag_id']),array('class'=>$selectedTag));
		  }
	?>
	<?php echo implode("&nbsp;&nbsp;|&nbsp;&nbsp;", $tagLinks)?>
</div>
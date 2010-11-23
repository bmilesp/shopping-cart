<div id="side-bar">
	<div class="pane_header">
		NARROW SEARCH
	</div>
	<ul id="side-bar-list">
	<?php 
	//if a group is selected, move selected group to the top of the list:
	if(isset($selectedGroup)){
		foreach($groups as $key=>$group){
			if($selectedGroup['Group']['group_id'] == $group['Group']['group_id']){
				$foundGroup = $group;
				unset($groups[$key]);
				array_unshift($groups,$foundGroup);
			}
		}
	}
	$relatedTags = array_diff($relatedTags, $selectedTags);
	if(isset($relatedTags) && !empty($relatedTags)){
		$tagKeys = array_keys($selectedTags);
		?>
		<li>
			RELATED:
			<ul>
			<?php foreach ($relatedTags as $tag_id => $tag){ ?>
				<li class="side-bar-child-tags">
					<?php 
					 $appendTagsUrl = array_merge($tagKeys,array('action'=>'tags',$tag_id));
					 echo $html->link(strtoupper($tag),$appendTagsUrl)?>
				</li>		
			<?php }?>
			</ul>
		</li>
	<?php } 
	
	
	if (isset($selectedGroup)){ 
		$group = $selectedGroup;?>
		<li>
			<?php if($group['Group']['dummy'] == 1){ ?>
				<span class="dummyGroupSide"><?php echo strtoupper($group['GroupTagName']['name']) ?></span>
			<?php }else{?>
				<a href="<?php echo $rootDir ?>products/tags/<?php echo $group['Group']['tag_id']?>" class="sf-with-ul"><?php echo strtoupper($group['GroupTagName']['name'])?></a>	
			<?php }?>
			<?php if (!empty($group['Tag'])) { ?>
				<ul>
				<?php foreach ($group['Tag'] as $tag){ ?>
					<li class="side-bar-child-tags">
						<?php $noDummyTag = ($group['Group']['dummy'] == 1)? null : $group['Group']['tag_id']."/" ?>
						<a href="<?php echo $rootDir ?>products/tags/<?php echo $noDummyTag?><?php echo $tag['tag_id']?>"><?php echo strtoupper($tag['name']) ?></a>
					</li>		
				<?php }?>
				</ul>
			<?php }?>
		</li>
	<?php }
	
	 /*?>
	<?php foreach ($groups as $group){ ?>
		<li>
			<?php if($group['Group']['dummy'] == 1){ ?>
				<span class="dummyGroupSide"><?php echo strtoupper($group['GroupTagName']['name']) ?></span>
			<?php }else{?>
				<a href="<?php echo $rootDir ?>products/tags/<?php echo $group['Group']['tag_id']?>" class="sf-with-ul"><?php echo strtoupper($group['GroupTagName']['name'])?></a>	
			<?php }?>
			<?php if (!empty($group['Tag'])) { ?>
				<ul>
				<?php foreach ($group['Tag'] as $tag){ ?>
					<li class="side-bar-child-tags">
						<?php $noDummyTag = ($group['Group']['dummy'] == 1)? null : $group['Group']['tag_id']."/" ?>
						<a href="<?php echo $rootDir ?>products/tags/<?php echo $noDummyTag?><?php echo $tag['tag_id']?>"><?php echo strtoupper($tag['name']) ?></a>
					</li>		
				<?php }?>
				</ul>
			<?php }?>
		</li>
	<?php }?>
	<?php */ ?>
	</ul>
	<div style="clear:both"></div>
	<div class="pane_footer"></div>
</div>
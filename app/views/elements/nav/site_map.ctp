<table id="site-map-list">
	<tr>
	<?php
		$totalGroups = count($groups) + 1; //plus one for customer service
		foreach ($groups as $group){ ?>
		<td class="site-map-groups" width="<?php echo number_format(100 / $totalGroups,0)."%"?>">
			<?php
				if($group['Group']['dummy'] == 1){ ?>
					<span class='dummyGroup'><?php echo strtoupper($group['GroupTagName']['name']) ?></span>
				<?php }else{
					echo $html->link(strtoupper($group['GroupTagName']['name']),array('controller'=>'products','action'=>'tags',$group['Group']['tag_id']));
				}
				if (!empty($group['Tag'])) { ?>
				<?php foreach ($group['Tag'] as $tag){ ?>
					<div class="site-map-child-tags">
					<?php $noDummyTag = ($group['Group']['dummy'] == 1)? array() : array($group['Group']['tag_id']) ?>
						<?php echo $html->link(strtoupper($tag['name']),array_merge($noDummyTag,array('controller'=>'products','action'=>'tags',$tag['tag_id'])))?>
					</div>		
				<?php }?>
			<?php }?>
		</td>
	<?php }?>
		<td class="site-map-groups customer_service_panel" width="100px">
			<span class="sf-with-ul">CUSTOMER&nbsp;SERVICE</span>
				<div class="site-map-child-tags">
					<?php echo $html->link('FAQ',array('controller'=>'pages','action'=>'display','faq'))?>
				</div>
				<div class="site-map-child-tags">
					<?php echo $html->link('CONTACT US',array('controller'=>'pages','action'=>'display','contact_us'))?>
				</div>
				<div class="site-map-child-tags">
					<?php echo $html->link('PRIVACY POLICY',array('controller'=>'pages','action'=>'display','privacy_policy'))?>
				</div>
				<div class="site-map-child-tags">
					<?php echo $html->link('ABOUT US',array('controller'=>'pages','action'=>'display','about_us'))?>
				</div>
				<div class="site-map-child-tags">
					<?php echo $html->link('CUSTOM SCREEN PRINTING','http://www.undergroundshirts.com/?standard=true&p=quote', array('target'=>'_blank'))?>
				</div>	
		</td>
	</tr>
</table>

<?php echo $javascript -> link('jquery.hoverintent.js'); ?>
<?php echo $javascript -> link('jquery.superfish.js'); ?>
<script>
	$().ready(init);
	function init(){
		$("ul.sf-menu").superfish({animation: {height:'show'},delay: 1, autoArrows: false});
	}
 
</script>
<div class="top-nav">
<div class="center-wrapper">
<div class="navHolder">
	<ul class="sf-menu sf-js-enabled sf-shadow" id="sample-menu-1">
	<?php foreach ($groups as $group){ ?>
		<li class="top-menu-item current <?php echo (empty($group['Tag']))? 'sf-menu-solo-item' : null ?>">
			<?php if($group['Group']['dummy'] == 1){ ?>
				<a href="javascript:void(0)" class="sf-with-ul"><?php echo strtoupper($group['GroupTagName']['name'])?><span class="sf-sub-indicator"> »</span></a>	
			<?php }else{?>
				<a href="<?php echo $rootDir ?>products/tags/<?php echo $group['Group']['tag_id']?>" class="sf-with-ul"><?php echo strtoupper($group['GroupTagName']['name'])?><span class="sf-sub-indicator"> »</span></a>	
			<?php }?>
			<?php if (!empty($group['Tag'])) { ?>
				<ul style="display: none; visibility: hidden;">
				<?php 
					$totalTags = count($group['Tag']);
					$i=1; 
					foreach ($group['Tag'] as $tag){ ?>
					<li class='<?php echo ($i == $totalTags)? 'lastMenuItem' : null?>'>
						<?php $noDummyTag = ($group['Group']['dummy'] == 1)? null : $group['Group']['tag_id']."/" ?>
						<a href="<?php echo $rootDir ?>products/tags/<?php echo $noDummyTag ?><?php echo $tag['tag_id']?>"><?php echo strtoupper($tag['name']) ?></a>
					</li>		
				<?php $i++;}?>
				</ul>
			<?php }?>
		</li>
	<?php }?>
	</ul>
</div> 
</div>
</div>


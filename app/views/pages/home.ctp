<div id="homePageContent">
	<div id="home_left_side">
		<div id="headlines" class="pane">
			<?php echo $this->element('home/jquery_showcase',array('headlineImages',$headlineImages))?>
		</div>
		<div style="clear:both"></div>
		<div id="popularItems" class="pane">
			<div class="pane_header">
				POPULAR ITEMS
			</div>
				<?php echo $this->element('home/popular_items',array('popularProducts'=>$popularProducts))?>
			<div style="clear:both"></div>
			<div class="pane_footer"></div>
		</div>
	</div>
	
	<div id="home_right_side">
		<?php foreach ($sideBoxes as $box){?>
			<div id="newArrivals" class="pane">
				<div class="pane_header">
					<?php echo strtoupper($box['SplashSideBox']['title'])?>
				</div>
				<div>
					<?php 
					$boxUrl = array();
					if(isset($box['Url'][0]['url']) && !strstr($box['Url'][0]['url'],'http://')){
						$boxUrl = array('url'=>$rootDirNoTrailingSlash.$box['Url'][0]['url']); 
					}else if(isset($box['Url'][0]['url'])) {
						$boxUrl = array('url'=>$box['Url'][0]['url']);
					}	
					echo $html->image("{$cartsAdminUrl}c/img/{$box['Upload']['name']}",array_merge($boxUrl,array('width'=>'255')))?>
				</div>
				<div style="clear:both"></div>
				<div class="pane_footer"></div>
			</div>
			<div style="clear:both"></div>
		<?php }
		if($tagCloudSet){
			?>
			<div id="tagCloud">
				<?php 
				$scoreCloudFormulated = $tagcloud->formulateTagCloud($scoreCloud);
				$nameCloudShuffled = $tagcloud->shuffleTags($nameCloud);
				foreach ($nameCloudShuffled as $id=>$word){?>
					<?php echo $html->link($word, array('controller'=>'products', 'action'=>'tags',$id),array('style'=>"font-size:{$scoreCloudFormulated[$id]['size']}%"))?>
				<?php }?>
			</div>
		<?php } ?>
	</div>
</div>
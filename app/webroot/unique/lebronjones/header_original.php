<div id="header<?php echo $prefix ?>" style="background-image:url('<?php echo "{$secureRootDir}unique/{$siteConfig->site}" ?>/img/banner<?php echo $prefix ?>.jpg')">
	<?php $img =  $html->image("{$secureRootDir}unique/{$siteConfig->site}/img/MyCART{$prefix}.jpg",array('alt'=>'MyCart', 'id'=>'mycart'));
		echo $html->link($img, $html->url(array('controller'=>'orders', 'action'=>'cart'),true,true),array('escape'=>false));
	?>
	<div id="twitter_book_icons_header">
	<?php $img =  $html->image("{$secureRootDir}img/twitter.png",array('alt'=>'Twitter'));
		echo $html->link($img, $html->url('http://twitter.com/lebronjones'),array('escape'=>false,'target'=>'_blank'));
	?>
	<?php $img =  $html->image("{$secureRootDir}img/facebook.png",array('alt'=>'Facebook'));
		echo $html->link($img, $html->url('http://www.facebook.com/staygonelebron'),array('escape'=>false,'target'=>'_blank'));
	?>
	</div>
	<div id="menu<?php echo $prefix ?>" style="background-image:url('<?php echo "{$secureRootDir}unique/{$siteConfig->site}" ?>/img/menu_bg<?php echo $prefix ?>.jpg')">
		<?php echo $html->link("SHOP ONLINE",$html->url(array('controller'=>'pages', 'action'=>'display', 'home'),true,true));?>
		<?php echo $html->link("FAQ",$html->url(array('controller'=>'pages', 'action'=>'display', 'faq'),true,true));?>
	</div>
</div>
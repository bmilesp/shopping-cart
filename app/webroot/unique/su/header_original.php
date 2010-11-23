<div id="header<?php echo $prefix ?>" style="background-image:url('<?php echo "{$secureRootDir}unique/{$siteConfig->site}" ?>/img/banner<?php echo $prefix ?>.jpg')">
	<?php $img =  $html->image("{$secureRootDir}unique/{$siteConfig->site}/img/MyCART{$prefix}.jpg",array('alt'=>'MyCart', 'id'=>'mycart'));
		echo $html->link($img, $html->url(array('controller'=>'orders', 'action'=>'cart'),true,true),array('escape'=>false));
	?>
	<div id="menu<?php echo $prefix ?>" style="background-image:url('<?php echo "{$secureRootDir}unique/{$siteConfig->site}" ?>/img/menu_bg<?php echo $prefix ?>.jpg')">
		<?php echo $html->link("SHOP ONLINE",$html->url(array('controller'=>'pages', 'action'=>'display', 'home'),true,true));?>
		<?php echo $html->link("OUR STORES",$html->url(array('controller'=>'pages', 'action'=>'display', 'about_us'),true,true));?>
		<?php echo $html->link("FAQ",$html->url(array('controller'=>'pages', 'action'=>'display', 'faq'),true,true));?>
		<?php echo $html->link("MOE SPORT SHOPS",'http://moesportshops.com');?>
		<?php echo $html->link("CUSTOM SCREENPRINTING",'http://www.undergroundshirts.com/?standard=true&p=quote', array('target'=>'_blank'));?>
	</div>
</div>
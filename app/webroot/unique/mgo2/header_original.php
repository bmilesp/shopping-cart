<div id="header">
<?php $img =  $html->image("{$secureRootDir}unique/{$siteConfig->site}/img/banner{$prefix}.jpg",array('alt'=>'Banner', 'id'=>'banner'));
	echo $html->link($img, $html->url(array('controller'=>'pages', 'action'=>'display', 'home'),true,true),array('escape'=>false));
?>
<?php $img =  $html->image("{$secureRootDir}unique/{$siteConfig->site}/img/Faq.jpg",array('alt'=>'Faq', 'id'=>'faq'));
		echo $html->link($img, $html->url(array('controller'=>'pages', 'action'=>'faq'),true,true),array('escape'=>false));
	?>
<Br><br>
<?php $img =  $html->image("{$secureRootDir}unique/{$siteConfig->site}/img/MyCART{$prefix}.jpg",array('alt'=>'MyCart', 'id'=>'mycart'));
		echo $html->link($img, $html->url(array('controller'=>'orders', 'action'=>'cart'),true,true),array('escape'=>false));
	?>
</div>

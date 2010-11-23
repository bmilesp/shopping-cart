<?php $html->css('center_products_list',null,array('inline'=>false));?>
<?php echo urldecode($siteConfig -> getCartDBField("home_tail_top")); ?>
<div id="products_list">
	<?php 
	foreach ($products as $product){
		echo $this->element('product_rollover',array("product" => $product));
	}?>
</div>
<div style="clear:both"></div>
<?php echo urldecode($siteConfig -> getCartDBField("home_tail")); ?>

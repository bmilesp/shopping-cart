<?php $html->css('center_products_list',null,array('inline'=>false));?>
<div id="products_list">
	<?php 
	foreach ($products as $product){
		echo $this->element('product_rollover',array("product" => $product));
	}?>
</div>
<div style="clear:both"></div>
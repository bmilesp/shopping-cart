<div id="product_spotlight">
	<?php echo $this->element('product/spotlight',array('product'=>$product,
														'prodImageUrl'=>$prodImgUrl,
														'socialURL'=>$socialURL,
														'bitlyURL'=>$bitlyURL,
														'pageTitle'=>$pageTitle))?>
</div>
<div id="product_selector" class="pane">
	<?php echo $this->element('product/selector',array('product'=>$product))?>
</div>
<div id="similar_products">
	<?php //echo $this->element('product\similarProducts',array('products'=>$similarProducts))?>
</div>

<div style="clear:both"></div>
<div id="product_description">
	<h2>Description:</h2>
	<p><?php echo urldecode($product['Product']['message2'])?></p>
</div>
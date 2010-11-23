<?php 
$jscode = 
"
	jQuery(document).ready(init);
	
	function init(){
		jQuery('#selector_sizes').bind('change',changeSize);
		jQuery('#selector_colors').bind('change',changeColor);
	}
	
	function changeSize(e){
		var unavailable = jQuery('#'+jQuery(this).val()).find('#unavailable').val();
		if(unavailable == 1){
			jQuery('#addToCart').hide(0);
		}else{
			jQuery('#addToCart').show(0);
		}
		jQuery('#selector_availability .selector_availability_text').addClass('unselected_availability_message');
		jQuery('#selector_availability').find('#'+jQuery(this).val()).removeClass('unselected_availability_message');
		jQuery('#ProductSize').val(jQuery(this).val());
		
	}
	
	function changeColor(e){
		window.location.href = '".Router::url(array('controller'=>'products', 'action'=>'view',$productId))."/'+jQuery(this).val();
	}

";

echo $javascript->codeBlock($jscode, array('inline'=>false));
?>
<div class="price_box">
	<?php echo $this->Form->create('Product',array('url' =>array('controller'=>'orders','action'=>'cart_add'), 'id'=>'frm' ));?>
	<?php echo $this->Form->input('product_id',array('type'=>'hidden','value'=>$productId));
			$sizes = array_combine(
				array_keys($product['sizes']),
				array_keys($product['sizes'])
			);
	?>
				<div id="productPriceWrapper">
					<span class="prod_price">$<?php echo $product['Product']['price']?></span>
				</div>
				<div>
					<?php 
						  $colorsList = array_combine(
							  Set::extract($colors,"{n}.Color.id"),
							  Set::extract($colors,"{n}.Color.color")
						  );
						  echo $form->input('Product.color_id',array(
																 'id'=>'selector_colors',
																 'type'=>'select',
																 'options'=>$colorsList,
																 'selected'=>$product['Color']['id'])); ?>
				
					<?php echo $form->input('Product.size',array('id'=>'selector_sizes',
																 'type'=>'select',
																 'options'=>$sizes)); ?>
					
					<?php echo $form->input('Product.qty', array('size'=>3,'value'=>1)) ?>
				</div>
				<br>
				<div id="selector_availability"><strong>Availability:</strong> 
					<?php $sizeKeys = array_keys($product['sizes']);
					foreach ($product['sizes'] as $size=>$sku){?>
						<?php if($sizeKeys[0] == $size){?>
							<?php echo $form->input('size',array('type'=>'hidden','value'=> $size ))?>
						<?php }?>
						<span id="<?php echo $size ?>" class="selector_availability_text <?php echo ($sizeKeys[0] == $size)? null : 'unselected_availability_message'?>">
							<?php if (!$product['allSkusStatus']['U'][$size] && $product['allSkusStatus']['O'][$size] && 
							($product['allSkusStatus']['B'][$size] || 
							 ($product['allSkusStatus']['AB'][$size] && !$product['allSkusStatus']['O'][$size]))){?>
									<span id='backordered_sku_message'>This particular size and color combination is currently on <strong>backorder</strong> for this item.  It will be back in stock within 10 business days.</span>
							<?php }else if(($product['allSkusStatus']['U'][$size] || 
								($product['allSkusStatus']['B'][$size] && !$product['allSkusStatus']['O'][$size]) || 
								($product['allSkusStatus']['AB'][$size] && !$product['allSkusStatus']['O'][$size])
							)){?>
									<?php echo $form->input('unavailable',array('type'=>'hidden','value'=>1,'id'=>'unavailable'))?>
									<span id='backordered_sku_message'>This particular size and color combination is currently <strong>unavailable</strong> for this item. Sorry for the inconvenience.</span>
							<?php }else{ ?>
								IN STOCK
							<?php }?> 
						</span>
					<?php }?>
					<div style="clear:both"></div>
					<div>
						<?php 
						$button_style = '';
						$selectedKey = array_shift(array_keys($product['sizes']));
						if($product['allSkusStatus']['U'][$selectedKey] || 
							($product['allSkusStatus']['B'][$selectedKey] && !$product['allSkusStatus']['O'][$selectedKey]) || 
							($product['allSkusStatus']['AB'][$selectedKey] && !$product['allSkusStatus']['O'][$selectedKey])
						){
							$button_style = 'display:none';
						}?>
						<span id="cart_span">
							<img onclick="jQuery('#frm').submit()" alt="Add To Cart" id="addToCart" style="<?php echo $button_style?>" 
								 src="<?php echo Router::url('/img/AddToCart.png')?>">
						</span>
					</div>
				</div>
		<?php echo $this->Form->end()?>
	</div>
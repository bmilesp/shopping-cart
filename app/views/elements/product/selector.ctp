<?php 

$jscode = 
<<<EOJAVASCRIPT
	$(document).ready(init);
	
	function init(){
		$('#selector_sizes .size_button').bind('click',changeSize);
	}
	
	function changeSize(e){
		var unavailable = $('#'+$(this).html()).find('#unavailable').val();	
		if(unavailable == 1){
			$('#add_button').hide(0);
		}else{
			$('#add_button').show(0);
		}
		$(this).siblings().removeClass('size_button_selected');
		$('#selector_availability').find('.selector_availability_text').addClass('unselected_availability_message');
		$('#selector_availability').find('#'+$(this).html()).removeClass('unselected_availability_message');
		$(this).addClass('size_button_selected');
		$(this).parent().find('#ProductSize').val($(this).html());
		
	}

EOJAVASCRIPT;

echo $javascript->codeBlock($jscode, array('inline'=>false));

?>
<div>
	<?php echo $form->create('Product',array('url' =>array('controller'=>'orders','action'=>'cart_add'),
											 'class'=>'cart_add_form'));
	echo $form->input('product_id',array('type'=>'hidden','value'=>$productId))?>
	<div class="pane_header">
		<?php echo strtoupper(urldecode($product['Product']['name']));?>
	</div>
	<div class="selector_pane_content">
		<div id="bigPrice">$<?php echo $product['Product']['price']?></div>
		<div id="size_quantity_selection">
			<div id="selector_availability"><strong>AVAILABILITY:</strong> 
				<?php $sizeKeys = array_keys($product['sizes']);
				foreach ($product['sizes'] as $size=>$sku){?>
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
			</div>
			<div style="clear:both"></div>
			<div id="selector_sizes">
				<strong id="selector_size_title">SIZE:</strong> 
				<?php foreach ($product['sizes'] as $size=>$sku){?>
					<?php if($sizeKeys[0] == $size){?>
						<?php echo $form->input('size',array('type'=>'hidden','value'=> $size ))?>
					<?php }?>
					<div class='size_button <?php echo ($sizeKeys[0] == $size)? 'size_button_selected' : null ?>'><?php echo $size?></div>
				<?php } ?>
			</div>
			<div style="clear:both"></div>
			<div id="selector_colors">
				<strong id="selector_color_title">COLOR:</strong> 
				<?php foreach ($colors as $color){
					if($colorId == $color['ColorsProduct']['color_id']){
						echo $form->input('color_id',array('type'=>'hidden', 'value'=>$color['ColorsProduct']['color_id']));
					}?>
					<div class="selector_color_swatch <?php echo ($colorId == $color['ColorsProduct']['color_id'])? 'selector_color_swatch_selected': null?>">
					<?php 
						$iconSize = ($colorId == $color['ColorsProduct']['color_id'])? '24px' : '16px';
						$image =  $html->image("http://catalog.undergroundshirts.com/swatches/{$color['Color']['filename']}",
										  array('alt'=>$color['Color']['color'],
										  		'width'=>$iconSize, 'height'=>$iconSize)
										 );
						echo $html->link($image,array('action'=>'view',$productId,$color['ColorsProduct']['color_id']),
												array('title'=>$color['Color']['color'],
													  'escape'=>false)
										 );
						?>
					</div>
				<?php }?>
			</div>
			<div style="clear:both"></div>
			<div id="selector_qty">
				<strong id="selector_qty_title">QUANTITY:</strong>
				<?php echo $form->input('qty', array('value'=>1, 'size'=>3, 'div'=>false, 'label'=>false));?>
			</div>
			<div style="clear:both"></div>
			<div id="add-to-cart">
				<?php 
					$button_style = '';
					$selectedKey = array_shift(array_keys($product['sizes']));
					if($product['allSkusStatus']['U'][$selectedKey] || 
						($product['allSkusStatus']['B'][$selectedKey] && !$product['allSkusStatus']['O'][$selectedKey]) || 
						($product['allSkusStatus']['AB'][$selectedKey] && !$product['allSkusStatus']['O'][$selectedKey])
					){
						$button_style = 'display:none';
					}
					echo $form->end(array('label'=>'ADD','style'=>$button_style,'id'=>'add_button'));
				?>
			</div>
			<div style="clear:both"></div>
		</div>	
	</div>
	<div class="pane_footer"></div>
</div>
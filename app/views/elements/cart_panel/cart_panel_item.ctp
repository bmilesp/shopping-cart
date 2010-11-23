<div class="cart-panel-item" onclick="window.location = '<?php echo $secureRootDir ?>products/view/<?php echo $item['Product']['id'] ?>/<?php echo $item['ColorsProduct']['color_id'] ?>'">
	<div class="cart-item-image">
	<?php echo $html->image("$prodImgUrl/position_1/{$item['Product']['id']}_{$item['ColorsProduct']['color_id']}.jpg",
										array('url'=>array('controller'=>'products', 'action'=>'view', $item['Product']['id'], $item['ColorsProduct']['color_id'] ),
											  'width'=>50)
									    )?>
	</div>
	<div class="cart-item-description">
		<span class="cart-item-text cart-item-title"><?php echo urldecode($item['Product']['name'])?></span>
		<br><span class="cart-item-text cart-item-color"><?php echo urldecode($item['Color']['color']) ?></span>
		</br><span class="cart-item-text cart-item-size"><?php echo $item['size'] ?></span><span class="cart-item-text cart-item-qty"> x <?php echo $item['qty'] ?></span>
		<?php if( /* $item['isBackordered'] */ !$item['thisItemStatus']['U'] && $item['thisItemStatus']['O'] && 
						($item['thisItemStatus']['B'] || 
						 ($item['thisItemStatus']['AB'] && !$item['thisItemStatus']['O']) )){  ?>
					<span class="cart-item-text cart-item-title"><font color='red'>Sorry! This item currently <strong>backorder</strong>.</font></span>
		<?php  } else if(($item['thisItemStatus']['U'] || 
							($item['thisItemStatus']['B'] && !$item['thisItemStatus']['O']) || 
							($item['thisItemStatus']['AB'] && !$item['thisItemStatus']['O'])
						)){ ?>
					<span class="cart-item-text cart-item-title"><font color='red'>Sorry! This item currently <strong>unavailable</strong>.</font></span>
		<?php } ?>
	</div>
</div>
<div style="clear:both"></div>
<?php $modifiable = (isset($modifiable))? $modifiable : true; ?>
<table class='cart_item'>
	<tr>
		<td>
			<?php echo $html->image("$cartItemImageUrl/position_1/{$item['Product']['id']}_{$item['ColorsProduct']['color_id']}.jpg",
									array('url'=>array('controller'=>'products', 'action'=>'view', $item['Product']['id'], $item['ColorsProduct']['color_id'] ),
										  'width'=>100)
								    )?>
			
		</td>
		<td style="text-align:left">
		<?php echo urldecode($item['Product']['name'])?> - <?php echo urldecode($item['Color']['color']) ?><Br><br><span 
		class='size'>Size: <strong><?php echo $item['size'] ?></strong></span><br><br>
		<?php if( /* $item['isBackordered'] */ !$item['thisItemStatus']['U'] && $item['thisItemStatus']['O'] && 
						($item['thisItemStatus']['B'] || 
						 ($item['thisItemStatus']['AB'] && !$item['thisItemStatus']['O']) )){  ?>
					<span id="backordered_sku_message">This particular size and color combination is currently on 
						<strong>backorder</strong> for this item.  It will be back in stock within 10 business days.
					</span>
					<br><br>
					<div style='clear:both'></div>
		<?php  } else if(($item['thisItemStatus']['U'] || 
							($item['thisItemStatus']['B'] && !$item['thisItemStatus']['O']) || 
							($item['thisItemStatus']['AB'] && !$item['thisItemStatus']['O'])
						)){ ?>
					<span id='backordered_sku_message'>This particular size and color combination is currently
						 <strong>unavailable</strong> for this item. Sorry for the inconvenience.</span>
					<br><br>
					<div style='clear:both'></div> 
			<?php } ?>
			<?php if($modifiable){?>
				<form><?php //this is a dummy form since firefox likes to remove the first nested form within a form?></form>
				<?php echo $this->Form->create('Edit',array('url' => $this->Html->url(array('controller'=>'orders','action'=>'cart_item_edit'),true,true), 
															'id'=>'frm_update_qty',
															'type'=>'get' ));?>
					<input type='text' size='3' name='data[OrdersProduct][qty]' id='qty' value='<?php echo $item['qty'] ?>'>
					<input type='hidden' name='data[OrdersProduct][prod_id]' value='<?php echo $item['Product']['id'] ?>'>
					<input type='hidden' name='data[OrdersProduct][color_id]' value='<?php echo $item['ColorsProduct']['color_id'] ?>'>
					<input type='hidden' name='data[OrdersProduct][size]' value='<?php echo $item['size'] ?>'>
					<input type='button' value='Update Quantity' onclick="if(document.getElementById('qty').value>0){$(this).parent().submit();}else{alert('Update quantity must be greater than zero.');}">
				<?php echo $this->Form->end();?>
				<?php echo $this->Form->create('Edit',array('url' => $this->Html->url(array('controller'=>'orders','action'=>'cart_item_remove'),true,true), 
															'id'=>'frm_remove',
															'type'=>'get' ));?>
					<input type='hidden' name='data[OrdersProduct][prod_id]' value='<?php echo $item['Product']['id'] ?>'>
					<input type='hidden' name='data[OrdersProduct][color_id]' value='<?php echo $item['ColorsProduct']['color_id'] ?>'>
					<input type='hidden' name='data[OrdersProduct][size]' value='<?php echo $item['size'] ?>'>
					<input type='button' class='remove_btn' value='Remove' onclick="$(this).parent().submit();">
				<?php echo $this->Form->end();?>
			<?php }else{?>
				<span class='size'>Qty: <strong><?php echo $item['qty'] ?></strong></span>
			<?php }?>
		</td>
		<td>
			<?php if(($item['thisItemStatus']['U'] || 
							($item['thisItemStatus']['B'] && !$item['thisItemStatus']['O']) || 
							($item['thisItemStatus']['AB'] && !$item['thisItemStatus']['O'])
						)){ ?>
			<span class='price'>$<?php echo number_format(0, 2) ?></span>
			<?php } else { ?>
			<span class='price'>$<?php echo number_format($item['price'] * $item['qty'], 2) ?></span>
			<?php } ?>
		</td>
	</tr>
</table>
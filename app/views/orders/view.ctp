<div class="orders view">
<h2><?php  __('Order #'); echo $order['Order']['order_id'];?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Transaction ID'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $order['Order']['transactionID']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Order Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $order['Order']['date_created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Prod Subtotal'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			$<?php echo $order['Order']['prod_subtotal']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ship Total'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			$<?php echo $order['Order']['ship_total']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tax Total'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			$<?php echo $order['Order']['tax_total']; ?>
			&nbsp;
		</dd>
		
		<?php if ($order['Order']['refund_amount'] > 0){ ?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Refund Amount'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				$<?php echo $order['Order']['refund_amount']; ?>
				&nbsp;
			</dd>
		<?php } ?>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Total'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<strong>$<?php echo $order['Order']['total']; ?></strong>
			&nbsp;
		</dd>
		
		<?php if ($order['Order']['gift_wrap']){ ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Gift Wrap'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo "*Order Was Gift Wrapped" ?>
			&nbsp;
		</dd>
		<?php } ?>
		
		<?php if ($order['Order']['gift_receipt']){ ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Gift Receipt'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $order['Order']['gift_receipt']; ?>
			&nbsp;
		</dd>
		<?php } ?>
	</dl>
</div>
<div id="shipping_info">
	<div id="shipping_process_wrapper">
		<h3>Shipping Details:</h3>
		<label>Status:</label>
		<div>
		<?php 
			  echo ($order['Order']['shipped'] == 1)? "<span class='shipped_text'>Shipped on {$order['Order']['last_shipped']}</span><br>" : null;
			  echo ($order['Order']['backorder'] == 1)? "<span class='backorder_text'>Backorder</span><br>" : null;
			  echo ($order['Order']['cancelled'] == 1)? "<span class='cancelled_text'>Cancelled</span><br>" : null;
		?>
		</div>
		<label>Shipping Method:</label>
		<div>
		<?php 
			  echo ($order['Order']['ship_type'])? "<span class='shipped_text'>{$order['Order']['ship_type']}</span><br>" : null;
		?>
		</div>

	</div>
	<div id="shipping_label_wrapper">
		<h3><?php  __('Shipped To:');?></h3>
		<?php echo $this->element('address_label', 
								array("data" => $order['ShippingAddress'],
									  "editMode" => false,
									  "primaryKey" => 'ship_id'
								));
		?>
	</div>
</div>
<br></br>
<div class="related">
<?php if (!empty($order['CouponsUsed'])):?>
	<h3><?php __('Coupons Used');?></h3>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Coupon ID #'); ?></th>
		<th><?php __('Message'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($order['CouponsUsed'] as $couponsUsed):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $couponsUsed['disc_id'];?></td>
			<td><?php echo urldecode($couponsUsed['message']);?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
<div class="related">
	<h3><?php __('Products');?></h3>
	<?php if (!empty($order['Product'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Quantity'); ?></th>
		<th><?php __('Product Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Price'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($order['Product'] as $product):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $product['OrdersProduct']['qty'];?></td>
			<td><?php echo $product['id'];?></td>
			<td><?php echo urldecode($product['name'])." (".$product['OrdersProduct']['size'].")";?></td>
			<td><?php echo $product['price'] * $product['OrdersProduct']['qty'];?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
<br><br>
<?php echo $html->link(__('Back To Your Account', true), array('controller'=>'users','action' => 'view', $order['User']['id'])); ?>
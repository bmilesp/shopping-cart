

<div class="users view">
<h2><?php echo __('My Account')?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('First Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['first_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Last Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['last_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['phone']; ?>
			&nbsp;
		</dd>
		
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit User Information and/or Password', true), array('action' => 'edit', $user['User']['id'])); ?> </li>
	</ul>
</div>
<div class="related" id="shipping_addresses">
	<h3><?php __('Shipping Addresses');?></h3>
	<?php if (!empty($user['ShippingAddress'])):?>
	<div class="list_addresses">
		<?php
		foreach ($user['ShippingAddress'] as $shippingAddress):?>
			<div id="address_label_container_<?php echo $shippingAddress['ship_id'] ?>">
				<?php echo $this->element('address_label', 
								array("data" => $shippingAddress,
									  "editMode" => true,
									  "primaryKey" => 'ship_id'
								));
				?>
			</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
	<div class="actions clear_both">
		<ul>
			<li><?php echo $html->link(__('Add New Shipping Address', true), array('controller' => 'shipping_addresses', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Billing Addresses');?></h3>
	<?php if (!empty($user['BillingAddress'])):?>
	<div class="list_addresses">
		<?php
		foreach ($user['BillingAddress'] as $billingAddress):?>
				<?php echo $this->element('address_label', 
								array("data" => $billingAddress,
									  "editMode" => true,
									  "primaryKey" => 'bill_id',
									  "controller" => 'billing_addresses'
								));
				?>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>

	<div class="actions clear_both">
		<ul>
			<li><?php echo $html->link(__('Add New Billing Address', true), array('controller' => 'billing_addresses', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Recent Orders');?></h3>
	<?php if (!empty($user['Order'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Order Date and Time');?></th>
		<th><?php __('Items');?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Order'] as $order):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
			?>
			<tr<?php echo $class;?>>
			<td><?php echo $order['date_created']; ?></td>
			<td>
				<ul class="retailSalesItemsList">
				<?php  foreach($order['Product'] as $product){ ?>
						<li><?php echo $product['OrdersProduct']['qty']?> of: <?php echo str_replace('+',' ',$product['OrdersProduct']['name']) ?> (<?php echo $product['OrdersProduct']['size'] ?>)</li>
					<?php } ?>
				</ul>
			</td>
				<td class="actions">
					<?php echo $html->link(__('View', true), array('controller' => 'orders', 'action' => 'view', $order['order_id'])); ?>
				</td>
			</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>

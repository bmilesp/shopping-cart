<div class="coupons view">
<h2><?php  __('Coupon');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $coupon['Coupon']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Site Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $coupon['Coupon']['site_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $coupon['Coupon']['code']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $coupon['Coupon']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Minprice'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $coupon['Coupon']['minprice']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Minitems'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $coupon['Coupon']['minitems']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Maxitems'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $coupon['Coupon']['maxitems']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Requireditem'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $coupon['Coupon']['requireditem']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Discounttype'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $coupon['Coupon']['discounttype']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Discountamount'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $coupon['Coupon']['discountamount']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Discountto'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $coupon['Coupon']['discountto']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Auto'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $coupon['Coupon']['auto']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Uses'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $coupon['Coupon']['uses']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Remove'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $coupon['Coupon']['remove']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $coupon['Coupon']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Start Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $coupon['Coupon']['start_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('End Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $coupon['Coupon']['end_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Usps'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $coupon['Coupon']['usps']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ups Ground'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $coupon['Coupon']['ups_ground']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ups 2 Day Air'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $coupon['Coupon']['ups_2_day_air']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ups Next Day Air'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $coupon['Coupon']['ups_next_day_air']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Coupon', true), array('action' => 'edit', $coupon['Coupon']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Coupon', true), array('action' => 'delete', $coupon['Coupon']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $coupon['Coupon']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Coupons', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Coupon', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Coupons Useds', true), array('controller' => 'coupons_useds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Coupons Used', true), array('controller' => 'coupons_useds', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Coupons Useds');?></h3>
	<?php if (!empty($coupon['CouponsUsed'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Disc Id'); ?></th>
		<th><?php __('Order Id'); ?></th>
		<th><?php __('Message'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($coupon['CouponsUsed'] as $couponsUsed):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $couponsUsed['disc_id'];?></td>
			<td><?php echo $couponsUsed['order_id'];?></td>
			<td><?php echo $couponsUsed['message'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'coupons_useds', 'action' => 'view', $couponsUsed['disc_id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'coupons_useds', 'action' => 'edit', $couponsUsed['disc_id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'coupons_useds', 'action' => 'delete', $couponsUsed['disc_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $couponsUsed['disc_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Coupons Used', true), array('controller' => 'coupons_useds', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Products');?></h3>
	<?php if (!empty($coupon['Product'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Site Id'); ?></th>
		<th><?php __('DaOrder'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Message'); ?></th>
		<th><?php __('Message2'); ?></th>
		<th><?php __('Sizing Link'); ?></th>
		<th><?php __('Price'); ?></th>
		<th><?php __('On Sale'); ?></th>
		<th><?php __('Active'); ?></th>
		<th><?php __('Out Of Stock'); ?></th>
		<th><?php __('Discontinue'); ?></th>
		<th><?php __('Style Id'); ?></th>
		<th><?php __('Is Apparel'); ?></th>
		<th><?php __('Pogo Id'); ?></th>
		<th><?php __('Is Guys'); ?></th>
		<th><?php __('Is Girls'); ?></th>
		<th><?php __('Is Youth'); ?></th>
		<th><?php __('Is Baby'); ?></th>
		<th><?php __('Is Accessory'); ?></th>
		<th><?php __('Pic1'); ?></th>
		<th><?php __('Pic1 L'); ?></th>
		<th><?php __('Pic2'); ?></th>
		<th><?php __('Pic2 L'); ?></th>
		<th><?php __('Pic3'); ?></th>
		<th><?php __('Pic3 L'); ?></th>
		<th><?php __('Pic4'); ?></th>
		<th><?php __('Pic4 L'); ?></th>
		<th><?php __('American Apparel'); ?></th>
		<th><?php __('Five Dollar Overlay'); ?></th>
		<th><?php __('Url Tags'); ?></th>
		<th><?php __('Special Product'); ?></th>
		<th><?php __('Shipping Groups Id'); ?></th>
		<th><?php __('Garment Type'); ?></th>
		<th><?php __('Was Price'); ?></th>
		<th><?php __('Alternate Size Category Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($coupon['Product'] as $product):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $product['id'];?></td>
			<td><?php echo $product['site_id'];?></td>
			<td><?php echo $product['daOrder'];?></td>
			<td><?php echo $product['name'];?></td>
			<td><?php echo $product['message'];?></td>
			<td><?php echo $product['message2'];?></td>
			<td><?php echo $product['sizing_link'];?></td>
			<td><?php echo $product['price'];?></td>
			<td><?php echo $product['on_sale'];?></td>
			<td><?php echo $product['active'];?></td>
			<td><?php echo $product['out_of_stock'];?></td>
			<td><?php echo $product['discontinue'];?></td>
			<td><?php echo $product['style_id'];?></td>
			<td><?php echo $product['is_apparel'];?></td>
			<td><?php echo $product['pogo_id'];?></td>
			<td><?php echo $product['is_guys'];?></td>
			<td><?php echo $product['is_girls'];?></td>
			<td><?php echo $product['is_youth'];?></td>
			<td><?php echo $product['is_baby'];?></td>
			<td><?php echo $product['is_accessory'];?></td>
			<td><?php echo $product['pic1'];?></td>
			<td><?php echo $product['pic1_l'];?></td>
			<td><?php echo $product['pic2'];?></td>
			<td><?php echo $product['pic2_l'];?></td>
			<td><?php echo $product['pic3'];?></td>
			<td><?php echo $product['pic3_l'];?></td>
			<td><?php echo $product['pic4'];?></td>
			<td><?php echo $product['pic4_l'];?></td>
			<td><?php echo $product['american_apparel'];?></td>
			<td><?php echo $product['five_dollar_overlay'];?></td>
			<td><?php echo $product['url_tags'];?></td>
			<td><?php echo $product['special_product'];?></td>
			<td><?php echo $product['shipping_groups_id'];?></td>
			<td><?php echo $product['garment_type'];?></td>
			<td><?php echo $product['was_price'];?></td>
			<td><?php echo $product['alternate_size_category_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'products', 'action' => 'view', $product['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'products', 'action' => 'edit', $product['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'products', 'action' => 'delete', $product['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $product['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>

<div class="coupons index">
	<h2><?php __('Coupons');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('site_id');?></th>
			<th><?php echo $this->Paginator->sort('code');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('minprice');?></th>
			<th><?php echo $this->Paginator->sort('minitems');?></th>
			<th><?php echo $this->Paginator->sort('maxitems');?></th>
			<th><?php echo $this->Paginator->sort('requireditem');?></th>
			<th><?php echo $this->Paginator->sort('discounttype');?></th>
			<th><?php echo $this->Paginator->sort('discountamount');?></th>
			<th><?php echo $this->Paginator->sort('discountto');?></th>
			<th><?php echo $this->Paginator->sort('auto');?></th>
			<th><?php echo $this->Paginator->sort('uses');?></th>
			<th><?php echo $this->Paginator->sort('remove');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('start_date');?></th>
			<th><?php echo $this->Paginator->sort('end_date');?></th>
			<th><?php echo $this->Paginator->sort('usps');?></th>
			<th><?php echo $this->Paginator->sort('ups_ground');?></th>
			<th><?php echo $this->Paginator->sort('ups_2_day_air');?></th>
			<th><?php echo $this->Paginator->sort('ups_next_day_air');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($coupons as $coupon):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $coupon['Coupon']['id']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['site_id']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['code']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['description']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['minprice']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['minitems']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['maxitems']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['requireditem']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['discounttype']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['discountamount']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['discountto']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['auto']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['uses']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['remove']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['modified']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['start_date']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['end_date']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['usps']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['ups_ground']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['ups_2_day_air']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['ups_next_day_air']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $coupon['Coupon']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $coupon['Coupon']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $coupon['Coupon']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $coupon['Coupon']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Coupon', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Coupons Useds', true), array('controller' => 'coupons_useds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Coupons Used', true), array('controller' => 'coupons_useds', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>
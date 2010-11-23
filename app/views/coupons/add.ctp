<div class="coupons form">
<?php echo $this->Form->create('Coupon');?>
	<fieldset>
 		<legend><?php __('Add Coupon'); ?></legend>
	<?php
		echo $this->Form->input('site_id');
		echo $this->Form->input('code');
		echo $this->Form->input('description');
		echo $this->Form->input('minprice');
		echo $this->Form->input('minitems');
		echo $this->Form->input('maxitems');
		echo $this->Form->input('requireditem');
		echo $this->Form->input('discounttype');
		echo $this->Form->input('discountamount');
		echo $this->Form->input('discountto');
		echo $this->Form->input('auto');
		echo $this->Form->input('uses');
		echo $this->Form->input('remove');
		echo $this->Form->input('start_date');
		echo $this->Form->input('end_date');
		echo $this->Form->input('usps');
		echo $this->Form->input('ups_ground');
		echo $this->Form->input('ups_2_day_air');
		echo $this->Form->input('ups_next_day_air');
		echo $this->Form->input('Product');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Coupons', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Coupons Useds', true), array('controller' => 'coupons_useds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Coupons Used', true), array('controller' => 'coupons_useds', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>
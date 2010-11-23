<?php 
	if(!isset($actions)){
		$actions = false;
	}

?>

<div class="shippingAddresses form">
<h3><?php __('Add A New Shipping Addresses');?></h3>
<?php echo $form->create('ShippingAddress',array('action'=>'add'));?>
	<?php
		echo $form->input('default',array('label'=>'Use As Default Address','type'=>'checkbox','checked'=>true));
		echo $form->input('user_id',array('type'=>'hidden','value'=>$authUser['id']));
		echo $form->input('firstname',array('label'=>'First Name'));
		echo $form->input('lastname',array('label'=>'Last Name'));
		echo $form->input('address_1');
		echo $form->input('address_2');
		echo $form->input('city');
		echo $form->input('state',array('div'=>'select text required'));
		echo $form->input('zip');
	?>
<div class="clear_both">
	<?php echo $form->end('Add');?>
</div>
</div>
<?php if ($actions){?>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Back to your Account', true), array('controller'=>'users' ,'action' => "view/{$authUser['id']}"));?></li>
	</ul>
</div>
<?php } ?>
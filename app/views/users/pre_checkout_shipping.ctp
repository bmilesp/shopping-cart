<div class="users pre_checkout_shipping">

<?php if (!empty($shippingAddresses)){ ?>
	<h2><?php echo __('Shipping Address Book')?></h2>
	<div class="list_addresses">
		<?php
		foreach ($shippingAddresses as $shippingAddress):?>
				<?php echo $this->element('address_label', 
								array("data" => $shippingAddress,
									  "editMode" => false,
									  "selectMode" => true,
									  "primaryKey" => 'ship_id',
									  "controller" => 'shipping_addresses'
								));
				?>
		<?php endforeach; ?>
	</div>
<?php } ?>

<div class="new_address_wrapper">


<?php if (empty($shippingAddresses)){ ?>
<fieldset>
<legend><?php __('Use this billing address as your shipping address?');?></legend>
<?php 
		echo $form->create('ShippingAddressCopy',array('url'=>array('controller'=>'shipping_addresses','action'=>'add'))); 
		echo $this->element('address_label', 
								array("data" => $billingAddress['BillingAddress'],
									  "editMode" => false,
									  "selectMode" => false,
									  "controller" => 'billing_addresses'
								));
								
		echo $form->hidden('default',array('value'=>1));
		echo $form->hidden('user_id',array('value'=>$billingAddress['BillingAddress']['user_id']));
		echo $form->hidden('firstname',array('value'=>$billingAddress['BillingAddress']['firstname']));
		echo $form->hidden('lastname',array('value'=>$billingAddress['BillingAddress']['lastname']));
		echo $form->hidden('address_1',array('value'=>$billingAddress['BillingAddress']['address_1']));
		echo $form->hidden('address_2',array('value'=>$billingAddress['BillingAddress']['address_2']));
		echo $form->hidden('city',array('value'=>$billingAddress['BillingAddress']['city']));
		echo $form->hidden('state',array('value'=>$billingAddress['BillingAddress']['state']));
		echo $form->hidden('zip',array('value'=>$billingAddress['BillingAddress']['zip']));
	?>
	<div class="clear_both">
	<?php echo $form->end('Use this Address as my Shipping Address');?>
	</div>
</fieldset>
<?php }?>

<?php echo $this->element('add_shipping_address')?>
</div>
<div class="users pre_checkout_billing">
<?php if (!empty($billingAddresses)){ ?>
	<h2><?php echo __('Billing Address Book')?></h2>
	<div class="list_addresses">
		<?php
		foreach ($billingAddresses as $billingAddress):?>
				<?php echo $this->element('address_label', 
								array("data" => $billingAddress,
									  "editMode" => false,
									  "selectMode" => true,
									  "primaryKey" => 'bill_id',
									  "controller" => 'billing_addresses'
								));
				?>
		<?php endforeach; ?>
	</div>
<?php } ?>

<div class="new_address_wrapper">
<?php echo $this->element('add_billing_address')//, array('cache'=>'1 week')?>
</div>
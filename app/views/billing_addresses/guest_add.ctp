<?php 
$jscode = <<<EOAJAVASCRIPT
$().ready(init);

function init(){
	$('#CopyFromBilling').bind('click',copyFromBilling);
}

function copyFromBilling(){
	$('#ShippingAddressFirstname').val($('#BillingAddressFirstname').val());
	$('#ShippingAddressLastname').val($('#BillingAddressLastname').val());
	$('#ShippingAddressAddress1').val($('#BillingAddressAddress1').val());
	$('#ShippingAddressAddress2').val($('#BillingAddressAddress2').val());
	$('#ShippingAddressCity').val($('#BillingAddressCity').val());
	$('#ShippingAddressState').val($('#BillingAddressState').val());
	$('#ShippingAddressZip').val($('#BillingAddressZip').val());
}

EOAJAVASCRIPT;

echo $javascript->codeBlock($jscode, array('inline'=>false));
?>
<div class="billingAddresses form">  
	<?php echo $form->create('BillingAddress',array('action'=>'guest_add'));?>
	<div>
		<h3><?php __('Billing Address');?></h3>
		<div class="clear_both">(Billing first and last name must match name on your credit card)</div> 
			<?php
			echo $form->input('default',array('type'=>'hidden', 'value'=>0));
			echo $form->input('firstname',array('label'=>'First Name'));
			echo $form->input('lastname',array('label'=>'Last Name'));
			echo $form->input('address_1');
			echo $form->input('address_2');
			echo $form->input('city');
			echo $form->input('state',array('div'=>'select text required'));
			echo $form->input('zip');
		?>
		<div class="clear_both"></div>
		</div>
	<div>
	<br>
	<h3><?php __('Shipping Address');?></h3>
	<a href="javascript:void(0)" id="CopyFromBilling">Copy From Billing</a>
	<div class="clear_both"></div> 
		<?php
			echo $form->input('ShippingAddress.default',array('type'=>'hidden', 'value'=>0));
			echo $form->input('ShippingAddress.firstname',array('label'=>'First Name'));
			echo $form->input('ShippingAddress.lastname',array('label'=>'Last Name'));
			echo $form->input('ShippingAddress.address_1');
			echo $form->input('ShippingAddress.address_2');
			echo $form->input('ShippingAddress.city');
			echo $form->input('ShippingAddress.state',array('div'=>'select text required'));
			echo $form->input('ShippingAddress.zip');
		?>
		<div class="clear_both"></div>
	</div>
	<br>
	<?php echo $form->end('Save and Continue');?>
</div>

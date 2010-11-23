<div class="shippingAddresses form">
	
 		<h3><?php __('Forgot your password?');?></h3>
 		<p>Please enter the email address associated with the account. <br>Your new password will be sent to this email address.</p>
		<div>
			<?php echo $form->create('User',array('controller'=>'users', 'action'=>'forgot_password'));?>
			<?php echo $form->input('email'); ?>
			<?php echo $form->end(array('label'=>'Reset Password' ,'div'=>'submit input_align'));?>
		</div>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Back Login Page', true), array('controller' => 'users', 'action' => "add"));?></li>
	</ul>
</div>
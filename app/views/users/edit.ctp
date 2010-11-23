
<div class="shippingAddresses form">
	<?php echo $form->create('User');?>
	 	<fieldset>
 		<legend><?php __('Change Email/Phone Number');?></legend>
		<?php
			echo $form->input('id');
			echo $form->input('email');
			echo $form->input('phone');
			echo $form->input('opt_in',array('type'=>'checkbox','label'=>'Check here to opt-in to our VIP club. With the VIP club you will receive store discounts and newsletters.'));
		?>
		</fieldset>
	<?php echo $form->end('Submit');?>
		
	
	<div class="clear_both">
	<?php echo $form->create('User',array('action'=>'change_password'));?>
 		<fieldset>
 		<legend><?php __('Change Password');?></legend>
		<?php
			echo $form->input('id');
			echo $form->input('old_password',array('type'=>'password','div'=>'input text required'));
			echo "<br><br>";
			echo $form->input('retail_password',array('type'=>'password','label'=>'New Password','value'=>''));
			echo $form->input('password_confirm',array('type'=>'password','div'=>'input text required'));
		?>
		</fieldset>
	<?php echo $form->end('Submit');?>
	</div>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Back To Account Page', true), array('controller' => 'users', 'action' => "view/{$this->data['User']['id']}"));?></li>
	</ul>
</div>

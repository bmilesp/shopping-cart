<div class="loginPanels">
	<div class="loginPanelSingle">
		<?php echo $form->create('User',array('action'=>'create_new_account'));?>
			<div class="panelTitle">Create A New Account</div>
			<?php echo $form->input('add',array('type'=>'hidden','value'=>'1'));?>
			<?php echo $form->input('email');?>
			<div class="multiInputContainer">
				<?php echo $form->input('first_name',array('label'=>'First Name','div'=>'multiInputLeft input'));?>
				<?php echo $form->input('last_name',array('label'=>'Last Name'));?>
			</div>
			<?php echo $form->input('phone');?>
			<?php echo $form->input('new_account',array('type'=>'hidden','value'=>'Yes'));?>
			<div id="user_passwords">
			<?php echo $form->input('retail_password',array('type'=>'password','label'=>'Password','value'=>''));?>
			<?php echo $form->input('password_confirm',array('type'=>'password'));?>
			</div>
			<?php echo $form->input('opt_in',array('checked'=>true,'type'=>'checkbox','label'=>'Opt me in to the UGP VIP Club! If you opt-in to our VIP club you will receive store discounts and newsletters.'));?>
			<?php echo $form->end('Continue');?>
		<?php $form->end()?>
	</div>
</div>
<?php   $session->flash('auth');?>
<div class="loginPanels">
	<div class="loginPanelSingle">
		<?php echo $form->create('User',array('action'=>'login'));?>
			<div class="panelTitle">Login</div>
			<?php echo $form->input('email');?>
			<?php echo $form->input('retail_password',array('type'=>'password','label'=>'Password'));?>
			<?php echo $form->input('auto_login', array('type' => 'checkbox', 'label' => 'Log me in automatically?','div'=>'input checkbox loginCheckbox')); ?> 
		<?php echo $form->end('Login');?>
	</div>
</div>
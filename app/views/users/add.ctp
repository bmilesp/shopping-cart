<?php echo $javascript -> link('jquery-ui-1.8.1.custom.min.js',false); ?>
<?php echo $javascript -> link('jquery.hoverintent.js',false); ?>
<?php echo $javascript -> link('jquery.superfish.js',false); ?>
<?php 
$jscode = <<<EOAJAVASCRIPT
$().ready(init);

function init(){
	$('#UserNewAccountYes').bind('focus',yesNoTogglePassowrdsOn);
	$('#UserNewAccountNo').bind('focus',yesNoTogglePassowrdsOff);
}

function yesNoTogglePassowrdsOn(){
	$('#user_passwords').stop(true,true).show('slide',{direction:'up', easing:'easeInOutQuint'},1000);
}

function yesNoTogglePassowrdsOff(){
	$('#user_passwords').hide('slide',{direction:'up', easing:'easeInOutQuint'},1000);
}
EOAJAVASCRIPT;

echo $javascript->codeBlock($jscode, array('inline'=>false));
?>
<div class="loginPanels">
	<div class="loginPanel">
		<?php echo $form->create('Login',array('url'=>Router::url(array('controller'=>'users','action'=>'login'),true,true)));?>
			<div class="panelTitle">Login</div>
			<?php echo $form->input('email',array('id'=>'loginEmail'));?>
			<?php echo $form->input('retail_password',array('id'=>'loginPassword','type'=>'password','label'=>'Password'));?>
			<?php echo $form->input('auto_login', array('type' => 'checkbox', 'label' => 'Log me in automatically?')); ?> 
			<?php echo $form->end('Login');?>
		<?php echo $form->end() ?>
		<div class="actions">
			<ul>
				<li><?php echo $html->link(__('Forgot Your Password?', true), array('controller' => 'users', 'action' => "forgot_password"));?></li>
			</ul>
		</div>
	</div>
	<div class="loginPanel loginPanelRight">
		<?php echo $form->create('User');?>
			<div class="panelTitle">Or Enter Checkout Information</div>
			<?php echo $form->input('add',array('type'=>'hidden','value'=>'1'));?>
			<?php echo $form->input('email');?>
			<div class="multiInputContainer">
				<?php echo $form->input('first_name',array('label'=>'First Name','div'=>'multiInputLeft input'));?>
				<?php echo $form->input('last_name',array('label'=>'Last Name'));?>
			</div>
			<?php echo $form->input('phone');?>
			<div class="yes_no_radios">
				<div style="clear:both"><strong>Would You like to create a new account?</strong> By Creating an Account you can track your orders and purchase future products more easily.</div>
				<?php echo $form->radio('new_account',array('Yes'=>'Yes','No'=>'No'),array('default'=>'Yes','legend'=>false,'class'=>'yes_no_radios'));?>
			</div>
			<div id="user_passwords">
			<?php echo $form->input('retail_password',array('type'=>'password','label'=>'Password','value'=>''));?>
			<?php echo $form->input('password_confirm',array('type'=>'password'));?>
			</div>
			<?php echo $form->input('opt_in',array('checked'=>true,'type'=>'checkbox','label'=>'Opt me in to the UGP VIP Club! If you opt-in to our VIP club you will receive store discounts and newsletters.'));?>
			<?php echo $form->end('Continue');?>
		<?php $form->end()?>
	</div>
</div>

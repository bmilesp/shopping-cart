<div class="pane_header">
	<div class="footer_pane_headers newsletter_text">MAILING LIST</div>
</div>
<div class="social_media">
	<div class="social_item">
		<?php echo $form->create('Newsletter',array('controller'=>'newsletters', 'action'=>'add'))?>
		<?php echo $form->input('email', array('label'=>false))?>
		<?php echo $form->end(array('label'=>'Submit','div'=>false));?>	
	</div>
	<div class="social_item">
		<?php echo $html->image('bookmark_button.png',array('class'=>'img_button','onclick'=>'bookmark()'))?>
	</div>
</div>
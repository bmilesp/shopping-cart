<script>
$().ready(init);

 function init(){
	 $("#NewsletterEmail").focus(newsletterFocusHandler);
	 $("#NewsletterEmail").blur(newsletterBlurHandler);	
	 newsletterBlurHandler();
 }

 function newsletterFocusHandler(){
	 if ($("#NewsletterEmail").val() == 'you@email.com') {
		 $("#NewsletterEmail").attr('class','searchDark');
		 $("#NewsletterEmail").val('');
	 }
 }

 function newsletterBlurHandler(){
	if ($("#NewsletterEmail").val() == '') {
		$("#NewsletterEmail").attr('class','searchDefault');
		$("#NewsletterEmail").val('you@email.com');
	}
} 
</script>
<div class="social_item">
	<?php echo $form->create('Newsletter',array('controller'=>'newsletters', 'action'=>'add'))?>
	<?php echo $form->input('email', array('label'=>'Mailing List:', 'div'=>false))?>
	<?php echo $form->end(array('label'=>'Submit','div'=>false));?>	
</div>
<div class="footer_pane box_pane">
	<?php echo $this->element('newsletter')?>
	<div style="clear:both"></div>
	<div class="envelope">
		<?php echo $html->image('envelope.png')?>
	</div>
	<?php if($this->name != "CakeError"){?>
	<div id="site-map-nav">
		<?php echo $this->element('nav/site_map',array('groups'=>$siteMapGroups)) ?>
	</div>
	<div id="copyright">
		<?php  echo $html->image('visa_icon.gif', array('alt' => 'Visa', 'width' =>39, 'height'=>26))?>
		<?php  echo $html->image('mastercard_icon.gif', array('alt' => 'Master Card', 'width' =>39, 'height'=>26))?>
		<?php  echo $html->image('discover_icon.gif', array('alt' => 'Discover', 'width' =>39, 'height'=>26))?>
		<?php  echo $html->image('amex_icon.gif', array('alt' => 'American Express', 'width' =>39, 'height'=>26))?>
		<br>
		&copy;<?php echo date('Y')?> <?php echo $siteConfig->getCartDBField('copyright_name');?>
		<br>
		<?php echo $siteConfig->getCartDBField('copyright_line2');?>
	</div>
	<?php }?>
</div>
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

 function bookmark(){
	 var url = "<?php echo $http."://{$_SERVER['HTTP_HOST']}".$this->here ?>"; 
	 var pageName = "<?php echo $siteConfig->getCartDBField('site_name'); echo " - ".$title_for_layout?>"; 
	 if(typeof(window.sidebar) != 'undefined'){ 
		 window.sidebar.addPanel(pageName,url,"");
 	 }else if(typeof(window.external.AddFavorite) != 'undefined'){
 	 	 window.external.AddFavorite(url,pageName);
 	 }else{ 
 	 	 alert("Please bookmark this site manually using your browser."); 
	 }
 }
</script>
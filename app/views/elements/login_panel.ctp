<div id="login_panel">	
	<div id="login_panel_left_side">
		<div class="search-input-wrapper">
			<?php echo $form->create('Product',array('controller'=>'products', 'action'=>'search'))?>
			<?php echo $form->input('search', array('size'=>15,'div'=>false, 'label'=>false))?>
			<?php echo $form->end(array('label'=>' ','class'=>'goButton','div'=>false));?>	
		</div>
		<div class="login_panel_login_button" onclick="window.location = '<?php echo $rootDir ?>users/login/'" ><?php echo $html->image('login-here-button.png')?></div>
	</div>
	<div id="login_panel_right_side">
		<?php echo $html->image('free-USPS-shipping.png')?>
	</div>

</div>
<script>
$().ready(init);

 function init(){
	 $("#ProductSearch").focus(searchFocusHandler);
	 $("#ProductSearch").blur(searchBlurHandler);	
	 searchBlurHandler();
 }

 function searchFocusHandler(){
	 if ($("#ProductSearch").val() == 'Search') {
		 $("#ProductSearch").attr('class','searchDark');
		 $("#ProductSearch").val('');
	 }
 }

 function searchBlurHandler(){
	if ($("#ProductSearch").val() == '') {
		$("#ProductSearch").attr('class','searchDefault');
		$("#ProductSearch").val('Search');
	}
} 
</script>
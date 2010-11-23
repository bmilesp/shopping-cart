<div id="login_panel">			
	<?php if(!empty($user)){?>
			<?php echo $html->link("My Account - ".$user['email'], array('controller'=>'users', 'action'=>'view', $user['id']))?>
			&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
			<?php echo $html->link("Logout", array('controller'=>'users', 'action'=>'logout'))?>
	<?php }else {?>
			<?php echo $html->link("Create New Account", array('controller'=>'users', 'action'=>'add'))?>
			&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
			<?php echo $html->link("Login", array('controller'=>'users', 'action'=>'add'))?>
	<?php } ?>
	<?php 
	echo $form->create('Product', array('controller'=>'products', 'action'=>'search', 'id'=>'searchForm'));
	$searchClass = isset($search)? "searchDark" : "searchDefault";
	$searchVal = isset($search)? trim(ereg_replace("[^a-zA-Z0-9/#/&/+/$/@/! ]",'',$search)) : "Search";
	echo $form->input('search', array('size'=> 15, 'class'=>$searchClass, 'value'=>$searchVal, 'div'=>false, 'label'=>false));
	?>
	<!--  <input type="text" id="SearchInput" value="<?php echo isset($_GET['search'])? trim(ereg_replace("[^a-zA-Z0-9/#/&/+/$/@/! ]",'',$_GET['search'])) : "Search"; ?>" class="<?php echo isset($_GET['search'])? "searchDark" : "searchDefault"?>" size="15" name="search"/> -->
	<?php echo $form->button('Go',array('class'=>'goButton', 'div'=>false, 'type'=>'submit'));
		  echo $form->end()?>
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
<?php 
$authUser = (isset($authUser)? $authUser : array());
echo $this->element('login_search_panel',array('user'=>$authUser))?>
<?php 
	  $ext = null;
	  $get_param = null;
	  $single_get_param = null;
	  if(isset($_REQUEST['etag'])){
	  	$ext = '_'.$_REQUEST['etag'];
	  }
?>
<div id="header<?php echo $ext ?>">
	
	<?php $img =  $html->image("{$secureRootDir}unique/{$siteConfig->site}/img/MyCART.jpg",array('alt'=>'MyCart', 'id'=>'mycart'));
		echo $html->link($img, $html->url(array('controller'=>'orders', 'action'=>'cart'),true,true),array('escape'=>false));
	?>
	<div id="menu<?php echo $ext ?>">
		<?php echo $html->link("SHOP ONLINE",$html->url(array('controller'=>'pages', 'action'=>'display', 'home'),true,true));?>
		<?php //echo $html->link("OUR STORE",$html->url(array('controller'=>'pages', 'action'=>'display', 'about_us'),true,true));?>
		<?php echo $html->link("FAQ",$html->url(array('controller'=>'pages', 'action'=>'display', 'faq'),true,true));?>
		<?php echo $html->link("CUSTOM SCREENPRINTING",'http://www.undergroundshirts.com/?standard=true&p=quote', array('target'=>'_blank'));?>
	</div>
</div>
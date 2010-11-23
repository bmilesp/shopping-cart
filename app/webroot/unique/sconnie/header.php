<div id="header">

<?php if($this->name != "CakeError"){?>
	<div id='logo'><?php echo $html->image("../unique/{$siteConfig->site}/img/LogoMOE.png",array('url'=>'/'))?></div>
	<div id="header_nav">
		<?php $headerNav = array();?>
		<?php //$headerNav[] =  $html->link('FAQ',array('controller'=>'pages', 'action'=>'display','faq'))?>
		<?php $headerNav[] = $html->link('VIEW CART',array('controller'=>'orders', 'action'=>'cart'))?>
		<?php if(!empty($authUser) && $authUser['cart_guest'] == 0){?>
			<?php 
				$headerNav[] = $html->link("ACCOUNT",$html->url(array('controller'=>'users', 'action'=>'view', $authUser['id']),true,true));
				$headerNav[] = $html->link("LOGOUT",array('controller'=>'users', 'action'=>'logout'))?>
		<?php }else {?>
			<?php $headerNav[] = $html->link("CREATE NEW ACCOUNT",array('controller'=>'users', 'action'=>'create_new_account')) ?>
		<?php }
			echo implode("&nbsp;&nbsp;|&nbsp;&nbsp",$headerNav);
		?>
	</div>
	<?php echo $this->element('login_panel',array('user'=>$authUser))?>
	<div style="clear:both"></div>	
	<?php echo $this->element('cart_panel'. DS .'cart_panel',array('cartItems'=>$cartItems, 
											 'coupons'=>$coupons, 
											 'cartItemImageUrl'=>$cartItemImageUrl,
											 'cartTotals'=>$cartTotals))?>
<?php } ?>
</div>